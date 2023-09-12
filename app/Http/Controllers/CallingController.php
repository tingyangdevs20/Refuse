<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Model\Account;
use App\Model\Blacklist;
use App\Model\Category;
use App\Model\Contact;
use App\Model\FailedSms;
use App\Model\Group;
use App\Model\Number;
use App\Model\Reply;
use App\Model\Sms;
use App\Model\Template;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Twilio\Rest\Client;

class CallingController extends Controller
{
    public function index()
    {
        return view('phoneCall.call_view');
    }
 
    public function make_call(Request $request){
       
        $twilioPhoneNumber = "+14234609555";
        $toPhoneNumber = $request->input('to_phone_number'); // Get the destination phone number from the request

        $client = new Client("AC28c9cf33623247a487bf51ca9af20b50","f569ce3698eafb02c536cae226d01fe3");

        $call = $client->calls
        ->create($toPhoneNumber, // to
                $twilioPhoneNumber, // from
                // ["url" => "http://demo.twilio.com/docs/voice.xml"]
                ["twiml" => "<Response><Say>Hello world how are you . Am i audible to you</Say></Response>"]
        );

        print($call->sid);
    }
}
