<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VoiceGrant;
use Twilio\TwiML\VoiceResponse;




use App\Model\Settings;


class VoiceController extends Controller
{

    public function handleIncomingCall(Request $request)
    {
        $phone = $request->get('To');
        $settings = Settings::first()->toArray();
        // $callerId = $settings['call_forward_number'];
        $callerId = '+14234609555';
        $response = new VoiceResponse();
        if ($phone == $callerId) {
            # Receiving an incoming call to the browser from an external phone
            $dial = $response->dial($phone);
            $dial->client('bulk-sms');
        } else if (!empty($phone) && strlen($phone) > 0) {
            $number = htmlspecialchars($phone);
            $dial = $response->dial('', ['callerId' => $callerId]);

            // Only include the necessary elements in the TwiML
            if (preg_match("/^[\d\+\-\(\) ]+$/", $number)) {
                $dial->number($number, ['token' => $this->generateAccessTokenforIncomingCall()]);
            } else {
                $dial->client($number);
            }
        } else {
            $response->say("Thanks for calling!");
        }

        // Return the TwiML response without additional content
        return response($response)->header('Content-Type', 'application/xml');
    }


    public function generateAccessToken(Request $request)
    {

        $settings = Settings::first()->toArray();


        //old account 

        //$TWILIO_ACCOUNT_SID = 'ACa068bcfb703b21e18077f86851761d44';
        // $TWILIO_SECRET_KEY = 'ev637SpAE8pP16xKI8wkuToVGrDtlkwt';
        // $API_KEY = 'SKe98914905647ed119d608121a51534db';
        // $TWIML_APP_SID = 'AP9150882055bff4025c1f7c6d94925d7d';


        //new account 

        $TWILIO_ACCOUNT_SID = 'ACa068bcfb703b21e18077f86851761d44';
        $TWILIO_SECRET_KEY = 'ev637SpAE8pP16xKI8wkuToVGrDtlkwt';
        $API_KEY = 'SKe98914905647ed119d608121a51534db';
        $TWIML_APP_SID = 'AP9150882055bff4025c1f7c6d94925d7d';

        $accessToken = new AccessToken($TWILIO_ACCOUNT_SID, $API_KEY, $TWILIO_SECRET_KEY, 3600, 'bulk-sms');


        $voiceGrant = new VoiceGrant();
        $voiceGrant->setOutgoingApplicationSid($TWIML_APP_SID);
        $voiceGrant->setIncomingAllow(true);
        $accessToken->addGrant($voiceGrant);

        $token = $accessToken->toJWT();
        return response()->json(['token' => $token]);
    }

    public function generateAccessTokenforIncomingCall()
    {

        $settings = Settings::first()->toArray();


        //old account 

        //$TWILIO_ACCOUNT_SID = 'ACa068bcfb703b21e18077f86851761d44';
        // $TWILIO_SECRET_KEY = 'ev637SpAE8pP16xKI8wkuToVGrDtlkwt';
        // $API_KEY = 'SKe98914905647ed119d608121a51534db';
        // $TWIML_APP_SID = 'AP9150882055bff4025c1f7c6d94925d7d';


        //new account 

        $TWILIO_ACCOUNT_SID = 'ACa068bcfb703b21e18077f86851761d44';
        $TWILIO_SECRET_KEY = 'ev637SpAE8pP16xKI8wkuToVGrDtlkwt';
        $API_KEY = 'SKe98914905647ed119d608121a51534db';
        $TWIML_APP_SID = 'AP9150882055bff4025c1f7c6d94925d7d';

        $accessToken = new AccessToken($TWILIO_ACCOUNT_SID, $API_KEY, $TWILIO_SECRET_KEY, 3600, 'bulk-sms');


        $voiceGrant = new VoiceGrant();
        $voiceGrant->setOutgoingApplicationSid($TWIML_APP_SID);
        $voiceGrant->setIncomingAllow(true);
        $accessToken->addGrant($voiceGrant);

        $token = $accessToken->toJWT();
        return $token;
    }
}
