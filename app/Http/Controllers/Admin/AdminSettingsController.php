<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Number;
use App\Model\AdminSettings;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminSettingsController extends Controller
{
    //
    public function index()
    {
        $adminsettings = AdminSettings::first();
        return view('back.pages.adminsettings.index', compact('adminsettings'));
    }
}
