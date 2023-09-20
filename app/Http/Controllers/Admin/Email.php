<?php

namespace App\Http\Controllers\Admin;

use App\Gmails;
use App\Model\Sms;
use App\Model\Reply;
use App\Model\Emails;
use App\Model\Number;
use App\Model\Contact;
use App\Mail\TestEmail;
use App\Model\Template;
use App\Model\Blacklist;
use App\Model\FailedSms;
use App\Model\LeadCategory;
use App\Model\QuickResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use Dacastro4\LaravelGmail\Services\Message\Mail as GMAIL;
use Illuminate\Support\Facades\Mail;

class Email extends Controller
{
    //
    public function index()
    {
        $numbers = Number::all();
        $templates = Template::all();
        $contact = Contact::all();
        return view('back.pages.email.index', compact('numbers', 'templates', 'contact'));
    }

    public function store(Request $request)
    {
        $send_to = $request->send_to;
        $subject = $request->subject;
        $message = $request->message;
        try {
            // $cont = Contact::where('id', $send_to)->get();

            $email = $send_to;

            // if ($cont->email1) {
            //     $email = $cont->email1;
            // } elseif ($cont->email2) {
            //     $email = $cont->email2;
            // }
            // $email = 'ayyfahim@gmail.com';

            $emails = new Emails();
            $emails->to = $email;
            $emails->from = LaravelGmail::user();
            $emails->contact_id = 1;

            $emails->is_received = 0;
            $emails->status = 0;
            $emails->is_campaign = 0;
            $emails->message = $message;
            $emails->subject = $subject;
            $emails->save();

            $unsub_link = url('admin/email/unsub/' . $email);
            $data = ['message' => $message, 'subject' => $subject, 'unsub_link' => $unsub_link];
            if (LaravelGmail::check()) {
                // Send Gmail
                $mail = new GMAIL;
                $mail->to($email);
                $mail->from(config('mail.from.address'), config('mail.from.name'));
                $mail->subject($subject);
                $mail->message($message);
                $mail->view('emails.test', ['test_message' => $data['message'], 'unsub_link' => $data['unsub_link']]);
                $mail->send();
                // $mail->load();
                $mail = LaravelGmail::message()->preload()->get($mail->id);

                $emails->gmail_thread_id = $mail->threadId;
                $emails->gmail_mail_id = $mail->id;

                $emails->is_received = 1;
                $emails->status = 1;
                $emails->save();

                $emails = Emails::where('to', $email)->where('contact_id', 1)->where('is_campaign', 0)->where('from', LaravelGmail::user())->where('gmail_mail_id', $mail->id)->first();

                $emails->replies()->create([
                    'to' => $email,
                    'from' => LaravelGmail::user(),
                    'reply' => $message,
                    'system_reply' => 0,
                    'is_unread' => 1,
                    'gmail_mail_id' => $mail->id,
                    'created_at' => $mail->getDate()->setTimezone(now()->timezoneName),
                ]);
            } else {
                Mail::to($email)->send(new TestEmail($data));
            }

            Alert::success('Success!', 'Email Created!');
            return redirect()->back();
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            Alert::error('Oops!', 'An error occured!');
            return redirect()->back();
        }
    }
}
