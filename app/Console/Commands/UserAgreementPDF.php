<?php

namespace App\Console\Commands;

use App\Mail\UserAgreementDownloadPDF;
use App\Model\UserAgreement;
use App\Model\UserAgreementSeller;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UserAgreementPDF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * @author Bhavesh Vyas
     */
    protected $signature = 'agreement:pdf';

    /**
     * description of the console command.
     *
     * @var string
     * @author Bhavesh Vyas
     */
    protected $description = 'Generate Agreement PDF';

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

        $userAgreementIds = UserAgreement::whereNull("pdf_path")
            ->where("is_sign", "2")
            ->pluck("id")
            ->all();

        $agreementDirectory = "agreement_pdf";
        $pdfPath            = storage_path("app/public/" . $agreementDirectory);
        makeDir($pdfPath, true);
        $userAgreement = null;
        foreach ($userAgreementIds as $key => $userAgreementId) {
            $userAgreement = UserAgreement::find($userAgreementId);
            $content       = stripslashes($userAgreement->content);
            $content       = str_replace("{SIGNATURE_USER}", "", $content);
            $pdf           = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView('agreement.pdf', compact('content', 'pdf'));
            $fileName = getUniqueFileName() . ".pdf";
            $pdf->save($pdfPath . '/' . $fileName);
            $userAgreement->pdf_path = $fileName;
            $userAgreement->save();
        }
        $userAgreementSel = UserAgreementSeller::where('user_agreement_id', $userAgreement)->first();
        

        $lead = DB::table('lead_info')->where('contact_id', $userAgreementSel->user_id)->first(['mail_to_owner1', 'mail_to_owner2', 'mail_to_owner3', 'owner1_email1', 'owner1_email2', 'owner2_email1', 'owner2_email2', 'owner3_email1', 'owner3_email2', ]);
        if ($lead->mail_to_owner1) {
            $userAgreementSeller =  UserAgreementSeller::where(["user_id"=> $userAgreementSel->user_id, "contact_number"=> "mail_to_owner1"])->first();
            if ($userAgreementSeller) {
                if(!empty($lead->owner1_email1)){
                    $this->sendMails($userAgreement, $userAgreementSeller, $lead->owner1_email1);
                } else {
                    $this->sendMails($userAgreement, $userAgreementSeller, $lead->owner1_email2);
                }
            }
        } 
        if ($lead->mail_to_owner2) {
            $userAgreementSeller =  UserAgreementSeller::where(["user_id"=> $userAgreementSel->user_id, "contact_number"=> "mail_to_owner2"])->first();
            if ($userAgreementSeller) {
                if(!empty($lead->owner1_email1)){
                    $this->sendMails($userAgreement, $userAgreementSeller, $lead->owner2_email1);
                } else {
                    $this->sendMails($userAgreement, $userAgreementSeller, $lead->owner2_email2);
                }
            }
        }
        if ($lead->mail_to_owner3) {
            $userAgreementSeller =  UserAgreementSeller::where(["user_id"=> $userAgreementSel->user_id, "contact_number"=> "mail_to_owner3"])->first();
            if ($userAgreementSeller) {
                if(!empty($lead->owner1_email1)){
                    $this->sendMails($userAgreement, $userAgreementSeller, $lead->owner3_email1);
                } else {
                    $this->sendMails($userAgreement, $userAgreementSeller, $lead->owner3_email2);
                }
            }
        }
        return 0;
    }
    public function sendMails($userAgreement, $userAgreementSeller, $userEmail){
        try {
            Mail::to($userEmail)
                ->bcc("bhaveshvyas23@gmail.com")
                ->send(new UserAgreementDownloadPDF($userAgreement, $userAgreementSeller->id));
        } catch (Exception $ex) {

        }
    }
}
