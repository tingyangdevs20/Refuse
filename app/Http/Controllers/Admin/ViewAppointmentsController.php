<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TestEmail;
use App\Model\Account;
use App\Model\CampaignLead;
use App\Model\CampaignLeadList;
use App\Model\Scheduler;
use Illuminate\Http\Request;
use App\Services\GoogleCalendar;
use Validator;
use Exception;
use Carbon\Carbon;
use DB;
use DATETIME;
use App\Model\Contact;
use App\Model\FailedSms;
use App\Model\Group;
use App\Model\Number;
use App\Model\Reply;
use App\Model\RvmFile;
use App\Model\Sms;
use App\Model\Template;
use App\Services\UserEventsService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\View as View;
use Twilio\Rest\Client;

class ViewAppointmentsController extends Controller
{
  public function index()
  {
    //if (!empty($uid)) {

    //  $this->setupGoogleCalendar();

    //  $slotsArr = $this->getBookedSlotsFromGoogleCalendar();

    //  $bookedSlots = json_encode($slotsArr);

    //  $uid = decrypt($uid);
    $appointments = Scheduler::select(DB::raw('DATE(appt_date) as appt_date'), 'appt_time', 'name', 'email', 'mobile', 'status', 'id')->orderBy('appt_date', 'DESC')->get();

    return view('back.pages.appointments.index', compact('appointments'));
    // } else {
    //  return Redirect::back();
    // }
  }

  public function reminder($id){
    $user_id = $id;
    $files = RvmFile::all();
    return view('back.pages.appointments.indexList', compact(['files', 'user_id']));
  }

