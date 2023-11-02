<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\Market;
use App\Model\Number;
use App\Model\Settings;
use App\Model\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class NumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sr = 1;
        $accounts = Account::all();
        $numbers = Number::all();
        $markets=Market::all();

        return view('back.pages.number.index', compact('sr', 'accounts', 'numbers','markets'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $number = new Number();
        $number->account_id = $request->account_id;
        $number->number = $this->contactEscapeString($request);
        $number->sms_allowed=Settings::first()->sms_allowed;
        $number->market_id=$request->market_id;
        $number->save();
        Alert::success('Success', 'Number Added!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Number $number
     * @return \Illuminate\Http\Response
     */
    public function show(Number $number)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Number $number
     * @return \Illuminate\Http\Response
     */
    public function edit(Number $number)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Number $number
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $contact = str_replace(' ', '', $request->number);
        $contact = Str::startsWith($contact, '+1') ? $contact : $contact = '+1' . $contact;
        $number = Number::find($request->id);
        $number->number = $contact;
        $number->account_id = $request->account_id;
        $number->market_id = $request->market_id;
        $number->save();
        Alert::success('Success', 'Number Updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Number $number
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Number::find($request->id)->delete();
        Alert::success('Success', 'Number Removed!');
        return redirect()->back();
    }

    public function contactEscapeString(Request $request)
    {
        $escape_arr = array(' ', '-', '(', ')', ' ');
        foreach ($escape_arr as $key => $value) {
            $request->number = str_replace($value, '', $request->number);
        }
        return Str::startsWith($request->number, '+1') ? $request->number : $request->number = '+1' . $request->number;
    }
}
