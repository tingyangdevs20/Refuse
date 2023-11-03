<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Blacklist;
use App\Model\Contact;
use App\Model\FailedSms;
use App\Model\LeadCategory;
use App\Model\CampaignLead;
use App\Model\Number;
use App\Model\QuickResponse;
use App\Model\Reply;
use App\Model\Sms;
use App\Model\Conversations;
use App\Model\Emails;
use App\Model\System_messages;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $systemsgResponses=System_messages::all();
        return view('back.pages.systemMessages.index',compact('systemsgResponses'));
    }  
    public function update(Request $request,$id)
    {
         $systemsgResponses = System_messages::find(intval($id));
         $systemsgResponses->message = $request->input('systemsg');
         $systemsgResponses->update();
        Alert::success('Success','System Messages Updated..');
        return redirect()->back();
    } 
    public function failedSms()
    {
        $messages=FailedSms::orderBy('created_at','DESC')->get();
        $sr=1;
        return view('back.pages.sms.failed',compact('messages','sr'));
    }
    public function failedSmsDestroy(Request $request)
    {
        FailedSms::find($request->id)->delete();
        Alert::success('Success!','Message Deleted!');
        return redirect()->back();
    }
    public function receivedSms()
    {
        $messages=Sms::orderBy('created_at','DESC')->where('is_received',1)->get();
        $sr=1;
        $error=null;
        return view('back.pages.sms.details',compact('messages','sr','error'));
    }
    public function show(Sms $sms)
    {   // code here
        // echo "<pre>";
       // print_r($sms);die;
        
        $quickResponses=QuickResponse::all();
        $number=Number::where('number',$sms->twilio_number)->first();
        print_r(strlen($number));
      // die('..');
     
        $smsInfo=Contact::where('number',$sms->client_number)->first();
       // print_r($smsInfo);
       // die('..');

        $leadCategories=LeadCategory::all();
        //print_r($leadCategories);
        //die('..');

        $leadCampaigns=CampaignLead::all();

        $conversations=Conversations::orderBy('received_on', 'ASC')->get();
   
        return view('back.pages.sms.replies',compact('sms','smsInfo',"quickResponses",'number','leadCategories','conversations','leadCampaigns'));
    }
    public function saveThread(Request $request)
    {
        $sms=Sms::find($request->id);
        $sms->lead_category_id=$request->lead_id;
        $sms->save();
        if ($request->lead_id==2){
            $blacklist=new Blacklist();
            $blacklist->number=$request->number;
            $blacklist->save();
            $contact=Contact::where('number',$request->number)->first();
            $contact->is_dnc=1;
            $contact->save();
            $sms=Sms::where('client_number',$request->number)->first();
            $sms->lead_category_id=2;
            $sms->save();
        }
        else{
            $sms=Sms::where('client_number',$request->number)->first();
            $sms->lead_category_id=$request->lead_id;
            $sms->save();
        }
        Alert::success('Success','Conversation Saved');
        return redirect()->back();
    }
    public function threads()
    {
        $sr=1;
        $leads=LeadCategory::all();
        $msg=Sms::orderBy('created_at','DESC')->where('lead_category_id','!=',null)->get();
        return view('back.pages.sms.threads',compact('sr','msg','leads'));
    }

    public function addToDNC(Request $request)
    {
        $sms=Sms::where('client_number',$request->number)->first();
        $sms->lead_category_id=$request->lead_id;
        $sms->save();
        if ($request->lead_id==2){
            $blacklist=new Blacklist();
            $blacklist->number=$request->number;
            $blacklist->save();
            $contact=Contact::where('number',$request->number)->first();
            $contact->is_dnc=1;
            $contact->save();
            $sms=Sms::where('client_number',$request->number)->first();
            $sms->lead_category_id=2;
            $sms->save();
        }
        else{
            $sms=Sms::where('client_number',$request->number)->first();
            $sms->lead_category_id=$request->lead_id;
            $sms->save();
        }
        Alert::success('Success','Conversation Saved');
        return redirect()->back();
    }

}
