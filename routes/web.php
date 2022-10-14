<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
//use \App\Http\Controllers\Admin\DesignationsController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('admin-dashboard');

    Route::resource('khas-jomi-applications', \App\Http\Controllers\Admin\KhasJomiApplicationController::class);
    Route::get('/jamabandi/create', [\App\Http\Controllers\Admin\KhasJomiApplicationController::class, 'createJamabandi'])->name('jamabandi.create');
    Route::get('/kabuliat/create', [\App\Http\Controllers\Admin\KhasJomiApplicationController::class, 'createKabuliat'])->name('jamabandi.create');

    Route::resources([
        'offices' => \App\Http\Controllers\Admin\OfficeController::class,
        'file-types' => \App\Http\Controllers\Admin\FileTypeController::class,
    ]);
    Route::post('offices/datatable', [\App\Http\Controllers\Admin\OfficeController::class, 'getDatatable'])->name('offices.datatable');
    Route::post('file-types/datatable', [\App\Http\Controllers\Admin\FileTypeController::class, 'getDatatable'])->name('file-types.datatable');

    Route::resource('designations', App\Http\Controllers\Designation\DesignationsController::class);
    Route::post('designations/datatable', [App\Http\Controllers\Designation\DesignationsController::class, 'getDatatable'])->name('designations.datatable');
});


Route::get('/', [\App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::post('get-districts', [\App\Http\Controllers\Admin\LocationController::class, 'getDistricts'])->name('get-districts');
Route::post('get-upazilas', [\App\Http\Controllers\Admin\LocationController::class, 'getUpazilas'])->name('get-upazilas');
Route::post('get-unions', [\App\Http\Controllers\Admin\LocationController::class, 'getUnions'])->name('get-unions');
Route::post('get-moujas', [\App\Http\Controllers\Admin\LocationController::class, 'getMoujas'])->name('get-moujas');

Route::prefix('landless-portal')->group(function() {
    Route::get('/login',[\App\Http\Controllers\Admin\Auth\LandlessLoginController::class, 'showLoginForm'])->name('landless.login');
    Route::post('/login', [\App\Http\Controllers\Admin\Auth\LandlessLoginController::class, 'login'])->name('landless.login-submit');
    Route::post('logout', [\App\Http\Controllers\Admin\Auth\LandlessLoginController::class, 'logout'])->name('landless.logout');

    Route::get('/', [\App\Http\Controllers\Portal\LandlessUserController::class, 'home'])->name('landless.dashboard');
    Route::get('/application', [\App\Http\Controllers\Portal\LandlessApplicationController::class, 'application'])->name('landless.application');
    Route::post('/application/store', [\App\Http\Controllers\Portal\LandlessApplicationController::class, 'store'])->name('landless.application.store');
    Route::get('/my-applications', [\App\Http\Controllers\Portal\LandlessUserController::class, 'myApplications'])->name('landless.my-applications');
    Route::get('/my-application/{id}', [\App\Http\Controllers\Portal\LandlessUserController::class, 'myApplication'])->name('landless.my-application');
    Route::get('/my-receipt/{id}', [\App\Http\Controllers\Portal\LandlessUserController::class, 'myReceipt'])->name('landless.my-receipt');

}) ;
