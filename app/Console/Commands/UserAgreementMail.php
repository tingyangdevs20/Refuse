<?php

namespace App\Console\Commands;

use App\Mail\CampaignConfirmation;
use App\Mail\UserAgreementSendMail;
use App\Model\UserAgreement;
use App\Model\UserAgreementSeller;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Support\Facades\Auth;

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

        $userAgreement = UserAgreement::where("id", $userAgreementId)
            ->first();

        if ($userAgreement) {
            $userAgreementSellers = UserAgreementSeller::where("user_agreement_id", $userAgreementId)
                ->get();

            foreach ($userAgreementSellers as $userAgreementSeller) {
                $new_array = [];
                $contacts = DB::table('contacts')->where('id', $userAgreementSeller->user_id)->first(['name','last_name','street','city','state','zip','number','number2','number3','number3','email1','email2']);
                if(!empty($contacts)){
                    foreach($contacts as $key => $contact){
                        $new_array['{'.$key.'}'] = $contact;
                    }
                }

                $leadinfo1 = DB::table('lead_info')->where('contact_id', $userAgreementSeller->user_id)->first();
                if ($leadinfo1) {
                    // The query returned a valid result, so you can access its properties safely
                    DB::table('lead_info')->where('contact_id', $userAgreementSeller->user_id)->update([
                        'user_1_name' => $leadinfo1->owner1_first_name.' ' .$leadinfo1->owner1_last_name ,
                        'user_2_name' => $leadinfo1->owner2_first_name.' ' .$leadinfo1->owner2_last_name ,
                        'user_3_name' => $leadinfo1->owner3_first_name.' ' .$leadinfo1->owner3_last_name,
                    ]);
                }
                $leadinfo = DB::table('lead_info')->where('contact_id', $userAgreementSeller->user_id)->first(['owner1_first_name','owner1_last_name','owner1_primary_number','owner1_number2','owner1_number3','owner1_email1','owner1_email2','owner1_dob','owner1_mother_name','owner2_first_name','owner2_last_name','owner2_primary_number','owner2_number2','owner2_number3','owner2_email1','owner2_email2','owner2_social_security','owner2_dob','owner2_mother_name','owner3_first_name','owner3_last_name','owner3_primary_number','owner3_number2','owner3_number3','owner3_email1','owner3_email2','owner3_social_security','owner3_dob','owner3_mother_name', 'user_1_name', 'user_1_signature', 'user_2_name', 'user_2_signature', 'user_3_name', 'user_3_signature']);
                if(!empty($leadinfo)){
                    foreach($leadinfo as $key => $lead){
                        $new_array['{'.$key.'}'] = $lead;
                    }
                }


                $property_infos = DB::table('property_infos')->where('contact_id', $userAgreementSeller->user_id)->first(['property_address','property_city','property_state','property_zip','map_link','zillow_link']);
                if(!empty($property_infos) ){
                    foreach($property_infos as $key => $property){
                        $new_array['{'.$key.'}'] = $property;
                    }
                }

                $users = DB::table('users')->first(["name", "email", "mobile", "company_name" , "address", "street", "state", "city", "zip"]);
                if(!empty($users) ){
                    foreach($users as $key => $user){
                        $new_array['{user_'.$key.'}'] = $user;
                    }
                }

               // $new_array['{auth_email}'] =  Auth::id();
                $settings = DB::table('settings')->where('id', '1')->first(["auth_email", "document_closed_by"]);
                if(!empty($settings) ){
                    foreach($settings as $key => $setting){
                        $new_array['{'.$key.'}'] = $setting;
                    }
                }
                //$new_array['{auth_email}'] = $settings->auth_email;
                $title_company = DB::table('title_company')->where('contact_id', $userAgreementSeller->user_id)->first(["buy_sell_entity_detail"]);
                if(!empty($title_company) ){
                    foreach($title_company as $key => $title){
                        $new_array['{'.$key.'}'] = $title;
                    }
                }


                $agreementDirectory = "agreement_pdf";
                $pdfPath            = public_path($agreementDirectory);
                makeDir($pdfPath, true);

                //$userAgreement_update_pdf = UserAgreement::find($userAgreementId);
                $content       = stripslashes($userAgreement->content);
                $content       = str_replace("{SIGNATURE_USER}", "", $content);
                if(!empty($new_array) && !empty($content)){
                    $find = array_keys($new_array);
                    $replace = array_values($new_array);
                    $content = str_replace($find, $replace, $content);
                }
                $pdf           = app('dompdf.wrapper');
                $pdf->getDomPDF()->set_option("enable_php", true);
                $pdf->loadView('agreement.pdf', compact('content', 'pdf'));
                $fileName = getUniqueFileName() . ".pdf";
                $pdf->save($pdfPath . '/' . $fileName);
                if($userAgreementSeller->pdf_path == null || $userAgreementSeller->pdf_path == ''){

                    $userAgreementSeller->pdf_path = $fileName;
                    $userAgreementSeller->save();
                }

                if ($userAgreementSeller->is_send_mail != "1") {
                    try {
                        if ($userAgreementSeller->user->email1 != '') {
                            $userEmail = $userAgreementSeller->user->email1;
                        } elseif ($userAgreementSeller->user->email2) {
                            $userEmail = $userAgreementSeller->user->email2;
                        }

                        Log::info(Crypt::encrypt($userAgreementSeller->id));


                        Mail::to($userEmail)
                            ->bcc("developer@technosharks.com")
                            ->send(new UserAgreementSendMail($userAgreement,$userAgreementSeller->id));

                        $userAgreementSeller->is_send_mail = "1";
                        $userAgreementSeller->save();
                        $userAgreement->is_sign = '2';
                        $userAgreement->save();
                    } catch (Exception $ex) {
                        
                    }
                }
            }
        }
        return 0;
    }
}
