<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
    
Route::resource('lead', LeadController::class);

Route::get('/', function () {
    return view('welcome');
});
