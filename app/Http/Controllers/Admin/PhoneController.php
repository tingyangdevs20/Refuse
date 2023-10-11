<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\Market;
use App\Model\Number;
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
        // dd( $activeNumbers);
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
            
            $phn_num = $activeNumber->phoneNumber;
            $phone_number = Number::where('number', $phn_num)->first();
            $account = Account::first();
            $market = Market::first();
            
            if(!$phone_number)
            {
                $capabilitiesString = [];
                
                foreach ($activeNumber->capabilities as $capability => $value) {
                    if($value) {

                        $capabilitiesString[] = "$capability = true ";
                    }else{
                        $capabilitiesString[] = "$capability = false ";

                    }
                }
                $phn_nums = new Number();
                $phn_nums->number= $phn_num;
                $phn_nums->sid= $activeNumber->sid;
                $phn_nums->capabilities= json_encode($capabilitiesString);
                $phn_nums->a2p_compliance= $activeNumber->capabilities["sms"];
                $phn_nums->sms_allowed = Settings::first()->sms_allowed;
                $phn_nums->account_id = $account->id;
                $phn_nums->market_id=$market->id;
                $phn_nums->save();
            }
        }
      // var_dump($numbers);
      // print_r($numbers[0]->number);

       
       //die(".");
       $all_phone_nums=Number::all();
        return view('back.pages.phone.index', compact('all_phone_nums'));
    }
    public function changeStatus(Request $request)
    {
        $phn = Number::find($request->phn_id); 
        $phn->is_active = $request->sts; 
        $phn->save(); 
        return response()->json(['success'=>'Status changed successfully.']); 
    }
}