  public function store(Request $request)
    {
       
        $campaign_id = $request->campaign_id;
        $campaign_list_id = $request->campaign_list_id;
        $types = $request->type;
        $send_after_days = $request->send_after_days;
        $send_after_hours = $request->send_after_hours;
        $send_after_hours = $request->send_after_hours;
        $subject = $request->subject;
        //dd($_POST['media_file']);
        $body = $request->body;

        $appointments = Scheduler::find($request->appointment_id);

        
        $count = 1;
        if(count($types)  > 0){
            foreach($types as $key => $val ){
                $sendAfter = null;
                if ($request->send_after_days[$key] !== null && $request->send_after_hours[$key] !== null) {
                    $sendAfter = now()->addDays($request->send_after_days[$key])->addHours($request->send_after_hours[$key]);
                }
                if($val == 'rvm'){
                    $media = $request->mediaUrl[$key];
                }else{
                    $imageName = 'media_file'.$count;
                    if ($request->hasFile($imageName)) {
                        $media = $request->file($imageName);;
                        $filename = $media->getClientOriginalName();
                        $extension = $media->getClientOriginalExtension();
                        $tmpname = 'Media_'.time() .'.'. $extension;
                        $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
                        $media = config('app.url') . '/public/uploads/' . $path;
                    }else{
                        $template = CampaignLeadList::find($request->campaign_list_id[$key]);
                        if($template){
                            $media = $template->mediaUrl;
                        }else{
                            $media = '';
                        }
                    }
                }
                
                //return $media;
                //return $sendAfter;

                //dd($request->campaign_list_id[$key]);
                // Create the campaign
                if($request->campaign_list_id[$key] == 0){
                    CampaignLeadList::create([
                        'campaign_id' => $campaign_id,
                        'type' => $val,
                        'send_after_days' => $request->send_after_days[$key],
                        'send_after_hours' => $request->send_after_hours[$key],
                        'schedule' => $sendAfter,
                        'mediaUrl' => $media,
                        'template_id' => $request->template_id,
                        'subject' => $request->subject[$key],
                        'body' => $request->body[$key],
                        'active' => 1, // Set active status
                    ]);
                }else{
                    CampaignLeadList::where('id' ,$request->campaign_list_id[$key] )->update([
                        'type' =>  $val,
                        'send_after_days' => $request->send_after_days[$key],
                        'send_after_hours' => $request->send_after_hours[$key],
                        'schedule' => $sendAfter,
                        'template_id' => 0,
                        'mediaUrl' => $media,
                        'body' => $request->body[$key],
                        'subject' => $request->subject[$key],
                        'active' => 1, // Set active status
                        // Add other fields for campaign details
                    ]);
                }
                $count++;
            }
        }
        $compain = CampaignLead::where('id',$campaign_id)->first();
        //dd($compain);
        $groupsID = Group::where('id',$compain->group_id)->first();
        if($groupsID){
            $sender_numbers = Number::where('market_id' , $groupsID->market_id)->inRandomOrder()->first();
             //dd($numbers);
          $account = Account::where('id' , $sender_numbers->account_id)->first();           
                if($account){
                    $sid = $account->account_id;
                    $token = $account->account_token;
                }else{
                    $sid = '';
                    $token = '';
                }
        }
      
    
        $checkCompainList = CampaignLeadList::where('campaign_id',$request->campaign_id)->get();
        if(count($checkCompainList) == 1){
            
            $template = Template::where('id',$request->template_id)->first();
            if($request->type == 'email'){
                $contacts = Contact::where('group_id' , $compain->group_id)->get();
                if(count($contacts) > 0){
                    foreach($contacts as $cont){
                        //return $cont->name;
                        if($cont->email1 != ''){
                            $email = $cont->email1;
                        }elseif($cont->email2){
                            $email = $cont->email2;
                        }
                        if($template){
                            $subject = $template->subject;
                        }else{
                            $subject = $checkCompainList->subject;
                        }
                        $subject = $template->subject;
                        $subject = str_replace("{name}", $cont->name, $subject);
                        $subject = str_replace("{street}", $cont->street, $subject);
                        $subject = str_replace("{city}", $cont->city, $subject);
                        $subject = str_replace("{state}", $cont->state, $subject);
                        $subject = str_replace("{zip}", $cont->zip, $subject);
                        if($template){
                            $message = $template->body;
                        }else{
                            $message = $checkCompainList->body;
                        }
                        $message = str_replace("{name}", $cont->name, $message);
                        $message = str_replace("{street}", $cont->street, $message);
                        $message = str_replace("{city}", $cont->city, $message);
                        $message = str_replace("{state}", $cont->state, $message);
                        $message = str_replace("{zip}", $cont->zip, $message);
                        $unsub_link = url('admin/email/unsub/'.$email);
                        $data = ['message' => $message ,'subject' => $subject, 'name' =>$cont->name, 'unsub_link' =>$unsub_link];
                        Mail::to($email)->send(new TestEmail($data));
                        //Mail::to('rizwangill132@gmail.com')->send(new TestEmail($data));
                    }
                }
                 
            }elseif($request->type == 'sms'){
                $client = new Client($sid, $token);
                $contacts = Contact::where('group_id' , $compain->group_id)->get();
                if(count($contacts) > 0){
                    foreach($contacts as $cont){
                        if($cont->number != ''){
                            $number = $cont->number;
                        }elseif($cont->number2 != ''){
                            $number = $cont->number2;
                        }elseif($cont->number3 != ''){
                            $number = $cont->number2;
                        }
                        $receiver_number = $number;
                        $sender_number = $sender_numbers->number;
                        if($template){
                            $message = $template->body;
                        }else{
                            $message = $checkCompainList->body;
                        }
                        $message = str_replace("{name}", $cont->name, $message);
                        $message = str_replace("{street}", $cont->street, $message);
                        $message = str_replace("{city}", $cont->city, $message);
                        $message = str_replace("{state}", $cont->state, $message);
                        $message = str_replace("{zip}", $cont->zip, $message);
                        try {
                            $sms_sent = $client->messages->create(
                                $receiver_number,
                                [
                                    'from' => $sender_number,
                                    'body' => $message,
                                ]
                            );
                            if ($sms_sent) {
                                $old_sms = Sms::where('client_number', $receiver_number)->first();
                                if ($old_sms == null) {
                                    $sms = new Sms();
                                    $sms->client_number = $receiver_number;
                                    $sms->twilio_number = $sender_number;
                                    $sms->message = $message;
                                    $sms->media = '';
                                    $sms->status = 1;
                                    $sms->save();
                                    $this->incrementSmsCount($sender_number);
                                } else {
                                    $reply_message = new Reply();
                                    $reply_message->sms_id = $old_sms->id;
                                    $reply_message->to = $sender_number;
                                    $reply_message->from = $receiver_number;
                                    $reply_message->reply = $message;
                                    $reply_message->system_reply = 1;
                                    $reply_message->save();
                                    $this->incrementSmsCount($sender_number);
                                }
                
                            }
                        } catch (\Exception $ex) {
                            $failed_sms = new FailedSms();
                            $failed_sms->client_number = $receiver_number;
                            $failed_sms->twilio_number = $sender_number;
                            $failed_sms->message = $message;
                            $failed_sms->media = '';
                            $failed_sms->error = $ex->getMessage();
                            $failed_sms->save();
                        }
                    }
                }
            }elseif($request->type == 'mms'){
                $client = new Client($sid, $token);
                $contacts = Contact::where('group_id' , $compain->group_id)->get();
                if(count($contacts) > 0){
                    foreach($contacts as $cont){
                        $receiver_number = $cont->number;
                        //$receiver_number = '4234606442';
                        $sender_number = $sender_numbers->number;
                        if($template){
                            $message = $template->body;
                        }else{
                            $message = $checkCompainList->body;
                        }
                        $message = str_replace("{name}", $cont->name, $message);
                        $message = str_replace("{street}", $cont->street, $message);
                        $message = str_replace("{city}", $cont->city, $message);
                        $message = str_replace("{state}", $cont->state, $message);
                        $message = str_replace("{zip}", $cont->zip, $message);
                        if($template){
                            $mediaUrl = $template->mediaUrl;
                        }else{
                            $mediaUrl = $checkCompainList->mediaUrl;
                        }
                        try {
                            $sms_sent = $client->messages->create(
                                $receiver_number,
                                [
                                    'from' => $sender_number,
                                    'body' => $message,
                                    'mediaUrl' => [$mediaUrl],
                                ]
                            );
                            //dd($sms_sent);
                            if ($sms_sent) {
                                $old_sms = Sms::where('client_number', $receiver_number)->first();
                                if ($old_sms == null) {
                                    $sms = new Sms();
                                    $sms->client_number = $receiver_number;
                                    $sms->twilio_number = $sender_number;
                                    $sms->message = $message;
                                    $sms->media = $mediaUrl == null ? 'No' : $mediaUrl;
                                    $sms->status = 1;
                                    $sms->save();
                                    $this->incrementSmsCount($sender_number);
                                } else {
                                    $reply_message = new Reply();
                                    $reply_message->sms_id = $old_sms->id;
                                    $reply_message->to = $sender_number;
                                    $reply_message->from = $receiver_number;
                                    $reply_message->reply = $message;
                                    $reply_message->system_reply = 1;
                                    $reply_message->save();
                                    $this->incrementSmsCount($sender_number);
                                }
                
                            }
                        } catch (\Exception $ex) {
                            $failed_sms = new FailedSms();
                            $failed_sms->client_number = $receiver_number;
                            $failed_sms->twilio_number = $sender_number;
                            $failed_sms->message = $message;
                            $failed_sms->media = $mediaUrl == null ? 'No' : $mediaUrl;
                            $failed_sms->error = $ex->getMessage();
                            $failed_sms->save();
                        }
                    }
                }
            }elseif($request->type == 'rvm'){
                $contactsArr = [];
                $contacts = Contact::where('group_id' , $compain->group_id)->get();
                if(count($contacts) > 0){
                    foreach($contacts as $cont){
                        $contactsArr[] = $cont->number;
                    }
                }
                if(count($contactsArr) > 0){
                    try {
                        if($template){
                            $message = $template->body;
                        }else{
                            $message = $checkCompainList->body;
                        }
                        $c_phones = implode(',',$contactsArr);
                        //$c_phones = '3128692422';
                        $vrm = \Slybroadcast::sendVoiceMail([
                                            'c_phone' => ".$c_phones.",
                                            'c_url' =>$message,
                                            'c_record_audio' => '',
                                            'c_date' => 'now',
                                            'c_audio' => 'Mp3',
                                            //'c_callerID' => "4234606442",
                                            'c_callerID' => $sender_numbers->number,
                                            //'mobile_only' => 1,
                                            'c_dispo_url' => 'https://brian-bagnall.com/bulk/bulksms/public/voicepostback'
                                           ])->getResponse();
                    }catch (\Exception $ex) {
                        
                    }
                }
                
            }
            // $campaign->active = $request->active; // Update active
            // $checkCompainList1 = CampaignLeadList::where('campaign_id',$request->campaign_id)->first();
            // $campaigns = CampaignLeadList::where('id' , $checkCompainList1->id)->update(['updated_at' => date('Y-m-d H:i:s') , 'active' => 0]);
        }
        
        //return $request->campaign_id;
        return redirect('/manage-appointments')->with('success', 'Reminder Sent successfully.');
    }
}
