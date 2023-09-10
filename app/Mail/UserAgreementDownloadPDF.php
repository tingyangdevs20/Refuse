<?php

namespace App\Mail;

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

            return $this->from(Config("mail.from.address"), Config("mail.from.name"))
                ->view('agreement.mail')
                ->with([
                    'url'      => $url,
                    'userName' => $userName,
                ]);
        }
    }
}
