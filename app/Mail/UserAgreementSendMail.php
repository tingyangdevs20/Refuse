<?php

namespace App\Mail;

use App\Model\Settings;
use App\Model\UserAgreement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use App\Model\UserAgreementSeller;

class UserAgreementSendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Model\UserAgreement
     */
    public $order;
    public $userAgreementSellerId;
    /**
     * Create a new message instance.
     *
     * @param int $userAgreementId
     * @author Bhavesh Vyas
     */
    public function __construct(UserAgreement $userAgreement,int $userAgreementSellerId)
    {
        $this->userAgreement = $userAgreement;
        $this->userAgreementId = $userAgreement->id;
        $this->userAgreementSellerId = $userAgreementSellerId;
    }

    /**
     * Build the message.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function build()
    {
        $userAgreementSeller = UserAgreementSeller::find($this->userAgreementSellerId);
        $settings = Settings::first();
        if($settings){
            
            $mail_signature = $settings->auth_email;
            if(!$mail_signature) {
                $mail_signature = "REIFuze";
            }
        } else {
            $mail_signature = "REIFuze";
        }
        if ($userAgreementSeller) {
            $url      = route("user.agreement.pdf", Crypt::encrypt($this->userAgreementSellerId));
            $userName = ucfirst($userAgreementSeller->user->name);

            return $this->view('agreement.mail')
                ->subject('User Agreement')
                ->with([
                    'url'      => $url,
                    'userName' => $userName,
                    'mail_signature' => $mail_signature,
                ]);
        }
    }
}
