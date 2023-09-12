<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AutoResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AutoResponderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responders=AutoResponder::all();
        $sr=1;
        return view('back.pages.autoresponder.index',compact('sr','responders'));
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
        $respond= new AutoResponder();
        $respond->keyword=ucfirst($request->keyword);
        $respond->response=$request->response;
        $respond->save();
        Alert::success('Success!','Response Created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\AutoResponder  $autoResponder
     * @return \Illuminate\Http\Response
     */
    public function show(AutoResponder $autoResponder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\AutoResponder  $autoResponder
     * @return \Illuminate\Http\Response
     */
    public function edit(AutoResponder $autoResponder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AutoResponder  $autoResponder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $response=AutoResponder::find($request->id);
        $response->keyword=$request->keyword;
        $response->response=$request->response;
        $response->save();
        Alert::success('Success!','Response Updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\AutoResponder  $autoResponder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        AutoResponder::find($request->id)->delete();
        Alert::success('Success!','Response Removed!');
        return redirect()->back();
    }
}
