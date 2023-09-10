<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\Blacklist;
use App\Model\Category;
use App\Model\Contact;
use App\Model\FailedSms;
use App\Model\Group;
use App\Model\Number;
use App\Model\Reply;
use App\Model\Sms;
use App\Model\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Twilio\Rest\Client;

class BulkSMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $numbers = Number::all();
        $templates = Template::all();
        $groups = Group::all();
        return view('back.pages.sms.bulk.index', compact('numbers', 'templates', 'groups'));
    }

    public function bulkCategory()
    {
        $numbers = Number::all();
        $categories = Category::all();
        $groups = Group::all();
        return view('back.pages.sms.bulkCategory.index', compact('numbers', 'categories', 'groups'));
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
        $blacklists = Blacklist::all();
        $account_info = explode('|', $request->sender_number);
        $sender_number = $account_info[0];

        // Your Account SID and Auth Token from twilio.com/console
        $sid = $account_info[1];
        $token = $account_info[2];
        $media = null;

        if ($request->media_file != null) {
            $media = $request->file('media_file');
            $filename = $media->getClientOriginalName();
            $tmpname = time() . $filename;
            $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
            $media = config('app.url')  . '/uploads/' . $path;
        }

        if ($request->bulk_type == 1) //manual numbers
        {
            $validator = $request->validate([
                'receiver_number' => 'required',
            ]);
            if ($validator) {
                $receiver_number = $this->contactEscapeString($request);
                $numbers_in_arrays = explode(',', $receiver_number);

                $message = $request->message;
                $count = 0;
                foreach ($numbers_in_arrays as $number) {
                    $count++;
                    foreach ($blacklists as $blacklist) {
                        if ($blacklist->number != $number) {
                            $bulkSms = $this->sendBulkSms($sid, $token, $sender_number, $number, $message, $media);
                        }
                    }


                }
                if ($bulkSms) {
                    Alert::success('Success!', 'Messages Sent!');
                    return redirect()->back();
                } else {
                    Alert::error('Oops!', 'Check Failed Messages Page!');
                    return redirect()->back();
                }


            } else {
                return back()->withErrors($validator);
            }
        } elseif ($request->bulk_type == 2)//group
        {
            $group_numbers = Group::find($request->group)->contacts()->get();
            $count = 0;
            foreach ($group_numbers as $contact) {
                $count++;
                $search = array('(', ')', '-', ' ');
                $replace = array('', '', '', '');
                $contact_cleaned = str_replace($search, $replace, $contact->number);
                $number = $contact_cleaned;
                $message = $this->messageFormat($request->message, $contact->name, $contact->street, $contact->city, $contact->state, $contact->zip);
                 if ($blacklist->number != $number) {
                $bulkSms = $this->sendBulkSms($sid, $token, $sender_number, $number, $message, $media);
                 }

            }
            if ($bulkSms) {
                Alert::success('Success!', 'Messages Sent!');
                return redirect()->back();
            } else {
                Alert::error('Oops!', 'Check Failed Messages Page!');
                return redirect()->back();
            }
        }
    }


    public function bulkCategoryStore(Request $request)
    {
        $account_info = explode('|', $request->sender_number);
        $sender_number = $account_info[0];

        // Your Account SID and Auth Token from twilio.com/console
        $sid = $account_info[1];
        $token = $account_info[2];

        $contacts = Contact::where("group_id", $request->group)->where("is_dnc", 0)->get();
        $templates = Template::where("category_id", $request->category)->get();
        foreach ($contacts as $contact) {
            $counter = rand(0, $templates->count() - 1);
            $message = $this->messageFormat($templates[$counter]->body, $contact->name, $contact->street, $contact->city, $contact->state, $contact->zip);
             
            $bulkSms = $this->sendBulkSmsByCategory($sid, $token, $sender_number, $contact, $message, null);
             
        }
        if ($bulkSms) {
            Alert::success('Success!', 'Messages Sent!');
            return redirect()->back();
        } else {
            Alert::error('Oops!', 'Check Failed Messages Page!');
            return redirect()->back();
        }

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Model\Sms $sms
     * @return \Illuminate\Http\Response
     */
    public function show(Sms $sms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Sms $sms
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
     * @param \App\Model\Sms $sms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sms $sms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Sms $sms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sms $sms)
    {
        //
    }

    public function messageFormat($message, $name, $street, $city, $state, $zip)
    {

        $search = array('{name}', '{street}', '{city}', '{state}', '{zip}');
        $replace = array($name, $street, $city, $state, $zip);
        $message = str_replace($search, $replace, $message);
        return $message;
    }

    public function sendBulkSms($sid, $token, $sender_number, $receiver_number, $message, $media_file)
    {
        try {
            $client = new Client($sid, $token);
            if ($media_file != null) {
                $sms_sent = $client->messages->create(
                    $receiver_number,
                    [
                        'from' => $sender_number,
                        'body' => $message,
                        'mediaUrl' => [$media_file],
                    ]
                );
            } else {
                $sms_sent = $client->messages->create(
                    $receiver_number,
                    [
                        'from' => $sender_number,
                        'body' => $message,
                    ]
                );
            }
            if ($sms_sent) {
                $old_sms = Sms::where('client_number', $receiver_number)->first();
                if ($old_sms == null) {
                    $sms = new Sms();
                    $sms->client_number = $receiver_number;
                    $sms->twilio_number = $sender_number;
                    $sms->message = $message;
                    $sms->media = $media_file == null ? 'No' : $media_file;
                    $sms->status = 1;
                    $sms->save();
                    $contact = Contact::where('number', $receiver_number)->first();
                    $contact->msg_sent=true;
                    $contact->save();
                    $this->incrementSmsCount($sender_number);
                } else {
                    $reply_message = new Reply();
                    $reply_message->sms_id = $old_sms->id;
                    $reply_message->to = $receiver_number;
                    $reply_message->from = $sender_number;
                    $reply_message->reply = $message;
                    $reply_message->system_reply = 1;
                    $reply_message->save();
                    $contact = Contact::where('number', $receiver_number)->first();
                    $contact->msg_sent=true;
                    $contact->save();
                    $this->incrementSmsCount($sender_number);
                }
            }
            return 1;
        } catch (\Exception $ex) {
            $failed_sms = new FailedSms();
            $failed_sms->client_number = $receiver_number;
            $failed_sms->twilio_number = $sender_number;
            $failed_sms->message = $message;
            $failed_sms->media = $media_file == null ? 'No' : $media_file;
            $failed_sms->error = $ex->getMessage();
            $failed_sms->save();
            return 0;
        }
    }



    public function sendBulkSmsByCategory($sid, $token, $sender_number, $receiver_number, $message, $media_file)
    {
        try {
            $client = new Client($sid, $token);
            if ($media_file != null) {
                $sms_sent = $client->messages->create(
                    $receiver_number->number,
                    [
                        'from' => $sender_number,
                        'body' => $message,
                        'mediaUrl' => [$media_file],
                    ]
                );
            } else {
                $sms_sent = $client->messages->create(
                    $receiver_number->number,
                    [
                        'from' => $sender_number,
                        'body' => $message,
                    ]
                );
            }
            if ($sms_sent) {
                $old_sms = Sms::where('client_number', $receiver_number->number)->first();
                if ($old_sms == null) {
                    $sms = new Sms();
                    $sms->client_number = $receiver_number->number;
                    $sms->twilio_number = $sender_number;
                    $sms->message = $message;
                    $sms->media = $media_file == null ? 'No' : $media_file;
                    $sms->status = 1;
                    $sms->save();
                    $receiver_number->msg_sent=true;
                    $receiver_number->save();
                    $this->incrementSmsCount($sender_number);
                } else {
                    $reply_message = new Reply();
                    $reply_message->sms_id = $old_sms->id;
                    $reply_message->to = $receiver_number->number;
                    $reply_message->from = $sender_number;
                    $reply_message->reply = $message;
                    $reply_message->system_reply = 1;
                    $reply_message->save();
                    $receiver_number->msg_sent=true;
                    $receiver_number->save();
                    $this->incrementSmsCount($sender_number);
                }
            }
            return 1;
        } catch (\Exception $ex) {
            $failed_sms = new FailedSms();
            $failed_sms->client_number = $receiver_number->number;
            $failed_sms->twilio_number = $sender_number;
            $failed_sms->message = $message;
            $failed_sms->media = $media_file == null ? 'No' : $media_file;
            $failed_sms->error = $ex->getMessage();
            $failed_sms->save();
            return 0;
        }
    }



    public function contactEscapeString(Request $request)
    {
        $escape_arr = array(' ', '-', '(', ')', ' ');
        foreach ($escape_arr as $key => $value) {
            $request->receiver_number = str_replace($value, '', $request->receiver_number);
        }
        return Str::startsWith($request->receiver_number, '+1') ? $request->receiver_number : $request->receiver_number = '+1' . $request->receiver_number;
    }

    public function incrementSmsCount(string $number)
    {
        $number=Number::where('number',$number)->first();
        $number->sms_count++;
        $number->save();
    }

}
