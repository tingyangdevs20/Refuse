<?php

namespace App\Http\Controllers;

use App\ScrapingSourceList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Storage; // Import Storage facade
use Spatie\Permission\Models\Role; // Import the Role model from Spatie
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;

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
<<<<<<< HEAD
=======
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
>>>>>>> fc47628412f3cfa6e39cd3693d49fe73f9f84771
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
    public function store(Request $request)
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

        $data =  new ScrapingSourceList();
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
         // Handle file upload (assuming you want to store a file path in the database)
         if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName); // Adjust the storage path as needed
            $data->file = $fileName;
        }
        $data = $data->save();

<<<<<<< HEAD
        session()->flash('success', 'Data added successfully !!');
=======
        // Save the Excel file to a temporary location
        $tempExcelPath = storage_path('app/temp/excel_file.xlsx');

        $excel->store($excelExport, $tempExcelPath, 'local');

        // Add the Excel file to the media collection of the model
        $data->addMedia($tempExcelPath)
            ->toMediaCollection('scraping_requests'); // Define your media collection name

        // Remove the temporary file (optional, if you don't need it)
        Storage::disk('local')->delete($tempExcelPath);

        session()->flash('success', 'Data added successfully, and Excel file saved!');
>>>>>>> fc47628412f3cfa6e39cd3693d49fe73f9f84771
        return redirect()->route('admin.scraping.list');
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
