<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/',"AppController@goBack");

Route::post('payment/pay/paypal',"PaymentController@payWithpaypal");

Route::get('status',"PaymentController@getPaymentStatus")->name('status');

Route::get('/dashboard',"HomeController@goToDashboard")->name('dashboard');

Route::get('/dashboard/digital-assitant/symptom-checker',"DiagnosisController@symptomCheckView")->name('checker');

Route::post('/dashboard/digital-assistant/diagnosis',"DiagnosisController@getDiagnostic")->name('diagnosis');
