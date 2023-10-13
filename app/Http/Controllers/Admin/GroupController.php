<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Contact;
use App\Model\CustomField;
use App\Model\Section;
use App\Model\Settings;
use App\Model\LeadCategory;
use App\Model\LeadStatus;
use App\Model\Number;
use App\Model\Group;
use App\Model\Market;
use App\Model\CampaignLead;
use App\Model\Tag;
use App\SkipTracingDetail;
use App\Model\Account;
use App\Model\Campaign;
use App\Model\CampaignList;
use App\Model\Script;
use App\Model\Reply;
use App\Model\Scheduler;
use App\Mail\TestEmail;
use App\Model\RvmFile;
use App\Mail\Mailcontact;  //  05092023 sachin
use App\Model\Contractupload; //  06092023 sachin
use Smalot\PdfParser\Parser; // 06092023 sachin
use Illuminate\Support\Facades\Mail;
use App\Model\Sms;
use App\Model\FailedSms;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use App\Model\FormTemplates;
use Illuminate\Support\Facades\Storage;
use Google_Client as GoogleClient;
use Google_Service_Drive as Drive;
use Auth;
use App\LeadInfo;
use App\TaskList;
use App\Model\TimeZones;
use Session;
use App\AccountDetail;
use App\User;
use App\TotalBalance;
use App\Services\DatazappService;

