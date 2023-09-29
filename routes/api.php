<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'agreement'], function () {
    Route::post('/{userAgreementId}/mail', function ($userAgreementId) {
        //Log::info("here");
        Artisan::call("agreement:mail", ['userAgreementId' => $userAgreementId]);
    });
    Route::post('pdf', function () {
        Artisan::call("agreement:pdf");
    });
});

// Sachin 05092023
Route::post('/verifiedcontact', 'Api\ApiController@verifiedcontact')->name('verifiedcontact');
Route::post('/contactmail', 'Api\ApiController@contactmail')->name('contactmail');
// Sachin 05092023

Route::prefix('v1')->group(function () {
    Route::prefix('chatroom')->group(function () {
        Route::post('create', 'ChatController@createChatRoom');
        Route::post('{session_id}/message/send', 'ChatController@saveMessage');
    });
});
