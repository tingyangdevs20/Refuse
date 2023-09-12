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

        return view( 'back.pages.formtemplate.index', compact('groups', 'sr','campaigns','markets','tags') ) ;

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