use App\Mail\CampaignConfirmation;
use App\Mail\CampaignMail;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $account = Account::first();
        try {
            $groups = Group::with('contacts')->get()->sortByDesc("created_at");

            $groupCounts = $groups->map(function ($group) {
                $totalColumns = 0;
                $filledColumns = 0;

                foreach ($group->contacts as $contact) {
                    $contactRecords = [$contact->number, $contact->number2, $contact->number3];

                    foreach ($contactRecords as $record) {
                        // Check if the record contains more than 6 digits or characters
                        if (strlen(preg_replace('/[^0-9]/', '', $record)) > 6) {
                            $filledColumns += 1;
                        }
                        $totalColumns += 1;
                    }
                }

                if ($totalColumns > 0) {
                    $percentage = ($filledColumns / $totalColumns) * 100;
                } else {
                    $percentage = 0;
                }

                return [
                    'group_name' => $group->name, // Replace 'name' with the actual group name attribute
                    'contact_count' => count($group->contacts),
                    'percentage' => $percentage,
                ];
            })->values();

            $sr = 1;;
            $markets = Market::all();
            $tags = Tag::all();
            $campaigns = Campaign::getAllCampaigns();
            $form_Template = FormTemplates::get();

            if ($request->wantsJson()) {
                return response()->json([
                    'data' => $groups,
                    'success' => true,
                    'status' => 200,
                    'message' => 'OK'
                ]);
            } else {
                return view('back.pages.group.index', compact('groups', 'groupCounts', 'sr', 'campaigns', 'markets', 'tags', 'form_Template', 'account'));
            }
        } catch (\Exception $e) {

            Log::error('An error occurred while processing the data: ' . $e->getMessage());
        }
    }

    public function contactInfo(Request $request, $id = '')
    {
        //return 'wertyui';
        $leads = LeadCategory::all();
        $scripts = Script::all();
        $tags = Tag::all();
        $sections = Section::all();
        $contact = Contact::where('id', $id)->first();
        $TaskliSt = TaskList::all();
        $files = RvmFile::all();

        if ($contact) {

            $collection = SkipTracingDetail::where('group_id', $contact->group_id)
                ->whereIn('id', function ($query) use ($contact) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('skip_tracing_details')
                        ->where('group_id', $contact->group_id)
                        ->groupBy('user_id', 'select_option');
                })
                ->whereNotNull('first_name')
                ->whereNotNull('last_name')
                ->whereNotNull('address')
                ->whereNotNull('zip')
                ->get();
        } else {
            $collection = null;
        }


        $leadinfo = DB::table('lead_info')->where('contact_id', $id)->first();
        if ($leadinfo == null) {
            $dateAdded = Carbon::now()->toDateString();
            DB::table('lead_info')->insert(['contact_id' => $id, 'date_added' => $dateAdded]);
            $leadinfo = DB::table('lead_info')->where('contact_id', $id)->first();
        }
        $leadinfo = DB::table('lead_info')->where('contact_id', $id)->first();
        DB::table('lead_info')->where('contact_id', $id)->update([
            'user_1_name' => $leadinfo->owner1_first_name . ' ' . $leadinfo->owner1_last_name,
            'user_2_name' => $leadinfo->owner2_first_name . ' ' . $leadinfo->owner2_last_name,
            'user_3_name' => $leadinfo->owner3_first_name . ' ' . $leadinfo->owner3_last_name,
        ]);

        $selected_tags = DB::table('lead_info_tags')->where('lead_info_id', $leadinfo->id)->pluck('tag_id')->toArray();
        $property_infos = DB::table('property_infos')->where('contact_id', $id)->first();
        if ($property_infos == null) {
            DB::table('property_infos')->insert(['contact_id' => $id]);
            $property_infos = DB::table('property_infos')->where('contact_id', $id)->first();
        }

        if (empty($property_infos->property_address)) {
            $property_infos->map_link = "Property address missing!";
            $property_infos->zillow_link = "Property address missing!";
        } else {
            $map_link = "https://www.google.com/maps?q=" . urlencode("$property_infos->property_address, $property_infos->property_city, $property_infos->property_state, $property_infos->property_zip");
            $property_infos->map_link = $map_link;
        }
        $values_conditions = DB::table('values_conditions')->where('contact_id', $id)->first();
        if ($values_conditions == null) {
            DB::table('values_conditions')->insert(['contact_id' => $id]);
            $values_conditions = DB::table('values_conditions')->where('contact_id', $id)->first();
        }
        $property_finance_infos = DB::table('property_finance_infos')->where('contact_id', $id)->first();
        if ($property_finance_infos == null) {
            DB::table('property_finance_infos')->insert(['contact_id' => $id]);
            $property_finance_infos = DB::table('property_finance_infos')->where('contact_id', $id)->first();
        }
        $selling_motivations = DB::table('selling_motivations')->where('contact_id', $id)->first();
        if ($selling_motivations == null) {
            DB::table('selling_motivations')->insert(['contact_id' => $id]);
            $selling_motivations = DB::table('selling_motivations')->where('contact_id', $id)->first();
        }
        $negotiations = DB::table('negotiations')->where('contact_id', $id)->first();
        if ($negotiations == null) {
            DB::table('negotiations')->insert(['contact_id' => $id]);
            $negotiations = DB::table('negotiations')->where('contact_id', $id)->first();
        }
        $title_company = DB::table('title_company')->where('contact_id', $id)->first();
        if ($title_company == null) {
            DB::table('title_company')->insert(['contact_id' => $id]);
            $title_company = DB::table('title_company')->where('contact_id', $id)->first();
        }

        $objections = DB::table('objections')->where('contact_id', $id)->first();
        if ($objections == null) {
            DB::table('objections')->insert(['contact_id' => $id]);
            $objections = DB::table('objections')->where('contact_id', $id)->first();
        }

        $agent_infos = DB::table('agent_infos')->where('contact_id', $id)->first();
        if ($agent_infos == null) {
            DB::table('agent_infos')->insert(['contact_id' => $id]);
            $agent_infos = DB::table('agent_infos')->where('contact_id', $id)->first();
        }

        $commitments = DB::table('commitments')->where('contact_id', $id)->first();
        if ($commitments == null) {
            DB::table('commitments')->insert(['contact_id' => $id]);
            $commitments = DB::table('commitments')->where('contact_id', $id)->first();
        }

        $stuffs = DB::table('stuffs')->where('contact_id', $id)->first();
        if ($stuffs == null) {
            DB::table('stuffs')->insert(['contact_id' => $id]);
            $stuffs = DB::table('stuffs')->where('contact_id', $id)->first();
        }

        $followup_sequences = DB::table('followup_sequences')->where('contact_id', $id)->first();
        if ($followup_sequences == null) {
            DB::table('followup_sequences')->insert(['contact_id' => $id]);
            $followup_sequences = DB::table('followup_sequences')->where('contact_id', $id)->first();
        }

        $insurance_company = DB::table('insurance_company')->where('contact_id', $id)->first();
        if ($insurance_company == null) {
            DB::table('insurance_company')->insert(['contact_id' => $id]);
            $insurance_company = DB::table('insurance_company')->where('contact_id', $id)->first();
        }

        $hoa_info = DB::table('hoa_info')->where('contact_id', $id)->first();
        if ($hoa_info == null) {
            DB::table('hoa_info')->insert(['contact_id' => $id]);
            $hoa_info = DB::table('hoa_info')->where('contact_id', $id)->first();
        }
        $future_seller_infos = DB::table('future_seller_infos')->where('contact_id', $id)->first();
        if ($future_seller_infos == null) {
            DB::table('future_seller_infos')->insert(['contact_id' => $id]);
            $future_seller_infos = DB::table('future_seller_infos')->where('contact_id', $id)->first();
        }

        $utility_deparments = DB::table('utility_deparments')->where('contact_id', $id)->first();
        if ($utility_deparments == null) {
            DB::table('utility_deparments')->insert(['contact_id' => $id]);
            $utility_deparments = DB::table('utility_deparments')->where('contact_id', $id)->first();
        }

        $uid = Auth::id();
        $contact = Contact::where('id', $id)->first();
        $cnt_mob1 = $contact->number ?? null;
        $cnt_mob2 = $contact->number2 ?? null;
        $cnt_mob3 = $contact->number3 ?? null;
        $getAllAppointments = Scheduler::where('admin_uid', $uid)->where('mobile', $cnt_mob1)->orWhere('mobile', $cnt_mob2)->orWhere('mobile', $cnt_mob3)->get();


        $hasGoogleDriveAccess =  $response = app()->call('App\Http\Controllers\GoogleDriveController@hasGoogleDriveAccess');
        $googleDriveFiles = null;
        if ($hasGoogleDriveAccess) {
            $googleDriveFiles = app()->call('App\Http\Controllers\GoogleDriveController@fetchFilesByFolderName');
        }

        return view('back.pages.group.contactDetail', compact('id', 'title_company', 'leadinfo', 'scripts', 'sections', 'property_infos', 'values_conditions', 'property_finance_infos', 'selling_motivations', 'negotiations', 'leads', 'tags', 'getAllAppointments', 'contact', 'collection', 'googleDriveFiles', 'agent_infos', 'objections', 'commitments', 'stuffs', 'followup_sequences', 'insurance_company', 'hoa_info', 'future_seller_infos', 'selected_tags', 'TaskliSt', 'utility_deparments', 'files'));
    }

    public function updateinfo(Request $request)
    {
        $table = $request->table;
        $id = $request->id;
        $feild_id = $request->feild_id;
        $section_id = $request->section_id;
        $fieldVal = $request->fieldVal;
        $fieldName = $request->fieldName;
        if ($table != null) {
            if ($table == 'custom_field_values') {
                $contact = DB::table($table)->where('contact_id', $id)->where('feild_id', $feild_id)->first();
                if ($contact) {
                    DB::table($table)->where('contact_id', $id)->where('feild_id', $feild_id)->update([$fieldName => $fieldVal]);
                } else {
                    DB::table($table)->insert(['contact_id' => $id, 'feild_id' => $feild_id, 'section_id' => $section_id, $fieldName => $fieldVal]);
                }
            } else {
                $contact = DB::table($table)->where('contact_id', $id)->first();
                if ($contact) {
                    DB::table($table)->where('contact_id', $id)->update([$fieldName => $fieldVal]);
                } else {
                    DB::table($table)->insert(['contact_id' => $id, $fieldName => $fieldVal]);
                }
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Data updated successfully!'
        ]);
    }

    public function updatetags(Request $request)
    {
        $table = $request->table;
        $id = $request->id;
        $field_id = $request->field_id; // Correct variable name
        $section_id = $request->section_id;
        $fieldVal = $request->fieldVal;
        $fieldName = $request->fieldName;
        $selectedTags = $request->selectedTags;

        if ($id != null) {
            $lead = DB::table('lead_info')->where('contact_id', $id)->first();

            if (!$selectedTags || empty($selectedTags)) {
                DB::table('lead_info_tags')
                    ->where('lead_info_id', $lead->id)
                    ->delete();

                return response()->json([
                    'status' => true,
                    'message' => "Data updated successfully! "
                ]);
            }
            // Get the currently associated tag IDs for the lead_info record
            $currentTags = DB::table('lead_info_tags')
                ->where('lead_info_id', $lead->id)
                ->pluck('tag_id')
                ->toArray();

            // Calculate the tags to insert (exclude already associated tags)
            $tagsToInsert = array_diff($selectedTags, $currentTags);

            // Calculate the tags to delete (tags in $currentTags but not in $selectedTags)
            $tagsToDelete = array_diff($currentTags, $selectedTags);

            // Delete the tags that are not in $selectedTags or delete all if none are selected
            if (!empty($tagsToDelete) || empty($selectedTags)) {
                DB::table('lead_info_tags')
                    ->where('lead_info_id', $lead->id)
                    ->whereIn('tag_id', $tagsToDelete)
                    ->delete();
            }

            // Insert the new tags
            if (!empty($tagsToInsert)) {
                // Iterate through the selected tags and insert them into the lead_info_tags table
                foreach ($tagsToInsert as $tagId) {
                    DB::table('lead_info_tags')->insert([
                        'lead_info_id' => $lead->id,
                        'tag_id' => $tagId,
                    ]);
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => "Data updated successfully! "
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function mapCSV(Request $request)
    {
        $file = $request->file('file');

        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("csv");

        // 2MB in Bytes
        $maxFileSize = 2097152;

        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {
            // Check file size
            if ($fileSize <= $maxFileSize) {
                // File upload location
                $location = 'uploads';

                // Upload file
                $file->move($location, $filename);

                // Import CSV to Database
                $filepath = public_path($location . "/" . $filename);

                // Reading file
                $file = fopen($filepath, "r");

                // Fetch headers only
                $headers = fgetcsv($file, 1000, ",");

                // Close the file
                fclose($file);

                // Return headers in a JSON response
                return response()->json([
                    'status' => true,
                    'message' => 'CSV read successfully!',
                    'headers' => $headers,
                ]);
            } else {
                // File size too large
                return response()->json([
                    'status' => false,
                    'message' => 'File too large. File must be less than 2MB!'
                ]);
            }
        } else {
            // Invalid File Extension
            return response()->json([
                'status' => false,
                'message' => 'Invalid File Extension!'
            ]);
        }
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param \Illuminate\Http\Request $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {

    //     $existing_group_id = '';
    //     $existing_group_id = $request->existing_group_id;
    //     $group_id = '';
    //     $campaign_id = '';
    //     //return $request->campaign_id;
    //     // if ($request->campaign_id != 0) {
    //     //     $campaign_id = $request->campaign_id;
    //     //     //die($campaign_id );
    //     //     $compain = Campaign::where('id', $campaign_id)->first();
    //     //     $group_id = $compain->group_id;
    //     // }


    //     //return $group_id;

    //     // if ($existing_group_id != 0) {

    //     //     $group_id = $existing_group_id;
    //     //     $group = Group::where('id', $group_id)->first();
    //     //     $group->market_id = $request->market_id;
    //     //     $group->tag_id = $request->tag_id;
    //     //     $group->save();
    //     // } else {

    //     $group = new Group();
    //     $group->market_id = $request->market_id ?? '0';
    //     // $group->tag_id = $request->tag_id;
    //     // $group->tag_id = json_encode($request->tag_id);
    //     $group->name = $request->name;
    //     $group->save();
    //     // }
    //     $selectedTags = $request->tag_id;
    //     if ($selectedTags || !empty($selectedTags)) {
    //         // Get the currently associated tag IDs for the group record
    //         $currentTags = DB::table('group_tags')
    //             ->where('group_id', $group->id)
    //             ->pluck('tag_id')
    //             ->toArray();

    //         // Calculate the tags to insert (exclude already associated tags)
    //         $tagsToInsert = array_diff($selectedTags, $currentTags);

    //         // Calculate the tags to delete (tags in $currentTags but not in $selectedTags)
    //         $tagsToDelete = array_diff($currentTags, $selectedTags);

    //         // Delete the tags that are not in $selectedTags or delete all if none are selected
    //         if (!empty($tagsToDelete) || empty($selectedTags)) {
    //             DB::table('group_tags')
    //                 ->where('group_id', $group->id)
    //                 ->whereIn('tag_id', $tagsToDelete)
    //                 ->delete();
    //         }

    //         // Insert the new tags
    //         if (!empty($tagsToInsert)) {
    //             // Iterate through the selected tags and insert them into the group_tags table
    //             foreach ($tagsToInsert as $tagId) {
    //                 DB::table('group_tags')->insert([
    //                     'group_id' => $group->id,
    //                     'tag_id' => $tagId,
    //                 ]);
    //             }
    //         }
    //     }

    //     $file = $request->file('file');

    //     // File Details
    //     $filename = $file->getClientOriginalName();
    //     $extension = $file->getClientOriginalExtension();
    //     $tempPath = $file->getRealPath();
    //     $fileSize = $file->getSize();
    //     $mimeType = $file->getMimeType();

    //     // Valid File Extensions
    //     $valid_extension = array("csv");

    //     // 2MB in Bytes
    //     $maxFileSize = 2097152;

    //     // Check file extension
    //     if (in_array(strtolower($extension), $valid_extension)) {

    //         // Check file size
    //         if ($fileSize <= $maxFileSize) {

    //             // File upload location
    //             $location = 'uploads';

    //             // Upload file
    //             $file->move($location, $filename);

    //             // Import CSV to Database
    //             $filepath = public_path($location . "/" . $filename);

    //             // Reading file
    //             $file = fopen($filepath, "r");

    //             $importData_arr = array();
    //             $i = 0;

    //             while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
    //                 $num = count($filedata);

    //                 // Skip first row (Remove below comment if you want to skip the first row)
    //                 if ($i == 0) {
    //                     $i++;
    //                     continue;
    //                 }
    //                 for ($c = 0; $c < $num; $c++) {
    //                     $importData_arr[$i][] = $filedata[$c];
    //                 }
    //                 $i++;
    //             }
    //             fclose($file);

    //             // Insert to MySQL database
    //             foreach ($importData_arr as $importData) {
    //                 if ($group_id != '') {
    //                     $checkContact = Contact::where('number', '+1' . preg_replace('/[^0-9]/', '', $importData[5]))->where('group_id', $group_id)->first();
    //                     if ($checkContact == null) {
    //                         $insertData1 = array(
    //                             "group_id" => $group_id,
    //                             "name" => $importData[0],
    //                             "last_name" => $importData[1],
    //                             "street" => $importData[2],
    //                             "city" => $importData[3],
    //                             "state" => $importData[4],
    //                             "zip" => $importData[5],
    //                             "number" => '+1' . preg_replace('/[^0-9]/', '', $importData[6]),
    //                             "number2" => '+1' . preg_replace('/[^0-9]/', '', $importData[7]),
    //                             "number3" => '+1' . preg_replace('/[^0-9]/', '', $importData[8]),
    //                             "email1" => $importData[9],
    //                             "email2" => $importData[10]
    //                         );
    //                         Contact::create($insertData1);
    //                         $groupsID = Group::where('id', $group_id)->first();
    //                         $sender_numbers = Number::where('market_id', $groupsID->market_id)->inRandomOrder()->first();
    //                         if ($sender_numbers) {
    //                             $account = Account::where('id', $sender_numbers->account_id)->first();
    //                             if ($account) {
    //                                 $sid = $account->account_id;
    //                                 $token = $account->account_token;
    //                             } else {
    //                                 $sid = '';
    //                                 $token = '';
    //                             }
    //                         }

    //                         $campaignsList = CampaignList::where('campaign_id', $campaign_id)->orderby('schedule', 'ASC')->first();
    //                         // print_r($campaignsList);die;
    //                         if ($campaignsList) {
    //                             $row = $campaignsList;
    //                             // $template = Template::where('id',$row->template_id)->first();
    //                             $template = FormTemplates::where('id', $request->email_template)->first();
    //                             $date = now()->format('d M Y');
    //                             if ($row->type == 'email') {


    //                                 if ($importData[9] != '') {
    //                                     $email = $importData[9];
    //                                 } elseif ($importData[10]) {
    //                                     $email = $importData[10];
    //                                 }
    //                                 if ($email != '') {
    //                                     $subject = $template->template_name;
    //                                     $subject = str_replace("{name}", $importData[0], $subject);
    //                                     $subject = str_replace("{street}", $importData[2], $subject);
    //                                     $subject = str_replace("{city}", $importData[3], $subject);
    //                                     $subject = str_replace("{state}", $importData[4], $subject);
    //                                     $subject = str_replace("{zip}", $importData[5], $subject);
    //                                     $subject = str_replace("{date}", $date, $subject);
    //                                     $message = $template != null ? $template->content : '';
    //                                     $message = str_replace("{name}", $importData[0], $message);
    //                                     $message = str_replace("{street}", $importData[2], $message);
    //                                     $message = str_replace("{city}", $importData[3], $message);
    //                                     $message = str_replace("{state}", $importData[4], $message);
    //                                     $message = str_replace("{zip}", $importData[5], $message);
    //                                     $message = str_replace("{date}", $date, $message);
    //                                     $unsub_link = url('admin/email/unsub/' . $email);
    //                                     $data = ['message' => $message, 'subject' => $subject, 'name' => $importData[0], 'unsub_link' => $unsub_link];
    //                                     // echo "<pre>";print_r($data);die;
    //                                     Mail::to($email)->send(new TestEmail($data));;
    //                                 }
    //                             } elseif ($row->type == 'sms') {
    //                                 $client = new Client($sid, $token);
    //                                 if ($importData[6] != '') {
    //                                     $number = '+1' . preg_replace('/[^0-9]/', '', $importData[6]);
    //                                 } elseif ($importData[7] != '') {
    //                                     $number = '+1' . preg_replace('/[^0-9]/', '', $importData[7]);
    //                                 } elseif ($importData[8] != '') {
    //                                     $number = '+1' . preg_replace('/[^0-9]/', '', $importData[8]);
    //                                 }
    //                                 $receiver_number = $number;
    //                                 $sender_number = $sender_numbers->number;
    //                                 $message = $template != null && $template->body ? $template->body : '';
    //                                 $message = str_replace("{name}", $importData[0], $message);
    //                                 $message = str_replace("{street}", $importData[2], $message);
    //                                 $message = str_replace("{city}", $importData[3], $message);
    //                                 $message = str_replace("{state}", $importData[4], $message);
    //                                 $message = str_replace("{zip}", $importData[5], $message);
    //                                 if ($receiver_number != '') {
    //                                     try {
    //                                         $sms_sent = $client->messages->create(
    //                                             $receiver_number,
    //                                             [
    //                                                 'from' => $sender_number,
    //                                                 'body' => $message,
    //                                             ]
    //                                         );
    //                                         if ($sms_sent) {
    //                                             $old_sms = Sms::where('client_number', $receiver_number)->first();
    //                                             if ($old_sms == null) {
    //                                                 $sms = new Sms();
    //                                                 $sms->client_number = $receiver_number;
    //                                                 $sms->twilio_number = $sender_number;
    //                                                 $sms->message = $message;
    //                                                 $sms->media = '';
    //                                                 $sms->status = 1;
    //                                                 $sms->save();
    //                                                 $this->incrementSmsCount($sender_number);
    //                                             } else {
    //                                                 $reply_message = new Reply();
    //                                                 $reply_message->sms_id = $old_sms->id;
    //                                                 $reply_message->to = $sender_number;
    //                                                 $reply_message->from = $receiver_number;
    //                                                 $reply_message->reply = $message;
    //                                                 $reply_message->system_reply = 1;
    //                                                 $reply_message->save();
    //                                                 $this->incrementSmsCount($sender_number);
    //                                             }
    //                                         }
    //                                     } catch (\Exception $ex) {
    //                                         $failed_sms = new FailedSms();
    //                                         $failed_sms->client_number = $receiver_number;
    //                                         $failed_sms->twilio_number = $sender_number;
    //                                         $failed_sms->message = $message;
    //                                         $failed_sms->media = '';
    //                                         $failed_sms->error = $ex->getMessage();
    //                                         $failed_sms->save();
    //                                     }
    //                                 }
    //                             } elseif ($row->type == 'mms') {
    //                                 $client = new Client($sid, $token);
    //                                 if ($importData[6] != '') {
    //                                     $number = '+1' . preg_replace('/[^0-9]/', '', $importData[6]);
    //                                 } elseif ($importData[7] != '') {
    //                                     $number = '+1' . preg_replace('/[^0-9]/', '', $importData[7]);
    //                                 } elseif ($importData[8] != '') {
    //                                     $number = '+1' . preg_replace('/[^0-9]/', '', $importData[8]);
    //                                 }
    //                                 $receiver_number = $number;
    //                                 $sender_number = $sender_numbers->number;
    //                                 $message = $template != null ? $template->body : '';
    //                                 $message = str_replace("{name}", $importData[0], $message);
    //                                 $message = str_replace("{street}", $importData[2], $message);
    //                                 $message = str_replace("{city}", $importData[3], $message);
    //                                 $message = str_replace("{state}", $importData[4], $message);
    //                                 $message = str_replace("{zip}", $importData[5], $message);
    //                                 if ($receiver_number != '') {
    //                                     try {
    //                                         $sms_sent = $client->messages->create(
    //                                             $receiver_number,
    //                                             [
    //                                                 'from' => $sender_number,
    //                                                 'body' => $message,
    //                                                 'mediaUrl' => [$template->mediaUrl],
    //                                             ]
    //                                         );

    //                                         if ($sms_sent) {
    //                                             $old_sms = Sms::where('client_number', $receiver_number)->first();
    //                                             if ($old_sms == null) {
    //                                                 $sms = new Sms();
    //                                                 $sms->client_number = $receiver_number;
    //                                                 $sms->twilio_number = $sender_number;
    //                                                 $sms->message = $message;
    //                                                 $sms->media = $template->mediaUrl;
    //                                                 $sms->status = 1;
    //                                                 $sms->save();
    //                                                 $this->incrementSmsCount($sender_number);
    //                                             } else {
    //                                                 $reply_message = new Reply();
    //                                                 $reply_message->sms_id = $old_sms->id;
    //                                                 $reply_message->to = $sender_number;
    //                                                 $reply_message->from = $receiver_number;
    //                                                 $reply_message->reply = $message;
    //                                                 $reply_message->system_reply = 1;
    //                                                 $reply_message->save();
    //                                                 $this->incrementSmsCount($sender_number);
    //                                             }
    //                                         }
    //                                     } catch (\Exception $ex) {
    //                                         $failed_sms = new FailedSms();
    //                                         $failed_sms->client_number = $receiver_number;
    //                                         $failed_sms->twilio_number = $sender_number;
    //                                         $failed_sms->message = $message;
    //                                         $failed_sms->media = $template->mediaUrl;
    //                                         $failed_sms->error = $ex->getMessage();
    //                                         $failed_sms->save();
    //                                     }
    //                                 }
    //                             } elseif ($row->type == 'rvm') {
    //                                 $contactsArr = [];
    //                                 if ($importData[6] != '') {
    //                                     $number = '+1' . preg_replace('/[^0-9]/', '', $importData[6]);
    //                                 } elseif ($importData[7] != '') {
    //                                     $number = '+1' . preg_replace('/[^0-9]/', '', $importData[7]);
    //                                 } elseif ($importData[8] != '') {
    //                                     $number = '+1' . preg_replace('/[^0-9]/', '', $importData[8]);
    //                                 }
    //                                 if ($number) {
    //                                     $c_phones = $number;
    //                                     $vrm = \Slybroadcast::sendVoiceMail([
    //                                         'c_phone' => ".$c_phones.",
    //                                         'c_url' => $template->body,
    //                                         'c_record_audio' => '',
    //                                         'c_date' => 'now',
    //                                         'c_audio' => 'Mp3',
    //                                         //'c_callerID' => "4234606442",
    //                                         'c_callerID' => $sender_numbers->number,
    //                                         //'mobile_only' => 1,
    //                                         'c_dispo_url' => 'https://brian-bagnall.com/bulk/bulksms/public/admin/voicepostback'
    //                                     ])->getResponse();
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //                 if ($existing_group_id == 0) {
    //                     $insertData = array(
    //                         "group_id" => $group->id,
    //                         "name" => $importData[0],
    //                         "last_name" => $importData[1],
    //                         "street" => $importData[2],
    //                         "city" => $importData[3],
    //                         "state" => $importData[4],
    //                         "zip" => $importData[5],
    //                         "number" => '+1' . preg_replace('/[^0-9]/', '', $importData[6]),
    //                         "number2" => '+1' . preg_replace('/[^0-9]/', '', $importData[7]),
    //                         "number3" => '+1' . preg_replace('/[^0-9]/', '', $importData[8]),
    //                         "email1" => $importData[9],
    //                         "email2" => $importData[10]
    //                     );
    //                     Contact::create($insertData);
    //                 }
    //             }
    //             Alert::success('Success!', 'Group Created!');
    //         } else {
    //             Alert::error('Oops!', 'File too large. File must be less than 2MB');
    //         }
    //     } else {
    //         $group->delete();
    //         Alert::error('Oops!', 'Invalid File Extension.');
    //     }
    //     return redirect()->back();
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $columns_array = [
            "name" => $request->name,
            "last_name" => $request->last_name,
            "street" => $request->street,
            "city" => $request->city,
            "state" => $request->state,
            "zip" => $request->zip,
            "number" => $request->number,
            "number2" => $request->number2,
            "email1" => $request->email1,
            "email2" => $request->email2
        ];

        $headers_indexes = [
            "name_header" =>  $request->name_header,
            "last_name_header" =>  $request->last_name_header,
            "street_header" =>  $request->street_header,
            "city_header" =>  $request->city_header,
            "state_header" =>  $request->state_header,
            "zip_header" =>  $request->zip_header,
            "number_header" =>  $request->number_header,
            "number2_header" =>  $request->number2_header,
            "email1_header" =>  $request->email1_header,
            "email2_header" =>  $request->email2_header
        ];

        $existing_group_id = '';
        $existing_group_id = $request->existing_group_id;
        $group_id = '';
        $campaign_id = '';

        $group = new Group();
        $group->market_id = $request->market_id ?? '0';
        // $group->tag_id = $request->tag_id;
        // $group->tag_id = json_encode($request->tag_id);
        $group->name = $request->list_name;
        $group->save();

        $group_id = $group->id;
        // }
        $selectedTags = $request->tag_id;
        if ($selectedTags || !empty($selectedTags)) {
            // Get the currently associated tag IDs for the group record
            $currentTags = DB::table('group_tags')
                ->where('group_id', $group->id)
                ->pluck('tag_id')
                ->toArray();

            // Calculate the tags to insert (exclude already associated tags)
            $tagsToInsert = array_diff($selectedTags, $currentTags);

            // Calculate the tags to delete (tags in $currentTags but not in $selectedTags)
            $tagsToDelete = array_diff($currentTags, $selectedTags);

            // Delete the tags that are not in $selectedTags or delete all if none are selected
            if (!empty($tagsToDelete) || empty($selectedTags)) {
                DB::table('group_tags')
                    ->where('group_id', $group->id)
                    ->whereIn('tag_id', $tagsToDelete)
                    ->delete();
            }

            // Insert the new tags
            if (!empty($tagsToInsert)) {
                // Iterate through the selected tags and insert them into the group_tags table
                foreach ($tagsToInsert as $tagId) {
                    DB::table('group_tags')->insert([
                        'group_id' => $group->id,
                        'tag_id' => $tagId,
                    ]);
                }
            }
        }

        // Assuming you have the arrays $columns_array and $headers_indexes
        $columnToHeader = [];

        // Create a mapping between columns and headers
        foreach ($columns_array as $column => $headerName) {
            // Get the corresponding header index for this column
            $headerIndexKey = $column . '_header';
            $headerIndex = $headers_indexes[$headerIndexKey];

            // Check if the header index is not null (i.e., there is a mapping)
            if ($headerIndex !== null) {
                $columnToHeader[$headerIndex] = $column;
            }
        }

        // Initialize the mapping between columns and header indexes
        $columnToHeaderIndex = $headers_indexes;

        $file = $request->file('file');

        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("csv");

        // 2MB in Bytes
        $maxFileSize = 2097152;

        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {

            // Check file size
            if ($fileSize <= $maxFileSize) {

                // File upload location
                $location = 'uploads';

                // Upload file
                $file->move($location, $filename);

                // Import CSV to Database
                $filepath = public_path($location . "/" . $filename);

                // Reading file
                $file = fopen($filepath, "r");

                $importData_arr = array();
                $i = 0;

                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $num = count($filedata);

                    // Skip first row (Remove below comment if you want to skip the first row)
                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }
                fclose($file);

                // Insert to MySQL database
                foreach ($importData_arr as $importData) {
                    if ($group_id != '') {
                        $checkContact = Contact::where('number', '+1' . preg_replace('/[^0-9]/', '', $importData[5]))->where('group_id', $group_id)->first();
                        if ($checkContact == null) {
                            $insertData = [
                                "group_id" => $group_id,
                            ];
                            // $insertData1 = array(
                            //     "group_id" => $group_id,
                            //     "name" => $importData[0],
                            //     "last_name" => $importData[1],
                            //     "street" => $importData[2],
                            //     "city" => $importData[3],
                            //     "state" => $importData[4],
                            //     "zip" => $importData[5],
                            //     "number" => '+1' . preg_replace('/[^0-9]/', '', $importData[6]),
                            //     "number2" => '+1' . preg_replace('/[^0-9]/', '', $importData[7]),
                            //     "number3" => '+1' . preg_replace('/[^0-9]/', '', $importData[8]),
                            //     "email1" => $importData[9],
                            //     "email2" => $importData[10]
                            // );
                            // Contact::create($insertData1);

                            // Iterate through the imported data and map it to the corresponding column
                            foreach ($importData as $headerIndex => $value) {

                                // Check if the header index is mapped to a column
                                if (isset($columnToHeader[$headerIndex])) {
                                    $column = $columnToHeader[$headerIndex];

                                    $header_index = $column . '_header';
                                    // Check if this column has header too
                                    if (isset($columnToHeaderIndex[$header_index])) {
                                        $header_index = $columnToHeaderIndex[$header_index];
                                    }

                                    if ($headerIndex == $header_index) {
                                        // Set the column value in the insert data
                                        $insertData[$column] = $value;
                                    }
                                }
                            }

                            // Insert the data into the Contact table
                            Contact::create($insertData);

                            $groupsID = Group::where('id', $group_id)->first();
                            $sender_numbers = Number::where('market_id', $groupsID->market_id)->inRandomOrder()->first();
                            if ($sender_numbers) {
                                $account = Account::where('id', $sender_numbers->account_id)->first();
                                if ($account) {
                                    $sid = $account->account_id;
                                    $token = $account->account_token;
                                } else {
                                    $sid = '';
                                    $token = '';
                                }
                            }

                            $campaignsList = CampaignList::where('campaign_id', $campaign_id)->orderby('schedule', 'ASC')->first();
                            // print_r($campaignsList);die;
                            if ($campaignsList) {
                                $row = $campaignsList;
                                // $template = Template::where('id',$row->template_id)->first();
                                $template = FormTemplates::where('id', $request->email_template)->first();
                                $date = now()->format('d M Y');
                                if ($row->type == 'email') {


                                    if ($importData[9] != '') {
                                        $email = $importData[9];
                                    } elseif ($importData[10]) {
                                        $email = $importData[10];
                                    }
                                    if ($email != '') {
                                        $subject = $template->template_name;
                                        $subject = str_replace("{name}", $importData[0], $subject);
                                        $subject = str_replace("{street}", $importData[2], $subject);
                                        $subject = str_replace("{city}", $importData[3], $subject);
                                        $subject = str_replace("{state}", $importData[4], $subject);
                                        $subject = str_replace("{zip}", $importData[5], $subject);
                                        $subject = str_replace("{date}", $date, $subject);
                                        $message = $template != null ? $template->content : '';
                                        $message = str_replace("{name}", $importData[0], $message);
                                        $message = str_replace("{street}", $importData[2], $message);
                                        $message = str_replace("{city}", $importData[3], $message);
                                        $message = str_replace("{state}", $importData[4], $message);
                                        $message = str_replace("{zip}", $importData[5], $message);
                                        $message = str_replace("{date}", $date, $message);
                                        $unsub_link = url('admin/email/unsub/' . $email);
                                        $data = ['message' => $message, 'subject' => $subject, 'name' => $importData[0], 'unsub_link' => $unsub_link];
                                        // echo "<pre>";print_r($data);die;
                                        Mail::to($email)->send(new TestEmail($data));;
                                    }
                                } elseif ($row->type == 'sms') {
                                    $client = new Client($sid, $token);
                                    if ($importData[6] != '') {
                                        $number = '+1' . preg_replace('/[^0-9]/', '', $importData[6]);
                                    } elseif ($importData[7] != '') {
                                        $number = '+1' . preg_replace('/[^0-9]/', '', $importData[7]);
                                    } elseif ($importData[8] != '') {
                                        $number = '+1' . preg_replace('/[^0-9]/', '', $importData[8]);
                                    }
                                    $receiver_number = $number;
                                    $sender_number = $sender_numbers->number;
                                    $message = $template != null && $template->body ? $template->body : '';
                                    $message = str_replace("{name}", $importData[0], $message);
                                    $message = str_replace("{street}", $importData[2], $message);
                                    $message = str_replace("{city}", $importData[3], $message);
                                    $message = str_replace("{state}", $importData[4], $message);
                                    $message = str_replace("{zip}", $importData[5], $message);
                                    if ($receiver_number != '') {
                                        try {
                                            $sms_sent = $client->messages->create(
                                                $receiver_number,
                                                [
                                                    'from' => $sender_number,
                                                    'body' => $message,
                                                ]
                                            );
                                            if ($sms_sent) {
                                                $old_sms = Sms::where('client_number', $receiver_number)->first();
                                                if ($old_sms == null) {
                                                    $sms = new Sms();
                                                    $sms->client_number = $receiver_number;
                                                    $sms->twilio_number = $sender_number;
                                                    $sms->message = $message;
                                                    $sms->media = '';
                                                    $sms->status = 1;
                                                    $sms->save();
                                                    $this->incrementSmsCount($sender_number);
                                                } else {
                                                    $reply_message = new Reply();
                                                    $reply_message->sms_id = $old_sms->id;
                                                    $reply_message->to = $sender_number;
                                                    $reply_message->from = $receiver_number;
                                                    $reply_message->reply = $message;
                                                    $reply_message->system_reply = 1;
                                                    $reply_message->save();
                                                    $this->incrementSmsCount($sender_number);
                                                }
                                            }
                                        } catch (\Exception $ex) {
                                            $failed_sms = new FailedSms();
                                            $failed_sms->client_number = $receiver_number;
                                            $failed_sms->twilio_number = $sender_number;
                                            $failed_sms->message = $message;
                                            $failed_sms->media = '';
                                            $failed_sms->error = $ex->getMessage();
                                            $failed_sms->save();
                                        }
                                    }
                                } elseif ($row->type == 'mms') {
                                    $client = new Client($sid, $token);
                                    if ($importData[6] != '') {
                                        $number = '+1' . preg_replace('/[^0-9]/', '', $importData[6]);
                                    } elseif ($importData[7] != '') {
                                        $number = '+1' . preg_replace('/[^0-9]/', '', $importData[7]);
                                    } elseif ($importData[8] != '') {
                                        $number = '+1' . preg_replace('/[^0-9]/', '', $importData[8]);
                                    }
                                    $receiver_number = $number;
                                    $sender_number = $sender_numbers->number;
                                    $message = $template != null ? $template->body : '';
                                    $message = str_replace("{name}", $importData[0], $message);
                                    $message = str_replace("{street}", $importData[2], $message);
                                    $message = str_replace("{city}", $importData[3], $message);
                                    $message = str_replace("{state}", $importData[4], $message);
                                    $message = str_replace("{zip}", $importData[5], $message);
                                    if ($receiver_number != '') {
                                        try {
                                            $sms_sent = $client->messages->create(
                                                $receiver_number,
                                                [
                                                    'from' => $sender_number,
                                                    'body' => $message,
                                                    'mediaUrl' => [$template->mediaUrl],
                                                ]
                                            );

                                            if ($sms_sent) {
                                                $old_sms = Sms::where('client_number', $receiver_number)->first();
                                                if ($old_sms == null) {
                                                    $sms = new Sms();
                                                    $sms->client_number = $receiver_number;
                                                    $sms->twilio_number = $sender_number;
                                                    $sms->message = $message;
                                                    $sms->media = $template->mediaUrl;
                                                    $sms->status = 1;
                                                    $sms->save();
                                                    $this->incrementSmsCount($sender_number);
                                                } else {
                                                    $reply_message = new Reply();
                                                    $reply_message->sms_id = $old_sms->id;
                                                    $reply_message->to = $sender_number;
                                                    $reply_message->from = $receiver_number;
                                                    $reply_message->reply = $message;
                                                    $reply_message->system_reply = 1;
                                                    $reply_message->save();
                                                    $this->incrementSmsCount($sender_number);
                                                }
                                            }
                                        } catch (\Exception $ex) {
                                            $failed_sms = new FailedSms();
                                            $failed_sms->client_number = $receiver_number;
                                            $failed_sms->twilio_number = $sender_number;
                                            $failed_sms->message = $message;
                                            $failed_sms->media = $template->mediaUrl;
                                            $failed_sms->error = $ex->getMessage();
                                            $failed_sms->save();
                                        }
                                    }
                                } elseif ($row->type == 'rvm') {
                                    $contactsArr = [];
                                    if ($importData[6] != '') {
                                        $number = '+1' . preg_replace('/[^0-9]/', '', $importData[6]);
                                    } elseif ($importData[7] != '') {
                                        $number = '+1' . preg_replace('/[^0-9]/', '', $importData[7]);
                                    } elseif ($importData[8] != '') {
                                        $number = '+1' . preg_replace('/[^0-9]/', '', $importData[8]);
                                    }
                                    if ($number) {
                                        $c_phones = $number;
                                        $vrm = \Slybroadcast::sendVoiceMail([
                                            'c_phone' => ".$c_phones.",
                                            'c_url' => $template->body,
                                            'c_record_audio' => '',
                                            'c_date' => 'now',
                                            'c_audio' => 'Mp3',
                                            //'c_callerID' => "4234606442",
                                            'c_callerID' => $sender_numbers->number,
                                            //'mobile_only' => 1,
                                            'c_dispo_url' => 'https://brian-bagnall.com/bulk/bulksms/public/admin/voicepostback'
                                        ])->getResponse();
                                    }
                                }
                            }
                        }
                    }
                    // if ($existing_group_id == 0) {
                    //     // $insertData = array(
                    //     //     "group_id" => $group->id,
                    //     //     "name" => $importData[0],
                    //     //     "last_name" => $importData[1],
                    //     //     "street" => $importData[2],
                    //     //     "city" => $importData[3],
                    //     //     "state" => $importData[4],
                    //     //     "zip" => $importData[5],
                    //     //     "number" => '+1' . preg_replace('/[^0-9]/', '', $importData[6]),
                    //     //     "number2" => '+1' . preg_replace('/[^0-9]/', '', $importData[7]),
                    //     //     "number3" => '+1' . preg_replace('/[^0-9]/', '', $importData[8]),
                    //     //     "email1" => $importData[9],
                    //     //     "email2" => $importData[10]
                    //     // );
                    //     // Contact::create($insertData);

                    //     // Create an array to hold the mapped data
                    //     $insertData = array(
                    //         "group_id" => $group->id
                    //     );


                    //     // Iterate through the imported data and map it to the corresponding column
                    //     foreach ($importData as $headerIndex => $value) {

                    //         // Check if the header index is mapped to a column
                    //         if (isset($columnToHeader[$headerIndex])) {
                    //             $column = $columnToHeader[$headerIndex];

                    //             $header_index = $column . '_header';
                    //             // Check if this column has header too
                    //             if (isset($columnToHeaderIndex[$header_index])) {
                    //                 $header_index = $columnToHeaderIndex[$header_index];
                    //             }

                    //             if ($headerIndex == $header_index) {
                    //                 // Set the column value in the insert data
                    //                 $insertData[$column] = $value;
                    //             }
                    //         }
                    //     }

                    //     // Insert the data into the Contact table
                    //     Contact::create($insertData);
                    // }
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Group created successfully!'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'File too large. File must be less than 2MB!'
                ]);
            }
        } else {
            $group->delete();
            return response()->json([
                'status' => false,
                'message' => 'Invalid File Extension!'
            ]);
        }
    }

    public function incrementSmsCount(string $number)
    {
        $number = Number::where('number', $number)->first();
        $number->sms_count++;
        $number->save();
    }


    public function getAllContacts(Group $group, Request $request)
    {
        $sr = 1;
        $leadstatus = LeadStatus::where("is_active", 0)->orderBy('sr_order', 'asc')->get();
        $contacts = Contact::where("is_dnc", 0)->get();
        $contractres = Contractupload::all()->sortByDesc("created_at");
        $id = $group->id;

        return view('back.pages.group.view_all', compact('contacts', 'group', 'contractres', 'id', 'sr', 'leadstatus'));
    }

    public function EditContacts(Request $request, $id)
    {

        $user = Contact::find($id);
        $timezones = TimeZones::all();
        return view('back.pages.group.editcontact', compact('user', 'timezones'));
    }

    public function StoreContacts(Request $request)
    {
        //  return $request->id;
        $user = Contact::where('id', $request->id)->first();

        $user->email1 = $request->input('email') ?? 0;

        $user->name                  = $request->input('name') ?? 0;
        $user->last_name             = $request->input('last_name') ?? 0;
        $user->number                = $request->input('mobile') ?? 0;
        $user->street                = $request->input('street') ?? 0;
        $user->state                 = $request->input('state') ?? 0;
        $user->city                  = $request->input('city') ?? 0;
        $user->zip                   = $request->input('zip') ?? 0;
        $user->save();

        return redirect()->route('admin.profile.show')->with('success', 'Contract updated successfully.');

        return view('back.pages.group.editcontact', compact('user', 'timezones'));
    }

    public function show(Group $group, Request $request)
    {
        $contractres = Contractupload::all()->sortByDesc("created_at");
        $id = $group->id;
        $sr = 1;
        if ($request->wantsJson()) {
            $contacts = Contact::where("group_id", $group->id)->where("is_dnc", 0)->get();
            return response()->json([
                'data' => $contacts,
                'success' => true,
                'status' => 200,
                'message' => 'OK'
            ]);
        } else {
            return view('back.pages.group.details', compact('group', 'sr', 'contractres', 'id'));
            //  return view('back.pages.group.details', compact('group', 'sr', 'id'));
        }
    }


    public function edit(Group $group)
    {
        //
    }


    public function update(Request $request, Group $group)
    {
        //
    }


    public function destroy(Request $request)
    {
        Group::find($request->id)->delete();
        Alert::success('Success!', 'Group Removed!');
        return redirect()->back();
    }


    public function getScript($id = '')
    {
        $scrip = Script::where('id', $id)->first();
        return view('back.pages.group.ajaxScript', compact('scrip'));
    }


    public function mailcontactlist(Request $request)
    {
        if (count($request->checked_id) > 0) {
            foreach ($request->checked_id as $contactId) {

                $contractRes = Contractupload::where("id", $request->contracttype)->first();
                $mailcontact = Contact::where("id", $contactId)->first();
                $subject = "Testing 05092023";
                // $message = "Message Testing 05092023".'<br>';
                $message = $contractRes->content;
                $url = url('myHtml/' . $contractRes->id . '/' . $mailcontact->id);
                $data = ['message' => $message, 'subject' => $subject, 'name' => $mailcontact->name, "contract_id" => $contractRes->id, "contactid" => $mailcontact->id, "Url" => $url];
                Mail::to($mailcontact->email1)->send(new Mailcontact($data));
                Contact::where("id", $contactId)->update(['mail_sent' => 1]);
            }
            Alert::success('Success!', 'Mail sent successfully!');
            return redirect()->back();
        }
    }

    public function uploadcontract(Request $request)
    {


        $file = $request->file;

        $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("pdf");
        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($file->path());
            $content = $pdf->getText();
            $filenameNew =  time() . '.' . $fileName;
            $Contractupload = new Contractupload;
            $Contractupload->content = $content;
            $Contractupload->type_contract = $request->optiontype;
            $Contractupload->file = $filenameNew;
            $Contractupload->save();
            $file->move('../public/contractpdf/', $filenameNew);
            Alert::success('Success!', 'Contract Uploaded successfully!');
            return redirect()->back();
        } else {
            Alert::error('Oops!', "Please enter only pdf file");
            return redirect()->back();
        }
    }




    public function uploadcontractedit(Request $request)
    {

        $file = $request->file;

        $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("pdf");
        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($file->path());
            $content = $pdf->getText();
            $filenameNew =  time() . '.' . $fileName;
            $Contractupload = Contractupload::find(1);
            $destinationPath = public_path('/contractpdf/' . $Contractupload->file);

            if (file_exists($destinationPath)) {
                unlink($destinationPath);
            }
            $Contractupload->content = $content;
            $Contractupload->type_contract = $request->optiontype;
            $Contractupload->file = $filenameNew;
            $Contractupload->save();
            $file->move('../public/contractpdf/', $filenameNew);
            Alert::success('Success!', 'Contract Updated successfully!');
            return redirect()->back();
        } else {
            Alert::error('Oops!', "Please enter only pdf file");
            return redirect()->back();
        }
    }

    public function contractview(Request $request)
    {
        $contractres = Contractupload::all()->sortByDesc("created_at");
        return view('back.pages.group.contractview', compact('contractres'));
    }

    public function myHtml($id, $contactid)
    {
        $contractRes = Contractupload::where("id", $id)->first();
        $contactrRes = Contact::where("id", $contactid)->first();
        $name = $contactrRes->name;
        $contractres = str_replace('#name#', $name, $contractRes->content);
        return view('back.pages.group.myFile', compact('contractres'));
    }

    public function skipTrace(DatazappService $datazappService, Request $request)
    {

        $date = now()->format('d M Y');
        $user_id = auth()->id();
        $balance = \DB::table('account_details')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'succeeded')
            ->sum('amount');

        Session::forget('payment_info');
        Session::forget('record_detail');


        $user_id = auth()->id();
        $groupId = $request->input('group_id');
        $selectedOption = $request->input('skip_trace_option');

        $checkPayment  = Session::get('payment_sucess');
        $paymentRecord = DB::table('skip_tracing_payment_records')
            ->where('user_id', $user_id)
            ->where('group_id', $groupId)
            ->where('skip_trace_option_id', $selectedOption)
            ->first();


        $group = Group::with('contacts')->find($groupId);


        if (!$group) {
            return response()->json(['error' => 'Group not found.']);
        }

        // Extract the contact data from the group
        $groupContacts = $group->contacts;

        // Remove duplicates based on both 'email' and 'number' attributes
        $uniqueContacts = $groupContacts->unique(function ($contact) {
            return $contact->email1 . '|' . $contact->number;
        });

        $skipTraceRate = null;
        Session::put('record_detail', [
            'group' => $group,
            'uniqueContacts' => $uniqueContacts,
            'groupId' => $groupId,
            'selectedOption' => $selectedOption,
        ]);

        if ($selectedOption == 'skip_entire_list_phone' || $selectedOption == 'skip_records_without_numbers_phone') {
            $skipTraceRate = Account::pluck('phone_cell_append_rate')->first();
        } elseif ($selectedOption == 'skip_entire_list_email' || $selectedOption == 'skip_records_without_emails') {
            $skipTraceRate = Account::pluck('phone_cell_append_rate')->first();;
        } elseif ($selectedOption == 'append_names') {
            $skipTraceRate = Account::pluck('name_append_rate')->first();
        } elseif ($selectedOption == 'append_emails') {
            $skipTraceRate = Account::pluck('email_append_rate')->first();
        } elseif ($selectedOption == 'email_verification_entire_list' || $selectedOption == 'email_verification_non_verified') {
            $skipTraceRate = Account::pluck('email_verification_rate')->first();
        } elseif ($selectedOption == 'phone_scrub_entire_list' || $selectedOption == 'phone_scrub_non_scrubbed_numbers') {
            $skipTraceRate = Account::pluck('phone_scrub_rate')->first();
        }

        if ($skipTraceRate === null) {

            return response()->json(['error' => 'Invalid skip trace option.']);
        } else {

            // $paymentInfo = Session::get('record_detail');
            if (isset($balance) && $balance > 0 || $balance >= $skipTraceRate) {
                // return response()->json([

                //     'data' => [
                //         'skip_trace_rate' => $skipTraceRate[0] * count($uniqueContacts),
                //         'group_id' => $groupId,
                //         'skip_trace_option' => $selectedOption,
                //     ]
                // ]);

                // Initialize the result variable
                $result = null;

                // Perform skip tracing based on the selected option
                if ($selectedOption === 'skip_entire_list_phone' || $selectedOption === 'skip_records_without_numbers_phone') {
                    // Implement skip tracing logic for the entire list of phone numbers
                    $result = $datazappService->skipTrace($uniqueContacts, $selectedOption);

                    if ($result) {
                        // Check if $result contains the expected data structure
                        if (
                            isset($result['ResponseDetail']['Data']) &&
                            is_array($result['ResponseDetail']['Data'])
                        ) {
                            $data = $result['ResponseDetail']['Data'];

                            foreach ($data as $record) {
                                // Check if the record has a matched phone number
                                if (
                                    isset($record['Matched']) &&
                                    $record['Matched'] &&
                                    isset($record['Phone'])
                                ) {
                                    $matchedPhone = $record['Phone'];

                                    // Find the corresponding contact based on additional criteria
                                    $matchingContact = $uniqueContacts->first(function ($contact) use ($record) {
                                        return ($contact->name === $record['FirstName'] &&
                                            $contact->last_name === $record['LastName'] &&
                                            $contact->street === $record['Address'] &&
                                            $contact->city === $record['City'] &&
                                            $contact->zip === $record['Zip']
                                        );
                                    });

                                    // Update the contact in the database with the matched phone number

                                    if ($matchingContact) {
                                        $matchingContact->update(['number' => $matchedPhone]);
                                    }


                                    if ($groupId) {

                                        $group = Group::where('id', $groupId)->first();

                                        $group->phone_skip_trace_date = $date;
                                        $group->save();
                                    }

                                    $sucess = TotalBalance::where('user_id', $user_id)->decrement('total_amount', $skipTraceRate);

                                    if ($sucess) {
                                        DB::table('skip_tracing_payment_records')->insert([
                                            'user_id' => $user_id,
                                            'skip_trace_option_id' => $selectedOption,
                                            'group_id' => $groupId,
                                            'amount' => $skipTraceRate,
                                            'is_paid' => true,
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ]);

                                        $skipTraceDetail = new SkipTracingDetail();
                                        $skipTraceDetail->user_id = $user_id;
                                        $skipTraceDetail->group_id = $groupId;
                                        $skipTraceDetail->select_option = $selectedOption;
                                        $skipTraceDetail->phone_skip_trace_date = $date;
                                        $skipTraceDetail->verified_numbers = $record['Phone'];
                                        $skipTraceDetail->scam_numbers = null;
                                        $skipTraceDetail->first_name = $record['FirstName'];
                                        $skipTraceDetail->last_name = $record['LastName'];
                                        $skipTraceDetail->address = $record['Address'];
                                        $skipTraceDetail->city = $record['City'];
                                        $skipTraceDetail->zip = $record['Zip'];
                                        $skipTraceDetail->matched = $record['Matched'];
                                        $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                        $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                        $skipTraceDetail->status = $result['Status'];
                                        $skipTraceDetail->save();
                                    }
                                } else {
                                    if ($groupId) {

                                        $group = Group::where('id', $groupId)->first();

                                        $group->phone_skip_trace_date = $date;
                                        $group->save();
                                    }

                                    $skipTraceDetail = new SkipTracingDetail();
                                    $skipTraceDetail->user_id = $user_id;
                                    $skipTraceDetail->group_id = $groupId;
                                    $skipTraceDetail->select_option = $selectedOption;
                                    $skipTraceDetail->phone_skip_trace_date = $date;
                                    $skipTraceDetail->verified_numbers = $record['Phone'];
                                    $skipTraceDetail->scam_numbers = null;
                                    $skipTraceDetail->first_name = $record['FirstName'];
                                    $skipTraceDetail->last_name = $record['LastName'];
                                    $skipTraceDetail->address = $record['Address'];
                                    $skipTraceDetail->city = $record['City'];
                                    $skipTraceDetail->zip = $record['Zip'];
                                    $skipTraceDetail->matched = $record['Matched'];
                                    $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                    $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                    $skipTraceDetail->status = $result['Status'];
                                    $skipTraceDetail->save();
                                }
                            }
                        }
                    }
                } elseif ($selectedOption === 'skip_entire_list_email' || $selectedOption === 'skip_records_without_emails') {
                    // Implement skip tracing logic for the entire list of emails
                    $result = $datazappService->skipTrace($uniqueContacts, $selectedOption);

                    if ($result) {
                        // Check if $result contains the expected data structure
                        if (
                            isset($result['ResponseDetail']['Data']) &&
                            is_array($result['ResponseDetail']['Data'])
                        ) {
                            $data = $result['ResponseDetail']['Data'];

                            foreach ($data as $record) {
                                // Check if the record has a matched phone number
                                if (
                                    isset($record['Matched']) &&
                                    $record['Matched'] &&
                                    isset($record['Email'])
                                ) {
                                    $matchedEmail = $record['Email'];

                                    // Find the corresponding contact based on additional criteria
                                    $matchingContact = $uniqueContacts->first(function ($contact) use ($record) {
                                        return ($contact->name === $record['FirstName'] &&
                                            $contact->last_name === $record['LastName'] &&
                                            $contact->street === $record['Address'] &&
                                            $contact->city === $record['City']
                                        );
                                    });

                                    // Update the contact in the database with the matched phone number
                                    if ($matchingContact) {
                                        $matchingContact->update(['email1' => $matchedEmail]);
                                    }

                                    if ($groupId) {

                                        $group = Group::where('id', $groupId)->first();

                                        $group->email_skip_trace_date = $date;
                                        $group->save();
                                    }

                                    $sucess = TotalBalance::where('user_id', $user_id)->decrement('total_amount', $skipTraceRate);
                                    $skipTraceDetail = new SkipTracingDetail();
                                    $skipTraceDetail->user_id = $user_id;
                                    $skipTraceDetail->group_id = $groupId;
                                    $skipTraceDetail->select_option = $selectedOption;
                                    $skipTraceDetail->email_skip_trace_date = $date;
                                    $skipTraceDetail->verified_emails = $record['Email'];
                                    $skipTraceDetail->scam_numbers = null;
                                    $skipTraceDetail->first_name = $record['FirstName'];
                                    $skipTraceDetail->last_name = $record['LastName'];
                                    $skipTraceDetail->address = $record['Address'];
                                    $skipTraceDetail->city = $record['City'];
                                    $skipTraceDetail->zip = $record['Zip'];
                                    $skipTraceDetail->matched = $record['Matched'];
                                    $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                    $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                    $skipTraceDetail->status = $result['Status'];
                                    $skipTraceDetail->save();
                                    if ($sucess) {
                                        DB::table('skip_tracing_payment_records')->insert([
                                            'user_id' => $user_id,
                                            'skip_trace_option_id' => $selectedOption,
                                            'group_id' => $groupId,
                                            'amount' => $skipTraceRate,
                                            'is_paid' => true,
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ]);
                                    }
                                } else {
                                    if ($groupId) {

                                        $group = Group::where('id', $groupId)->first();

                                        $group->email_skip_trace_date = $date;
                                        $group->save();
                                    }

                                    $skipTraceDetail = new SkipTracingDetail();
                                    $skipTraceDetail->user_id = $user_id;
                                    $skipTraceDetail->group_id = $groupId;
                                    $skipTraceDetail->select_option = $selectedOption;
                                    $skipTraceDetail->email_skip_trace_date = $date;
                                    $skipTraceDetail->verified_emails = $record['Email'];
                                    $skipTraceDetail->scam_numbers = null;
                                    $skipTraceDetail->first_name = $record['FirstName'];
                                    $skipTraceDetail->last_name = $record['LastName'];
                                    $skipTraceDetail->address = $record['Address'];
                                    $skipTraceDetail->city = $record['City'];
                                    $skipTraceDetail->zip = $record['Zip'];
                                    $skipTraceDetail->matched = $record['Matched'];
                                    $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                    $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                    $skipTraceDetail->status = $result['Status'];
                                    $skipTraceDetail->save();
                                }
                            }
                        }
                    }
                } elseif ($selectedOption === 'append_names') {
                    // Implement append names logic for records without names
                    $result = $datazappService->skipTrace($uniqueContacts, $selectedOption);

                    if ($result) {
                        // Check if $result contains the expected data structure
                        if (
                            isset($result['ResponseDetail']['Data']) &&
                            is_array($result['ResponseDetail']['Data'])
                        ) {
                            $data = $result['ResponseDetail']['Data'];

                            foreach ($data as $record) {
                                // Check if the record has a matched phone number
                                if (
                                    isset($record['Matched']) &&
                                    $record['Matched']
                                ) {
                                    $matchedFirstName = $record['FirstName'];
                                    $matchedLastName = $record['LastName'];

                                    // Find the corresponding contact based on additional criteria
                                    $matchingContact = $uniqueContacts->first(function ($contact) use ($record) {
                                        return ($contact->street === $record['Address'] &&
                                            $contact->city === $record['City'] &&
                                            $contact->zip === $record['Zip']
                                        );
                                    });

                                    // Update the contact in the database with the matched phone number
                                    if ($matchingContact) {
                                        $matchingContact->update([
                                            'name' => $matchedFirstName,
                                            'last_name' => $matchedLastName,
                                        ]);
                                    }



                                    if ($groupId) {

                                        $group = Group::where('id', $groupId)->first();

                                        $group->name_skip_trace_date = $date;
                                        $group->save();
                                    }

                                    $sucess = TotalBalance::where('user_id', $user_id)->decrement('total_amount', $skipTraceRate);
                                    $skipTraceDetail = new SkipTracingDetail();
                                    $skipTraceDetail->user_id = $user_id;
                                    $skipTraceDetail->group_id = $groupId;
                                    $skipTraceDetail->select_option = $selectedOption;
                                    $skipTraceDetail->email_skip_trace_date = null;
                                    $skipTraceDetail->phone_skip_trace_date = null;
                                    $skipTraceDetail->name_skip_trace_date = $date;
                                    $skipTraceDetail->email_verification_date = null;
                                    $skipTraceDetail->phone_scrub_date = null;
                                    $skipTraceDetail->verified_emails = null;
                                    $skipTraceDetail->verified_numbers = null;
                                    $skipTraceDetail->append_names = $record['FirstName'] . '' . $record['FirstName'];
                                    $skipTraceDetail->append_emails = null;
                                    $skipTraceDetail->scam_numbers = null;
                                    $skipTraceDetail->scam_emails = null;
                                    $skipTraceDetail->first_name = $record['FirstName'];
                                    $skipTraceDetail->last_name = $record['LastName'];
                                    $skipTraceDetail->address = $record['Address'];
                                    $skipTraceDetail->city = $record['City'];
                                    $skipTraceDetail->zip = $record['Zip'];
                                    $skipTraceDetail->matched = $record['Matched'];
                                    $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                    $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                    $skipTraceDetail->status = $result['Status'];
                                    $skipTraceDetail->save();
                                    if ($sucess) {
                                        DB::table('skip_tracing_payment_records')->insert([
                                            'user_id' => $user_id,
                                            'skip_trace_option_id' => $selectedOption,
                                            'group_id' => $groupId,
                                            'amount' => $skipTraceRate,
                                            'is_paid' => true,
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ]);
                                    }
                                } else {
                                    if ($groupId) {

                                        $group = Group::where('id', $groupId)->first();

                                        $group->name_skip_trace_date = $date;
                                        $group->save();
                                    }

                                    $skipTraceDetail = new SkipTracingDetail();
                                    $skipTraceDetail->user_id = $user_id;
                                    $skipTraceDetail->group_id = $groupId;
                                    $skipTraceDetail->select_option = $selectedOption;
                                    $skipTraceDetail->email_skip_trace_date = null;
                                    $skipTraceDetail->phone_skip_trace_date = null;
                                    $skipTraceDetail->name_skip_trace_date = $date;
                                    $skipTraceDetail->email_verification_date = null;
                                    $skipTraceDetail->phone_scrub_date = null;
                                    $skipTraceDetail->verified_emails = null;
                                    $skipTraceDetail->verified_numbers = null;
                                    $skipTraceDetail->append_names = $record['FirstName'] . '' . $record['FirstName'];
                                    $skipTraceDetail->append_emails = null;
                                    $skipTraceDetail->scam_numbers = null;
                                    $skipTraceDetail->scam_emails = null;
                                    $skipTraceDetail->first_name = $record['FirstName'];
                                    $skipTraceDetail->last_name = $record['LastName'];
                                    $skipTraceDetail->address = $record['Address'];
                                    $skipTraceDetail->city = $record['City'];
                                    $skipTraceDetail->zip = $record['Zip'];
                                    $skipTraceDetail->matched = $record['Matched'];
                                    $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                    $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                    $skipTraceDetail->status = $result['Status'];
                                    $skipTraceDetail->save();
                                }
                            }
                        }
                    }
                } elseif ($selectedOption === 'append_emails') {
                    // Implement append names logic for records without names
                    $result = $datazappService->skipTrace($uniqueContacts, $selectedOption);

                    if ($result) {
                        // Check if $result contains the expected data structure
                        if (
                            isset($result['ResponseDetail']['Data']) &&
                            is_array($result['ResponseDetail']['Data'])
                        ) {
                            $data = $result['ResponseDetail']['Data'];

                            foreach ($data as $record) {
                                // Check if the record has a matched phone number
                                if (
                                    isset($record['Matched']) &&
                                    $record['Matched']
                                ) {
                                    $matchedEmail = $record['Email'];

                                    // Find the corresponding contact based on additional criteria
                                    $matchingContact = $uniqueContacts->first(function ($contact) use ($record) {
                                        return ($contact->name === $record['FirstName'] &&
                                            $contact->last_name === $record['LastName'] &&
                                            $contact->street === $record['Address'] &&
                                            $contact->city === $record['City'] &&
                                            $contact->zip === $record['Zip']
                                        );
                                    });

                                    // Update the contact in the database with the matched phone number
                                    if ($matchingContact) {
                                        $matchingContact->update([
                                            'email1' => $matchedEmail,
                                        ]);
                                    }



                                    if ($groupId) {

                                        $group = Group::where('id', $groupId)->first();

                                        $group->email_skip_trace_date = $date;
                                        $group->save();
                                    }

                                    $sucess = TotalBalance::where('user_id', $user_id)->decrement('total_amount', $skipTraceRate);
                                    $skipTraceDetail = new SkipTracingDetail();
                                    $skipTraceDetail->user_id = $user_id;
                                    $skipTraceDetail->group_id = $groupId;
                                    $skipTraceDetail->select_option = $selectedOption;
                                    $skipTraceDetail->email_skip_trace_date = $date;
                                    $skipTraceDetail->phone_skip_trace_date = null;
                                    $skipTraceDetail->name_skip_trace_date = null;
                                    $skipTraceDetail->email_verification_date = null;
                                    $skipTraceDetail->phone_scrub_date = null;
                                    $skipTraceDetail->verified_emails = $record['Email'];
                                    $skipTraceDetail->verified_numbers = null;
                                    $skipTraceDetail->append_names = null;
                                    $skipTraceDetail->append_emails = $record['Email'];
                                    $skipTraceDetail->scam_numbers = null;
                                    $skipTraceDetail->scam_emails = null;
                                    $skipTraceDetail->first_name = $record['FirstName'];
                                    $skipTraceDetail->last_name = $record['LastName'];
                                    $skipTraceDetail->address = $record['Address'];
                                    $skipTraceDetail->city = $record['City'];
                                    $skipTraceDetail->zip = $record['Zip'];
                                    $skipTraceDetail->matched = $record['Matched'];
                                    $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                    $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                    $skipTraceDetail->status = $result['Status'];
                                    $skipTraceDetail->save();
                                    if ($sucess) {
                                        DB::table('skip_tracing_payment_records')->insert([
                                            'user_id' => $user_id,
                                            'skip_trace_option_id' => $selectedOption,
                                            'group_id' => $groupId,
                                            'amount' => $skipTraceRate,
                                            'is_paid' => true,
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ]);
                                    }
                                } else {
                                    if ($groupId) {

                                        $group = Group::where('id', $groupId)->first();

                                        $group->email_skip_trace_date = $date;
                                        $group->save();
                                    }

                                    $skipTraceDetail = new SkipTracingDetail();
                                    $skipTraceDetail->user_id = $user_id;
                                    $skipTraceDetail->group_id = $groupId;
                                    $skipTraceDetail->select_option = $selectedOption;
                                    $skipTraceDetail->email_skip_trace_date = $date;
                                    $skipTraceDetail->phone_skip_trace_date = null;
                                    $skipTraceDetail->name_skip_trace_date = null;
                                    $skipTraceDetail->email_verification_date = null;
                                    $skipTraceDetail->phone_scrub_date = null;
                                    $skipTraceDetail->verified_emails = $record['Email'];
                                    $skipTraceDetail->verified_numbers = null;
                                    $skipTraceDetail->append_names = null;
                                    $skipTraceDetail->append_emails = $record['Email'];
                                    $skipTraceDetail->scam_numbers = null;
                                    $skipTraceDetail->scam_emails = null;
                                    $skipTraceDetail->first_name = $record['FirstName'];
                                    $skipTraceDetail->last_name = $record['LastName'];
                                    $skipTraceDetail->address = $record['Address'];
                                    $skipTraceDetail->city = $record['City'];
                                    $skipTraceDetail->zip = $record['Zip'];
                                    $skipTraceDetail->matched = $record['Matched'];
                                    $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                    $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                    $skipTraceDetail->status = $result['Status'];
                                    $skipTraceDetail->save();
                                }
                            }
                        }
                    }
                } elseif ($selectedOption === 'email_verification_entire_list' || $selectedOption === 'email_verification_non_verified') {
                    // Implement email verification logic for the entire list of emails
                    $result = $datazappService->skipTrace($uniqueContacts, $selectedOption);

                    if ($result) {
                        // Check if $result contains the expected data structure
                        if (
                            isset($result['ResponseDetail']['Data']) &&
                            is_array($result['ResponseDetail']['Data'])
                        ) {
                            $data = $result['ResponseDetail']['Data'];

                            // Assuming $data is the array from the API response
                            foreach ($data as $record) {
                                // Check if the record has a matched email status
                                if (isset($record['Status'])) {
                                    $matchedEmail = $record['Email'];

                                    // Find the corresponding contact based on additional criteria
                                    $matchingContact = $uniqueContacts->first(function ($contact) use ($record) {

                                        return ($contact->email2 === $record['Email']

                                        );
                                    });

                                    // Update the contact in the database with the matched email
                                    if ($matchingContact) {
                                        $matchingContact->update([
                                            'email1' => $matchedEmail,
                                            'email2' => $matchedEmail,
                                        ]);
                                    }



                                    // Assuming $user_id and $skipTraceRate are defined earlier
                                    $userBalance = TotalBalance::where('user_id', $user_id)->first();

                                    if ($groupId) {
                                        $group = Group::find($groupId);

                                        if ($group) {
                                            // Assuming $date is defined earlier
                                            $group->email_verification_date = $date;
                                            $group->save();
                                        }
                                    }

                                    if ($userBalance && $userBalance->total_amount >= $skipTraceRate) {
                                        $userBalance->decrement('total_amount', $skipTraceRate);

                                        DB::table('skip_tracing_payment_records')->insert([
                                            'user_id' => $user_id,
                                            'skip_trace_option_id' => $selectedOption,
                                            'group_id' => $groupId,
                                            'amount' => $skipTraceRate,
                                            'is_paid' => true,
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ]);
                                    }

                                    $skipTraceDetail = new SkipTracingDetail();
                                    $skipTraceDetail->user_id = $user_id;
                                    $skipTraceDetail->group_id = $groupId;
                                    $skipTraceDetail->select_option = $selectedOption;
                                    $skipTraceDetail->email_skip_trace_date = null;
                                    $skipTraceDetail->phone_skip_trace_date = null;
                                    $skipTraceDetail->name_skip_trace_date = null;
                                    $skipTraceDetail->email_verification_date = $date;
                                    $skipTraceDetail->phone_scrub_date = null;
                                    $skipTraceDetail->verified_emails = $record['Status'];
                                    $skipTraceDetail->verified_numbers = null;
                                    $skipTraceDetail->append_names = null;
                                    $skipTraceDetail->append_emails = $record['Email'];
                                    $skipTraceDetail->scam_numbers = null;
                                    $skipTraceDetail->scam_emails = null;
                                    $skipTraceDetail->first_name = null;
                                    $skipTraceDetail->last_name = null;
                                    $skipTraceDetail->address = null;
                                    $skipTraceDetail->city = null;
                                    $skipTraceDetail->zip = null;
                                    $skipTraceDetail->matched = 'Matched';
                                    $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                    $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                    $skipTraceDetail->status = $result['Status'];
                                    $skipTraceDetail->save();
                                } else {
                                    if ($groupId) {

                                        $group = Group::where('id', $groupId)->first();

                                        $group->email_verification_date = $date;
                                        $group->save();
                                    }

                                    $skipTraceDetail = new SkipTracingDetail();
                                    $skipTraceDetail->user_id = $user_id;
                                    $skipTraceDetail->group_id = $groupId;
                                    $skipTraceDetail->select_option = $selectedOption;
                                    $skipTraceDetail->email_skip_trace_date = null;
                                    $skipTraceDetail->phone_skip_trace_date = null;
                                    $skipTraceDetail->name_skip_trace_date = null;
                                    $skipTraceDetail->email_verification_date = $date;
                                    $skipTraceDetail->phone_scrub_date = null;
                                    $skipTraceDetail->verified_emails = $record['Status'];
                                    $skipTraceDetail->verified_numbers = null;
                                    $skipTraceDetail->append_names = null;
                                    $skipTraceDetail->append_emails = $record['Email'];
                                    $skipTraceDetail->scam_numbers = null;
                                    $skipTraceDetail->scam_emails = null;
                                    $skipTraceDetail->first_name = null;
                                    $skipTraceDetail->last_name = null;
                                    $skipTraceDetail->address = null;
                                    $skipTraceDetail->city = null;
                                    $skipTraceDetail->zip = null;
                                    $skipTraceDetail->matched = null;
                                    $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                    $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                    $skipTraceDetail->status = $result['Status'];
                                    $skipTraceDetail->save();
                                }
                            }
                        }
                    }
                } elseif ($selectedOption === 'phone_scrub_entire_list' || $selectedOption === 'phone_scrub_non_scrubbed_numbers') {
                    // Implement phone scrubbing logic for the entire list of phone numbers
                    $result = $datazappService->skipTrace($uniqueContacts, $selectedOption);

                    if ($result) {
                        // Check if $result contains the expected data structure
                        if (
                            isset($result['ResponseDetail']['Data']) &&
                            is_array($result['ResponseDetail']['Data'])
                        ) {
                            $data = $result['ResponseDetail']['Data'];

                            foreach ($data as $record) {
                                // Check if the record has a matched phone number
                                if (
                                    isset($result['Status'])
                                ) {
                                    $matchedPhone1 = $record['Phone'];
                                    $matchedPhone2 = $record['Phone'];
                                    $matchedPhone3 = $record['Phone'];

                                    // Find the corresponding contact based on additional criteria
                                    $matchingContact = $uniqueContacts->first(function ($contact) use ($record) {
                                        return ($contact->number === $record['FormattedPhone'] ||
                                            $contact->number2 === $record['FormattedPhone'] ||
                                            $contact->number3 === $record['FormattedPhone'] ||
                                            $contact->number === $record['Phone'] ||
                                            $contact->number2 === $record['Phone'] ||
                                            $contact->number3 === $record['Phone']
                                        );
                                    });

                                    // Update the contact in the database with the matched phone number
                                    if ($matchingContact) {
                                        $matchingContact->update([
                                            'number' => $matchedPhone1,
                                            'number2' => $matchedPhone2,
                                            'number3' => $matchedPhone3,
                                        ]);
                                    }



                                    if ($groupId) {

                                        $group = Group::where('id', $groupId)->first();

                                        $group->phone_scrub_date = $date;
                                        $group->save();
                                    }

                                    $sucess = TotalBalance::where('user_id', $user_id)->decrement('total_amount', $skipTraceRate);

                                    if ($sucess) {
                                        DB::table('skip_tracing_payment_records')->insert([
                                            'user_id' => $user_id,
                                            'skip_trace_option_id' => $selectedOption,
                                            'group_id' => $groupId,
                                            'amount' => $skipTraceRate,
                                            'is_paid' => true,
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ]);
                                    }
                                }

                                $skipTraceDetail = new SkipTracingDetail();
                                $skipTraceDetail->user_id = $user_id;
                                $skipTraceDetail->group_id = $groupId;
                                $skipTraceDetail->select_option = $selectedOption;
                                $skipTraceDetail->email_skip_trace_date = null;
                                $skipTraceDetail->phone_skip_trace_date = null;
                                $skipTraceDetail->name_skip_trace_date = null;
                                $skipTraceDetail->email_verification_date = null;
                                $skipTraceDetail->phone_scrub_date = $date;
                                $skipTraceDetail->verified_emails = null;
                                $skipTraceDetail->verified_numbers = $record['FormattedPhone'];
                                $skipTraceDetail->append_names = null;
                                $skipTraceDetail->append_emails = null;
                                $skipTraceDetail->scam_numbers = null;
                                $skipTraceDetail->scam_emails = null;
                                $skipTraceDetail->first_name = null;
                                $skipTraceDetail->last_name = null;
                                $skipTraceDetail->address = null;
                                $skipTraceDetail->city = null;
                                $skipTraceDetail->zip = null;
                                $skipTraceDetail->matched = 'Matched';
                                $skipTraceDetail->order_amount = $result['ResponseDetail']['OrderAmount'];
                                $skipTraceDetail->token = $result['ResponseDetail']['Token'];
                                $skipTraceDetail->status = $result['Status'];
                                $skipTraceDetail->save();
                            }
                        }
                    }
                } else {
                    // Handle other options or provide an error response
                    return response()->json(['error' => 'Invalid skip trace option.']);
                }

                return $result;
            } else {

                return response()->json(['modal' => "Please Recharge your Account Balance!"]);
            }
        }
    }



    public function pushToCampaign(Request $request)
    {
        try{
        // dd($request);
        //die('here');
        
        
        $groupId = $request->input('group_id');
        $groupName = $request->input('group_name');
        $emails = explode(',', $request->input('email'));
        $campaignId = $request->input('campaign_id');
        $marketId = $request->input('market_id');
        $campaignName = $request->input('campaign_name');
        $marketName = $request->input('market_name');

        
        // Check if a record with the same group_id exists
        $existingCampaign = Campaign::where('id', $campaignId)->first();
        $existingCampaign->group_id = $groupId;
        $existingCampaign->save();

        $groupUpdate = Group::where('id', $groupId)->first();
        $groupUpdate->pushed_to_camp_date = now();
        $groupUpdate->campaign_name = $campaignName;
        $groupUpdate->save();

        // foreach ($emails as $email) {
        //     Mail::to(trim($email))->send(new CampaignConfirmation($groupName));
        // }

        $campaign_lists = CampaignList::where('campaign_id', $campaignId)->get();
        
       

        foreach ($campaign_lists as $campaign_list) {

            $_typ = $campaign_list->type;
            $_body = $campaign_list->body;
           
            
            //die('here');
            if (trim($_typ) == 'email') {


                
                $_subject = $campaign_list->subject;


                $contact_numbrs = Contact::where('group_id', $groupId)->get();
                foreach ($contact_numbrs as $contact_num) {


                    $subject = $_subject;
                    $body = strip_tags($_body);
                    $body = str_replace("{name}", $contact_num->name, $body);
                    $body = str_replace("{street}", $contact_num->street, $body);
                    $body = str_replace("{city}", $contact_num->city, $body);
                    $body = str_replace("{state}", $contact_num->state, $body);
                    $body = str_replace("{zip}", $contact_num->zip, $body);
                    // Define the recipient's email address
                    $email = $contact_num->email1;

                    // Send the email
                    Mail::raw($body, function ($message) use ($subject, $email) {
                        $message->subject($subject);
                        $message->to($email);
                    });
                }
            } elseif ($_typ == 'sms') {
                
                $contact_numbrs = Contact::where('group_id', $groupId)->get();
                
                $body = strip_tags($_body);
                
                foreach ($contact_numbrs as $contact_num) {
                
                   // print_r($contact_num->number);
               // die("..");
               $twilio_number = Number::where('id', 1)->get();
               
               $settings = Settings::first()->toArray();
              // die($settings);
               $sid = $settings['twilio_acc_sid'];
               $token = $settings['twilio_auth_token'];
               $numberCounter = 0;
               
             
                   $client = new Client($sid, $token);
                   
                   $cont_num=$contact_num->number;
                  // die($body);
       
                   $sms_sent = $client->messages->create(
                       $cont_num,
                       [
                           'from' => $twilio_number,
                           'body' => $body,
                       ]
                   );
                  // die($sms_sent);
                   if ($sms_sent) {
                       $old_sms = Sms::where('client_number', $cont_num)->first();
                       if ($old_sms == null) {
                           $sms = new Sms();
                           $sms->client_number = $cont_num;
                           $sms->twilio_number = $twilio_number;
                           $sms->lname = null;
                           $sms->fname = null;
                           $sms->message = $body;
                           $sms->media = "NO";
                           $sms->status = 1;
                           $sms->save();
                           //$contact = Contact::where('number', $contact->number)->get();;
                           // foreach ($contact as $contacts) {
                           // $contacts->msg_sent = 1;
                           // $contacts->save();
                           // }
                           // $this->incrementSmsCount($numbers[$numberCounter]->number);
                       } else {
                           $reply_message = new Reply();
                           $reply_message->sms_id = $old_sms->id;
                           $reply_message->to = $cont_num;
                           $reply_message->from = $twilio_number;
                           $reply_message->reply = $body;
                           $reply_message->system_reply = 1;
                           $reply_message->save();
                           // $contact = Contact::where('number', $contact->number)->get();;
                           // foreach ($contact as $contacts) {
                           //  $contacts->msg_sent = 1;
                           //  $contacts->save();
                           //  }
                           // $this->incrementSmsCount($numbers[$numberCounter]->number);
                       }
       
                       // Alert::toast("SMS Sent Successfully", "success");
       
                   }
               



                }
            } else {
                
            }
        }
        
    }
    catch (\Exception $ex) {
        $failed_sms = new FailedSms();
        $failed_sms->client_number = $cont_num;
        $failed_sms->twilio_number = $twilio_number;
        $failed_sms->message = $body;
        $failed_sms->media = '';
        $failed_sms->error = $ex->getMessage();
        $failed_sms->save();
            Alert::Error("Oops!", "Unable to send check Failed SMS Page!");
    }




        // Return a response to indicate success
        return response()->json(['message' => 'Pushed to campaign successfully', 'success' => true]);
        
    }

  

    // Show list create form
    public function newListForm()
    {
        $groups = Group::all();
        $markets = Market::all();
        $tags = Tag::all();
        $campaigns = Campaign::getAllCampaigns();
        $form_Template = FormTemplates::get();
        return view('back.pages.group.newList', compact('groups', 'markets', 'tags', 'campaigns', 'form_Template'));
    }
}
