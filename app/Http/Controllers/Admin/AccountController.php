<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\Number;
use App\Model\Market;
use Illuminate\Http\Request;
use App\Model\Settings;
use App\Model\CalendarSetting;
use RealRashid\SweetAlert\Facades\Alert;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::first();
        $settings = Settings::first();

        return view('back.pages.account.index', compact('accounts','settings'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Account::create($request->all());
        Alert::success('Success', 'Account Created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }


    public function edit(Account $account)
    {
        //
    }


    public function update(Request $request)
    {
        $account = Account::find(1);
        //$account->account_id=$request->account_id;
        // $account->account_token=$request->account_token;
        // $account->account_copilot=$request->account_copilot;
        // $account->account_name=$request->account_name;
        $account->sms_rate = $request->sms_rate;
        $account->sms_allowed = $request->sms_allowed;
        $account->phone_cell_append_rate    = $request->phone_cell_append_rate;
        $account->email_append_rate         = $request->email_append_rate;
        $account->name_append_rate          = $request->name_append_rate;
        $account->email_verification_rate   = $request->email_verification_rate;
        $account->rvm_rate                  = $request->rvm_rate;
            $account->mms_rate                  = $request->mms_rate;
            $account->email_rate                = $request->email_rate;
        $account->phone_scrub_rate          = $request->phone_scrub_rate;
        $account->scraping_charge_per_record          = $request->scraping_charge_per_record;
        $account->save();

        $numbers = Number::all();
        if ($numbers != null) {
            foreach ($numbers as $number) {
                $number->sms_allowed = $request->sms_allowed;
                $number->save();
            }
        }

        Alert::success('Success', 'Account Updated!');
        return redirect()->back();
    }

    public function googleCalendersetting(Request $request){
        $accounts = Account::first();
    
        return view('back.pages.GoogleCalenderSetting.index', compact('accounts'));
    }
    public function updateGoogleCalendarSettings(Request $request)
    {

        $path = $request->calendar_credentials_path ?? null;

        if ($request->hasFile('calendar_credentials_file')) {
            $path = $request->file('calendar_credentials_file')->storeAs(
                $request->user()->id,
                'service-account-credentials.json',
                'google_calendar'
            );
        }

        $account = Account::find(1);
        $account->calendar_id = $request->calendar_id;
        $account->calendar_enable = $request->calendar_enable;
        $account->calendar_credentials_path = $path;
        $account->save();

        Alert::success('Success', 'Google Calendar Settings Updated!');
        return redirect()->back();
    }


    public function destroy(Request $request)
    {
        Account::find($request->account_id)->delete();
        Alert::success('Success', 'Account Removed!');
        return redirect()->back();
    }
}
