<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MarketingSpend;
use App\Model\CalendarSetting;
use App\Model\Number;
use App\Model\Template;
use App\Model\Settings;
use App\Model\Account;
use App\Model\Tag;
use Illuminate\Http\Request;
use App\Model\AutoResponder;
use App\Model\AutoReply;
use App\Model\Blacklist;
use App\Model\Campaign;
use App\Model\CampaignLead;
use App\Model\Group;
use App\Model\Category;
use App\Model\FormTemplates;
use App\Model\Market;
use App\Model\RvmFile;
use Twilio\Rest\Client;
use App\Model\QuickResponse;
use App\Model\Script;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Model\CustomField;
use App\Model\DNC;
use App\Model\Section;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $client = null;
    public function __construct()
    {
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

    public function appointment()
    {
        // dd('ok');
        $settings = Settings::first();

        $timezones = timezone_identifiers_list();
        $appointmentSetting = CalendarSetting::where('calendar_type', "Appointments")->get();

        $appointmentSetting = $appointmentSetting->count() ? $appointmentSetting[0] : new CalendarSetting();

        return view('back.pages.settings.appointmentSettings', compact('settings', 'timezones', 'appointmentSetting'));
    }

    // Marketing spend index
    public function marketingSpend()
    {
        $data = MarketingSpend::where('user_id', auth()->id())->get();
        return view('back.pages.settings.marketingSpend', compact('data'));
    }

    public function CommunicationSetting()
    {

        $groups = Group::all(); // Fetch groups from the database
        $campaigns = Campaign::getAllCampaigns();
        $leadcampaigns = CampaignLead::getAllLeadsCampaign();
        $templates = Template::where('type' , 'SMS')->get();
       // return view('back.pages.campaign.index', compact('groups', 'campaigns','templates'));

        $responders = AutoResponder::all();
        $autoReplies = AutoReply::all();
        $quickResponses = QuickResponse::all();

        $categories = Category::all();
        $markets = Market::all();
        $rvms = RvmFile::all();
        $Settings = Settings::first();

        $context = $this->client->getAccount();
        $activeNumbers = $context->incomingPhoneNumbers;
        // dd( $activeNumbers);
        $activeNumberArray = $activeNumbers->read();
        //print_r($activeNumberArray);
        //die("...");
        $numbers = [];
        $account = Account::first();
        $market = Market::first();
        foreach ($activeNumberArray as $activeNumber) {
            error_log('active number = ' . $activeNumber->phoneNumber);

            $phn_num = $activeNumber->phoneNumber;
            $numbers[] = (object) [
                'number' => $phn_num,
                'name' => $activeNumber->friendlyName,
                'sid' => $activeNumber->sid,
                'capabilities' => $activeNumber->capabilities,
            ];
            // dd($numbers);
            $phone_number = Number::where('number', $activeNumber->phoneNumber)->first();
            // dd($phone_number);
            if (!$phone_number) {
                $phn_nums = new Number();
                $phn_nums->number = $phn_num;
                //dd($phn_num);
                $phn_nums->sid = $activeNumber->sid;
                $capability = "";
                if ($activeNumber->capabilities["sms"] == true) {
                    $capability .= "sms, ";
                }
                if ($activeNumber->capabilities["mms"] == true) {
                    $capability .= "mms, ";
                }
                if ($activeNumber->capabilities["voice"] == true) {
                    $capability .= "voice, ";
                }
                if ($activeNumber->capabilities["fax"] == true) {
                    $capability .= "fax, ";
                }
                $phn_nums->capabilities = $capability;
                $phn_nums->sms_allowed = Settings::first()->sms_allowed;
                $phn_nums->a2p_compliance= $activeNumber->capabilities["sms"];
                $phn_nums->account_id = $account->id;
                $phn_nums->market_id=$market->id;
                $phn_nums->save();

            }
        }

        $all_phone_nums = Number::all();
        return view('back.pages.settings.communication', compact('responders','campaigns','leadcampaigns','templates', 'Settings', 'quickResponses', 'autoReplies', 'categories', 'all_phone_nums', 'markets', 'rvms'));
    }

    // Templates
    public function templatesIndex()
    {
        $sr = 1;
        $scripts = Script::all();
        $templates = Template::all();

        $categories = Category::all();

        $groups = FormTemplates::all()->sortByDesc("created_at");
        $markets = Market::all();
        $tags = Tag::all();
        $campaigns = Campaign::getAllCampaigns();

        $short_code = [];
        $contacts = DB::table('contacts')->first(['name', 'last_name', 'street', 'city', 'state', 'zip', 'number', 'number2', 'number3', 'number3', 'email1', 'email2']);
        if (!empty($contacts)) {
            foreach ($contacts as $key => $contact) {
                $short_code[$key] = $contact;
            }
        }

        $leadinfo = DB::table('lead_info')->first(['owner1_first_name', 'owner1_last_name', 'owner1_primary_number', 'owner1_number2', 'owner1_number3', 'owner1_email1', 'owner1_email2', 'owner1_dob', 'owner1_mother_name', 'owner2_first_name', 'owner2_last_name', 'owner2_primary_number', 'owner2_number2', 'owner2_number3', 'owner2_email1', 'owner2_email2', 'owner2_social_security', 'owner2_dob', 'owner2_mother_name', 'owner3_first_name', 'owner3_last_name', 'owner3_primary_number', 'owner3_number2', 'owner3_number3', 'owner3_email1', 'owner3_email2', 'owner3_social_security', 'owner3_dob', 'owner3_mother_name', 'user_1_name', 'user_1_signature', 'user_2_name', 'user_2_signature', 'user_3_name', 'user_3_signature']);
        if (!empty($leadinfo)) {
            foreach ($leadinfo as $key => $lead) {
                $short_code[$key] = $lead;
            }
        }

        $property_infos = DB::table('property_infos')->first(['property_address', 'property_city', 'property_state', 'property_zip', 'map_link', 'zillow_link']);
        if (!empty($property_infos)) {
            foreach ($property_infos as $key => $property) {
                $short_code[$key] = $property;
            }
        }

        $users = DB::table('users')->first(["name", "email", "mobile", "company_name", "address", "street", "state", "city", "zip"]);
        if (!empty($users)) {
            foreach ($users as $key => $user) {
                $short_code['user_' . $key] = $user;
            }
        }

        $settings = DB::table('settings')->first(["auth_email", "document_closed_by"]);
        if (!empty($settings)) {
            foreach ($settings as $key => $setting) {
                $short_code[$key] = $setting;
            }
        }

        $title_company = DB::table('title_company')->first(["buy_sell_entity_detail"]);
        if (!empty($title_company)) {
            foreach ($title_company as $key => $title) {
                $short_code[$key] = $title;
            }
        }

        $short_code = array_keys($short_code);
        foreach ($short_code as $code) {
            $shortcode[$code] = ucwords(str_replace('_', ' ', $code));
        }

        $short_code = $shortcode;
        return view('back.pages.settings.templates', compact('scripts', 'sr', 'templates', 'categories', 'groups', 'campaigns', 'markets', 'tags', 'short_code'));
    }

    public function listManagement()
    {
        $tags = Tag::all();

        // Calculate the contact counts for each tag
        foreach ($tags as $tag) {
            $tag->contactCount = $this->getContactCountForTag($tag);
        }

        $sections = Section::all();
        $customfields = CustomField::all();

        $dncs = DNC::all();

        $sr=1;

        $numbers = Blacklist::all();

        return view('back.pages.settings.listManagement', compact('tags', 'sections', 'customfields', 'dncs', 'sr', 'numbers'));
    }

    // Helper method to get the contact count for a specific tag
    private function getContactCountForTag(Tag $tag)
    {
        // Get all groups associated with the tag
        $groups = $tag->groups;

        // Initialize a variable to store the total contact count
        $totalContactCount = 0;

        // Iterate through the groups and sum up the contact counts
        foreach ($groups as $group) {
            $totalContactCount += $group->contacts()->count();
        }

        return $totalContactCount;
    }

    public function AppointmentSettings()
    {
        $settings = Settings::first();

        $timezones = timezone_identifiers_list();
        $appointmentSetting = CalendarSetting::where('calendar_type', "Appointments")->get();

        $appointmentSetting = $appointmentSetting->count() ? $appointmentSetting[0] : new CalendarSetting();
        return view('back.pages.settings.appointment', compact('appointmentSetting', 'timezones'));
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

    public function updateCommunicationSetting(Request $request)
    {
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
        $settings->auto_reply = $request->auto_reply ?? 0;
        $settings->auto_responder = $request->auto_respond ?? 0;
        //$settings->sms_rate = $request->sms_rate;
        //$settings->sms_allowed = $request->sms_allowed;
        if ($request->sender_email != '')
            $settings->sender_email = $request->sender_email ?? 0;
        if ($request->sender_name != '')
            $settings->sender_name = $request->sender_name ?? 0;
        if ($request->auth_email != '')
            $settings->auth_email = $request->auth_email ?? 0;
        if ($request->auth_name != '')
            $settings->auth_name = $request->auth_name ?? 0;
        if ($request->document_closed_by != '')
            $settings->document_closed_by = $request->document_closed_by ?? 0;
        if ($request->reply_email != '')
            $settings->reply_email = $request->reply_email ?? 0;
        if ($request->sendgrid_key != '')
            $settings->sendgrid_key = $request->sendgrid_key ?? 0;
            if ($request->slybroad_call_url != '')
            $settings->slybroad_number = $request->slybroad_call_url ?? 0;

        if ($request->twilio_acc_sid != '')
            $settings->twilio_acc_sid = $request->twilio_acc_sid ?? 0;
        if ($request->twilio_api_sid != '')
            $settings->twilio_api_sid = $request->twilio_api_sid ?? 0;
        if ($request->twilio_auth_token != '')
            $settings->twilio_auth_token = $request->twilio_auth_token ?? 0;
        if ($request->twilio_secret_key != '')
            $settings->twilio_secret_key = $request->twilio_secret_key ?? 0;
        if ($request->twiml_app_sid != '')
            $settings->twiml_app_sid = $request->twiml_app_sid ?? 0;
        if ($request->twiml_app_sid != '')
            $settings->messaging_service_sid = $request->messaging_service_sid ?? 0;


        if ($request->call_forward_number != '')
            $settings->call_forward_number = $request->call_forward_number ?? 0;
        if ($request->schedule_hours != '')
            $settings->schedule_hours = $request->schedule_hours ?? 0;
        if ($request->google_drive_client_id != '')
            $settings->google_drive_client_id = $request->google_drive_client_id ?? 0;
        if ($request->google_drive_client_secret != '')
            $settings->google_drive_client_secret = $request->google_drive_client_secret ?? 0;
        if ($request->google_drive_developer_key != '')
            $settings->google_drive_developer_key = $request->google_drive_developer_key ?? 0;
        if ($request->stripe_screct_key != '')
            $settings->stripe_screct_key = $request->stripe_screct_key ?? 0;
        if ($request->strip_publishable_key != '')
            $settings->strip_publishable_key = $request->strip_publishable_key ?? 0;
        if ($request->paypal_client_id != '')
            $settings->paypal_client_id = $request->paypal_client_id ?? 0;
        if ($request->paypal_secret_key != '')
            $settings->paypal_secret_key = $request->paypal_secret_key ?? 0;

        $settings->save();
        $account = Account::find(1);
        if ($request->twilio_acc_sid != '')
            $account->account_id = $request->twilio_acc_sid;
        if ($request->twilio_auth_token != '')
            $account->account_token = $request->twilio_auth_token;
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
        if (empty($data["advance_booking_duration"])){
            $data["advance_booking_duration"] = 7;
        }

        if ($appointmentSetting = CalendarSetting::first()) {
            $appointmentSetting->update($data);
        } else {
            $appointmentSetting = CalendarSetting::create($data);
        }

        Alert::success('Success', 'Appointments Calendar Settings Updated!');
        return redirect()->back();
    }

    public function storeMarketingSpend(Request $request)
    {
        $data = [
            'lead_source' => $request->lead_source,
            'daterange' => $request->daterange,
            'amount' => $request->amount
        ];

        $data['user_id'] = auth()->id();

        $record = MarketingSpend::where('lead_source', $request->lead_source)->first();
        if ($record) {
            $record->update($data);
        } else {
            MarketingSpend::create($data);
        }

        Alert::success('Success', 'Marketing Spend Settings Updated!');
        return redirect()->back();
    }

    public function updateMarketingSpend(Request $request)
    {
        $data = [
            'lead_source' => $request->lead_source,
            'daterange' => $request->daterange,
            'amount' => $request->amount
        ];

        $data['user_id'] = auth()->id();

        $marketing = MarketingSpend::find($request->id);
        $marketing->update($data);

        Alert::success('Success', 'Marketing Spend Settings Updated!');
        return redirect()->back();
    }

    public function destroyMarketingSpend(Request $request)
    {
        $marketing = MarketingSpend::find($request->id);
        $marketing->delete();

        Alert::success('Success', 'Marketing Spend Settings Deleted!');
        return redirect()->back();
    }
}
