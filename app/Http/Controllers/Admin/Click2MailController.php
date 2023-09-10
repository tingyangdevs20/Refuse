<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Click2Mail;

class Click2MailController extends Controller
{
    public function index(Request $request) 
    {
        $opts = array(
            'http' => array(
                'method'  => 'GET',
                'header'  => 'Content-type: application/x-www-form-urlencoded'
            )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents("https://us.stannp.com/api/v1/users/me?api_key=" . env('STANPP_API_KEY'), false, $context);
        $response = json_decode($result, true);
        
        print_r($response);
    }
}
