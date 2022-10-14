<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::resources([
        'landless' => \Modules\Landless\App\Http\Controllers\LandlessController::class,
        'kabuliats' => \Modules\Landless\App\Http\Controllers\KabuliatController::class,
        'land-assignments' => \Modules\Landless\App\Http\Controllers\LandAssignmentController::class,
    ]);

    Route::get('/landless/approve-to-meeting/{landlessId}/{meetingId}', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'approveToMeeting'])->name('landless.approve.to.meeting');
    Route::delete('/landless/reject-from-meeting/{landlessId}/{meetingId}', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'rejectFromMeeting'])->name('landless.reject.from.meeting');
    Route::post('/landless/applicants/datatable/{meeting}', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'getApplicantsDatatable'])->name('landless.applicants.datatable');
    Route::get('/landless/applicants/show/{landless}/{meeting}', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'applicantsShow'])->name('landless.applicants.show');
    Route::post('/landless/datatable', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'getDatatable'])->name('landless.datatable');
    Route::post('landless/get-owners-info-from-nid-api', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'getUserInfoFromNidApi'])->name('get-owners-info-from-nid-api');
    Route::put('/landless/approve/{landless}', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'approve'])->name('landless.approve');
    Route::put('/landless/multi/approve', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'multiApprove'])->name('landless.multi-approve');
    Route::put('/landless/reject/{landless}', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'reject'])->name('landless.reject');
    Route::put('/landless/multi/reject', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'multiReject'])->name('landless.multi-reject');
    Route::get('/landless/kabuliat/{landless}', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'showKabuliat'])->name('landless.kabuliat.show');
    Route::get('/landless/check/nothi-number', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'checkNothiNumber'])->name('landless.check-nothi-number');
    Route::get('/landless/{landless}/receipt', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'receipt'])->name('landless.receipt.view');
    Route::get('/landless/acland-approved/list', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'aclandAprovedList'])->name('landless.acland-approved-list');
    Route::post('/landless/acland-approved/list/datatable', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'getAclandaAprovedDatatable'])->name('landless.acland-approved-list.datatable');

    Route::post('/kabuliats/datatable', [\Modules\Landless\App\Http\Controllers\KabuliatController::class, 'getDatatable'])->name('kabuliats.datatable');

    Route::post('/land-assignments/datatable', [\Modules\Landless\App\Http\Controllers\LandAssignmentController::class, 'getDatatable'])->name('land-assignments.datatable');
    Route::put('/land-assignments/approve-scratch-map/{land_assignment}', [\Modules\Landless\App\Http\Controllers\LandAssignmentController::class, 'approveScratchMap'])->name('land-assignments.approve-scratch-map');

});


Route::group(['prefix' => 'landless', 'as' => 'landless.'], function () {
    Route::get('/landless-application', [\Modules\Landless\App\Http\Frontend\Controllers\LandlessController::class, 'create'])->name('landless-application');
    Route::post('/landless-application/store', [\Modules\Landless\App\Http\Frontend\Controllers\LandlessController::class, 'store'])->name('landless-application.store');
});

Route::group(['prefix' => 'public', 'as' => 'public.'], function () {
    Route::post('public/get-owners-info-from-nid-api', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'getUserInfoFromNidApi'])->name('get-owners-info-from-nid-api');
});

Route::get('/file-types/check-allow-format/{fileType}', [\Modules\Landless\App\Http\Controllers\LandlessController::class, 'checkAllowFormat'])->name('file-types.check-allow-format');
