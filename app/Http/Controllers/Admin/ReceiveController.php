<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\AutoReply;
use App\Model\AutoResponder;
use App\Model\Blacklist;
use App\Model\Contact;
use App\Model\DNC;
use App\Model\FailedSms;
use App\Model\Number;
use App\Model\Reply;
use App\Model\Settings;
use App\Model\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;



class ReceiveController extends Controller
{
    
    public function index(Request $request)
    {
       
     
      $response = new MessagingResponse();
       $response->message(
       "thiiiiiis is automatically sent."
);

echo $response;

}

    public function store(Request $request)
    {
        $blacklist = Blacklist::where('number', $request->From)->first();
        if ($blacklist) {
            exit();
        }

        $settings = Settings::first();
        $tmpKeyword = ucfirst($request->Body);
        $keyword = strtok($tmpKeyword, " ");
        $number = Sms::where('client_number', $request->From)->first();
        $old_replies = Reply::where('from', $request->From)->first();
        $autoResponderMessage = "";
        $autoResponse = false;

        // check if keyword is in dnc, if so then add to blacklist and dnc
        $dncDatabase = DNC::where('keyword', $keyword)->first();
        if ($dncDatabase) {
            $blacklist = new Blacklist();
            $blacklist->number = $request->From;
            $blacklist->save();
            $number->lead_category_id = 2;
            $number->save();
            $contact = Contact::where('number', $request->From)->first();
            if ($contact) {
                $contact->is_dnc = true;
                $contact->save();
            }
            exit();
        }

        if ($settings->auto_responder) {
            $autoResponder = AutoResponder::where('keyword', $keyword)->first();
            if ($autoResponder) {
                $autoResponse = true;
                $autoResponderMessage = $autoResponder->response;
            }
        }
        if ($settings->auto_reply) {
            $autoResponse = true;
            $autoResponderMessage = AutoReply::where('category_id', $number->template_cat_id)->first()->message;
           // print $autoResponderMessage;
           // die("auto response");
        }


        if ($number == null) // if the message is received for the first time
        {
            $sms = new Sms();
            $sms->client_number = $request->From;
            $sms->twilio_number = $request->To;
            $sms->template_cat_id = 1;
            $sms->message = $request->Body;
            $sms->lead_category_id = 3;
            $sms->media = 'No';
            $sms->status = 1;
            $sms->is_received = 1;
            $sms->is_unread = 1;
            $sms->save();
        } else {
            if ($old_replies != null) {
                $this->saveReply($number, $request); // if messaging for the first time
            } else {
                if ($autoResponse) {
                    $this->saveReply($number, $request);//person's reply

                    $auto_reply_message = new Reply(); //autoresponder's reply
                    $auto_reply_message->sms_id = $number->id;
                    $auto_reply_message->to = $request->To;
                    $auto_reply_message->from = $request->From;
                    $auto_reply_message->reply = $autoResponderMessage;
                    $auto_reply_message->system_reply = 1;
                    $auto_reply_message->save();

                    $response = new MessagingResponse();
                    $response->message($autoResponderMessage);
                    $this->incrementSmsCount($request->To);
                    print $response;

                } else {
                    $this->saveReply($number, $request);
                }
            }
        }
    }

    public function saveReply($number, Request $request): void
    {
        $reply_message = new Reply();
        $reply_message->sms_id = $number->id;
        $reply_message->to = $request->To;
        $reply_message->from = $request->From;
        $reply_message->reply = $request->Body;
        $reply_message->save();
        if ($number->lead_category_id == 1 && $number->lead_category_id != 2) {
            $number->lead_category_id = 3;
            $number->save();
        }
    }

    public function incrementSmsCount(string $number)
    {
        $number = Number::where('number', $number)->first();
        $number->sms_count++;
        $number->save();
    }
}
