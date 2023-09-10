<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Campaign;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use App\Model\Group;
use App\Model\Number;
use App\Model\Contact;
use App\Model\Account;
use App\Model\Template;
use App\Model\CampaignList;
use App\Model\Reply;
use App\Model\Sms;
use App\Model\FailedSms;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class CampeignSchedual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campeignschedual:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to reset numbers counter daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //DB::table('test')->insert(['name' => 'SMS','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        $currentTime = date('Y-m-d H:i:s');
        //$scheduleTime = '2023-08-21 07:43:02';
        $campaigns = Campaign::where('active' , 1)->get();
        $count = 0;
        //dd($campaigns);
        if(count($campaigns) > 0){
            foreach($campaigns as $key1 => $camp){
                $campaignsList = CampaignList::where('campaign_id' , $camp->id)->where('active' , 1)->orderby('schedule', 'ASC')->get();
                //dd($campaignsList);
                if(count($campaignsList) > 0){
                    
                    foreach($campaignsList as $key => $row){
                        $schedule = date('Y-m-d H:i:s' , strtotime($row->schedule));
                        if($schedule <= $currentTime){
                            DB::table('test')->insert(['name' => 'Match','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            $groupsID = Group::where('id',$camp->group_id)->first();
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
                                            if($template){
                                                $subject = $template->subject;
                                            }else{
                                                $subject = $row->subject;
                                            }
                                            $subject = str_replace("{name}", $cont->name, $subject);
                                            $subject = str_replace("{street}", $cont->street, $subject);
                                            $subject = str_replace("{city}", $cont->city, $subject);
                                            $subject = str_replace("{state}", $cont->state, $subject);
                                            $subject = str_replace("{zip}", $cont->zip, $subject);
                                            if($template){
                                                $message = $template->body;
                                            }else{
                                                $message = $row->body;
                                            }
                                            $message = str_replace("{name}", $cont->name, $message);
                                            $message = str_replace("{street}", $cont->street, $message);
                                            $message = str_replace("{city}", $cont->city, $message);
                                            $message = str_replace("{state}", $cont->state, $message);
                                            $message = str_replace("{zip}", $cont->zip, $message);
                                            $unsub_link = url('admin/email/unsub/'.$email);
                                            $data = ['message' => $message,'subject' => $subject, 'name' =>$cont->name, 'unsub_link' =>$unsub_link];
                                            Mail::to($email)->send(new TestEmail($data));
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
                                        $sender_number = $sender_numbers->number;
                                        if($template){
                                            $message = $template->body;
                                        }else{
                                            $message = $row->body;
                                        }
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
                                        $sender_number = $sender_numbers->number;
                                        if($template){
                                            $message = $template->body;
                                        }else{
                                            $message = $row->body;
                                        }
                                        $message = str_replace("{name}", $cont->name, $message);
                                        $message = str_replace("{street}", $cont->street, $message);
                                        $message = str_replace("{city}", $cont->city, $message);
                                        $message = str_replace("{state}", $cont->state, $message);
                                        $message = str_replace("{zip}", $cont->zip, $message);
                                        if($template){
                                            $mediaUrl = $template->mediaUrl;
                                        }else{
                                            $mediaUrl = $row->mediaUrl;
                                        }
                                        if($receiver_number != ''){
                                            try {
                                                $sms_sent = $client->messages->create(
                                                    $receiver_number,
                                                    [
                                                        'from' => $sender_number,
                                                        'body' => $message,
                                                        'mediaUrl' => [$mediaUrl],
                                                    ]
                                                );
                                                
                                                if ($sms_sent) {
                                                    $old_sms = Sms::where('client_number', $receiver_number)->first();
                                                    if ($old_sms == null) {
                                                        $sms = new Sms();
                                                        $sms->client_number = $receiver_number;
                                                        $sms->twilio_number = $sender_number;
                                                        $sms->message = $message;
                                                        $sms->media = $mediaUrl;
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
                                                $failed_sms->media = $mediaUrl;
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
                                    if($template){
                                        $mediaUrl = $template->body;
                                    }else{
                                        $mediaUrl = $row->body;
                                    }
                                    $c_phones = implode(',',$contactsArr);
                                    $vrm = \Slybroadcast::sendVoiceMail([
                                                        'c_phone' => ".$c_phones.",
                                                        'c_url' =>$mediaUrl,
                                                        'c_record_audio' => '',
                                                        'c_date' => 'now',
                                                        'c_audio' => 'Mp3',
                                                        //'c_callerID' => "3124673501",
                                                        'c_callerID' => $sender_numbers->number,
                                                        //'mobile_only' => 1,
                                                        'c_dispo_url' => 'https://brian-bagnall.com/bulk/bulksms/public/admin/voicepostback'
                                                       ])->getResponse();
                                }
                                
                            }
                            $campaigns = CampaignList::where('id' , $row->id)->update(['updated_at' => date('Y-m-d H:i:s') , 'active' => 0]);
                            break;
                        }else{
                            //return '3333333';
                            if($count == 0){
                                
                                $campaignsCheck = CampaignList::where('active' , 0)->orderby('updated_at', 'desc')->first();
                                if($campaignsCheck){
                                    $scheduledate = date('Y-m-d H:i:s' , strtotime($campaignsCheck->schedule));
                                    $sendAfter = null;
                                    //return (int) $campaignsCheck->send_after_days;
                                    $sendAfter = Carbon::parse($scheduledate)->addDays($row->send_after_days)->addHours($row->send_after_hours);
                                    //$sendAfter = now()->addDays($row->send_after_days)->addHours($row->send_after_hours);
                                    DB::table('test')->insert(['name' => 'Update','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'),'schedule'=>$sendAfter]);
                                    $campaigns = CampaignList::where('id' , $row->id)->update(['schedule' => $sendAfter]);
                                    $count++;
                                }
                            }
                        }
                    }
                }
                
            }
        }
    }
}
