<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AutoReply;
use App\Model\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AutoReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autoReplies = AutoReply::all();
        $categories = Category::all();
        $sr = 1;
        return view('back.pages.auto-reply.index', compact('autoReplies','categories', 'sr'));
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
        $autoReply = AutoReply::where("category_id", $request->category_id)->first();
        if ($autoReply) {
            Alert::error('Oops!', 'Auto-Reply against this category already exists!');
            return redirect()->back();
        }

        $autoReply = new AutoReply();
        $autoReply->category_id = $request->category_id;
        $autoReply->is_active = $request->is_active;
        $autoReply->message = $request->message;
        $autoReply->save();

        Alert::success('Success!', 'Auto-Reply Creatted!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\AutoReply $autoReply
     * @return \Illuminate\Http\Response
     */
    public function show(AutoReply $autoReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\AutoReply $autoReply
     * @return \Illuminate\Http\Response
     */
    public function edit(AutoReply $autoReply)
    {
        //
    }
    
  

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\AutoReply $autoReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $autoReply = AutoReply::find($request->id);
        $autoReply->message = $request->message;
        $autoReply->category_id = $request->category_id;
        $autoReply->is_active = $request->is_active;
        $autoReply->save();
        Alert::success('Success!', 'Auto-Reply Updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\AutoReply $autoReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        AutoReply::find($request->id)->delete();
        Alert::success('Success!', 'Auto-Reply Removed!');
        return redirect()->back();
    }
    
    
}
