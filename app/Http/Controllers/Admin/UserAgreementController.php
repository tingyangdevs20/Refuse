<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Contact;
use App\Model\FormTemplate;
use App\Model\Settings;
use App\Model\UserAgreement;
use App\Model\UserAgreementSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Artisan;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use DB;
use Illuminate\Support\Facades\Schema;

class UserAgreementController extends Controller
{
    public $viewPath = "back.pages.user-agreement.";

    /**
     * list user agreement
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function index()
    {
        //sachin
        $settings = Settings::first();
        $userAgreements = UserAgreement::select('user_agreements.*', 'form_templates.template_name')
            ->leftjoin('form_templates', 'form_templates.id', 'user_agreements.template_id')
            ->get();
        //sachin
        return view($this->viewPath . 'index', compact('userAgreements', 'settings'));
    }

    /**
     * create user agreement
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function create()
    {
        $response = [
            'success' => true,
            'html'    => view($this->viewPath . 'form')->render(),
        ];
        return response()->json($response, 200);
    }

    /**
     * store user agreement
     *
     * @param Request $request
     * @return void
     * @author Bhavesh Vyas
     */

    public function store(Request $request)
    {
        $rules = [
            'template_id' => ['required'],
            'content'     => ['required'],
        ];

        $message = [
            'template_id.required'    => "This field is required!",
            'agreement_date.required' => "This field is required!",
            'content.required'        => "This field is required!",
        ];
        
        if(!$request->mail_to_owner1 && !$request->mail_to_owner2 && !$request->mail_to_owner3) {
            $rules = [
                "seller_name" => ['required'],
                
            ];

        $validator = Validator::make($request->all(), $rules, $message);
            
        }
        $contact_id = $request->contact_id;
        

        $columns_with_user = [];
        
        $selle_name = Contact::find($contact_id);
        $lead = DB::table('lead_info')->where('contact_id', $contact_id)->first(['mail_to_owner1', 'mail_to_owner2', 'mail_to_owner3', 'owner1_email1', 'owner1_email2', 'owner2_email1', 'owner2_email2', 'owner3_email1', 'owner3_email2' ]);

        if($lead->mail_to_owner1){
            
            if(empty($lead->owner1_email1) && empty($lead->owner1_email2)){
            
                $rules = [
                    "Contact_1_Email" => ['required'],
                    
                ];
                
            } 
        }
        if($lead->mail_to_owner2){
            if(empty($lead->owner2_email1) && empty($lead->owner2_email2)){
            
                $rules = [
                    "Contact_2_Email" => ['required'],
                    
                ];
    
            } 
        }
        if($lead->mail_to_owner3){
            if(empty($lead->owner3_email1) && empty($lead->owner3_email2)){
            
                $rules = [
                    "Contact_3_Email" => ['required'],
                    
                ];
    
            } 
        }
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'errors'  => $validator->errors()->toArray(),
            ];
            return response()->json($response, 400);
        }
        $pattern = '/\{([^}]+)\}/';
        preg_match_all($pattern, $request->content, $matches);
        $emptyColumns = [];
        // $matches[1] will contain the words or substrings
        $wordsInCurlyBraces = $matches[1];
        $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'contacts', $contact_id);
        $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'lead_info', $contact_id);
        $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'property_infos', $contact_id);
        $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'settings', $contact_id);
        $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'title_company', $contact_id);
        $columns = [];
        $emptyColumns = array_unique(array_filter($emptyColumns));
        
        if(!empty($emptyColumns)){
            foreach($emptyColumns as $col){
                $columns_with_user[$selle_name->name] = $col;
                
            }
        }
        
        
        if( !empty($columns_with_user)) {
            return response()->json(["success" => false , "errors" => $columns_with_user], 400);
        }
        
        $userAgreement                             = new UserAgreement();
        $userAgreement->template_id                = $request->template_id;
        $userAgreement->agreement_date             = date("Y-m-d");
        $userAgreement->content                    = $request->content;
        $userAgreement->agreement_template_content = $request->content;
        $userAgreement->admin_id                   = auth()->id();
        $userAgreement->created_at                 = date("Y-m-d H:i:s");
        $userAgreement->updated_at                 = date("Y-m-d H:i:s");
        $userAgreement->save();
        
        $replaceSignature = "";
        if($request->mail_to_owner1){
            $replaceSignature .= "<p>{SIGNATURE_$contact_id}</p>";
            $userAgreementSeller                    = new UserAgreementSeller();
            $userAgreementSeller->user_agreement_id = $userAgreement->id;
            $userAgreementSeller->user_id           = $contact_id;
            $userAgreementSeller->signature_key     = "{SIGNATURE_$contact_id}";
            $userAgreementSeller->contact_number = "mail_to_owner1";
            $userAgreementSeller->created_at        = date("Y-m-d H:i:s");
            $userAgreementSeller->updated_at        = date("Y-m-d H:i:s");
            $userAgreementSeller->save();
        }

        if($request->mail_to_owner2){
            $replaceSignature .= "<p>{SIGNATURE_$contact_id}</p>";
            $userAgreementSeller                    = new UserAgreementSeller();
            $userAgreementSeller->user_agreement_id = $userAgreement->id;
            $userAgreementSeller->user_id           = $contact_id;
            $userAgreementSeller->signature_key     = "{SIGNATURE_$contact_id}";
            $userAgreementSeller->contact_number = "mail_to_owner2";
            $userAgreementSeller->created_at        = date("Y-m-d H:i:s");
            $userAgreementSeller->updated_at        = date("Y-m-d H:i:s");
            $userAgreementSeller->save();    
        }

        if($request->mail_to_owner3){
            $replaceSignature .= "<p>{SIGNATURE_$contact_id}</p>";
            $userAgreementSeller                    = new UserAgreementSeller();
            $userAgreementSeller->user_agreement_id = $userAgreement->id;
            $userAgreementSeller->user_id           = $contact_id;
            $userAgreementSeller->signature_key     = "{SIGNATURE_$contact_id}";
            $userAgreementSeller->contact_number = "mail_to_owner3";
            $userAgreementSeller->created_at        = date("Y-m-d H:i:s");
            $userAgreementSeller->updated_at        = date("Y-m-d H:i:s");
            $userAgreementSeller->save();
        }
            
        

        if ($replaceSignature != "") {
            $replaceSignature .= "<p>{SIGNATURE_USER}</p>";
            $userAgreement->content = str_replace("<p>{SIGNATURE_USER}</p>", $replaceSignature, $userAgreement->content);
            $userAgreement->save();
        }

        Artisan::call("agreement:mail", ['contact_id' => $contact_id]);
        //runCURL(url("api/agreement/{$userAgreement->id}/mail"));

        $response = [
            'success' => true,
            'message' => "Contract has been created successfully.",
        ];

        return response()->json($response, 200);
    }

    public function pdf(Request $request){
        return $request->all();
        $rules = [
            'content'     => ['required'],
        ];

        $message = [
            'template_id.required'    => "This field is required!",
            'agreement_date.required' => "This field is required!",
            'content.required'        => "This field is required!",
        ];
        
        $validator = Validator::make($request->all(), $rules, $message);
        $contact_id = $request->contact_id;
        

        $columns_with_user = [];
        
        $selle_name = Contact::find($contact_id);
        $lead = DB::table('lead_info')->where('contact_id', $contact_id)->first(['mail_to_owner1', 'mail_to_owner2', 'mail_to_owner3', 'owner1_email1', 'owner1_email2', 'owner2_email1', 'owner2_email2', 'owner3_email1', 'owner3_email2' ]);

        if($lead->mail_to_owner1){
            
            if(empty($lead->owner1_email1) && empty($lead->owner1_email2)){
            
                $rules = [
                    "Contact_1_Email" => ['required'],
                    
                ];
                
            } 
        }
        if($lead->mail_to_owner2){
            if(empty($lead->owner2_email1) && empty($lead->owner2_email2)){
            
                $rules = [
                    "Contact_2_Email" => ['required'],
                    
                ];
    
            } 
        }
        if($lead->mail_to_owner3){
            if(empty($lead->owner3_email1) && empty($lead->owner3_email2)){
            
                $rules = [
                    "Contact_3_Email" => ['required'],
                    
                ];
    
            } 
        }
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'errors'  => $validator->errors()->toArray(),
            ];
            return response()->json($response, 400);
        }
        $pattern = '/\{([^}]+)\}/';
        preg_match_all($pattern, $request->content, $matches);
        $emptyColumns = [];
        // $matches[1] will contain the words or substrings
        $wordsInCurlyBraces = $matches[1];
        $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'contacts', $contact_id);
        $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'lead_info', $contact_id);
        $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'property_infos', $contact_id);
        $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'settings', $contact_id);
        $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'title_company', $contact_id);
        $emptyColumns = array_unique(array_filter($emptyColumns));
        
        if(!empty($emptyColumns)){
            foreach($emptyColumns as $col){
                $columns_with_user[$selle_name->name] = $col;
                
            }
        }
        
        if( !empty($columns_with_user)) {
            return response()->json(["success" => false , "errors" => $columns_with_user], 400);
        }
        
        $replaceSignature = "";
        $new_array = [];
            $contacts = DB::table('contacts')->where('id', $contact_id)->first(['name','last_name','street','city','state','zip','number','number2','number3','number3','email1','email2']);
            if(!empty($contacts)){
                foreach($contacts as $key => $contact){
                    $new_array['{'.$key.'}'] = $contact;
                }
            }

            $leadinfo1 = DB::table('lead_info')->where('contact_id', $contact_id)->first();
            if ($leadinfo1) {
                // The query returned a valid result, so you can access its properties safely
                if ($leadinfo1->owner1_first_name || $leadinfo1->owner1_last_name) {
                    DB::table('lead_info')->where('contact_id', $contact_id)->update([
                        'user_1_name' => $leadinfo1->owner1_first_name . ' ' . $leadinfo1->owner1_last_name,
                    ]);
                }
                if ($leadinfo1->owner2_first_name || $leadinfo1->owner2_last_name) {
                    DB::table('lead_info')->where('contact_id', $contact_id)->update([
                        'user_2_name' => $leadinfo1->owner2_first_name . ' ' . $leadinfo1->owner2_last_name,
                        
                    ]); 
                }
                if ($leadinfo1->owner3_first_name || $leadinfo1->owner3_last_name) {
                    DB::table('lead_info')->where('contact_id', $contact_id)->update([
                        'user_3_name' => $leadinfo1->owner3_first_name . ' ' . $leadinfo1->owner3_last_name,
                    ]);
                
                }
            }
            $leadinfo = DB::table('lead_info')->where('contact_id', $contact_id)->first(['owner1_first_name','owner1_last_name','owner1_primary_number','owner1_number2','owner1_number3','owner1_email1','owner1_email2','owner1_dob','owner1_mother_name','owner2_first_name','owner2_last_name','owner2_primary_number','owner2_number2','owner2_number3','owner2_email1','owner2_email2','owner2_social_security','owner2_dob','owner2_mother_name','owner3_first_name','owner3_last_name','owner3_primary_number','owner3_number2','owner3_number3','owner3_email1','owner3_email2','owner3_social_security','owner3_dob','owner3_mother_name', 'user_1_name', 'user_1_signature', 'user_2_name', 'user_2_signature', 'user_3_name', 'user_3_signature']);
            if(!empty($leadinfo)){
                foreach($leadinfo as $key => $lead){
                    $new_array['{'.$key.'}'] = $lead;
                }
            }


            $property_infos = DB::table('property_infos')->where('contact_id', $contact_id)->first(['property_address','property_city','property_state','property_zip','map_link','zillow_link']);
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
            $settings = DB::table('settings')->where('id', '1')->first(["auth_email","auth_name", "document_closed_by"]);
            if(!empty($settings) ){
                foreach($settings as $key => $setting){
                    $new_array['{'.$key.'}'] = $setting;
                }
            }
            //$new_array['{auth_email}'] = $settings->auth_email;
            $title_company = DB::table('title_company')->where('contact_id', $contact_id)->first(["buy_sell_entity_detail"]);
            if(!empty($title_company) ){
                foreach($title_company as $key => $title){
                    $new_array['{'.$key.'}'] = $title;
                }
            }

            

            $agreementDirectory = "agreement_pdf";
            $pdfPath            = public_path($agreementDirectory);
            makeDir($pdfPath, true);

            //$userAgreement_update_pdf = UserAgreement::find($userAgreementId);
            $content       = stripslashes($request->content);
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
            return response()->json(["success" => true ,$pdf], 200);         
           
    }

    public function fetch_empty_columns($columnPattern, $table, $sellerId){
        $emptyColumns = [];
        if($table == "contacts"){
            $query = DB::table($table)->where('id', $sellerId);
        } else if ($table == "settings"){
            $query = DB::table($table);
        } else {
            
            $query = DB::table($table)->where('contact_id', $sellerId);
        }
        foreach ($columnPattern as $column) {
            // Check if the column exists in the database table
            if (Schema::hasColumn($table, $column)) {
                $query->addSelect($column);
            }
        }

        // Execute the query and fetch the results
        $results = $query->get();

        // Loop through the results
        foreach ($results as $row) {
            foreach ($columnPattern as $column) {
                // Check if the column exists in the row and if its value is empty
                if (property_exists($row, $column) && empty($row->$column) || property_exists($row, $column) && $row->$column == " " ) {
                    $emptyColumns[] = $column;
                }
            }
        }
        
            return $emptyColumns;
        

    }
    public function softreminder($userId){
        Artisan::call("agreement:mail", ['userAgreementId' => $userId]);
    }

    /**
     * get template content
     *
     * @param int $templateId
     * @return void
     * @author Bhavesh Vyas
     */
    public function getTemplateData(int $templateId)
    {
        $template = FormTemplate::find($templateId);

        $response = [
            'success' => true,
            'content' => $template->content,
        ];

        return response()->json($response, 200);
    }

    /**
     * edit user agreement
     *
     * @param Request $request
     * @param int $userAgreementId
     * @return void
     * @author Bhavesh Vyas
     */
    public function edit(Request $request, int $userAgreementId)
    {
        $userAgreement = UserAgreement::find($userAgreementId);

        $userAgreementSellerIds = UserAgreementSeller::where("user_agreement_id", $userAgreementId)->pluck("user_id")->all();

        $response = [
            'success'    => true,
            'userSeller' => $userAgreementSellerIds,
            'html'       => view($this->viewPath . 'edit', compact('userAgreement', 'userAgreementSellerIds'))->render(),
        ];

        return response()->json($response, 200);
    }

    /**
     * update user agreement
     *
     * @param Request $request
     * @param integer $userAgreementId
     * @return void
     * @author Bhavesh Vyas
     */
    public function update(Request $request, int $userAgreementId)
    {
        $rules = [
            'template_id' => ['required'],
            'content'     => ['required'],
            'seller_id'   => ['required'],
        ];

        $message = [
            'template_id.required'    => "The field is required.",
            'agreement_date.required' => "The field is required.",
            'content.required'        => "The field is required.",
            'seller_id.required'      => "The field is required.",
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'errors'  => $validator->errors()->toArray(),
            ];
            return response()->json($response, 400);
        }

        $userAgreement          = UserAgreement::find($userAgreementId);
        $userAgreementSellerIds = UserAgreementSeller::where("user_agreement_id", $userAgreementId)->pluck("user_id")->all();

        $userAgreement->template_id                = $request->template_id;
        $userAgreement->agreement_date             = date("Y-m-d");
        $userAgreement->content                    = $request->content;
        $userAgreement->agreement_template_content = $request->content;
        $userAgreement->admin_id                   = auth()->id();
        $userAgreement->updated_at                 = date("Y-m-d H:i:s");
        $userAgreement->save();

        $replaceSignature = "";
        if (count($request->seller_id) > 0) {
            foreach ($request->seller_id as $sellerId) {
                if (!in_array($sellerId, $userAgreementSellerIds)) {
                    $replaceSignature .= "<p>{SIGNATURE_$sellerId}</p>";
                    $userAgreementSeller                    = new UserAgreementSeller();
                    $userAgreementSeller->user_agreement_id = $userAgreement->id;
                    $userAgreementSeller->user_id           = $sellerId;
                    $userAgreementSeller->signature_key     = "{SIGNATURE_$sellerId}";
                    $userAgreementSeller->created_at        = date("Y-m-d H:i:s");
                    $userAgreementSeller->updated_at        = date("Y-m-d H:i:s");
                    $userAgreementSeller->save();
                }
            }
        }

        if ($replaceSignature != "") {
            $replaceSignature .= "<p>{SIGNATURE_USER}</p>";
            $userAgreement->content = str_replace("<p>{SIGNATURE_USER}</p>", $replaceSignature, $userAgreement->content);
            $userAgreement->save();
        }
        Artisan::call("agreement:mail", ['userAgreementId' => $userAgreement->id]);
        //runCURL(url("api/agreement/{$userAgreement->id}/mail"));

        $response = [
            'success' => true,
            'message' => "Contract has been updated successfully.",
        ];

        return response()->json($response, 200);
    }

    /**
     * delete user agreement
     *
     * @param integer $userAgreementId
     * @return void
     * @author Bhavesh Vyas
     */
    public function delete(int $userAgreementId)
    {
        $userAgreement = UserAgreement::find($userAgreementId);
        if ($userAgreement) {
            //sachin changed the id
            UserAgreementSeller::where("id", $userAgreementId)->delete();
            $userAgreement->delete();
        }

        Alert::success('Success', 'User Agreement has been deleted successfully.');
        return redirect()->back();
    }

    public function signers($id)
    {

        $userAgreement = UserAgreement::find($id);
        $contact = UserAgreementSeller::where("user_agreement_id", $id)->first();
        $lead = DB::table('lead_info')->where('contact_id', $contact->user_id)->first(['owner1_first_name', 'owner2_first_name', 'owner3_first_name', 'owner1_email1', 'owner1_email2', 'owner2_email1', 'owner2_email2', 'owner3_email1', 'owner3_email2' ]);
        $returnvalue = '<a href="/admin/contact.detail/' . $contact->user_id . '">';
        if ($userAgreement) {
            // sachin changed the id

            $owner1 = UserAgreementSeller::where(["user_agreement_id" => $userAgreement->id, 'contact_number' => 'mail_to_owner1'])->first();
                if (!empty($owner1)) {
                    $returnvalue = $returnvalue . $lead->owner1_first_name ;
                }

                $owner2 = UserAgreementSeller::where(["user_agreement_id" => $userAgreement->id, 'contact_number' => 'mail_to_owner2'])->first();
                if (!empty($owner2)) {
                    $returnvalue = $returnvalue .', '. $lead->owner2_first_name;
                }

                $owner3 = UserAgreementSeller::where(["user_agreement_id" => $userAgreement->id, 'contact_number' => 'mail_to_owner3'])->first();
                if (!empty($owner3)) {
                    $returnvalue = $returnvalue .', '. $lead->owner3_first_name;
                }
                $returnvalue =  $returnvalue.' </a> <br>';

        }

        
        // return response()->json( $contact);
        return response()->json( $returnvalue);
        // $data = json_decode($request->input('data'));
        // if ($data) {
        //     $userIds = collect($data)->pluck('user_id'); // Extract user_id values
            
        //     $contacts = Contact::whereIn('id', $userIds)->select('name', 'last_name')->get();
        // }else {
        //     // Handle the case where the JSON data couldn't be decoded
        //     return response()->json(['error' => 'Invalid JSON data'], 400);
        // }
        
    }

    public function fileManager(Request $request)
    {
        $contact = Contact::find($request->id);
        $mediaItems = $contact->getMedia($request->fileType);
        $link = null;
        foreach($mediaItems as $media){
            $url = $media->getUrl();
            $media->url = $url;
        }
        
        $response = [
            'success' => true,
            'data' => $mediaItems,
        ];
        return response()->json($response, 200);
    }

    public function deleteFile(Request $request)
    {
        $mediaItem = DB::table('media')
        ->where('uudi', $request->fileId)
        ->delete();
        return response()->json(['message' => $mediaItem], 200);
        // $contact = Contact::find($request->id);
        // $mediaItem = $contact->getMedia($request->fileId);
        // if (!$file) {
            //     return response()->json(['message' => 'File not found'], 404);
        // }
        
        // // Find and delete the media item by its name or other criteria
        // $media = $file->getMedia('your_media_collection_name')->first();

        // if (!$media) {
        //     return response()->json(['message' => 'Media item not found'], 404);
        // }

        // // Delete the media item
        // $media->delete();

}

}
