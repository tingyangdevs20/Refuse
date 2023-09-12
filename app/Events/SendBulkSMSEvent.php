<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendBulkSMSEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $numbers;
    public $contacts;
    public $templates;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($numbers, $contacts, $templates)
    {
        $this->numbers = $numbers;
        $this->contacts = $contacts;
        $this->templates = $templates;
    }
}
