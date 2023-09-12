<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\QuickResponse;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class QuickResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quickResponses = QuickResponse::all();
        $sr = 1;
        return view('back.pages.quickResponse.index', compact('quickResponses', 'sr'));
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
        QuickResponse::create($request->all());
        Alert::success('Success!', 'Quick Response Created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\QuickResponse  $quickResponse
     * @return \Illuminate\Http\Response
     */
    public function show(QuickResponse $quickResponse)
    {
        return response($quickResponse, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\QuickResponse  $quickResponse
     * @return \Illuminate\Http\Response
     */
    public function edit(QuickResponse $quickResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\QuickResponse  $quickResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $quickResponse = QuickResponse::find($request->id);
        $quickResponse->title = $request->title;
        $quickResponse->body = $request->body;
        $quickResponse->save();
        Alert::success('Success!', 'Quick Response Updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\QuickResponse  $quickResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        QuickResponse::find($request->id)->delete();
        Alert::success('Success!', 'Quick Response Updated');
        return redirect()->back();
    }
}
