<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Blacklist;
use App\Model\FailedSms;
use App\Model\Number;
use App\Model\Phone;
use App\Model\Reply;
use App\Model\Sms;
use App\Model\Template;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Twilio\Rest\Client;
use Illuminate\Http\Request;

class SingleSMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $numbers = Number::all();
       $numbers = Number::all();
        $templates = Template::all();
        return view('back.pages.sms.single.index', compact('numbers', 'templates'));
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
        
        $account_info = explode('|', $request->sender_number);
        $sender_number = $account_info[0];
        $sid = $account_info[1];
        $token = $account_info[2];
        $receiver_number = $this->contactEscapeString($request);

        

        if ($this->checkBlacklist($receiver_number)) {
            Alert::error('Error', 'Number is in blacklist');
            return redirect()->back();
        }

        if ($request->media_file != null) {
            $media = $request->file('media_file');
            $filename = $media->getClientOriginalName();
            $mediaExt = $media->getClientOriginalExtension();
            $filename = preg_replace('/[^A-Za-z0-9]/', '', $filename);
            $tmpname = time() . $filename.'.'.$mediaExt;
            $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
            $media = config('app.url') . '/public/uploads/' . $path;
        }
        try {
            $client = new Client($sid, $token);

           // dd($client);
            
            //return $media;
            if ($request->media_file != null) {
                $sms_sent = $client->messages->create(
                    $receiver_number,
                    [
                        'from' => $sender_number,
                        'body' => $request->message,
                        'mediaUrl' => [$media],
                    ]
                );
                //dd($sms_sent);
            } else {
                $sms_sent = $client->messages->create(
                    $receiver_number,
                    [
                        'from' => $sender_number,
                        'body' => $request->message,
                    ]
                );
               // dd($sms_sent);
            }
            if ($sms_sent) {
                $old_sms = Sms::where('client_number', $receiver_number)->first();
                if ($old_sms == null) {
                    $sms = new Sms();
                    $sms->client_number = $receiver_number;
                    $sms->twilio_number = $sender_number;
                    $sms->message = $request->message;
                    $sms->media = $request->media_file == null ? 'No' : $media;
                    $sms->status = 1;
                    $sms->save();
                   // $this->incrementSmsCount($sender_number);
                } else {
                    $reply_message = new Reply();
                    $reply_message->sms_id = $old_sms->id;
                    $reply_message->to = $sender_number;
                    $reply_message->from = $receiver_number;
                    $reply_message->reply = $request->message;
                    $reply_message->system_reply = 1;
                    $reply_message->save();
                   // $this->incrementSmsCount($sender_number);
                }

            }
            Alert::success('Success', 'Message Sent To ' . $receiver_number);
            return redirect()->back();
        } catch (\Exception $ex) {
            //dd($ex->getMessage());
            $failed_sms = new FailedSms();
            $failed_sms->client_number = $receiver_number;
            $failed_sms->twilio_number = $sender_number;
            $failed_sms->message = $request->message;
            $failed_sms->media = $request->media_file == null ? 'No' : $media;
            $failed_sms->error = $ex->getMessage();
            $failed_sms->save();
            Alert::error('Oops!', 'Check Failed Message Page!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\sms $sms
     * @return \Illuminate\Http\Response
     */
    public function show(Sms $sms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\sms $sms
     * @return \Illuminate\Http\Response
     */
    public function edit(Sms $sms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\sms $sms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sms $sms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\sms $sms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sms $sms)
    {
        //
    }

    public function contactEscapeString(Request $request)
    {
        $escape_arr = array(' ', '-', '(', ')', ' ');
        foreach ($escape_arr as $key => $value) {
            $request->receiver_number = str_replace($value, '', $request->receiver_number);
        }
        return Str::startsWith($request->receiver_number, '+1') ? $request->receiver_number : $request->receiver_number = '+1' . $request->receiver_number;
    }

    public function checkBlacklist(string $receiver_number)
    {
        $blacklist = Blacklist::where('number', $receiver_number)->first();
        if ($blacklist == null) {
            return false;
        } else {
            return true;
        }
    }

    public function incrementSmsCount(string $number)
    {
        $number=Number::where('number',$number)->first();
        $number->sms_count++;
        $number->save();
    }
}
