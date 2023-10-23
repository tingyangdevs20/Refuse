<?php

namespace App\Http\Controllers;

use App\Exports\GenerateScrapingRequestExcel;
use App\Model\Account;
use App\Model\Campaign;
use App\Model\CampaignList;
use App\Model\Contact;
use App\Model\FormTemplates;
use App\Model\Group;
use App\Model\Market;
use App\Model\Number;
use App\Model\Tag;
use App\ScrapingSourceList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ScrapingSourceListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scrapingdata = ScrapingSourceList::all();

        return view('back.pages.secrapinglist.index', compact('scrapingdata'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requests(Request $request)
    {
        $status = $request->status;
        $scrapingdata = ScrapingSourceList::orderBy('deleted_at', 'desc');

        if ($status !== null) {
            if ($status == 'showAll') {
                $scrapingdata = $scrapingdata->withTrashed();
            } else if ($status == 'data-ready') {
                $scrapingdata->where('status', 1);
            } else if ($status == 'in-progress') {
                $scrapingdata->where('status', 0)->orWhere('status', null);
            } else if ($status == 'deleted') {
                $scrapingdata = $scrapingdata->onlyTrashed();
            } else {
                $scrapingdata = $scrapingdata->withTrashed();
            }
        }

        $scrapingdata = $scrapingdata->get();
        return view('back.pages.secrapinglist.requests', compact('scrapingdata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.pages.secrapinglist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Excel $excel)
    {
        $request->validate([
            'city_county_zip' => 'required|string',
            'state' => 'required|string',
            'listing_type' => 'required|array',
            'price_range' => 'required|string',
            'no_of_bedrooms' => 'required|string',
            'no_of_bathrooms' => 'required|string',
            'property_type' => 'required|array',
            'filters' => 'required|array',
            'job_name' => 'required|string',
        ]);

        $data = new ScrapingSourceList();
        $data->city_county_zip = $request->city_county_zip;
        $data->state = $request->state;
        $data->price_range = $request->price_range;
        $data->listing_type = implode(', ', $request->listing_type);
        $data->property_type = implode(', ', $request->property_type);
        $data->no_of_bedrooms = $request->no_of_bedrooms;
        $data->no_of_bathrooms = $request->no_of_bathrooms;
        $data->filters = implode(', ', $request->filters);
        $data->job_name = $request->job_name;
        $data->status = $request->data_status;
        $data->save();

        // Create an array for price range
        $price_range = $request->price_range;
        $stepSize = 50000;

        $priceRanges = $this->splitPriceRange($price_range, $stepSize);

         // Create a collection to store the records
        $collection = collect();

        foreach ($priceRanges as $price_range) {
            // Append a new record to the collection for each price range
            $collection->push([
                'State' => $data->state,
                'City/ County/ Zip Codes' => $data->city_county_zip,
                'Listing Type' => $data->listing_type,
                'Price Range' => $price_range,
                'Property Type' => $data->property_type,
                'Bathrooms' => $data->no_of_bathrooms,
                'Bedrooms' => $data->no_of_bedrooms,
                'Additional Filters' => $data->filters,
                'Job Name' => $data->job_name,
            ]);

            // Generate the Excel file using the Laravel Excel package
            $excelExport = new GenerateScrapingRequestExcel($collection);
        }

        // Save the Excel file to a temporary location
        $tempExcelPath = storage_path('app/temp/excel_file.xlsx');

        $excel->store($excelExport, $tempExcelPath, 'local');

        // Add the Excel file to the media collection of the model
        $data->addMedia($tempExcelPath)
            ->toMediaCollection('scraping_requests'); // Define your media collection name

        // Remove the temporary file (optional, if you don't need it)
        Storage::disk('local')->delete($tempExcelPath);

        session()->flash('success', 'Data added successfully, and Excel file saved!');
        return redirect()->route('admin.scraping.list');
    }

    public function upload(Request $request, ScrapingSourceList $scraping)
    {
        $file = $request->file('excel_file');

        if ($file) {
            // Clear the existing media from the collection
            $scraping->clearMediaCollection('scraping_uploads');

            // Add the Excel file to the media collection of the model
            $scraping->addMedia($file)
                ->toMediaCollection('scraping_uploads'); // Define your media collection name

            $scraping->status = 1;
            $scraping->save();
            session()->flash('success', 'File uploaded and request completed successfully!');
            return redirect()->route('admin.scraping.requests');
        } else {
            session()->flash('error', 'File not found!');
            return redirect()->route('admin.scraping.requests');
        }
    }

    public function pushToListsView(Request $request, ScrapingSourceList $scraping)
    {
        $tags = Tag::all();
        $campaigns = Campaign::getAllCampaigns();
        $form_Template = FormTemplates::get();
        return view('back.pages.secrapinglist.newList', compact('scraping', 'tags', 'campaigns', 'form_Template'));
    }

    public function pushToLists(Request $request, ScrapingSourceList $scraping)
    {
        $group_id = '';
        $campaign_id = '';

        // $market = Market::whereNotNull('id')->first();
        // $market_id = 0;
        // if ($market) {
        //     $market_id = $market->id;
        // } else {
        //     $newMarket = new Market();
        //     $newMarket->name = 'Demo Market';
        //     $newMarket->save();
        //     $market_id = $newMarket->id;
        // }

        // $group = new Group();
        // $group->market_id = $market_id ?? '0';
        // // $group->tag_id = $request->tag_id;
        // // $group->tag_id = json_encode($request->tag_id);
        // $group->name = $request->list_name;
        // $group->save();

        // $group_id = $group->id;
        // // }
        // $selectedTags = $request->tag_id;
        // if ($selectedTags || !empty($selectedTags)) {
        //     // Get the currently associated tag IDs for the group record
        //     $currentTags = DB::table('group_tags')
        //         ->where('group_id', $group->id)
        //         ->pluck('tag_id')
        //         ->toArray();

        //     // Calculate the tags to insert (exclude already associated tags)
        //     $tagsToInsert = array_diff($selectedTags, $currentTags);

        //     // Calculate the tags to delete (tags in $currentTags but not in $selectedTags)
        //     $tagsToDelete = array_diff($currentTags, $selectedTags);

        //     // Delete the tags that are not in $selectedTags or delete all if none are selected
        //     if (!empty($tagsToDelete) || empty($selectedTags)) {
        //         DB::table('group_tags')
        //             ->where('group_id', $group->id)
        //             ->whereIn('tag_id', $tagsToDelete)
        //             ->delete();
        //     }

        //     // Insert the new tags
        //     if (!empty($tagsToInsert)) {
        //         // Iterate through the selected tags and insert them into the group_tags table
        //         foreach ($tagsToInsert as $tagId) {
        //             DB::table('group_tags')->insert([
        //                 'group_id' => $group->id,
        //                 'tag_id' => $tagId,
        //             ]);
        //         }
        //     }
        // }

        if ($scraping->hasMedia('scraping_uploads')) {
            $media = $scraping->getFirstMedia('scraping_uploads');

            if ($media) {
                // Get the file path
                $filePath = $media->getPath();

                try {
                    // Load the Excel file
                    $spreadsheet = IOFactory::load($filePath);

                    // Select the first worksheet
                    $worksheet = $spreadsheet->getActiveSheet();

                    // Get all rows from the worksheet
                    $rows = $worksheet->toArray();

                    // Extract headers from the first row (assuming the headers are in the first row)
                    $headers = $rows[0];

                    // Define the required headers in an array
                    $requiredHeaders = [
                        'address', 'city', 'state', 'zipcode', 'FSBO_Owner_contact_no',
                        'description', 'price', 'zestimate', 'rent_zestimate', 'beds',
                        'bath', 'sqr_ft', 'lot_size', 'year_built', 'SoldOnDate',
                        'last_tax_assessment', 'last_tax_year', 'days_on_zillow', 'image_1',
                        'Agent Name 1', 'Agent Contact No 1',
                    ];

                    // Check if all required headers are present
                    foreach ($requiredHeaders as $header) {
                        if (!in_array($header, $headers)) {
                            throw new \Exception("Header '$header' is missing in the CSV file.");
                        }
                    }

                    // Define the indices of the headers you want to use
                    $addressIndex = array_search('address', $headers);
                    $cityIndex = array_search('city', $headers);
                    $stateIndex = array_search('state', $headers);
                    $zipcodeIndex = array_search('zipcode', $headers);
                    $primaryPhoneNumberIndex = array_search('FSBO_Owner_contact_no', $headers);
                    $descriptionIndex = array_search('description', $headers);
                    $priceIndex = array_search('price', $headers);
                    $zestimateIndex = array_search('zestimate', $headers);
                    $rent_zestimateIndex = array_search('rent_zestimate', $headers);
                    $bedsIndex = array_search('beds', $headers);
                    $bathIndex = array_search('bath', $headers);
                    $sqr_ftIndex = array_search('sqr_ft', $headers);
                    $lot_sizeIndex = array_search('lot_size', $headers);
                    $year_builtIndex = array_search('year_built', $headers);
                    $SoldOnDateIndex = array_search('SoldOnDate', $headers);
                    $last_tax_assessmentIndex = array_search('last_tax_assessment', $headers);
                    $last_tax_yearIndex = array_search('last_tax_year', $headers);
                    $days_on_zillowIndex = array_search('days_on_zillow', $headers);
                    $photosIndex = array_search('image_1', $headers);
                    $AgentName1Index = array_search('Agent Name 1', $headers);
                    $AgentPhoneIndex = array_search('Agent Contact No 1', $headers);

                    // Loop through the rows (skip the header row)
                    for ($i = 1; $i < count($rows); $i++) {
                        $row = $rows[$i];

                        // Extract data based on headers
                        $address = $row[$addressIndex];
                        $city = $row[$cityIndex];
                        $state = $row[$stateIndex];
                        $zip = $row[$zipcodeIndex];
                        $primaryPhoneNumber = $row[$primaryPhoneNumberIndex];
                        $description = $row[$descriptionIndex];
                        $price = $row[$priceIndex];
                        $zestimate = $row[$zestimateIndex];
                        $rent_zestimate = $row[$rent_zestimateIndex];
                        $beds = $row[$bedsIndex];
                        $bath = $row[$bathIndex];
                        $sqr_ft = $row[$sqr_ftIndex];
                        $lot_size = $row[$lot_sizeIndex];
                        $year_built = $row[$year_builtIndex];
                        $soldOnDate = $row[$SoldOnDateIndex];
                        $last_tax_assessment = $row[$last_tax_assessmentIndex];
                        $last_tax_year = $row[$last_tax_yearIndex];
                        $days_on_zillow = $row[$days_on_zillowIndex];
                        $photos = $row[$photosIndex];
                        $AgentName1 = $row[$AgentName1Index];
                        $AgentPhone = $row[$AgentPhoneIndex];

                        if ($group_id != '') {
                            $checkContact = Contact::where('group_id', $group_id)->first();
                            if ($checkContact == null) {
                                $insertData = [
                                    "group_id" => $group_id,
                                ];

                                // Insert the data into the Contact table
                                $contact = Contact::create($insertData);

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

                    }

                } catch (\Exception $e) {
                    // Handle exceptions here
                    echo "An error occurred: " . $e->getMessage();
                }
            } else {
                echo "No media found in 'scraping_uploads' collection.";
            }
        }


    }

    public function splitPriceRange($selectedPriceRange, $stepSize)
    {
        // Initialize an array to store the parsed price ranges
        $priceRanges = [];

        // Split the selected price range and generate the array
        list($min, $max) = explode('-', $selectedPriceRange);

        $min = (int) $min;
        $max = (int) $max;

        while ($min < $max) {
            // Determine the maximum value for the current segment
            if (count($priceRanges) === 0) {
                // For the first iteration, increment the maximum by step size
                $segmentMax = $min + $stepSize;
            } else {
                // For other iterations, keep the maximum constant
                $segmentMax = $min + $stepSize - 1;
            }

            // Ensure that the maximum value doesn't exceed the selected price range
            if ($segmentMax > $max) {
                $segmentMax = $max;
            }

            // Add the segment to the priceRanges array
            $priceRanges[] = $min . '-' . $segmentMax;

            // Move to the next segment
            $min = $segmentMax + 1;
        }

        return $priceRanges;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\ScrapingSourceList  $scrapingSourceList
     * @return \Illuminate\Http\Response
     */
    public function show(ScrapingSourceList $scrapingSourceList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScrapingSourceList  $scrapingSourceList
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $scrapingdata = ScrapingSourceList::find($id);


        return view('back.pages.secrapinglist.edit', compact('scrapingdata'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScrapingSourceList  $scrapingSourceList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $validatedData = $request->validate([
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|numeric',
            'listing_type' => 'required|array',
            'price_range' => 'required|string',
            'no_of_bedrooms' => 'required|string',
            'no_of_bathrooms' => 'required|string',
            'property_type' => 'required|array',
            'filters' => 'required|string',
            'job_name' => 'required|string',
            'data_status' => 'required|in:0,1',
            'file' => 'nullable|file|mimes:csv,txt,xlsx', // You can specify the allowed file types
        ]);



        $data =  ScrapingSourceList::find($id);
        $data->country = $request->country ;
        $data->state = $request->state ;
        $data->city = $request->city ;
        $data->zip_code = $request->zip ;
        $data->price_range = $request->price_range ;
        $data->listing_type = implode(',', $request->listing_type);
        $data->property_type = implode(',', $request->property_type);
        $data->no_of_bedrooms = $request->no_of_bedrooms ;
        $data->no_of_bathrooms = $request->no_of_bathrooms ;
        $data->filters = $request->filters ;
        $data->job_name = $request->job_name ;
        $data->status = $request->data_status ;
        if ($request->hasFile('file')) {
            // Delete the old file if it exists
            if (!empty($data->file)) {
                // Assuming you are storing files in the 'uploads' directory
                $oldFilePath = public_path('uploads/' . $data->file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Upload the new file
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName); // Adjust the storage path as needed
            $data->file = $fileName;
        }

        $data = $data->save();

        session()->flash('success', 'Data update successfully !!');
        return redirect()->route('admin.scraping.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScrapingSourceList  $scrapingSourceList
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $record = ScrapingSourceList::find($id);
        $record->delete();
        session()->flash('success', 'Record has been deleted!');
        return redirect()->route('admin.scraping.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScrapingSourceList  $scrapingSourceList
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(Request $request)
    {
        $id = $request->id;
        $softDeletedRecord = ScrapingSourceList::withTrashed()
                        ->where('id', $id) // Replace 'id' with the column you want to use for identification
                        ->first();
        if ($softDeletedRecord) {
            $softDeletedRecord->forceDelete();
            session()->flash('success', 'Record has been deleted!');
            return redirect()->route('admin.scraping.requests');
        } else {
            session()->flash('error', 'Record has been deleted!');
            return redirect()->route('admin.scraping.requests');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScrapingSourceList  $scrapingSourceList
     * @return \Illuminate\Http\Response
     */
    public function forceDestroyMultiple(Request $request)
    {
        $ids = $request->ids;
        ScrapingSourceList::withTrashed()
            ->whereIn('id', $ids)
            ->forceDelete();

        return response()->json(['message' => 'Records deleted successfully!']);
    }
}
