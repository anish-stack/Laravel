<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadCallOutComeController;
use App\Http\Controllers\LeadActivityTypeController;
use App\Http\Controllers\LeadPipelineController;
use App\Http\Controllers\LeadPipelineStageController;
use App\Http\Controllers\LeadSourceTypeController;
use App\Http\Controllers\LeadStatusController;
use App\Http\Controllers\LeadTypeController;
use App\Http\Controllers\LeadDocumentTypeController;
use App\Http\Controllers\LeadAddController;
use App\Http\Controllers\LeadAvailableSizeController;
use App\Http\Controllers\LeadProjectNameController;
use App\Http\Controllers\LeadUpdateRecordController;

Route::get('/', function () {
    return view('welcome');
});



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


// Route::get('/home', [HomeController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/userprofile', [ProfileController::class, 'userprofile'])->name('userprofile');
    Route::get('/changepasswordpage', [ProfileController::class, 'changepasswordpage'])->name('changepasswordpage');
    Route::get('/addstaffpage', [ProfileController::class, 'addstaffpage'])->name('addstaffpage');
    Route::get('/stafflist', [ProfileController::class, 'stafflist'])->name('stafflist');
    Route::post('/addstaffsubmit', [ProfileController::class, 'addstaffsubmit'])->name('addstaffsubmit');
    Route::get('/staffedit/{id}', [ProfileController::class, 'staffedit'])->name('staffedit');
    Route::post('/updatestaff', [ProfileController::class, 'updatestaff'])->name('updatestaff');
    Route::get('/staffdelete/{id}', [ProfileController::class, 'staffdelete'])->name('staffdelete');
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

// lead Available Size
Route::resource('Leadavailablesize', LeadAvailableSizeController::class);
Route::post('Leadavailablesize/update-status', [LeadAvailableSizeController::class, 'updateStatus'])->name('Leadavailablesize.updateStatus');
// lead type
Route::resource('Leadprojectname', LeadProjectNameController::class);
Route::post('Leadprojectname/update-status', [LeadProjectNameController::class, 'updateStatus'])->name('Leadprojectname.updateStatus');

// Lead Add

Route::resource('leadadd', LeadAddController::class);
Route::post('leadadd/update-status', [LeadAddController::class, 'updateStatus'])->name('leadadd.updateStatus');
Route::get('leadadd/create', [LeadAddController::class, 'createLead'])->name('leadadd.create');
Route::get('leadadd/edit/{id}', [LeadAddController::class, 'edit'])->name('leadadd.edit');

// pop data 
Route::resource('leadpopdata', LeadUpdateRecordController::class);
Route::post('lead/store-form-data', [LeadUpdateRecordController::class, 'store'])->name('storeFormData');
// Route::post('/store-form-data', 'LeadUpdateRecordController@store')->name('storeFormData');

require __DIR__.'/auth.php';
