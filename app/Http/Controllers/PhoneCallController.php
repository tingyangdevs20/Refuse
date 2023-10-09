<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VoiceGrant;
use Twilio\TwiML\VoiceResponse;
use App\Model\Settings;
use App\Model\Number;

 
class PhoneCallController extends Controller
{
    public function index()
    {
        $settings = Settings::first()->toArray(); 
        $twilio_number=Number::first()->toArray();
        return view('phoneCall.call_view');
    }

    public function getAccessToken(Request $request){
        $settings = Settings::first()->toArray(); 
        
        $TWILIO_ACCOUNT_SID = 'AC28c9cf33623247a487bf51ca9af20b50';
        $TWILIO_API_SECRET = 'Tl2HBCvYyM3Cok2nZF24m2iraSUGk1IE';
        $TWILIO_API_KEY = 'SK425464914ef14c872c7646fd4a8bf990';
        $TWIML_APP_SID = 'APdeee523d0cc61d907533530460b34197';
 
       
        $TWILIO_ACCOUNT_SID = $settings['twilio_api_key'];
        $TWILIO_API_SECRET = $settings['call_secret_token'];
        $TWILIO_API_KEY = $settings['call_api_key'];
        $TWIML_APP_SID = $settings['twiml_app_sid'];

        $twilio_number=Number::first()->toArray();
        $caller_id=$twilio_number['number'];
        
        
        $identity=$request['identity'];

        if($identity != "")
        {
          
            $access_token= new AccessToken(
                $TWILIO_ACCOUNT_SID,
                $TWILIO_API_KEY,
                $TWILIO_API_SECRET,
                3600,
                $identity
            );

            //grant voice permisssions
            $voiceGrant=new VoiceGrant();
            $voiceGrant->setOutgoingApplicationSid($TWILIO_TWIML_APP_SID);

            $voiceGrant->setIncomingAllow(true);

            $access_token->addGrant($voiceGrant);


            $token = $access_token->toJWT();

            return response()->json([
                "identity"  => $identity,
                "token"     => $token,
                "caller_id" =>$caller_id
            ]);
        }
        else
            return false;
    }

    public function handleCallRouting(Request $request){

        $requestData = json_encode($request->all());

       
       // $filePath = 'C:\xampp\htdocs\bulk_sms\app\Http\Notepad.txt';

        // Open the file for writing (create if it doesn't exist)
       // $file = fopen($filePath, 'w');

        // Write the request data to the file
      //  fwrite($file, $requestData);

        // Close the file
       // fclose($file);

        
        $dialedNumber = $request->get('To') ?? null;
        
      
        $voiceResponse = new VoiceResponse();
        $voiceResponse->say("Calling Now Please Wait");

        if($dialedNumber != env('TWILIO_CALLER_ID'))
        {
            #outbond phone call

            $number=htmlspecialchars($dialedNumber);
            $dial=$voiceResponse->dial('',['callerId'=>env('TWILIO_CALLER_ID')]);

            if(preg_match("/^[\d+\-\(\) ]+$/",$number)){
                #standard outbond phone call to telephpone number
                $dial->number($dialedNumber);
            }
           else{
                #client to client (user - user ) Phone call

           }
       }
        elseif($dialedNumber == env('TWILIO_CALLER_ID')){
            #inboud Phone call

            //setup an dial response
            $dial= $voiceResponse->dial('');

            $dial->client('Mathew_james');

        }else{
            $voiceResponse->say("Thanku For calling us");
        }
        return (string) $voiceResponse;
    }
}
