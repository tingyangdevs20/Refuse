<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemMsg;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class SystemMessages extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $accounts = 'aaa';
        return view('back.pages.systemMessages.index',compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     //   return view('admin.admin.store.store_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     //   $Store = new Store;
     //   $Store->name = $request->input('name');
     //   $Store->address =$request->address;        
     //   $Store->working_hour =$request->working_hours;     
     //   $Store->phone_number =$request->phone_number;     
     //   $Store->fax_number =$request->fax_number;       
     //   $Store->online =$request->online;       
     //   $Store->save();
     //   return redirect('/stores')->with('status','Add Store Successfully...');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     //     $store = Store::find(intval($id));
     //     return view('admin.admin.store.store_show',compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     //     $store = Store::find(intval($id));
     //     return view('admin.admin.store.store_edit',compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    { 
     //   $Store = Store::find(intval($id));
     //   $Store->name = $request->input('name');
     //   $Store->address =$request->address;        
     //   $Store->working_hour =$request->working_hours;     
     //   $Store->phone_number =$request->phone_number;     
     //   $Store->fax_number =$request->fax_number;       
     //   $Store->online =$request->online;       
     //   $Store->update();
     //   return redirect('/stores')->with('status','Update Store Successfully...');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
     //    $Store = Store::find(intval($id));
     //    $Store->delete();
     //    return redirect('/stores')->with('status','Delete Store Successfully...');
    }
}
