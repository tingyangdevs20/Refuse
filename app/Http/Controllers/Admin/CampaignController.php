<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Campaign;
use App\Mail\TestEmail;
use App\Model\CampaignList;
use Illuminate\Support\Facades\Mail;
use App\Model\Group;
use App\Model\Number;
use App\Model\Contact;
use App\Model\Account;
use App\Model\Template;
use App\Model\FailedSms;
use App\Model\Reply;
use App\Model\Sms;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class CampaignController extends Controller
{
    public function index()
    {
        $groups = Group::all(); // Fetch groups from the database
        $campaigns = Campaign::getAllCampaigns();
        $templates = Template::where('type' , 'SMS')->get();
        return view('back.pages.campaign.index', compact('groups', 'campaigns','templates'));
    }
    public function changeStatus(Request $request)
    {
        
        $id=$request->id;
        $camp = Campaign::where('id' , $id)->first();
        $camp->active = $request->sts; 
        
        $camp->save(); 
        return response()->json(['success'=>'Status changed successfully.']); 
    }

    public function copy($id = ''){
        $campaigns = Campaign::where('id' , $id)->first();
        if($campaigns){
            $compaignRes = Campaign::create([
                'name' => $campaigns->name,
                'group_id' => $campaigns->group_id,
                'active' => $campaigns->active,
            ]);
            $campaign_id = $compaignRes->id;
            $checkCompainList = CampaignList::where('campaign_id',$id)->get();
            if(count($checkCompainList) > 0){
                foreach($checkCompainList as $compaign){
                    $insertData = array(
                        "campaign_id" => $campaign_id,
                        "type" => $compaign->type,
                        "send_after_days" => $compaign->send_after_days,
                        "send_after_hours" => $compaign->send_after_hours,
                        "body" => $compaign->body,
                        "subject" => $compaign->subject,
                        "mediaUrl" => $compaign->mediaUrl,
                        "template_id" => 0
                    );
                    $c_id = CampaignList::create($insertData);
                    $checkCompainList = CampaignList::where('campaign_id',$campaign_id)->get();
                }

            }
            $compain = Campaign::where('id' , $campaign_id)->first();
            $groupsID = Group::where('id',$compain->group_id)->first();
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
            $checkCompainList = CampaignList::where('campaign_id',$campaign_id)->orderby('schedule','ASC')->first();
            if($checkCompainList) {
                $template = Template::where('id', $checkCompainList->template_id)->first();
                if($checkCompainList->type == 'email') {
                    $contacts = Contact::where('group_id', $compain->group_id)->get();
                    if(count($contacts) > 0) {
                        foreach($contacts as $cont) {
                            //return $cont->name;
                            if($cont->email1 != '') {
                                $email = $cont->email1;
                            } elseif($cont->email2) {
                                $email = $cont->email2;
                            }
                            if($template){
                                $subject = $template->subject;
                            }else{
                                $subject = $checkCompainList->subject;
                            }
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
                            $data = ['message' => $message ,'subject' => $subject, 'name' => $cont->name, 'unsub_link' => $unsub_link];
                            Mail::to($email)->send(new TestEmail($data));
                            //Mail::to('rizwangill132@gmail.com')->send(new TestEmail($data));
                        }
                    }

                } elseif($checkCompainList->type == 'sms') {
                    $client = new Client($sid, $token);
                    $contacts = Contact::where('group_id', $compain->group_id)->get();
                    if(count($contacts) > 0) {
                        foreach($contacts as $cont) {
                            if($cont->number != '') {
                                $number = $cont->number;
                            } elseif($cont->number2 != '') {
                                $number = $cont->number2;
                            } elseif($cont->number3 != '') {
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
                } elseif($checkCompainList->type == 'mms') {
                    $client = new Client($sid, $token);
                    $contacts = Contact::where('group_id', $compain->group_id)->get();
                    if(count($contacts) > 0) {
                        foreach($contacts as $cont) {
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
                } elseif($checkCompainList->type == 'rvm') {
                    $contactsArr = [];
                    $contacts = Contact::where('group_id', $compain->group_id)->get();
                    if(count($contacts) > 0) {
                        foreach($contacts as $cont) {
                            $contactsArr[] = $cont->number;
                        }
                    }
                    if(count($contactsArr) > 0) {
                        try {
                            $c_phones = implode(',', $contactsArr);
                            //$c_phones = '3128692422';
                            if($template){
                                $mediaUrl = $template->mediaUrl;
                            }else{
                                $mediaUrl = $checkCompainList->mediaUrl;
                            }
                            $vrm = \Slybroadcast::sendVoiceMail([
                                                'c_phone' => ".$c_phones.",
                                                'c_url' => $mediaUrl,
                                                'c_record_audio' => '',
                                                'c_date' => 'now',
                                                'c_audio' => 'Mp3',
                                                //'c_callerID' => "4234606442",
                                                'c_callerID' => $sender_numbers->number,
                                                //'mobile_only' => 1,
                                                'c_dispo_url' => 'https://brian-bagnall.com/bulk/bulksms/public/voicepostback'
                                            ])->getResponse();
                        } catch (\Exception $ex) {

                        }
                    }

                }
                // $campaign->active = $request->active; // Update active
                $checkCompainList1 = CampaignList::where('campaign_id', $campaign_id)->first();
                $campaigns = CampaignList::where('id', $checkCompainList1->id)->update(['updated_at' => date('Y-m-d H:i:s') , 'active' => 0]);
            }
        }
        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign created successfully.');

    }

    public function schedual()
    {
        $currentTime = date('Y-m-d H:i:s');
        //$scheduleTime = '2023-08-21 07:43:02';
        $campaigns = Campaign::where('active' , 1)->get();
        //dd($campaigns);
        if(count($campaigns) > 0){
            foreach($campaigns as $key1 => $camp){
                $campaignsList = CampaignList::where('campaign_id' , $camp->id)->where('active' , 1)->orderby('schedule', 'ASC')->get();
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
                                $contacts = Contact::where('group_id' , $row->group_id)->where('is_email',1)->get();
                                if(count($contacts) > 0){
                                    foreach($contacts as $cont){
                                        //return $cont->name;
                                        if($cont->email1 != ''){
                                            $email = $cont->email1;
                                        }elseif($cont->email2){
                                            $email = $cont->email2;
                                        }
                                        if($email != ''){
                                            $unsub_link = url('admin/email/unsub/'.$email);
                                            $data = ['message' => $template->body,'subject' => $template->subject, 'name' =>$cont->name, 'unsub_link' =>$unsub_link];
                                            Mail::to($cont->email1)->send(new TestEmail($data));
                                            //Mail::to('rizwangill132@gmail.com')->send(new TestEmail($data));
                                        }

                                    }
                                }

                            }elseif($row->type == 'sms'){
                                $client = new Client($sid, $token);
                                $contacts = Contact::where('group_id' , $row->group_id)->get();
                                if(count($contacts) > 0){
                                    foreach($contacts as $cont){
                                        if($cont->number != ''){
                                            $number = $cont->number;
                                        }elseif($cont->number2 != ''){
                                            $number = $cont->number2;
                                        }elseif($cont->number3 != ''){
                                            $number = $cont->number2;
                                        }
                                        if($number != ''){
                                            $sms_sent = $client->messages->create(
                                                $number,
                                                [
                                                    'from' => '+14234609555',
                                                    'body' => $template->body,
                                                ]
                                            );
                                        }

                                    }
                                }
                            }elseif($row->type == 'mms'){
                                $client = new Client($sid, $token);
                                $contacts = Contact::where('group_id' , $row->group_id)->get();
                                if(count($contacts) > 0){
                                    foreach($contacts as $cont){
                                        if($cont->number != ''){
                                            $number = $cont->number;
                                        }elseif($cont->number2 != ''){
                                            $number = $cont->number2;
                                        }elseif($cont->number3 != ''){
                                            $number = $cont->number2;
                                        }
                                        if($number != ''){
                                            $sms_sent = $client->messages->create(
                                                $number,
                                                [
                                                    'from' => '+14234609555',
                                                    'body' => $template->body,
                                                    'mediaUrl' => [$template->body],
                                                ]
                                            );
                                        }
                                    }
                                }
                            }elseif($row->type == 'rvm'){
                                $contactsArr = [];
                                $contacts = Contact::where('group_id' , $row->group_id)->get();
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
                            $campaigns = CampaignList::where('id' , $row->id)->update(['updated_at' => date('Y-m-d H:i:s') , 'active' => 0]);
                            break;
                        }else{
                            if($key == 0){
                                $campaignsCheck = CampaignList::where('active' , 0)->orderby('updated_at', 'desc')->first();
                                if($campaignsCheck){
                                    $scheduledate = date('Y-m-d H:i:s' , strtotime($campaignsCheck->schedule));
                                    $sendAfter = null;
                                    //return (int) $campaignsCheck->send_after_days;
                                    //$sendAfter = Carbon::parse($scheduledate)->addDays($row->send_after_days)->addHours($row->send_after_hours);
                                    $sendAfter = now()->addDays($row->send_after_days)->addHours($row->send_after_hours);
                                    $campaigns = CampaignList::where('id' , $row->id)->update(['schedule' => $sendAfter]);
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
        $groups = Group::all();
        $request->validate([
            'name' => 'required|string|max:255',
           
            //'active' => 'required|boolean', // Add validation for active status
            // Add other validation rules for campaign details
        ]);


        // Calculate the send_after time
        $sendAfter = null;
        if ($request->send_after_days !== null && $request->send_after_hours !== null) {
            $sendAfter = now()->addDays($request->send_after_days)->addHours($request->send_after_hours);
        }

        // Create the campaign
        Campaign::create([
            'name' => $request->name,
            //'type' => $request->type,
            //'send_after_days' => $request->send_after_days,
            //'send_after_hours' => $request->send_after_hours,
            //'schedule' => $sendAfter,
           // 'group_id' => $request->group_id, // Assign group_id
            //'template_id' => $request->template_id,
            //'active' => $request->active, // Set active status
            // Add other fields for campaign details
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign created successfully.');
    }

    public function show(Campaign $campaign , Request $request)
    {
        $sr = 1;
        $campaign_id = $campaign->id;
        $groups = Group::all(); // Fetch groups from the database
        $templates = Template::where('type' , 'SMS')->get();
        if ($request->wantsJson()) {
            $campaignList = CampaignList::where("campaign_id", $campaign->id)->where("is_dnc", 0)->get();
            return response()->json([
                'data' => $campaignList,
                'success' => true,
                'status' => 200,
                'message' => 'OK'
            ]);
        } else {
            return view('back.pages.campaign.detail', compact('campaign', 'sr','templates','groups','campaign_id'));
        }
        //return view('back.pages.campaign.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('back.pages.campaign.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            //'type' => 'required|in:email,sms,mms,rvm',
            //'send_after_days' => 'nullable|integer|min:0',
            //'send_after_hours' => 'nullable|integer|min:0',
            //'group_id' => 'nullable|exists:groups,id', // Ensure group_id exists in the groups table
           // 'active' => 'required|boolean', // Add validation for active status
            // Add other validation rules for campaign details
        ]);

        // Calculate the send_after time
        $sendAfter = null;
        if ($request->send_after_days !== null && $request->send_after_hours !== null) {
            $sendAfter = now()->addDays($request->send_after_days)->addHours($request->send_after_hours);
        }
        // Update the campaign
        Campaign::where('id' , $request->id)->update([
            'name' => $request->name,
            //'type' => $request->type,
            //'group_id' => $request->group_id, // Assign group_id
           // 'active' => $request->active, // Set active status
            // Add other fields for campaign details
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Request $request)
    {
        try {
            Campaign::find($request->id)->delete();
            Alert::success('Success!', 'Campaign Removed!');
            return redirect()->back();
        }
            catch (exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
