<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadCallOutComeController;
    
Route::resource('lead', LeadController::class);
Route::resource('leadcall', LeadCallOutComeController::class);

Route::post('leadcall/update-status', [LeadCallOutComeController::class, 'updateStatus'])->name('leadcall.updateStatus');

Route::get('/', function () {
    return view('welcome');
});
