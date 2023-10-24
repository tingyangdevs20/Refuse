<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Campaign;
use App\Model\Category;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use App\Model\Group;
use App\Model\Number;
use App\Model\CampaignList;
use App\Model\Contact;
use App\Model\Settings;
use App\Model\Account;
use App\Model\Template;
use App\Model\TemplateMessages;
use App\Model\Reply;
use App\Model\Sms;
use App\Model\RvmFile;
use App\Model\FailedSms;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CampaignListController extends Controller
{
    public function index()
    {
        $groups = Group::all(); // Fetch groups from the database
        $campaigns = Campaign::getAllCampaigns();
        $templates = Template::where('type', 'SMS')->get();

        return view('back.pages.campaignlist.index', compact('groups', 'campaigns', 'templates'));
    }

    public function getTemplateText($id = '')
    {

        $templates = Template::where();


        return view('back.pages.campaign.indexList', compact('numbers', 'templates', 'campaignsList', 'id', 'files', 'categories'));
    }

    public function compaignList($id = '')
    {
        $numbers = Number::all();
        $templates = Template::all();
        //dd($templates);
        $files = RvmFile::all();
        //die($files);
        $categories = Category::all();
        $campaignsList = CampaignList::where('campaign_id', $id)->orderby('schedule', 'ASC')->get();
       // die($campaignsList);
        $campaign_name=Campaign::where('id', $id)->first();

        return view('back.pages.campaign.indexList', compact('numbers', 'templates', 'campaignsList', 'id', 'files', 'categories','campaign_name'));
    }

    public function schedual()
    {
        $currentTime = date('Y-m-d H:i:s');
        //$scheduleTime = '2023-08-21 07:43:02';
        $campaigns = Campaign::where('active', 1)->get();
        //dd($campaigns);
        if (count($campaigns) > 0) {
            foreach ($campaigns as $key1 => $camp) {
                $campaignsList = CampaignList::where('campaign_id', $camp->id)->where('active', 1)->orderby('schedule', 'ASC')->get();
                //dd($campaignsList);
                if (count($campaignsList) > 0) {
                    foreach ($campaignsList as $key => $row) {
                        $schedule = date('Y-m-d H:i:s', strtotime($row->schedule));
                        if ($schedule <= $currentTime) {
                            $account = Account::first();
                            if ($account) {
                                $sid = $account->account_id;
                                $token = $account->account_token;
                            } else {
                                $sid = '';
                                $token = '';
                            }
                            $template = Template::where('id', $row->template_id)->first();
                            if ($row->type == 'email') {
                                //return '333333';
                                $contacts = Contact::where('group_id', $camp->group_id)->where('is_email', 1)->get();
                                //dd($contacts);
                                if (count($contacts) > 0) {
                                    foreach ($contacts as $cont) {
                                        //return $cont->name;
                                        if ($cont->email1 != '') {
                                            $email = $cont->email1;
                                        } elseif ($cont->email2) {
                                            $email = $cont->email2;
                                        }
                                        //return $email;
                                        if ($email != '') {
                                            $subject = $template->subject;
                                            $subject = str_replace("{name}", $cont->name, $subject);
                                            $subject = str_replace("{street}", $cont->street, $subject);
                                            $subject = str_replace("{city}", $cont->city, $subject);
                                            $subject = str_replace("{state}", $cont->state, $subject);
                                            $subject = str_replace("{zip}", $cont->zip, $subject);
                                            $message = $template->body;
                                            $message = str_replace("{name}", $cont->name, $message);
                                            $message = str_replace("{street}", $cont->street, $message);
                                            $message = str_replace("{city}", $cont->city, $message);
                                            $message = str_replace("{state}", $cont->state, $message);
                                            $message = str_replace("{zip}", $cont->zip, $message);
                                            $unsub_link = url('admin/email/unsub/' . $email);
                                            $data = ['message' => $message, 'subject' => $subject, 'name' => $cont->name, 'unsub_link' => $unsub_link];
                                            Mail::to($cont->email1)->send(new TestEmail($data));

                                            //Mail::to('rizwangill132@gmail.com')->send(new TestEmail($data));
                                        }
                                    }
                                }
                            } elseif ($row->type == 'sms') {
                                $client = new Client($sid, $token);
                                $contacts = Contact::where('group_id', $camp->group_id)->get();
                                if (count($contacts) > 0) {
                                    foreach ($contacts as $cont) {
                                        if ($cont->number != '') {
                                            $number = $cont->number;
                                        } elseif ($cont->number2 != '') {
                                            $number = $cont->number2;
                                        } elseif ($cont->number3 != '') {
                                            $number = $cont->number2;
                                        }
                                        $receiver_number = $number;
                                        $sender_number = '+14234609555';
                                        $message = $template->body;
                                        $message = str_replace("{name}", $cont->name, $message);
                                        $message = str_replace("{street}", $cont->street, $message);
                                        $message = str_replace("{city}", $cont->city, $message);
                                        $message = str_replace("{state}", $cont->state, $message);
                                        $message = str_replace("{zip}", $cont->zip, $message);
                                        if ($receiver_number != '') {
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
                                }
                            } elseif ($row->type == 'mms') {
                                $client = new Client($sid, $token);
                                $contacts = Contact::where('group_id', $camp->group_id)->get();
                                if (count($contacts) > 0) {
                                    foreach ($contacts as $cont) {
                                        if ($cont->number != '') {
                                            $number = $cont->number;
                                        } elseif ($cont->number2 != '') {
                                            $number = $cont->number2;
                                        } elseif ($cont->number3 != '') {
                                            $number = $cont->number2;
                                        }
                                        $receiver_number = $number;
                                        $sender_number = '+14234609555';
                                        $message = $template->body;
                                        $message = str_replace("{name}", $cont->name, $message);
                                        $message = str_replace("{street}", $cont->street, $message);
                                        $message = str_replace("{city}", $cont->city, $message);
                                        $message = str_replace("{state}", $cont->state, $message);
                                        $message = str_replace("{zip}", $cont->zip, $message);
                                        if ($receiver_number != '') {
                                            try {
                                                $sms_sent = $client->messages->create(
                                                    $receiver_number,
                                                    [
                                                        'from' => $sender_number,
                                                        'body' => $message,
                                                        'mediaUrl' => [$template->mediaUrl],
                                                    ]
                                                );

                                                if ($sms_sent) {
                                                    $old_sms = Sms::where('client_number', $receiver_number)->first();
                                                    if ($old_sms == null) {
                                                        $sms = new Sms();
                                                        $sms->client_number = $receiver_number;
                                                        $sms->twilio_number = $sender_number;
                                                        $sms->message = $message;
                                                        $sms->media = $template->mediaUrl;
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
                                                $failed_sms->media = $template->mediaUrl;
                                                $failed_sms->error = $ex->getMessage();
                                                $failed_sms->save();
                                            }
                                        }
                                    }
                                }
                            } elseif ($row->type == 'rvm') {
                                $contactsArr = [];
                                $contacts = Contact::where('group_id', $camp->group_id)->get();
                                if (count($contacts) > 0) {
                                    foreach ($contacts as $cont) {
                                        if ($cont->number != '') {
                                            $number = $cont->number;
                                        } elseif ($cont->number2 != '') {
                                            $number = $cont->number2;
                                        } elseif ($cont->number3 != '') {
                                            $number = $cont->number2;
                                        }
                                        $contactsArr[] = $number;
                                    }
                                }
                                if (count($contactsArr) > 0) {
                                    $c_phones = implode(',', $contactsArr);
                                    $vrm = \Slybroadcast::sendVoiceMail([
                                        'c_phone' => ".$c_phones.",
                                        'c_url' => $template->body,
                                        'c_record_audio' => '',
                                        'c_date' => 'now',
                                        'c_audio' => 'Mp3',
                                        //'c_callerID' => "4234606442",
                                        'c_callerID' => "18442305060",
                                        //'mobile_only' => 1,
                                        'c_dispo_url' => 'https://brian-bagnall.com/bulk/bulksms/public/admin/voicepostback'
                                    ])->getResponse();
                                }
                            }
                            $campaigns = CampaignList::where('id', $row->id)->update(['updated_at' => date('Y-m-d H:i:s'), 'active' => 0]);
                            break;
                        } else {
                            //return '3333333';
                            if ($key == 0) {
                                $campaignsCheck = CampaignList::where('active', 0)->orderby('updated_at', 'desc')->first();
                                if ($campaignsCheck) {
                                    $scheduledate = date('Y-m-d H:i:s', strtotime($campaignsCheck->schedule));
                                    $sendAfter = null;
                                    //return (int) $campaignsCheck->send_after_days;
                                    //$sendAfter = Carbon::parse($scheduledate)->addDays($row->send_after_days)->addHours($row->send_after_hours);
                                    $sendAfter = now()->addDays($row->send_after_days)->addHours($row->send_after_hours);
                                    $campaigns = CampaignList::where('id', $row->id)->update(['schedule' => $sendAfter]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return 'success';
    }

    public function create()
    {
        return view('back.pages.campaign.create');
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
       
        $templ_ate = $request->templat;
        
       
        
        $settings = Settings::first()->toArray(); 
        $sid = $settings['twilio_acc_sid'];
        $token = $settings['twilio_auth_token'];
        $body_text ="";
        $bodytext='';
        $subject='';

        

    // dd($request);
        // die("..");
        
        $count = 1;
        if (count($types)  > 0) {
            foreach ($types as $key => $val) {
                $sendAfter = null;
                if ($request->send_after_days[$key] !== null && $request->send_after_hours[$key] !== null) {
                    $sendAfter = now()->addDays($request->send_after_days[$key])->addHours($request->send_after_hours[$key]);
                }
                if ($val == 'rvm') {
                    $media = $request->mediaUrl[$key];
                    
                } else {
                    $imageName = 'media_file' . $count;
                   
                    if ($request->hasFile($imageName)) {
                        $media = $request->file($imageName);;
                        $filename = $media->getClientOriginalName();
                        $extension = $media->getClientOriginalExtension();
                        $tmpname = 'Media_' . time() . '.' . $extension;
                        $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
                        $media = config('app.url') . '/public/uploads/' . $path;
                    } else {
                        $template = CampaignList::find($request->campaign_list_id[$key]);
                        if ($template) {
                            $media = $template->mediaUrl;
                        } else {
                            $media = '';
                        }

                        $body_text = TemplateMessages::where('template_id', $request->templat[$key])->get();
                
                if(count($body_text)>0)
                {
                $bodytext=$body_text[0]->msg_content;
                $subject=$body_text[0]->subject;
                }
               
                    }
                }
                
                //return $media;
                //return $sendAfter;
               
                //die(count($request->templat));
                //die("..");
                
                
                // Create the campaign
                if ($request->campaign_list_id[$key] == 0) {
                    //dd($request->campaign_list_id[$key]);
                    
                    
                        
                               
                                
                                CampaignList::create([
                                    'campaign_id' => $campaign_id,
                                    'type' => $val,
                                    'send_after_days' => $request->send_after_days[$key],
                                    'send_after_hours' => $request->send_after_hours[$key],
                                    'schedule' => $sendAfter,
                                    'mediaUrl' => $media,
                                    'template_id' => $request->templat[$key],
                                    'body' => $bodytext,
                                    'subject' => $subject,
                                    'active' => 1, // Set active status
                                ]);
                            
                        
                    
                } else {

                   
                              
                                CampaignList::where('id', $request->campaign_list_id[$key])->update([
                                    'type' =>  $val,
                                    'send_after_days' => $request->send_after_days[$key],
                                    'send_after_hours' => $request->send_after_hours[$key],
                                    'schedule' => $sendAfter,
                                    'template_id' => $request->templat[$key],
                                    'mediaUrl' => $media,
                                    'body' => $bodytext,
                                    'subject' => $subject,
                                    'active' => 1, // Set active status
                                    // Add other fields for campaign details
                                ]);
                            
                        
                    
                }
                $count++;
            }
        }
       // $compain = Campaign::where('id', $campaign_id)->first();

        $checkCompainList = CampaignList::where('campaign_id', $request->campaign_id)->get();

        //dd($checkCompainList);


        //COMMENTED ON - 8 Oct 2023 by JSingh
        // not require to run the campaign as it will run after push to campaign

        // if(count($checkCompainList) > 0){

        //     $template = Template::where('id',$request->template_id)->first();

        //     if($request->type[0] == 'email'){
        //         $contacts = Contact::where('group_id' , $compain->group_id)->get();

        //        if(count($contacts) > 0){
        //             foreach($contacts as $cont){

        //                 if($cont->email1 != ''){
        //                     $email = $cont->email1;
        //                 }elseif($cont->email2){
        //                     $email = $cont->email2;
        //                 }


        //                 if($template){
        //                     $subject_new = $template->subject;
        //                 }else{
        //                     $subject_new = $checkCompainList[0]->subject;
        //                 }
        //               if($subject=='')
        //               {
        //                  $subject=$subject_new;
        //               }


        //                 $subject = str_replace("{name}", $cont->name, $subject);
        //                 $subject = str_replace("{street}", $cont->street, $subject);
        //                 $subject = str_replace("{city}", $cont->city, $subject);
        //                 $subject = str_replace("{state}", $cont->state, $subject);
        //                 $subject = str_replace("{zip}", $cont->zip, $subject);



        //                 if($template){
        //                     $message = $template->body;
        //                 }else{
        //                     $message = $checkCompainList[0]->body;
        //                 }
        //                 $message = str_replace("{name}", $cont->name, $message);
        //                 $message = str_replace("{street}", $cont->street, $message);
        //                 $message = str_replace("{city}", $cont->city, $message);
        //                 $message = str_replace("{state}", $cont->state, $message);
        //                 $message = str_replace("{zip}", $cont->zip, $message);

        //                // print_r($email);
        //                //die("..");
        //                 $unsub_link = url('admin/email/unsub/'.$email);
        //                 $data = ['message' => $message ,'subject' => $subject, 'name' =>$cont->name, 'unsub_link' =>$unsub_link];
        //                 //dd($data);
        //                 Mail::to($email)->send(new TestEmail($data));

        //             }
        //         }

        //     }

        //     elseif($request->type[0] == 'sms'){

        //         $client = new Client($sid, $token);
        //         $contacts = Contact::where('group_id' , $compain->group_id)->get();
        //         if(count($contacts) > 0){
        //             foreach($contacts as $cont){
        //                 if($cont->number != ''){
        //                     $number = $cont->number;
        //                 }elseif($cont->number2 != ''){
        //                     $number = $cont->number2;
        //                 }elseif($cont->number3 != ''){
        //                     $number = $cont->number2;
        //                 }
        //                 $receiver_number = $number;

        //                 $sender_number = $sender_numbers->number;

        //                 if($template){
        //                     $message = $template->body;
        //                 }else{
        //                     $message = $checkCompainList[0]->body;
        //                 }

        //                 $message = str_replace("{name}", $cont->name, $message);
        //                 $message = str_replace("{street}", $cont->street, $message);
        //                 $message = str_replace("{city}", $cont->city, $message);
        //                 $message = str_replace("{state}", $cont->state, $message);
        //                 $message = str_replace("{zip}", $cont->zip, $message);


        //                 try {
        //                     $sms_sent = $client->messages->create(
        //                         $receiver_number,
        //                         [
        //                             'from' => $sender_number,
        //                             'body' => $message,
        //                         ]
        //                     );

        //                     if ($sms_sent) {

        //                         $old_sms = Sms::where('client_number', $receiver_number)->first();
        //                         if ($old_sms == null) {
        //                             $sms = new Sms();
        //                             $sms->client_number = $receiver_number;
        //                             $sms->twilio_number = $sender_number;
        //                             $sms->message = $message;
        //                             $sms->media = '';
        //                             $sms->status = 1;
        //                             $sms->save();
        //                             $this->incrementSmsCount($sender_number);
        //                         } else {
        //                             $reply_message = new Reply();
        //                             $reply_message->sms_id = $old_sms->id;
        //                             $reply_message->to = $sender_number;
        //                             $reply_message->from = $receiver_number;
        //                             $reply_message->reply = $message;
        //                             $reply_message->system_reply = 1;
        //                             $reply_message->save();
        //                             $this->incrementSmsCount($sender_number);
        //                         }

        //                     }
        //                 } catch (\Exception $ex) {
        //                     //echo $ex;
        //                     //die("here");
        //                     $failed_sms = new FailedSms();
        //                     $failed_sms->client_number = $receiver_number;
        //                     $failed_sms->twilio_number = $sender_number;
        //                     $failed_sms->message = $message;
        //                     $failed_sms->media = '';
        //                     $failed_sms->error = $ex->getMessage();
        //                     $failed_sms->save();
        //                 }
        //             }
        //         }
        //     }elseif($request->type[0] == 'mms'){
        //         $client = new Client($sid, $token);
        //         $contacts = Contact::where('group_id' , $compain->group_id)->get();
        //         if(count($contacts) > 0){
        //             foreach($contacts as $cont){
        //                 $receiver_number = $cont->number;
        //                 //$receiver_number = '4234606442';
        //                 $sender_number = $sender_numbers->number;
        //                 if($template){
        //                     $message = $template->body;
        //                 }else{
        //                     $message = $checkCompainList->body;
        //                 }
        //                 $message = str_replace("{name}", $cont->name, $message);
        //                 $message = str_replace("{street}", $cont->street, $message);
        //                 $message = str_replace("{city}", $cont->city, $message);
        //                 $message = str_replace("{state}", $cont->state, $message);
        //                 $message = str_replace("{zip}", $cont->zip, $message);
        //                 if($template){
        //                     $mediaUrl = $template->mediaUrl;
        //                 }else{
        //                     $mediaUrl = $checkCompainList->mediaUrl;
        //                 }
        //                 try {
        //                     $sms_sent = $client->messages->create(
        //                         $receiver_number,
        //                         [
        //                             'from' => $sender_number,
        //                             'body' => $message,
        //                             'mediaUrl' => [$mediaUrl],
        //                         ]
        //                     );
        //                     //dd($sms_sent);
        //                     if ($sms_sent) {
        //                         $old_sms = Sms::where('client_number', $receiver_number)->first();
        //                         if ($old_sms == null) {
        //                             $sms = new Sms();
        //                             $sms->client_number = $receiver_number;
        //                             $sms->twilio_number = $sender_number;
        //                             $sms->message = $message;
        //                             $sms->media = $mediaUrl == null ? 'No' : $mediaUrl;
        //                             $sms->status = 1;
        //                             $sms->save();
        //                            // $this->incrementSmsCount($sender_number);
        //                         } else {
        //                             $reply_message = new Reply();
        //                             $reply_message->sms_id = $old_sms->id;
        //                             $reply_message->to = $sender_number;
        //                             $reply_message->from = $receiver_number;
        //                             $reply_message->reply = $message;
        //                             $reply_message->system_reply = 1;
        //                             $reply_message->save();
        //                             $this->incrementSmsCount($sender_number);
        //                         }

        //                     }
        //                 } catch (\Exception $ex) {
        //                     $failed_sms = new FailedSms();
        //                     $failed_sms->client_number = $receiver_number;
        //                     $failed_sms->twilio_number = $sender_number;
        //                     $failed_sms->message = $message;
        //                     $failed_sms->media = $mediaUrl == null ? 'No' : $mediaUrl;
        //                     $failed_sms->error = $ex->getMessage();
        //                     $failed_sms->save();
        //                 }
        //             }
        //         }
        //     }elseif($request->type == 'rvm'){
        //         $contactsArr = [];
        //         $contacts = Contact::where('group_id' , $compain->group_id)->get();
        //         if(count($contacts) > 0){
        //             foreach($contacts as $cont){
        //                 $contactsArr[] = $cont->number;
        //             }
        //         }
        //         if(count($contactsArr) > 0){
        //             try {
        //                 if($template){
        //                     $message = $template->body;
        //                 }else{
        //                     $message = $checkCompainList->body;
        //                 }
        //                 $c_phones = implode(',',$contactsArr);
        //                 //$c_phones = '3128692422';
        //                 $vrm = \Slybroadcast::sendVoiceMail([
        //                                     'c_phone' => ".$c_phones.",
        //                                     'c_url' =>$message,
        //                                     'c_record_audio' => '',
        //                                     'c_date' => 'now',
        //                                     'c_audio' => 'Mp3',
        //                                     //'c_callerID' => "4234606442",
        //                                     'c_callerID' => $sender_numbers->number,
        //                                     //'mobile_only' => 1,
        //                                     'c_dispo_url' => 'https://brian-bagnall.com/bulk/bulksms/public/voicepostback'
        //                                    ])->getResponse();
        //             }catch (\Exception $ex) {

        //             }
        //         }

        //     }
        //     // $campaign->active = $request->active; // Update active
        //     $checkCompainList1 = CampaignList::where('campaign_id',$request->campaign_id)->first();
        //     $campaigns = CampaignList::where('id' , $checkCompainList1->id)->update(['updated_at' => date('Y-m-d H:i:s') , 'active' => 0]);
        // }
        //COMMENTED ON - 8 Oct 2023 by JSingh

        //return $request->campaign_id;
        return redirect('admin/campaign/list/' . $request->campaign_id)->with('success', 'Campaign list created successfully.');
    }

    public function show(CampaignList $campaignList)
    {
        return view('back.pages.campaign.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('back.pages.campaign.edit', compact('campaign'));
    }

    public function update(Request $request, CampaignList $campaignlist)
    {
        //dd($campaignlist);
        $request->validate([
            //'name' => 'required|string|max:255',
            'type' => 'required|in:email,sms,mms,rvm',
            'send_after_days' => 'nullable|integer|min:0',
            'send_after_hours' => 'nullable|integer|min:0',
            //'group_id' => 'required|exists:groups,id', // Ensure group_id exists in the groups table
            'active' => 'required|boolean', // Add validation for active status
            // Add other validation rules for campaign details
        ]);

        // Calculate the send_after time
        $sendAfter = null;
        if ($request->send_after_days !== null && $request->send_after_hours !== null) {
            $sendAfter = now()->addDays($request->send_after_days)->addHours($request->send_after_hours);
        }
        //return $sendAfter;
        // Update the campaign
        CampaignList::where('id', $request->id)->update([
            'type' => $request->type,
            'send_after_days' => $request->send_after_days,
            'send_after_hours' => $request->send_after_hours,
            'schedule' => $sendAfter,
            'template_id' => $request->template_id,
            'active' => $request->active, // Set active status
            // Add other fields for campaign details
        ]);

        return redirect()->route('admin.campaign.show', $request->campaign_id)->with('success', 'Campaign list updated successfully.');
    }

    public function destroy(CampaignList $campaignlist)
    {
        //dd($campaignlist);
        $campaignlist->delete();
        return redirect()->route('admin.campaign.show', $campaignlist->campaign_id)->with('success', 'Campaign list deleted successfully.');
    }
    public function listCampeign(Group $group, Request $request)
    {
        $sr = 1;
        if ($request->wantsJson()) {
            $contacts = Contact::where("group_id", $group->id)->where("is_dnc", 0)->get();
            return response()->json([
                'data' => $contacts,
                'success' => true,
                'status' => 200,
                'message' => 'OK'
            ]);
        } else {
            return view('back.pages.campaignlist.details', compact('group', 'sr'));
        }
    }

    public function getTemplate($type = '', $count = '')
    {
        $files = RvmFile::all();
        return view('back.pages.campaign.ajaxTemplate', compact('type', 'files', 'count'));
    }
}
