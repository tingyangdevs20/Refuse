<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\LeadCategory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LeadCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leads = LeadCategory::all();
        $sr = 1;
        return view('back.pages.leadCategory.index',compact('leads','sr'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        LeadCategory::create($request->all());
        Alert::success('Success!', 'Lead Category Created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\LeadCategory  $leadCategory
     * @return \Illuminate\Http\Response
     */
    public function show(LeadCategory $leadCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\LeadCategory  $leadCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadCategory $leadCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\LeadCategory  $leadCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $lead = LeadCategory::find($request->id);
        $lead->title = $request->lead_title;
        $lead->save();
        Alert::success('Success!', 'Lead Category Updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\LeadCategory  $leadCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        LeadCategory::find($request->lead_id)->delete();
        Alert::success('Success!', 'Lead Category Removed');
        return redirect()->back();
    }
}
