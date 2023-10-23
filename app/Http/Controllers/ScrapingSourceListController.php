<?php

namespace App\Http\Controllers;

use App\Exports\GenerateScrapingRequestExcel;
use App\ScrapingSourceList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

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

        $excel->store($excelExport, 'temp/excel_file.xlsx', 'local');

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
