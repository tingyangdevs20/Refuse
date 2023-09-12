<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Blacklist;
use Illuminate\Support\Facades\Mail;
use App\Model\Contact;
use App\Mail\TestEmail;
use App\Model\Emails;
use App\Model\FailedSms;
use App\Model\LeadCategory;
use App\Model\Template;
use App\Model\Number;
use App\Model\QuickResponse;
use App\Model\Reply;
use App\Model\Sms;
use RealRashid\SweetAlert\Facades\Alert;

class Email extends Controller
{
    //
    public function index()
    {
        
        $numbers = Number::all();
        $templates = Template::all();
        $contact = Contact::all();
        return view('back.pages.email.index', compact('numbers', 'templates','contact'));
    }

    public function store(Request $request)
    {
        $send_to = $request->send_to;
        $subject = $request->subject;
        $message = $request->message;    
 try {
    $cont = Contact::where('id' , $send_to)->get();  
    
    $emails = new Emails();
    $emails->subject = $subject;
    $emails->message= $message;
    $emails->contact_id= $send_to;
    $emails->save();
    //print_r($cont);die;    
   // $email = $cont[0]->email1 ? $cont[0]->email1: $cont[0]->email2;
    $email = 'developerweb6@gmail.com';
                        // $subject = str_replace("{name}", $cont->name, $subject);
                        // $subject = str_replace("{street}", $cont->street, $subject);
                        // $subject = str_replace("{city}", $cont->city, $subject);
                        // $subject = str_replace("{state}", $cont->state, $subject);
                        // $subject = str_replace("{zip}", $cont->zip, $subject);
                        // if($template){
                        //     $message = $template->body;
                        // }else{
                        //     $message = $checkCompainList->body;
                        // }
                        // $message = str_replace("{name}", $cont->name, $message);
                        // $message = str_replace("{street}", $cont->street, $message);
                        // $message = str_replace("{city}", $cont->city, $message);
                        // $message = str_replace("{state}", $cont->state, $message);
                        // $message = str_replace("{zip}", $cont->zip, $message);
                        $unsub_link = url('admin/email/unsub/'.$email);
                        $data = ['message' => $message ,'subject' => $subject, 'name' =>$cont[0]->name, 'unsub_link' =>$unsub_link];
                        Mail::to($email)->send(new TestEmail($data));
 } catch (\Exception $ex) {
            dd($ex->getMessage());
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
}
