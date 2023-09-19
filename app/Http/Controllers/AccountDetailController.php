<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountDetailController extends Controller
{
    public function index(){

        return view('back.pages.transaction.index');

    }
}
