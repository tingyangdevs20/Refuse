<?php

namespace App\Listeners;

use App\Model\Contact;
use App\Model\FailedSms;
use App\Model\Number;
use App\Model\Reply;
use App\Model\Sms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Twilio\Rest\Client;

class SendBulkSMSListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        echo "Sending Bulk SMS";
        foreach ($event->contacts as $contact) {
            $templateCounter = rand(0, $event->templates->count() - 1);
            $numberCounter = rand(0, $event->numbers->count() - 1);

            $message = $this->messageFormat($event->templates[$templateCounter]->body,
                                            $contact->name,
                                            $contact->street,
                                            $contact->city,
                                            $contact->state,
                                            $contact->zip);
            $this->sendBulkSms($event->numbers[$numberCounter]->accountid(),
                $event->numbers[$numberCounter]->accountToken(),
                $event->numbers[$numberCounter]->number,
                $contact->number,
                $message);
        }

    }

    public function messageFormat($message, $name, $street, $city, $state, $zip)
    {
        $search = array('{name}', '{street}', '{city}', '{state}', '{zip}');
        $replace = array($name, $street, $city, $state, $zip);
        $message = str_replace($search, $replace, $message);
        return $message;
    }

    public function sendBulkSms($sid, $token, $sender_number, $receiver_number, $message)
    {
        try {
            $client = new Client($sid, $token);
            $sms_sent = $client->messages->create(
                $receiver_number,
                [
                    'from' => $sender_number,
                    'body' => $message,
                ]
            );
            if ($sms_sent) {
                $old_sms = Sms::where('client_number', $receiver_number)->first();
                if ($old_sms == null) {
                    $sms = new Sms();
                    $sms->client_number = $receiver_number;
                    $sms->twilio_number = $sender_number;
                    $sms->message = $message;
                    $sms->media = "NO";
                    $sms->status = 1;
                    $sms->save();
                    $contact = Contact::where('number', $receiver_number)->first();
                    $contact->msg_sent = true;
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
                    $contact->msg_sent = true;
                    $contact->save();
                    $this->incrementSmsCount($sender_number);
                }
            }
        } catch (\Exception $ex) {
            $failed_sms = new FailedSms();
            $failed_sms->client_number = $receiver_number;
            $failed_sms->twilio_number = $sender_number;
            $failed_sms->message = $message;
            $failed_sms->media = "NO";
            $failed_sms->error = $ex->getMessage();
            $failed_sms->save();
        }
    }

    public function incrementSmsCount(string $number)
    {
        $number = Number::where('number', $number)->first();
        $number->sms_count++;
        $number->save();
    }

}
