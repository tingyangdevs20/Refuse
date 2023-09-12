<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Mail\TestEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use DB;

class RvmController extends Controller
{
    public function sendrvm()
    {
        //return 'rvm test';
        
        $vrm = \Slybroadcast::sendVoiceMail([
                                'c_phone' => "4234606433",
                                'c_url' =>"https://s3-ap-southeast-1.amazonaws.com/exotelrecordings/oxygentimes1/fb46a88602c47186874fabc4a2f2176a.mp3",
                                'c_record_audio' => '',
                                'c_date' => 'now',
                                'c_audio' => 'Mp3',
                                //'c_callerID' => "4234606442",
                                'c_callerID' => "13124673501",
                                //'mobile_only' => 1,
                                'c_dispo_url' => 'https://brian-bagnall.com/bulk/bulksms/public/admin/voicepostback'
                               ])->getResponse();
                               
                               dd($vrm);
        //\Slybroadcast::pause($session_id)->getResponse();
        
        //\Slybroadcast::resume($session_id)->getResponse();
         
        $balance = \Slybroadcast::accountMessageBalance()->getResponse();
        //dd($balance);
        $files = \Slybroadcast::listAudioFiles()->getResponse();
        dd($files);
        // if you wana user different credentials for api call
        //\Slybroadcast::setCredentials($user_email,$password); 
        return '111111';
    }
    
    public function voicepostback(Request $request){
        DB::table('test')->insert(['name' => $_POST['var']]);
        Log::info("RVM Responce ".$_POST['var']);
    }
}