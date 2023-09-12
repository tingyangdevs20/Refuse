<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Script;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ScriptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scripts = Script::all();
        $sr = 1;
        return view('back.pages.script.index', compact('scripts', 'sr'));
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
        
        //return $media;
        $script = new Script();
        $script->name = $request->name;
        $script->scripts = $request->scripts;
        $script->save();
        Alert::success('Success!', 'Script Created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Template $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        return response($template, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Template $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Template $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $script = Script::find($request->id);
        $script->name = $request->name;
        $script->scripts = $request->scripts;
        $script->save();
        Alert::success('Success!', 'Script Updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Template $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Script::find($request->id)->delete();
        Alert::success('Success!', 'Script Updated');
        return redirect()->back();
    }
    
    public function getTemplate($type = ''){
        $templates = Template::where('type',$type)->get();
        return view('back.pages.template.ajaxTemplate', compact('templates'));
    }
}
