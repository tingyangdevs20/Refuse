<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Contact;
use App\Model\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Models\Media as ModelsMedia;

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
    public function create(Group $group)
    {
        return view('back.pages.group.newContact', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $contact = new Contact([
            'name' => $request->name,
            'last_name' => $request->input('last_name'),
            'street' => $request->input('street'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'),
            'number' => $request->input('number'),
            'number2' => $request->input('number2'),
            'number3' => $request->input('number3'),
            'email1' => $request->input('email1'),
            'email2' => $request->input('email2'),
        ]);

        $group->contacts()->save($contact);

        // Add lead info
        DB::table('lead_info')->updateOrInsert(
            ['contact_id' => $contact->id],
            [
                'owner1_first_name' => $contact->name,
                'owner1_last_name' => $contact->last_name,
                'owner1_primary_number' => $contact->number,
                'owner1_number2' => $contact->number2,
                'owner1_number3' => $contact->number3,
                'owner1_email1' => $contact->email1,
                'owner1_email2' => $contact->email2
            ]
        );

        // Add property info
        DB::table('property_infos')->updateOrInsert(
            ['contact_id' => $contact->id],
            [
                'property_address' => $contact->street,
                'property_city' => $contact->city,
                'property_state' => $contact->state,
                'property_zip' => $contact->zip
            ]
        );

        Alert::success('Success', 'Contact Record Added!');
        return redirect()->route('admin.group.show', $group->id);
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
    public function edit(Contact $contact)
    {
        return view('back.pages.group.editcontact', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $contact->name = $request->name;
        $contact->last_name = $request->input('last_name');
        $contact->street = $request->input('street');
        $contact->city = $request->input('city');
        $contact->state = $request->input('state');
        $contact->zip = $request->input('zip');
        $contact->number = $request->input('number');
        $contact->number2 = $request->input('number2');
        $contact->number3 = $request->input('number3');
        $contact->email1 = $request->input('email1');
        $contact->email2 = $request->input('email2');
        $contact->save();

        // Update or insert lead info
        DB::table('lead_info')->updateOrInsert(
            ['contact_id' => $contact->id],
            [
                'owner1_first_name' => $contact->name,
                'owner1_last_name' => $contact->last_name,
                'owner1_primary_number' => $contact->number,
                'owner1_number2' => $contact->number2,
                'owner1_number3' => $contact->number3,
                'owner1_email1' => $contact->email1,
                'owner1_email2' => $contact->email2
            ]
        );

        // Update or insert property info
        DB::table('property_infos')->updateOrInsert(
            ['contact_id' => $contact->id],
            [
                'property_address' => $contact->street,
                'property_city' => $contact->city,
                'property_state' => $contact->state,
                'property_zip' => $contact->zip
            ]
        );

        Alert::success('Success', 'Contact Record Updated!');
        return redirect()->route('admin.group-contacts-all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $contactId = $request->id;
        deleteContactRecords($contactId);

        Alert::success('Success', 'Contact Record Removed!');
        return redirect()->back();
    }
}
