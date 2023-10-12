<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Number;
use App\Model\Account;
use App\Model\Settings;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ApiSettingsController extends Controller
{
    public function index()
    {
        $accounts = Account::first();
        $settings = Settings::first();
        return view('back.pages.apisettings.index', compact('settings','accounts'));
    }
}
