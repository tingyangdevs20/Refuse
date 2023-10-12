<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CalendarSetting;
use App\Model\Number;
use App\Model\Settings;
use App\Model\Account;
use Illuminate\Http\Request;
use App\Model\AutoResponder; 
use App\Model\AutoReply;
use App\Model\Category;
use App\Model\Market;
use App\Model\RvmFile;
use Twilio\Rest\Client;
use App\Model\QuickResponse;
use RealRashid\SweetAlert\Facades\Alert;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $client = null;
    public function __construct() {
        $settings = Settings::first()->toArray(); 
        
        
       $sid = $settings['twilio_acc_sid'];
        
       $token = $settings['twilio_auth_token'];
       
      $this->client = new Client($sid, $token);
    }   
    public function index()
    {
        $settings = Settings::first();

        $timezones = timezone_identifiers_list();
        $appointmentSetting = CalendarSetting::where('calendar_type', "Appointments")->get();

        $appointmentSetting = $appointmentSetting->count() ? $appointmentSetting[0] : new CalendarSetting();

        return view('back.pages.settings.index', compact('settings', 'timezones', 'appointmentSetting'));
    }

    public function CommunicationSetting(){
        $responders=AutoResponder::all();   
        $autoReplies = AutoReply::all();
        $quickResponses = QuickResponse::all();
      
          $categories = Category::all();
          $markets=Market::all();
          $rvms=RvmFile::all();
          $Settings=Settings::first();
          
          
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
              
              $account = Account::first();
              $market = Market::first();
              $phn_num[] = $activeNumber->phoneNumber;
              $numbers[] = (object) [
                  'number' => $phn_num,
                  'name' => $activeNumber->friendlyName,
                  'sid' => $activeNumber->sid,
                  'capabilities' => $activeNumber->capabilities,
              ];
          //dd($numbers);
              $phone_number = Number::where('number', $numbers[0]->number)->first();
             // dd($phone_number);
             if (!$phone_number) {
                  $phn_nums = new Number();
                  $phn_nums->number = $phn_num;
                  //dd($phn_num);
                 $phn_nums->sid = $activeNumber->sid;
                 $capability="";
                 if($numbers[0]->capabilities["sms"]==true)
                 {
                    $capability .="sms,";
                 }
                 if($numbers[0]->capabilities["mms"]==true)
                 {
                    $capability .="mms,";
                 }
                 if($numbers[0]->capabilities["voice"]==true)
                 {
                    $capability .="voice,";
                 }
                 if($numbers[0]->capabilities["fax"]==true)
                 {
                    $capability .="fax,";
                 }
                 
                // $phn_nums->capabilities = $capability;
                // $phn_nums->sms_allowed = Settings::first()->sms_allowed;
                // $phn_nums->a2p_compliance= $activeNumber->capabilities["sms"];
                // $phn_nums->account_id = $account->id;
                // $phn_nums->market_id=$market->id;
                // $phn_nums->save();
              }
              $all_phone_nums = Number::all();
          }
          
          return view('back.pages.settings.communication', compact('responders','Settings','quickResponses', 'autoReplies', 'categories', 'all_phone_nums','markets','rvms'));
    }

    public function AppointmentSettings()
    {
        $settings = Settings::first();

        $timezones = timezone_identifiers_list();
        $appointmentSetting = CalendarSetting::where('calendar_type', "Appointments")->get();

        $appointmentSetting = $appointmentSetting->count() ? $appointmentSetting[0] : new CalendarSetting();
        return view('back.pages.settings.appointment', compact('appointmentSetting','timezones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function updateCommunicationSetting(Request $request) {
        $numberId = $request->input('numberId');
        $number = Number::find($numberId);
    
        if ($number) {
            if ($request->has('isActive')) {
                $isActive = $request->input('isActive');
                $number->is_active = $isActive;
            } elseif ($request->has('isPhoneSystem')) {
                $isPhoneSystem = $request->input('isPhoneSystem');
                $number->system_number = $isPhoneSystem;
            }
    
            $number->save();
    
            return response()->json(['status' => 200]);
        }
    
        return response()->json(['status' => 400]);
    }
    

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Settings $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Settings $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Settings $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        // if ($request->auto_reply == 1 && $request->auto_respond == 1) {
        //     Alert::error("Oops!", 'You can not enable auto reply or auto respond at the same time.');
        //     return redirect()->back();
        // } elseif ($request->auto_reply == 0 && $request->auto_respond == 0) {
        //     Alert::error("Oops!", 'You can not disable auto reply or auto respond at the same time.');
        //     return redirect()->back();
        // }

        $settings = $settings->find(1);
        $settings->auto_reply = $request->auto_reply??0;
        $settings->auto_responder = $request->auto_respond??0;
        //$settings->sms_rate = $request->sms_rate;
        //$settings->sms_allowed = $request->sms_allowed;
        if($request->sender_email!='')
        $settings->sender_email = $request->sender_email??0;
        if($request->sender_name!='')
        $settings->sender_name = $request->sender_name??0;
        if($request->auth_email!='')
        $settings->auth_email = $request->auth_email??0;
        if($request->document_closed_by!='')
        $settings->document_closed_by = $request->document_closed_by??0;
        if($request->reply_email!='')
        $settings->reply_email = $request->reply_email??0;
        if($request->sendgrid_key!='')
        $settings->sendgrid_key = $request->sendgrid_key??0;

        if($request->twilio_acc_sid!='')
        $settings->twilio_acc_sid = $request->twilio_acc_sid??0;
        if($request->twilio_api_sid!='')
        $settings->twilio_api_sid = $request->twilio_api_sid??0;
        if($request->twilio_auth_token!='')
        $settings->twilio_auth_token = $request->twilio_auth_token??0;
        if($request->twilio_secret_key!='')
        $settings->twilio_secret_key = $request->twilio_secret_key??0;
        if($request->twiml_app_sid!='')
        $settings->twiml_app_sid = $request->twiml_app_sid??0;
        

        if($request->call_forward_number!='')
        $settings->call_forward_number = $request->call_forward_number??0;
        if($request->schedule_hours!='')
        $settings->schedule_hours = $request->schedule_hours??0;
        if($request->google_drive_client_id!='')
        $settings->google_drive_client_id = $request->google_drive_client_id??0;
        if($request->google_drive_client_secret!='')
        $settings->google_drive_client_secret = $request->google_drive_client_secret??0;
        if($request->google_drive_developer_key!='')
        $settings->google_drive_developer_key = $request->google_drive_developer_key??0;
        if($request->stripe_screct_key!='')
        $settings->stripe_screct_key = $request->stripe_screct_key??0;
        if($request->strip_publishable_key!='')
        $settings->strip_publishable_key = $request->strip_publishable_key??0;
        if($request->paypal_client_id!='')
        $settings->paypal_client_id = $request->paypal_client_id??0;
        if($request->paypal_secret_key!='')
        $settings->paypal_secret_key = $request->paypal_secret_key??0;

        $settings->save();
        $account = Account::find(1);
        if($request->twilio_acc_sid!='')
        $account->account_id=$request->twilio_acc_sid;
        if($request->twilio_secret_key!='')
        $account->account_token=$request->twilio_secret_key;
        $account->save();

        $numbers = Number::all();
        if ($numbers != null) {
            foreach ($numbers as $number) {
                $number->sms_allowed = $request->sms_allowed;
                $number->save();
            }
        }


        Alert::success('Success', 'Settings Updated Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Settings $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }


    public function updateAppointmentCalendarSettings(Request $request)
    {
        $data = $request->all();
        $data['calendar_type'] = "Appointments";

        if ($appointmentSetting = CalendarSetting::first()) {
            $appointmentSetting->update($data);
        } else {
            $appointmentSetting = CalendarSetting::create($data);
        }

        Alert::success('Success', 'Appointments Calendar Settings Updated!');
        return redirect()->back();
    }
}
