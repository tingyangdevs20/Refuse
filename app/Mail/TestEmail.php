<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = 'help@propdaddyserver.com';
        $subject = $this->data['subject'];
        $name = $this->data['name'];

        return $this->view('emails.test')
                    ->from($address, 'Brian B. (House Helpers)')
                    //->cc($address, $name)
                    //->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([ 'test_message' => $this->data['message'], 'unsub_link' => $this->data['unsub_link'] ]);
    }
}