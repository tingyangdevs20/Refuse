<?php

namespace App\Console\Commands;

use App\Mail\UserAgreementDownloadPDF;
use App\Model\UserAgreement;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AgreementPDF extends Command
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

        foreach ($userAgreementIds as $key => $userAgreementId) {
            $userAgreement = UserAgreement::find($userAgreementId);
            $content       = stripslashes($userAgreement->content);
            $pdf           = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView('agreement.pdf', compact('content', 'pdf'));
            $fileName = getUniqueFileName() . ".pdf";
            $pdf->save($pdfPath . '/' . $fileName);
            $userAgreement->pdf_path = $fileName;
            $userAgreement->save();

            $userAgreementSellers = $userAgreement->userAgreementSeller;

            foreach ($userAgreementSellers as $userAgreementSeller) {
                $userEmail = $userAgreementSeller->user->email;
                Mail::to($userEmail)->send(new UserAgreementDownloadPDF($userAgreementId));
            }

        }
        return 0;
    }
}
