<?php

namespace App\Mail;

use App\Model\Settings;
use App\Model\UserAgreement;
use App\Model\UserAgreementSeller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class UserAgreementDownloadPDF extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * user agreement id
     *
     * @var int
     * @author Bhavesh Vyas
     */
    public $userAgreementSellerId;

    /**
     * Create a new message instance.
     *
     * @param int $userAgreementSellerId
     * @author Bhavesh Vyas
     */
    public function __construct(int $userAgreementSellerId)
    {
        $this->userAgreementSellerId = $userAgreementId;
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

        if ($userAgreementSeller) {

            $url      = route("user.agreement.pdf", Crypt::encrypt($this->userAgreementSellerId));
            $userName = ucfirst($userAgreementSeller->user->name);

            // return $this->from(Config("mail.from.address"), Config("mail.from.name"))
            //     ->view('agreement.mail')
            //     ->with([
            //         'url'      => $url,
            //         'userName' => $userName,
            //     ]);

            $settings = Settings::first();
            if($settings){
                
                $mail_signature = $settings->auth_email;
                if(!$mail_signature) {
                    $mail_signature = "REIFuze";
                }
            } else {
                $mail_signature = "REIFuze";
            }

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
