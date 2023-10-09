<?php

namespace App\Mail;

use App\Model\UserAgreement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use App\Model\UserAgreementSeller;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Model\UserAgreement
     */
  
    /**
     * Create a new message instance.
     *
     * @param int $userAgreementId
     * @author Bhavesh Vyas
     */
    public function __construct()
    {
        
    }

    /**
     * Build the message.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function build()
    {
        

       

            return ('test campaign mail')
                ->subject('test mail...')
                ->with([
                    'url'      => $url,
                    'userName' => $userName,
                ]);
        
    }
}
