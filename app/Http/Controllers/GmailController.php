<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;

class GmailController extends Controller
{
    public function redirect() {
        try {
            return LaravelGmail::redirect();
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function callback() {
        try {
            LaravelGmail::makeToken();
            return redirect()->route('admin.settings.index');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function logout() {
        LaravelGmail::logout();
        return redirect()->route('admin.settings.index');
    }

    
}
