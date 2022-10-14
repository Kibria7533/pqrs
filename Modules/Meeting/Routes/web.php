<?php

use Illuminate\Support\Facades\Route;
use Modules\Meeting\App\Http\Controllers\CommitteeTypesController;
use Modules\Meeting\App\Http\Controllers\MeetingController;
use Modules\Meeting\App\Http\Controllers\NotificationController;
use Modules\Meeting\App\Http\Controllers\TemplateController;

Route::group(['prefix' => 'admin/meeting-management', 'as' => 'admin.meeting_management.', 'middleware' => ['auth']], function () {
    Route::resources([
        'committee-types' => CommitteeTypesController::class,
        'templates' => TemplateController::class,
        'meetings' => MeetingController::class,
        'meetings/{meeting}/notifications' => NotificationController::class,
    ]);

    Route::get('landless/applicants/list/{meeting}', [MeetingController::class, 'getApplicantList'])->name('landless-applicants-list');
    Route::post('committee-types/datatable', [CommitteeTypesController::class, 'getCommitteeTypeList'])->name('committee-types.datatable');
    Route::post('templates/datatable', [TemplateController::class, 'getDataTable'])->name('templates.datatable');
    Route::post('meetings/datatable', [MeetingController::class, 'getMeetingList'])->name('meetings.datatable');

    Route::get('committee-types/{committeeType}/committee-setting', [CommitteeTypesController::class, 'committeeSettingCreate'])->name('committee-types.committee-setting.create');
    Route::post('committee-types/{committeeType}/committee-setting/store', [CommitteeTypesController::class, 'committeeSettingStore'])->name('committee-types.committee-setting.store');
    Route::post('meetings/meeting-no-check', [MeetingController::class, 'checkMeetingNo'])->name('meetings.meeting-no-check');
    Route::get('meetings/{meeting}/meeting-committee-create', [MeetingController::class, 'meetingCommitteeConfig'])->name('meetings.meeting-committee-config');
    Route::post('meetings/{meeting}/meeting-committee-store', [MeetingController::class, 'meetingCommitteeConfigStore'])->name('meetings.meeting-committee-config-store');
    Route::put('meetings/{meeting}/resolution-file-upload', [MeetingController::class, 'resolutionFileUpload'])->name('meetings.resolution-file-upload');
    Route::get('meetings/{meeting}/landless-meeting-list', [MeetingController::class, 'landlessMeetingList'])->name('meetings.landless-meeting-list');
    Route::post('meetings/{meeting}/landless-meeting-list-datatable', [MeetingController::class, 'landlessMeetingDatatable'])->name('meetings.landless-meeting-list-datatable');
    Route::put('meetings/{meeting}/landless-meeting-list-update', [MeetingController::class, 'landlessMeetingListUpdate'])->name('meetings.landless-meeting-list-update');
    Route::get('meetings/{meeting}/worksheet', [MeetingController::class, 'worksheet'])->name('meetings.worksheet');
    Route::get('meetings/{meeting}/landless-pdf', [MeetingController::class, 'landlessPdf'])->name('meetings.landless-pdf');
    Route::get('meetings/{meeting}/land-assignment/create', [MeetingController::class, 'createLandAssignment'])->name('meetings.land-assignment.create');
    Route::post('meetings/{meeting}/land-assignment/store', [MeetingController::class, 'storeLandAssignment'])->name('meetings.land-assignment.store');
    Route::get('check-unique-case-number', [MeetingController::class, 'checkUniqueCaseNumber'])->name('check-unique-case-number');

    //Route::get('meetings/{meeting}/notifications/create', [MeetingController::class, 'landlessPdf'])->name('meetings.landless-pdf');

    Route::post('templates/load-template-details', [TemplateController::class, 'loadTemplateDetails'])->name('templates.load-template-details');

    //Notifications
    /*Route::get('meetings/{meeting}/notifications', [NotificationController::class, 'create'])->name('notifications.create');
    Route::get('meetings/{meeting}/notifications', [NotificationController::class, 'create'])->name('notifications.store');*/


});
