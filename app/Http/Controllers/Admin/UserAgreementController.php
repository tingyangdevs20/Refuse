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
            'seller_id'   => ['required'],
        ];

        $message = [
            'template_id.required'    => "This field is required!",
            'agreement_date.required' => "This field is required!",
            'content.required'        => "This field is required!",
            'seller_id.required'      => "This field is required!",
        ];
        
        $validator = Validator::make($request->all(), $rules, $message);
        
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'errors'  => $validator->errors()->toArray(),
            ];
            return response()->json($response, 400);
        }
        $columns_with_user = [];
        if (count($request->seller_id) > 0) {
            foreach ($request->seller_id as $sellerId) {
                $selle_name = Contact::find($sellerId);
                $pattern = '/\{([^}]+)\}/';
                preg_match_all($pattern, $request->content, $matches);
                $emptyColumns = [];
                // $matches[1] will contain the words or substrings
                $wordsInCurlyBraces = $matches[1];
                $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'contacts', $sellerId);
                $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'lead_info', $sellerId);
                $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'property_infos', $sellerId);
                $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'settings', $sellerId);
                $emptyColumns[] = $this->fetch_empty_columns($wordsInCurlyBraces, 'title_company', $sellerId);
                $columns = [];
                $emptyColumns = array_unique(array_filter($emptyColumns));
                
                if(!empty($emptyColumns)){
                    foreach($emptyColumns as $col){
                        $columns_with_user[$selle_name->name] = $col;
                        
                    }
                }
            }
        } else{
            return response()->json("Please select at least one seller", 400);
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
        if (count($request->seller_id) > 0) {
            foreach ($request->seller_id as $sellerId) {
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

        if ($replaceSignature != "") {
            $replaceSignature .= "<p>{SIGNATURE_USER}</p>";
            $userAgreement->content = str_replace("<p>{SIGNATURE_USER}</p>", $replaceSignature, $userAgreement->content);
            $userAgreement->save();
        }

        Artisan::call("agreement:mail", ['userAgreementId' => $userAgreement->id]);
        //runCURL(url("api/agreement/{$userAgreement->id}/mail"));

        $response = [
            'success' => true,
            'message' => "Contract has been created successfully.",
        ];

        return response()->json($response, 200);
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

    public function signers(Request $request)
    {
        
        $data = json_decode($request->input('data'));
        if ($data) {
            $userIds = collect($data)->pluck('user_id'); // Extract user_id values
            
            $contacts = Contact::whereIn('id', $userIds)->select('name', 'last_name')->get();
            return response()->json($contacts);
        }else {
            // Handle the case where the JSON data couldn't be decoded
            return response()->json(['error' => 'Invalid JSON data'], 400);
        }
        
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
