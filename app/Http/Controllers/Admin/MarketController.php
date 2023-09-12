<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\Market;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {;
        $sr=1;
        $markets=Market::all();
        return view('back.pages.market.index',compact('markets','sr'));
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
        Market::create($request->all());
        Alert::success('Success','Market Created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function show(Market $market)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function edit(Market $market)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $market=Market::find($request->id);
        $market->name=$request->name;
        $market->save();
        Alert::success('Success','Market Updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Market::find($request->id)->delete();
        Alert::success('Success','Market Removed!');
        return redirect()->back();
    }
}
