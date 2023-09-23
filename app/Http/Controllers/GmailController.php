<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;

class GmailController extends Controller
{
    public function redirect() {
        return LaravelGmail::redirect();
    }

    public function callback() {
        LaravelGmail::makeToken();
        return redirect()->route('admin.settings.index');
    }

    public function logout() {
        LaravelGmail::logout();
        return redirect()->route('admin.settings.index');
    }

    
}
