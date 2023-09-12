<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Contact;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ContactListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        $group_id = $request->group_id;
        $contact = new Contact();
        $contact->group_id = $group_id;
        $contact->name = $request->name;
        $contact->last_name = $request->last_name;
        $contact->street = $request->street;
        $contact->city = $request->city;
        $contact->state = $request->state;
        $contact->zip = $request->zip;
        $contact->number = $request->number;
        $contact->number2 = $request->number2;
        $contact->email1 = $request->email1;
        $contact->email2 = $request->email2;

        $contact->save();
        Alert::success('Success', 'Contact Added!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $media = null;
        if ($request->mediaUrl != null) {
            $media = $request->file('mediaUrl');
            $filename = $media->getClientOriginalName();
            $extension = $media->getClientOriginalExtension();
            $tmpname = 'RVM_'.time() .'.'. $extension;
            $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
            $media = config('app.url') . '/public/uploads/' . $path;
        }
        $rvm=RvmFile::find($request->id);
        $rvm->name=$request->name;
        $rvm->mediaUrl=$media;
        $rvm->save();
        Alert::success('Success','Tag Updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        RvmFile::find($request->rvm_id)->delete();
        Alert::success('Success','Rvm Removed!');
        return redirect()->back();
    }
}
