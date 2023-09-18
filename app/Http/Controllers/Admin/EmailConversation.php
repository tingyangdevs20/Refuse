<?php

namespace App\Http\Controllers\Admin;

use App\Gmails;
use App\Model\Emails;
use App\Model\LeadCategory;
use App\Model\QuickResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use Dacastro4\LaravelGmail\Services\Message\Mail;

class EmailConversation extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sr = 1;
        $leads = LeadCategory::all();
        $msg = Emails::where('from', LaravelGmail::user())->whereNotNull('to')->whereNotNull('gmail_thread_id')->with('replies')->latest()->get();

        // dd($msg);
        
        return view('back.pages.email.reply.index', compact('sr', 'msg', "leads"));
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
        $email = Emails::where('from', LaravelGmail::user())->whereNotNull('to')->whereNotNull('gmail_thread_id')->where('id', $request->emails_id)->with('replies')->firstOrFail();

        $message = $request->reply;
        $unsub_link = url('admin/email/unsub/' . $email->to);

        $mail = LaravelGmail::message()->get($email->replies->last()->gmail_mail_id)->load();
        if ($email->replies->count() == 1) {
            $mail->to($email->to);
            $mail->setHeader('In-Reply-To', $mail->getHeader('Message-Id'));
            $mail->setHeader('References', $mail->getHeader('Message-Id'));
            $mail->setHeader('Message-ID', $mail->getHeader('Message-Id'));
        }
        $mail->message($message);
        $mail->view('emails.test', ['test_message' => $message, 'unsub_link' => $unsub_link]);
        $mail->reply();

        $email->replies()->create([
            'gmail_mail_id' => $mail->id,
            'to' => $email->to,
            'from' => LaravelGmail::user(),
            'reply' => $message,
            'system_reply' => 0,
            'is_unread' => 1,
            'created_at' => $mail->getDate()->setTimezone(now()->timezoneName),
        ]);

        Alert::success('Success', 'Message Sent To ' . $email->to);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $email = Emails::where('from', LaravelGmail::user())->whereNotNull('to')->whereNotNull('gmail_thread_id')->where('id', $id)->with('replies')->firstOrFail();
        $quickResponses = QuickResponse::all();

        return view('back.pages.email.reply.replies', compact('email', 'quickResponses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
