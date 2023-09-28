<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\Group;
use App\Model\Market;
use App\Model\Tag;
use App\Model\Campaign;
use App\Model\FormTemplates;
use RealRashid\SweetAlert\Facades\Alert;

class FormTemplatesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request)
    {
        $groups = FormTemplates::all()->sortByDesc("created_at");
        $sr = 1;;
        $markets=Market::all();
        $tags=Tag::all();
        $campaigns = Campaign::getAllCampaigns();

        $short_code = array('name', 'street', 'city', 'state', 'zip', 'date', 'owner1_first_name', 'owner1_last_name', 'owner1_email1', 'owner1_email2','owner1_primary_number','
        owner1_number2', 'owner1_number3', 'owner1_social_security', 'owner1_dob','owner1_mother_name', 'owner2_first_name', 'owner2_last_name', 'owner2_email1', 'owner2_email2','owner2_primary_number','
        owner2_number2', 'owner2_number3', 'owner2_social_security', 'owner2_dob','owner2_mother_name', 'owner3_first_name', 'owner3_last_name', 'owner3_email1', 'owner3_email2','owner3_primary_number','
        owner3_number2', 'owner3_number3', 'owner3_social_security', 'owner3_dob','owner3_mother_name','property_address','property_city','property_state','property_zip','map_link','zillow_link','property_type','auth_email');

        return view( 'back.pages.formtemplate.index', compact('groups', 'sr','campaigns','markets','tags','short_code') ) ;

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

        $contact = new FormTemplates();
        $contact->template_name = $request->template_name ;
        $contact->content = $request->content;
        $contact->status = $request->status;

        $contact->save() ;

        Alert::success('Success', 'Template Added!');
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
        $id = $request->id ;
         if ($id != null) {

            $contact = FormTemplates::where('id',$id)->first();
            $contact->template_name = $request->template_name;
            $contact->content = $request->content;
            $contact->status = $request->status;
            $contact->save() ;

         }

        Alert::success('Success','Form Template Updated !');
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
        FormTemplates::find($request->id)->delete();
        Alert::success('Success','Form Templates Removed!');
        return redirect()->back();
    }
}
