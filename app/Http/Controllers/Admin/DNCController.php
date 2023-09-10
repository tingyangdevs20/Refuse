<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\DNC;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DNCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $dncs = DNC::all();
        $sr=1;
        return view('back.pages.dnckeywords.index',compact('dncs','sr'));
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
        $dncKeyword=new DNC();
        $dncKeyword->keyword=ucfirst($request->keyword);
        $dncKeyword->save();
        Alert::success('Success!','Keyword Created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\DNC  $dNC
     * @return \Illuminate\Http\Response
     */
    public function show(DNC $dNC)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\DNC  $dNC
     * @return \Illuminate\Http\Response
     */
    public function edit(DNC $dNC)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\DNC  $dNC
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $dncKeyword=DNC::find($request->id);
        $dncKeyword->keyword=ucfirst($request->keyword);
        $dncKeyword->save();
        Alert::success('Success!','Keyword Updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\DNC  $dNC
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DNC::find($request->id)->delete();
        Alert::success('Success!','Keyword Removed!');
        return redirect()->back();
    }
}
