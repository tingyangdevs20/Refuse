<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public $groupName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.campaign-confirmation')
            ->subject('Campaign Confirmation');
    }
}
