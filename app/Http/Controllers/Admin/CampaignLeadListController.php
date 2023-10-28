<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CampaignLead;
use App\Mail\TestEmail;
use App\Model\CampaignList;
use Illuminate\Support\Facades\Mail;
use App\Model\Group;
use App\Model\Number;
use App\Model\CampaignLeadList;
use App\Model\Campaign;
use App\Model\Contact;
use App\Model\Account;
use App\Model\Template;
use App\Model\Reply;
use App\Model\Sms;
use App\Model\RvmFile;
use App\Model\FailedSms;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CampaignLeadListController extends Controller
{
    public function index()
    {
        $groups = Group::all(); // Fetch groups from the database
        $campaigns = CampaignLead::getAllCampaigns();
        $templates = Template::where('type' , 'SMS')->get();
        
        return view('back.pages.campaignlist.index', compact('groups', 'campaigns','templates'));
    }

    public function compaignList($id = '')
    {
        $numbers = Number::all();
        $templates = Template::all();
        $files = RvmFile::all();
        $campaignsList = CampaignLeadList::where('campaign_id' , $id)->orderby('schedule', 'ASC')->get();
        $campaign_name=CampaignLead::where('id', $id)->first();
        return view('back.pages.campaignleads.indexList', compact('numbers', 'templates','campaignsList','id','files','campaign_name'));
    }
    
    public function schedual()
    {
        $currentTime = date('Y-m-d H:i:s');
        //$scheduleTime = '2023-08-21 07:43:02';
        $campaigns = CampaignLead::where('active' , 1)->get();
        //dd($campaigns);
        if(count($campaigns) > 0){
            foreach($campaigns as $key1 => $camp){
                $campaignsList = CampaignLeadList::where('campaign_id' , $camp->id)->where('active' , 1)->orderby('schedule', 'ASC')->get();
                //dd($campaignsList);
                if(count($campaignsList) > 0){
                    foreach($campaignsList as $key => $row){
                        $schedule = date('Y-m-d H:i:s' , strtotime($row->schedule));
                        if($schedule <= $currentTime){
                            $account = Account::first();
                            if($account){
                                $sid = $account->account_id;
                                $token = $account->account_token;
                            }else{
                                $sid = '';
                                $token = '';
                            }
                            $template = Template::where('id',$row->template_id)->first();
                            if($row->type == 'email'){
                                //return '333333';
                                $contacts = Contact::where('group_id' , $camp->group_id)->where('is_email',1)->get();
                                //dd($contacts);
                                if(count($contacts) > 0){
                                    foreach($contacts as $cont){
                                        
                                        //return $cont->name;
                                        if($cont->email1 != ''){
                                            $email = $cont->email1;
                                        }elseif($cont->email2){
                                            $email = $cont->email2;
                                        }
                                        //return $email;
                                        if($email != ''){
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
                                            $unsub_link = url('admin/email/unsub/'.$email);
                                            $data = ['message' => $message,'subject' => $subject, 'name' =>$cont->name, 'unsub_link' =>$unsub_link];
                                            Mail::to($cont->email1)->send(new TestEmail($data));
                                            //Mail::to('rizwangill132@gmail.com')->send(new TestEmail($data));
                                        }
                                        
                                    }
                                }
                                 
                            }elseif($row->type == 'sms'){
                                $client = new Client($sid, $token);
                                $contacts = Contact::where('group_id' , $camp->group_id)->get();
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
                                        $sender_number = '+14234609555';
                                        $message = $template->body;
                                        $message = str_replace("{name}", $cont->name, $message);
                                        $message = str_replace("{street}", $cont->street, $message);
                                        $message = str_replace("{city}", $cont->city, $message);
                                        $message = str_replace("{state}", $cont->state, $message);
                                        $message = str_replace("{zip}", $cont->zip, $message);
                                        if($receiver_number != ''){
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
                            }elseif($row->type == 'mms'){
                                $client = new Client($sid, $token);
                                $contacts = Contact::where('group_id' , $camp->group_id)->get();
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
                                        $sender_number = '+14234609555';
                                        $message = $template->body;
                                        $message = str_replace("{name}", $cont->name, $message);
                                        $message = str_replace("{street}", $cont->street, $message);
                                        $message = str_replace("{city}", $cont->city, $message);
                                        $message = str_replace("{state}", $cont->state, $message);
                                        $message = str_replace("{zip}", $cont->zip, $message);
                                        if($receiver_number != ''){
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
                            }elseif($row->type == 'rvm'){
                                $contactsArr = [];
                                $contacts = Contact::where('group_id' , $camp->group_id)->get();
                                if(count($contacts) > 0){
                                    foreach($contacts as $cont){
                                        if($cont->number != ''){
                                            $number = $cont->number;
                                        }elseif($cont->number2 != ''){
                                            $number = $cont->number2;
                                        }elseif($cont->number3 != ''){
                                            $number = $cont->number2;
                                        }
                                        $contactsArr[] = $number;
                                    }
                                }
                                if(count($contactsArr) > 0){
                                    $c_phones = implode(',',$contactsArr);
                                    $vrm = \Slybroadcast::sendVoiceMail([
                                                        'c_phone' => ".$c_phones.",
                                                        'c_url' =>$template->body,
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
                            $campaigns = CampaignLeadList::where('id' , $row->id)->update(['updated_at' => date('Y-m-d H:i:s') , 'active' => 0]);
                            break;
                        }else{
                            //return '3333333';
                            if($key == 0){
                                $campaignsCheck = CampaignLeadList::where('active' , 0)->orderby('updated_at', 'desc')->first();
                                if($campaignsCheck){
                                    $scheduledate = date('Y-m-d H:i:s' , strtotime($campaignsCheck->schedule));
                                    $sendAfter = null;
                                    //return (int) $campaignsCheck->send_after_days;
                                    //$sendAfter = Carbon::parse($scheduledate)->addDays($row->send_after_days)->addHours($row->send_after_hours);
                                    $sendAfter = now()->addDays($row->send_after_days)->addHours($row->send_after_hours);
                                    $campaigns = CampaignLeadList::where('id' , $row->id)->update(['schedule' => $sendAfter]);
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
        dd($request);
        $types = $request->type;
        $campaign_id=$request->camp_id;
        $subject='';
        $media="";

       

                $sendAfter = null;
                if ($request->send_after_days !== null && $request->send_after_hours !== null) {
                    $sendAfter = now()->addDays($request->send_after_days)->addHours($request->send_after_hours);
                }
                if ($types == 'rvm') 
                {
                    $media = $request->rvm;
                   
                    
                } 
                if ($types == 'mms') 
                {
                    $media = $request->media_file_mms;
                    
                } 
                if ($types == 'email') 
                {
                    $subject = $request->subject;
                   
                    
                } 
               

                
              
                    CampaignLeadList::create([
                        'campaign_id' => $campaign_id,
                        'type' => $types,
                        'send_after_days' => $request->send_after_days,
                        'send_after_hours' => $request->send_after_hours,
                        'schedule' => $sendAfter,
                        'mediaUrl' => $media,
                        'template_id' => null,
                        'subject' => $request->subject,
                        'body' => $request->body,
                        'active' => 1, // Set active status
                    ]);
                
               
                 
            
        
       
    
 
        
        //return $request->campaign_id;
        return redirect('admin/compaignlead/list/'.$campaign_id)->with('success', 'Campaign list created successfully.');
    }

    public function show(CampaignList $campaignList)
    {
        return view('back.pages.campaign.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('back.pages.campaign.edit', compact('campaign'));
    }

    public function update(Request $request)
    {

       
        $types = $request->type;
        $id=$request->cid;
        $subject='';
        $media="";

       

                $sendAfter = null;
                if ($request->send_after_days !== null && $request->send_after_hours !== null) {
                    $sendAfter = now()->addDays($request->send_after_days)->addHours($request->send_after_hours);
                }
                if ($types == 'rvm') 
                {
                    $media = $request->rvm;
                   
                    
                } 
                if ($types == 'mms') 
                {
                    $media = $request->media_file_mms;
                    
                } 
                if ($types == 'email') 
                {
                    $subject = $request->subject;
                   
                    
                } 

        // Update the campaign
        CampaignLeadList::where('id' ,$request->cid )->update([
            'type' => $request->type,
            'send_after_days' => $request->send_after_days,
            'send_after_hours' => $request->send_after_hours,
            'schedule' => $sendAfter,
            'mediaUrl' => $media,
            'template_id' => null,
            'subject' => $subject,
            'body' => $request->body,
            'active' => 1, // Set active status
        ]);
    
        return redirect()->back();
    }

    public function destroy(CampaignList $campaignlist)
    {
        //dd($campaignlist);
        $campaignlist->delete();
        return redirect()->route('admin.campaign.show',$campaignlist->campaign_id)->with('success', 'Campaign list deleted successfully.');
    }

    public function remove(Request $request)
    {
       // dd($request);
        CampaignLeadList::where('id',$request->id)->delete();
        return redirect()->back();
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

    public function getTemplate($type = '' , $count = ''){
        $files = RvmFile::all();
        return view('back.pages.campaignleads.ajaxTemplate', compact('type','files','count'));
    }
}
