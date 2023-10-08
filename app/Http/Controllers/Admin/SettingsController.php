<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CalendarSetting;
use App\Model\Number;
use App\Model\Settings;
use App\Model\Account;
use App\Model\QuickResponse;
use Illuminate\Http\Request;
use App\Model\AutoResponder; 
use App\Model\AutoReply;
use App\Model\Category;
use App\Model\Market;
use App\Model\RvmFile;
use Twilio\Rest\Client;
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
        
        
        $sid = $settings['twilio_api_key'];
        
        $token = $settings['twilio_acc_secret'];
       
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
          $context = $this->client->getAccount();
          $activeNumbers = $context->incomingPhoneNumbers;
          $activeNumberArray = $activeNumbers->read();
          
          $numbers = [];
          foreach ($activeNumberArray as $activeNumber) {
              error_log('active number = ' . $activeNumber->phoneNumber);
          
              // Get the phone number as a string
              $phn_num[] = $activeNumber->phoneNumber;
          
              $numbers[] = (object) [
                  'number' => $phn_num,
                  'name' => $activeNumber->friendlyName,
                  'sid' => $activeNumber->sid,
                  'capabilities' => $activeNumber->capabilities,
              ];
          
              $phone_number = Number::where('number', $phn_num)->first();
              if (!$phone_number) {
                  $phn_nums = new Number();
                  $phn_nums->number = $phn_num;
                  $phn_nums->sid = $activeNumber->sid;
                  $phn_nums->capabilities = $activeNumber->capabilities;
                  $phn_nums->sms_allowed = Settings::first()->sms_allowed;
                  $phn_nums->account_id = null;
                  $phn_nums->market_id = null;
                  $phn_nums->save();
              }
          
              $all_phone_nums = Number::all();
          }
          
          return view('back.pages.settings.communication', compact('responders','quickResponses', 'autoReplies', 'categories', 'all_phone_nums','markets','rvms'));

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
        $settings->sender_email = $request->sender_email??0;
        $settings->sender_name = $request->sender_name??0;
        $settings->auth_email = $request->auth_email??0;
        $settings->document_closed_by = $request->document_closed_by??0;
        $settings->reply_email = $request->reply_email??0;
        $settings->sendgrid_key = $request->sendgrid_key??0;
        $settings->twilio_api_key = $request->twilio_api_key??0;
        $settings->twilio_acc_secret = $request->twilio_secret??0;
        $settings->call_forward_number = $request->call_forward_number??0;
        $settings->schedule_hours = $request->schedule_hours??0;

        $settings->google_drive_client_id = $request->google_drive_client_id??0;
        $settings->google_drive_client_secret = $request->google_drive_client_secret??0;
        $settings->google_drive_developer_key = $request->google_drive_developer_key??0;

        $settings->stripe_screct_key = $request->stripe_screct_key??0;
        $settings->strip_publishable_key = $request->strip_publishable_key??0;

        $settings->paypal_client_id = $request->paypal_client_id??0;
        $settings->paypal_secret_key = $request->paypal_secret_key??0;


        $settings->save();
        $account = Account::find(1);
        $account->account_id=$request->twilio_api_key;
        $account->account_token=$request->twilio_secret;
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
