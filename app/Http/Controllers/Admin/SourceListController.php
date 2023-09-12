<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\System_messages;
use Illuminate\Http\Request;

class SourceListController extends Controller
{
    public function index(){
        $systemsgResponses=System_messages::all();
        return view('back.pages.sourceList.index',compact('systemsgResponses'));
    }
}
