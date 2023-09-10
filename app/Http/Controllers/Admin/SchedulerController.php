<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    public function index(){
        return view('back.pages.sourceList.index');
    }
}
