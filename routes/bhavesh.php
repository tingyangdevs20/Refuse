<?php
use App\Http\Controllers\AgreementSignController;
use Illuminate\Support\Facades\Route;

// Bhavesh Vyas

// User Agreement Routes
Route::get('{agreementKey}/view', [AgreementSignController::class, 'view'])->name("user.agreement.view");
Route::get('{agreementKey}/pdf', [AgreementSignController::class, 'pdf'])->name("user.agreement.pdf");
Route::post('getSign', [AgreementSignController::class, 'getSign'])->name("user.agreement.getSign");
Route::post('sign', [AgreementSignController::class, 'signAgreement'])->name("user.agreement.sign");
Route::get('user-agreement', [AgreementSignController::class, 'sampleAgreement'])->name("user.agreement");
