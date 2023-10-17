<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendBulkSMSEvent;
use App\Http\Controllers\Controller;
use App\Model\Contact;
use App\Model\FailedSms;
use App\Model\Group;
use App\Model\Market;
use App\Model\Number;
use App\Model\Settings;
use App\Model\Reply;
use App\Model\Sms;
use App\Model\Template;
use App\Model\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Twilio\Rest\Client;

class OneSMSController extends Controller
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
        $markets = Market::all();
        $categories = Category::all();

        return view('back.pages.sms.oat.index', compact('numbers', 'templates', 'groups', 'markets', 'categories'));
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
       // dd("in here");
        $numbers = Number::where('id', 1)->get();
        //print_r($numbers);
        // die("--");
        $contact = Contact::where('number', $request->number)->first();
        $templates = Template::where('category_id', $request->category)->get();

        // $market = Market::find($request->sender_market);
        $settings = Settings::first()->toArray(); 
        $sid = $settings['twilio_api_key'];
        $token = $settings['twilio_acc_secret'];

        $templateCounter = rand(0, $templates->count() - 1);
        $numberCounter = 0;
        $message = $this->messageFormat($templates[$templateCounter]->body, $contact->name, $contact->street, $contact->city, $contact->state, $contact->zip);
        try {
           $client = new Client($sid, $token);
             $sms_sent = $client->messages->create(
                 $contact->number,
                 [
                     'from' => $numbers[$numberCounter]->number,
                     'body' => $message,
                 ]
             );
            if ($sms_sent) {
                $old_sms = Sms::where('client_number', $contact->number)->first();
                if ($old_sms == null) {
                    $sms = new Sms();
                    $sms->client_number = $contact->number;
                    $sms->twilio_number = $numbers[$numberCounter]->number;
                    $sms->template_cat_id=$templates[$templateCounter]->category_id;
                    $sms->message = $message;
                    $sms->media = "NO";
                    $sms->status = 1;
                    $sms->save();
                    $contact = Contact::where('number', $contact->number)->get();;
                    foreach ($contact as $contacts) {
                        $contacts->msg_sent = 1;
                        $contacts->save();
                    }
                    $this->incrementSmsCount($numbers[$numberCounter]->number);
                } else {
                    $reply_message = new Reply();
                    $reply_message->sms_id = $old_sms->id;
                    $reply_message->to = $contact->number;
                    $reply_message->from = $numbers[$numberCounter]->number;
                    $reply_message->reply = $message;
                    $reply_message->system_reply = 1;
                    $reply_message->save();
                    $contact = Contact::where('number', $contact->number)->get();;
                    foreach ($contact as $contacts) {
                        $contacts->msg_sent = 1;
                        $contacts->save();
                    }
                    $this->incrementSmsCount($numbers[$numberCounter]->number);
                }

                Alert::toast("SMS Sent Successfully", "success");
                return $this->showDetails($request);
            }
        } catch (\Exception $ex) {
            $failed_sms = new FailedSms();
            $failed_sms->client_number = $contact->number;
            $failed_sms->twilio_number = $numbers[$numberCounter]->number;
            $failed_sms->message = $message;
            $failed_sms->media = "NO";
            $failed_sms->error = $ex->getMessage();
            $failed_sms->save();
            Alert::Error("Oops!", "Unable to send check Failed SMS Page!");
            return $this->showDetails($request);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showDetails(Request $request)
    {
        $contact = Contact::where('group_id', $request->group)->where('is_dnc', 0)->where('msg_sent', 0)->first();
        $market = Market::find($request->sender_market);

        if ($market->totalSends() - $market->availableSends() <= 0) {
            Alert::error('Oops!', 'Select a market with more available sends');
            return $this->index();
        }
        if ($contact == null) {
            Alert::error('Oops!', 'No contacts found in this list that haven\'t received Messages yet');
            return $this->index();
        }
        return view('back.pages.sms.oat.details', compact('contact', 'request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function incrementSmsCount(string $number)
    {
        $number = Number::where('number', $number)->first();
        $number->sms_count++;
        $number->save();
    }

    public function messageFormat($message, $name, $street, $city, $state, $zip)
    {
        $search = array('{name}', '{street}', '{city}', '{state}', '{zip}');
        $replace = array($name, $street, $city, $state, $zip);
        $message = str_replace($search, $replace, $message);
        return $message;
    }


}
