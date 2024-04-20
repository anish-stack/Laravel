<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadCallOutComeController;
use App\Http\Controllers\LeadActivityTypeController;
use App\Http\Controllers\LeadPipelineController;
use App\Http\Controllers\LeadPipelineStageController;
use App\Http\Controllers\LeadSourceTypeController;
use App\Http\Controllers\LeadStatusController;
use App\Http\Controllers\LeadTypeController;
use App\Http\Controllers\LeadDocumentTypeController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('lead', LeadController::class);

// lead Activity type
Route::resource('leadactivitytype', LeadActivityTypeController::class);
Route::post('leadactivitytype/update-status', [LeadActivityTypeController::class, 'updateStatus'])->name('leadactivitytype.updateStatus');


// lead call Out come 
Route::resource('leadcall', LeadCallOutComeController::class);
Route::post('leadcall/update-status', [LeadCallOutComeController::class, 'updateStatus'])->name('leadcall.updateStatus');

// lead Document type
Route::resource('leaddocumenttype', LeadDocumentTypeController::class);
Route::post('leaddocumenttype/update-status', [LeadDocumentTypeController::class, 'updateStatus'])->name('leaddocumenttype.updateStatus');

// lead Pipeline
Route::resource('leadpipeline', LeadPipelineController::class);
Route::post('leadpipeline/update-status', [LeadPipelineController::class, 'updateStatus'])->name('leadpipeline.updateStatus');

// lead pipelinestage
Route::resource('leadpipelinestage', LeadPipelineStageController::class);
Route::post('leadpipelinestage/update-status', [LeadPipelineStageController::class, 'updateStatus'])->name('leadpipelinestage.updateStatus');

// lead source type
Route::resource('leadsource', LeadSourceTypeController::class);
Route::post('leadsource/update-status', [LeadSourceTypeController::class, 'updateStatus'])->name('leadsource.updateStatus');


// lead Status
Route::resource('leadstatus', LeadStatusController::class);
Route::post('leadstatus/update-status', [LeadStatusController::class, 'updateStatus'])->name('leadstatus.updateStatus');

// lead type
Route::resource('leadtype', LeadTypeController::class);
Route::post('leadtype/update-status', [LeadTypeController::class, 'updateStatus'])->name('leadtype.updateStatus');

