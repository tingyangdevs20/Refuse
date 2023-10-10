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
use DB;
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

        $short_code = [];
        $contacts = DB::table('contacts')->first(['name','last_name','street','city','state','zip','number','number2','number3','number3','email1','email2']);
        if(!empty($contacts)){
            foreach($contacts as $key => $contact){
                $short_code[$key] = $contact;
            }
        }

        $leadinfo = DB::table('lead_info')->first(['owner1_first_name','owner1_last_name','owner1_primary_number','owner1_number2','owner1_number3','owner1_email1','owner1_email2','owner1_dob','owner1_mother_name','owner2_first_name','owner2_last_name','owner2_primary_number','owner2_number2','owner2_number3','owner2_email1','owner2_email2','owner2_social_security','owner2_dob','owner2_mother_name','owner3_first_name','owner3_last_name','owner3_primary_number','owner3_number2','owner3_number3','owner3_email1','owner3_email2','owner3_social_security','owner3_dob','owner3_mother_name']);
        if(!empty($leadinfo)){
            foreach($leadinfo as $key => $lead){
                $short_code[$key] = $lead;
            }
        }

        $property_infos = DB::table('property_infos')->first(['property_address','property_city','property_state','property_zip','map_link','zillow_link']);
        if(!empty($property_infos) ){
            foreach($property_infos as $key => $property){
                $short_code[$key] = $property;
            }
        }

        $users = DB::table('users')->first(["name", "email", "mobile", "company_name" , "address", "street", "state", "city", "zip"]);
        if(!empty($users) ){
            foreach($users as $key => $user){
                $short_code['user_'.$key] = $user;
            }
        }

        $settings = DB::table('settings')->first(["auth_email", "document_closed_by"]);
        if(!empty($settings) ){
            foreach($settings as $key => $setting){
                $short_code[$key] = $setting;
            }
        }

        $title_company = DB::table('title_company')->first(["buy_sell_entity_detail"]);
        if(!empty($title_company) ){
            foreach($title_company as $key => $title){
                $short_code[$key] = $title;
            }
        }

        $short_code = array_keys($short_code);
        foreach($short_code as $code) {
            $shortcode[$code] = ucwords(str_replace('_', ' ', $code));
        }

        $short_code = $shortcode;
        // foreach($short_code as $key=> $code) {
        //     dd($key);
        // }
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
