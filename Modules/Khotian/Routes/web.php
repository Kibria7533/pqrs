<?php

use Illuminate\Support\Facades\Route;
use Modules\Khotian\app\Http\Controllers\AcLandApprovedKhotianController;
use Modules\Khotian\app\Http\Controllers\MutedKhotianApproveController;
use Modules\Khotian\app\Http\Controllers\MutedKhotianBatchEntryController;

Route::prefix('khotians')->group(function() {
    Route::get('/', 'KhotianController@index');
});

Route::group(['prefix' => 'admin/khotians', 'as' => 'admin.khotians.', 'middleware' => ['auth']], function () {
    Route::get('history-log/{id}/{khotian_number}/{type?}', [MutedKhotianBatchEntryController::class, 'historyLog'])->name('history_log');
    /**
     * Muted khotian batch entry
     **/
    Route::get('batch-entry/index', [MutedKhotianBatchEntryController::class, 'index'])->name('batch-entry.index');
    Route::get('batch-entry/create', [MutedKhotianBatchEntryController::class, 'create'])->name('batch-entry.create');
    Route::post('batch-entry/store', [MutedKhotianBatchEntryController::class, 'store'])->name('batch-entry.store');
    Route::post('batch-entry/list', [MutedKhotianBatchEntryController::class, 'list'])->name('batch-entry.list');
    Route::get('batch-entry/{id}/show', [MutedKhotianBatchEntryController::class, 'show'])->name('batch-entry.show');
    Route::get('batch-entry/{id}/edit', [MutedKhotianBatchEntryController::class, 'edit'])->name('batch-entry.edit');
    Route::post('batch-entry/{id}/update', [MutedKhotianBatchEntryController::class, 'update'])->name('batch-entry.update');

    /**
     * khotian approve
     **/
    Route::get('approve/index', [MutedKhotianApproveController::class, 'index'])->name('approve.index');
    Route::post('approve/list', [MutedKhotianApproveController::class, 'list'])->name('approve.list');
    Route::post('approve/store/{id}/{khotian_number}', [MutedKhotianApproveController::class, 'store'])->name('approve.store');
    Route::post('approve/return/{id}/{khotian_number}', [MutedKhotianApproveController::class, 'return'])->name('approve.return');
    Route::post('scan-file-upload/{id}', [MutedKhotianApproveController::class, 'scanFileUpload'])->name('ascan-file-upload');
    Route::get('show/{id}', [MutedKhotianBatchEntryController::class, 'show'])->name('show');

    /**
     * Register-8 updatable data
    **/
    Route::get('acland-approved/index', [AcLandApprovedKhotianController::class, 'index'])->name('acland-approved.index');
    Route::post('acland-approved/datatable', [AcLandApprovedKhotianController::class, 'getDatatable'])->name('acland-approved.datatable');
    Route::get('register-eight/{id}/create', [AcLandApprovedKhotianController::class, 'createPanel'])->name('register-eight.create');
    Route::post('register-eight/{id}/store', [AcLandApprovedKhotianController::class, 'store'])->name('register-eight.store');
    Route::put('register-eight/{id}/approve', [AcLandApprovedKhotianController::class, 'approve'])->name('register-eight.approve');
    Route::put('register-eight/{id}/reject', [AcLandApprovedKhotianController::class, 'reject'])->name('register-eight.reject');
    Route::get('register-eight/{id}/details', [AcLandApprovedKhotianController::class, 'details'])->name('register-eight.details');
    Route::get('register-eight/check-dag-khasland-area/{id}/{dag_id}', [AcLandApprovedKhotianController::class, 'checkDagKhasLandArea'])->name('register-eight.check-dag-khasland-area');
    Route::get('register-eight/check-register-khasland-area/{dag_id}', [AcLandApprovedKhotianController::class, 'checkRegisterKhaslandArea'])->name('register-eight.check-register-khasland-area');

    Route::get('register-eight/report', [AcLandApprovedKhotianController::class, 'report'])->name('register-eight.report');
    Route::post('register-eight/report/details', [AcLandApprovedKhotianController::class, 'reportDetails'])->name('register-eight.report-details');

    Route::post('get-register-eight/data', [AcLandApprovedKhotianController::class, 'getRegisterEightData'])->name('get-register-eight-data');



    /**
     * get geo location
     **/
    Route::post('get-districts', [MutedKhotianBatchEntryController::class, 'getDistricts'])->name('get-districts');
    Route::post('get-upazilas', [MutedKhotianBatchEntryController::class, 'getUpazilas'])->name('get-upazilas');
    Route::post('get-all-moujas', [MutedKhotianBatchEntryController::class, 'getAllMoujas'])->name('get-all-moujas');
    Route::post('get-moujas-dglr-code', [MutedKhotianBatchEntryController::class, 'getMoujasDglrCode'])->name('get-moujas-dglr-code');

    //NID API ROUTE
    Route::post('get-owners-info-from-nid-api',[MutedKhotianBatchEntryController::class, 'nidVerification'])->name('get-owners-info-from-nid-api');

    Route::get('/khasland-khotian-search', [\Modules\Khotian\App\Http\Controllers\KhasLandKhotianController::class, 'search'])->name('khasland-khotian');
    Route::post('/khasland-khotian-search', [\Modules\Khotian\App\Http\Controllers\KhasLandKhotianController::class, 'searchKhotian'])->name('khasland-khotian-search');
    Route::get('/khasland-khotians', [\Modules\Khotian\App\Http\Controllers\KhasLandKhotianController::class, 'index'])->name('khasland-khotians.index');
    Route::post('/khasland-khotians/datatable', [\Modules\Khotian\App\Http\Controllers\KhasLandKhotianController::class, 'getDatatable'])->name('khasland-khotians.datatable');
    Route::post('/khasland-khotians/approve/{khaslandKhotian}', [\Modules\Khotian\App\Http\Controllers\KhasLandKhotianController::class, 'approve'])->name('khasland-khotians.approve');
    Route::get('/khasland-khotians/{khaslandKhotian}', [\Modules\Khotian\App\Http\Controllers\KhasLandKhotianController::class, 'show'])->name('khasland-khotians.show');
    Route::put('/khasland-khotians/khotian-approve-all', [\Modules\Khotian\App\Http\Controllers\KhasLandKhotianController::class, 'khaslandKhotianApprove'])->name('khotian-approve-all');
});
