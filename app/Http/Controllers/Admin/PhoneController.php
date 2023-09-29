<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Phone;
use App\Model\Settings;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

class PhoneController extends Controller
{
    private $client = null;
    public function __construct() {
        $settings = Settings::first()->toArray(); 
        
        
        $sid = $settings['twilio_api_key'];
        
        $token = $settings['twilio_acc_secret'];
       
        $this->client = new Client($sid, $token);
    }
    public function index(){
        $context = $this->client->getAccount();
        $activeNumbers = $context->incomingPhoneNumbers;
        
        $activeNumberArray = $activeNumbers->read();
        //print_r($activeNumberArray);
        //die("...");
        $numbers = [];
        foreach($activeNumberArray as $activeNumber) {
            error_log('active number = '.$activeNumber->phoneNumber);
            $numbers[] = (object)[
                'number' => $activeNumber->phoneNumber,
                'name' => $activeNumber->friendlyName,
                'sid' => $activeNumber->sid,
                'capabilities' => $activeNumber->capabilities,
            ];

            $phn_num=$activeNumber->phoneNumber;
            $phone_number = Phone::where('number', $phn_num)->first();
            if(!$phone_number)
            {
                $phn_nums = new Phone();
                $phn_nums->number= $phn_num;
                $phn_nums->sid= $activeNumber->sid;
                $phn_nums->capabilities= $activeNumber->capabilities;
                $phn_nums->save();

            }
       }
      // var_dump($numbers);
      // print_r($numbers[0]->number);

       
       //die(".");
       $all_phone_nums=Phone::all();
        return view('back.pages.phone.index', compact('all_phone_nums'));
    }
    public function changeStatus(Request $request)
    {
        $phn = Phone::find($request->phn_id); 
        $phn->is_active = $request->sts; 
        $product->save(); 
        return response()->json(['success'=>'Status changed successfully.']); 
    }
}
