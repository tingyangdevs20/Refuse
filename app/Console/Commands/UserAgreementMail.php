<?php

namespace App\Console\Commands;

use App\Mail\UserAgreementSendMail;
use App\Model\UserAgreement;
use App\Model\UserAgreementSeller;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserAgreementMail extends Command
{
    public $userAgreementId;

    /**
     * The name and signature of the console command.
     *
     * @var string
     * @author Bhavesh Vyas
     */
    protected $signature = 'agreement:mail {userAgreementId}';

    /**
     * description of the console command.
     *
     * @var string
     * @author Bhavesh Vyas
     */
    protected $description = 'Send User Agreement Mail';

    /**
     * Create a new command instance.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @author Bhavesh Vyas
     */
    public function handle()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        set_time_limit(0);

        Log::info("here send mail called");

        $userAgreementId = $this->argument('userAgreementId');

        $userAgreement = UserAgreement::whereNull("pdf_path")
            ->where("id", $userAgreementId)
            ->first();

        if ($userAgreement) {
            $userAgreementSellers = UserAgreementSeller::where("user_agreement_id", $userAgreementId)
                ->get();
            foreach ($userAgreementSellers as $userAgreementSeller) {
                if ($userAgreementSeller->is_mail_sent != "1") {
                    try {
                        if ($userAgreementSeller->user->email1 != '') {
                            $userEmail = $userAgreementSeller->user->email1;
                        } elseif ($userAgreementSeller->user->email2) {
                            $userEmail = $userAgreementSeller->user->email2;
                        }
                        Log::info(Crypt::encrypt($userAgreementSeller->id));
                        Mail::to($userEmail)
                            ->bcc("bhaveshvyas23@gmail.com")
                            ->send(new UserAgreementSendMail($userAgreement, $userAgreementSeller));
                        $userAgreementSeller->is_mail_sent = "1";
                        $userAgreementSeller->save();
                    } catch (Exception $ex) {

                    }
                }
            }

            // $userAgreementSellerCount     = $userAgreementSellers->count();
            // $userAgreementSellerSendCount = UserAgreementSeller::where("user_agreement_id", $userAgreementId)
            //     ->where("is_mail_sent", 1)
            //     ->count();
            // if ($userAgreementSellerCount == $userAgreementSellerSendCount) {
            //     $userAgreement->is_mail_sent = "1";
            //     $userAgreement->save();
            // }
        }
        return 0;
    }
}
