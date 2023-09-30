<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DateInterval;
use DateTime;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class GoogleCalendarController extends Controller
{
    /**
     * 
     * redirect user to google OAuth consent screen to get access token.
     * 
     * @param 
     * 
     * 
     */
    public function redirectUserToGoogle()
    {
        // dd(auth()->user());
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        $client->setScopes(['https://www.googleapis.com/auth/calendar.readonly']);
        // $client->setAccessType('offline');
        // dd($client);
        // dd(config('services.google.redirect_uri'));
        return redirect($client->createAuthUrl());
    }


    public function handleGoogleCallback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        // $client->setAccessType('offline');

        // Exchange the authorization code for an access token
        $accessToken = $client->fetchAccessTokenWithAuthCode($request->get('code'));

        if ($accessToken['access_token']) {
            auth()->user()->update([
                'access_token' => $accessToken['access_token'],
                'refresh_token' => isset($accessToken['refresh_token']) ? $accessToken['refresh_token'] : null,
            ]);
        }

        // dd(auth()->user());

        return redirect(route('admin.appointment', [Crypt::encryptString(auth()->user()->id)]));
    }
}
