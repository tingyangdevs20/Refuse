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
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Storage; // Import Storage facade
use Spatie\Permission\Models\Role; // Import the Role model from Spatie
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\ScrapingSourceList;

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

        // // Save the Excel file to a temporary location
        // $tempExcelPath = storage_path('app/temp/excel_file.xlsx');

        // $excel->store($excelExport, $tempExcelPath, 'local');

        $tempDirectory = public_path('temp');

        if (!file_exists($tempDirectory)) {
            mkdir($tempDirectory, 0755, true);
        }

        // Remove spaces from the job name
        $jobNameWithoutSpaces = str_replace(' ', '_', $request->job_name);

        // Define the file path with the job name without spaces
        $tempExcelPath = public_path('temp/' . $jobNameWithoutSpaces . '.xlsx');
        file_put_contents($tempExcelPath, $excelExport);

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

        $market = Market::whereNotNull('id')->first();
        $market_id = 0;
        if ($market) {
            $market_id = $market->id;
        } else {
            $newMarket = new Market();
            $newMarket->name = 'Demo Market';
            $newMarket->save();
            $market_id = $newMarket->id;
        }

        $group = new Group();
        $group->market_id = $market_id ?? '0';
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
                            session()->flash("error", "Header '$header' is missing in the CSV file.");
                            return redirect()->back();
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
                        $photoURL = $row[$photosIndex];
                        $AgentName1 = $row[$AgentName1Index];
                        $AgentPhone = $row[$AgentPhoneIndex];

                        if ($group_id != '') {
                            $checkContact = Contact::where('group_id', $group_id)->first();
                            if ($checkContact == null) {
                                $insertData = [
                                    "group_id" => $group_id,
                                ];

                                $contact = Contact::create($insertData);

                                // Check if contact is created
                                if ($contact) {
                                    $insertContactPropertyData = [
                                        "contact_id" => $contact->id,
                                        "property_address" => $address,
                                        "property_city" => $city,
                                        "property_state" => $state,
                                        "property_zip" => $zip,
                                        "bedrooms" => $beds,
                                        "bathrooms" => $bath,
                                        "square_footage" => $sqr_ft,
                                        "lot_size" => $lot_size,

                                    ];

                                    // Insert the data into the Contact table
                                    $property_infos = DB::table('property_infos')->where('contact_id', $contact->id)->first();
                                    if ($property_infos == null) {
                                        DB::table('property_infos')->insert($insertContactPropertyData);
                                    }

                                    // Save contact lead info
                                    $insertContactLeadData = [
                                        "contact_id" => $contact->id,
                                        "owner1_primary_number" => $primaryPhoneNumber,
                                    ];

                                    // Insert the data into the Contact table
                                    $lead_info = DB::table('lead_info')->where('contact_id', $contact->id)->first();
                                    if ($lead_info == null) {
                                        // $lead = DB::table('lead_info')->insert($insertContactLeadData);
                                        $leadData = $insertContactLeadData; // Assuming $insertContactLeadData is an array of data to be inserted
                                        $leadId = DB::table('lead_info')->insertGetId($leadData);
                                    }

                                    // Save contact Value and condition info
                                    $insertContactValuesConditionData = [
                                        "contact_id" => $contact->id,
                                        "notes_condition" => $description,
                                        "asking_price" => $price,
                                    ];

                                    // Insert the data into the Contact table
                                    $values_conditions = DB::table('values_conditions')->where('contact_id', $contact->id)->first();
                                    if ($values_conditions == null) {
                                        DB::table('values_conditions')->insert($insertContactValuesConditionData);
                                    }

                                    // Save contact's agent info
                                    $insertContactAgentInfo = [
                                        "contact_id" => $contact->id,
                                        "days_on_market" => $days_on_zillow,
                                        "agent_name" => $AgentName1,
                                        "agent_phone" => $AgentPhone
                                    ];

                                    $agent_infos = DB::table('agent_infos')->where('contact_id', $contact->id)->first();
                                    if ($agent_infos == null) {
                                        DB::table('agent_infos')->insert($insertContactAgentInfo);
                                    }

                                    // Add/upload the photo
                                    $contact->addMediaFromUrl($photoURL)->toMediaCollection("Photo");
                                }
                            }
                        }

                    }

                } catch (\Exception $e) {
                    // Handle exceptions here
                    session()->flash("error", "An error occurred: " . $e->getMessage());
                    return redirect()->back();
                }
            } else {
                session()->flash("error", "No media found in 'scraping_uploads' collection.");
                return redirect()->back();
            }
        }


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
