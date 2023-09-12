<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Blacklist;
use App\Model\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use function Composer\Autoload\includeFile;

class BlacklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sr=1;
        $numbers=Blacklist::all();
        return view('back.pages.blacklist.index',compact('sr','numbers'));
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
        $number=new Blacklist();
        $number->number=$this->contactEscapeString($request);
        $number->save();
        Alert::success('Success','Number Added!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Blacklist  $blacklist
     * @return \Illuminate\Http\Response
     */
    public function show(Blacklist $blacklist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Blacklist  $blacklist
     * @return \Illuminate\Http\Response
     */
    public function edit(Blacklist $blacklist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Blacklist  $blacklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $blacklist_number=str_replace(' ', '', $request->number);
        $blacklist_number=Str::startsWith($blacklist_number,'+')?$blacklist_number:$blacklist_number='+'.$blacklist_number;
        $number=Blacklist::find($request->id);
        $number->number=$blacklist_number;
        $number->save();
        Alert::success('Success','Number Updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Blacklist  $blacklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $blacklist=Blacklist::where('id',$request->id)->first();
        $contact=Contact::where('number',$blacklist->number)->first();
        $contact->is_dnc=false;
        $contact->save();
        $blacklist->delete();
        Alert::success('Success!','Number Removed!');
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
