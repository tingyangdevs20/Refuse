<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Number;
use App\Model\Settings;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Settings::first();
        return view('back.pages.settings.index', compact('settings'));
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
        if ($request->auto_reply == 1 && $request->auto_respond == 1) {
            Alert::error("Oops!", 'You can not enable auto reply or auto respond at the same time.');
            return redirect()->back();
        } elseif ($request->auto_reply == 0 && $request->auto_respond == 0) {
            Alert::error("Oops!", 'You can not disable auto reply or auto respond at the same time.');
            return redirect()->back();
        }

        $settings = $settings->find(1);
        $settings->auto_reply = $request->auto_reply;
        $settings->auto_responder = $request->auto_respond;
        //$settings->sms_rate = $request->sms_rate;
        //$settings->sms_allowed = $request->sms_allowed;
        $settings->sender_email = $request->sender_email;
        $settings->sender_name = $request->sender_name;
        $settings->auth_email = $request->auth_email;
        $settings->reply_email = $request->reply_email;
        $settings->sendgrid_key = $request->sendgrid_key;
        $settings->twilio_api_key = $request->twilio_api_key;
        $settings->twilio_acc_secret = $request->twilio_secret;
        $settings->call_forward_number = $request->call_forward_number;
        $settings->schedule_hours = $request->schedule_hours;

        $settings->google_drive_client_id = $request->google_drive_client_id;
        $settings->google_drive_client_secret = $request->google_drive_client_secret;
        $settings->google_drive_developer_key = $request->google_drive_developer_key;

        $settings->save();

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
}
