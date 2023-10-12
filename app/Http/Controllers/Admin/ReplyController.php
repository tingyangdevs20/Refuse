<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\FailedSms;
use App\Model\LeadCategory;
use App\Model\Number;
use App\Model\Reply;
use App\Model\Sms;
use App\Model\Settings;
use App\Model\Conversations;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Twilio\Rest\Client;


class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sr=1;
        $leads=LeadCategory::all();
        $msg=Sms::orderBy('created_at','DESC')->get();
        // echo "<pre>";
        // print_r($msg);die;
        return view('back.pages.sms.reply.index',compact('sr','msg',"leads"));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $number=Number::where('number',$request->twilio_number)->first();
        if($number){
            // Your Account SID and Auth Token from twilio.com/console
            $settings = Settings::first()->toArray(); 
        
            $sid = $settings['twilio_acc_sid'];
            
            $token = $settings['twilio_auth_token'];
           
            
        }
      
        try {
            $client = new Client( $sid, $token );
                $sms_sent = $client->messages->create(
                    $request->to,
                    [
                        'from' => $request->twilio_number,
                        'body' => $request->reply,
                    ]
                );

            if($sms_sent)
            {


                $reply=new Reply();
                $reply->sms_id=$request->sms_id;
                $reply->to=$request->to;
                $reply->from=$request->twilio_number;
               $reply->reply=$request->reply;
                $reply->type='SMS';
                $reply->system_reply=1;
                $reply->save();
               // $this->incrementSmsCount($request->twilio_number);

                $conversation =new Conversations();
                $conversation->sms_id=$request->sms_id;
                $conversation->sent_to=$request->to;
                $conversation->sent_from=$request->twilio_number;
                $conversation->body_text=$request->reply;
                $conversation->conv_type='SMS';
                $conversation->system_reply=0;
                $conversation->save();
                $this->incrementSmsCount($request->twilio_number);







            }
            Alert::success('Success','Message Sent To '.$request->from);
           
            return redirect()->back();
        } catch (\Exception $ex) {
            $failed_sms=New FailedSms();
            $failed_sms->client_number=$request->to;
            $failed_sms->twilio_number=$request->twilio_number;
            $failed_sms->message='$request->reply';
            $failed_sms->media='No';
            $failed_sms->error=$ex->getMessage();
            $failed_sms->save();
            Alert::error('Oops!',$ex->getMessage())->autoclose(100000);
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function show(Sms $sms)
    {
        dd($sms);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function edit(Sms $sms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sms $sms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $sms=Sms::find($request->id);
        $sms->replies()->delete();
        $sms->delete();
        Alert::success('Success!','Conversation Removed!');
        return redirect()->back();
    }


    public function incrementSmsCount(string $number)
    {
        $number=Number::where('number',$number)->first();
        $number->sms_count++;
        $number->save();
    }
}
