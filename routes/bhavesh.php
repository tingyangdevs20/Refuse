<?php

use App\Http\Controllers\Admin\UserAgreementController;
use App\Http\Controllers\AgreementSignController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Bhavesh Vyas

Route::get('/mail', function () {
    Mail::raw('Hello World!', function ($msg) {
        $msg->to('bhaveshvyas23@gmail.com')
            ->subject('Test Email');
    });
});

// User Agreement Routes
Route::get('{agreementKey}/view', [AgreementSignController::class, 'view'])->name("user.agreement.view");
Route::get('{agreementKey}/pdf', [AgreementSignController::class, 'pdf'])->name("user.agreement.pdf");
Route::post('getSign', [AgreementSignController::class, 'getSign'])->name("user.agreement.getSign");
Route::post('sign', [AgreementSignController::class, 'signAgreement'])->name("user.agreement.sign");
Route::get('user-agreement', [AgreementSignController::class, 'sampleAgreement'])->name("user.agreement");

Route::group(['as' => 'admin.', 'middleware' => 'auth', 'prefix' => 'admin'], function () {
    // user  agreement route start
    Route::prefix('user-agreement')->group(function () {
        Route::get('/', [UserAgreementController::class, 'index'])->name('user-agreement.index');
        
        // Route::post('/reminder/{id}', [UserAgreementController::class, 'softreminder'])->name('user-agreement.reminder');
        Route::post('create', [UserAgreementController::class, 'create'])->name('user-agreement.create');
        Route::post('{templateId}/getTemplateData', [UserAgreementController::class, 'getTemplateData'])->name('user-agreement.template')->where('templateId', '[0-9]+');
        Route::post('save', [UserAgreementController::class, 'store'])->name('user-agreement.store');
        Route::post('pdf', [UserAgreementController::class, 'pdf'])->name('user-agreement.pdf');
        Route::post('{userAgreementId}/edit', [UserAgreementController::class, 'edit'])->name('user-agreement.edit')->where('userAgreementId', '[0-9]+');
        Route::post('{userAgreementId}/update', [UserAgreementController::class, 'update'])->name('user-agreement.update')->where('userAgreementId', '[0-9]+');
        Route::get('/signers/{id}', [UserAgreementController::class, 'signers'])->name('user-agreement.signers');
        Route::post('{userAgreementId}/delete', [UserAgreementController::class, 'delete'])->name('user-agreement.delete')->where('userAgreementId', '[0-9]+');
        Route::post('{userAgreementId}/status', [UserAgreementController::class, 'status'])->name('user-agreement.status')->where('userAgreementId', '[0-9]+');
        Route::post('{userAgreementId}/download', [UserAgreementController::class, 'download'])->name('user-agreement.download')->where('userAgreementId', '[0-9]+');
        Route::post('{userAgreementId}/view', [UserAgreementController::class, 'view'])->name('user-agreement.view')->where('userAgreementId', '[0-9]+');
        Route::post('{userAgreementId}/send', [UserAgreementController::class, 'sendEmail'])->name('user-agreement.sendEmail')->where('userAgreementId', '[0-9]+');
    });
});
