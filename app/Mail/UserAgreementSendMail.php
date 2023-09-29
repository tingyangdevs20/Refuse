<?php

namespace App\Mail;

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
        // $userAgreement = UserAgreement::select("user_agreements.id", "user_agreements.is_sign", "users.name as user_name", "users.email")
        //     ->where("user_agreements.id", $this->userAgreementId)
        //     // ->where("user_agreements.is_sign", "2")
        //     // ->whereNotNull("user_agreements.sign")
        //     // ->whereNotNull("user_agreements.pdf_path")
        //     ->leftJoin("users", "users.id", "user_agreements.user_id")
        //     ->first();
        //dd($this->userAgreementSellerId);
        $userAgreementSeller = UserAgreementSeller::find($this->userAgreementSellerId);

        if ($userAgreementSeller) {
            $url      = route("user.agreement.pdf", Crypt::encrypt($this->userAgreementSellerId));
            $userName = ucfirst($userAgreementSeller->user->name);

            return $this->view('agreement.mail')
                ->subject('User Agreement')
                ->with([
                    'url'      => $url,
                    'userName' => $userName,
                ]);
        }
    }
}
