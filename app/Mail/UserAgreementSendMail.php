<?php

namespace App\Mail;

use App\Model\UserAgreement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class UserAgreementSendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Model\UserAgreement
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @param int $userAgreementId
     * @author Bhavesh Vyas
     */
    public function __construct(UserAgreement $userAgreement)
    {
        $this->userAgreement = $userAgreement;
        $this->userAgreementId = $userAgreement->id;
    }

    /**
     * Build the message.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function build()
    {
        $userAgreement = UserAgreement::select("user_agreements.id", "user_agreements.studio_id", "user_agreements.studio_id", "user_agreements.is_sign", "users.name as user_name", "users.email")
            ->where("user_agreements.id", $this->userAgreementId)
            // ->where("user_agreements.is_sign", "2")
            // ->whereNotNull("user_agreements.sign")
            // ->whereNotNull("user_agreements.pdf_path")
            ->leftJoin("users", "users.id", "user_agreements.user_id")
            ->first();

        if ($userAgreement) {

            $url      = route("user.agreement.pdf", Crypt::encrypt($userAgreement->id));
            $userName = ucfirst($userAgreement->user_name);


            return $this->view('agreement.mail')
                ->subject('User Agreement')
                ->with([
                    'url'      => $url,
                    'userName' => $userName,
                ]);
        }
    }
}
