<?php


namespace Modules\Meeting\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\NumberToBanglaWord;
use App\Http\Controllers\BaseController;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocUpazila;
use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Modules\Khotian\App\Models\EightRegister;
use Modules\Landless\App\Models\LandAssignment;
use Modules\Landless\App\Models\Landless;
use Modules\Meeting\App\Services\MeetingService;
use Modules\Meeting\Models\CommitteeSetting;
use Modules\Meeting\Models\CommitteeType;
use Modules\Meeting\Models\Meeting;
use Modules\Meeting\Models\MeetingCommittee;
use Modules\Meeting\Models\Notification;
use Modules\Meeting\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

/**
 * Class MeetingsController
 * @package Modules\Landless\App\Http\Controllers
 */
class MeetingController extends BaseController
{
    const VIEW_PATH = 'meeting::backend.meetings.';

    protected MeetingService $meetingService;

    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
        $this->authorizeResource(Meeting::class);
    }

    public function index()
    {
        return view(self::VIEW_PATH . 'browse');
    }

    public function create(): View
    {
        $authUser = AuthHelper::getAuthUser();

        $committeeTypes = new CommitteeType;
        if($authUser->isUnoUser()){
            $committeeTypes = $committeeTypes->where('office_type',CommitteeType::OFFICE_TYPE_UPAZILA);
        }
        if($authUser->isDcUser()){
            $committeeTypes = $committeeTypes->where('office_type',CommitteeType::OFFICE_TYPE_DC);
        }
        $committeeTypes = $committeeTypes->get();

        $templates = Template::get();

        return \view(self::VIEW_PATH . 'edit-add', compact('committeeTypes', 'templates'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->meetingService->validator($request);
        if ($validatedData->fails()) {
            $errors = $validatedData->errors();
            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();

        try {
            $meeting = $this->meetingService->createMeeting($data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.meeting_not_added'),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('generic.meeting_added'),
            'alertType' => 'success',
            'redirectTo' => route('admin.meeting_management.meetings.index'),
        ]);
    }

    public function show(Meeting $meeting)
    {
        $financialYear = '2022';
        return view(self::VIEW_PATH . '.read', compact('meeting', 'financialYear'));
    }

    public function edit(Request $request, Meeting $meeting): View
    {
        $committeeTypes = CommitteeType::get();
        $templates = Template::get();
        return \view(self::VIEW_PATH . 'edit-add', compact('meeting', 'committeeTypes', 'templates'));
    }

    public function update(Request $request, Meeting $meeting): JsonResponse
    {
        $validatedData = $this->meetingService->validator($request, $meeting->id);

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();

        try {
            $this->meetingService->updateMeeting($data, $meeting);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.meeting_update_failed'),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('generic.meeting_update_success'),
            'alertType' => 'success',
            'redirectTo' => route('admin.meeting_management.meetings.index'),
        ]);
    }

    public function destroy(Meeting $meeting)
    {
        try {
            $this->meetingService->deleteMeeting($meeting);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());

            return redirect(route('admin.meeting_management.meetings.index'))->with([
                'message' => __('generic.meeting_delete_failed'),
                'alert-type' => 'error',
            ]);

        }

        return redirect(route('admin.meeting_management.meetings.index'))->with([
            'message' => __('generic.meeting_delete_success'),
            'alert-type' => 'success',
        ]);
    }

    public function getMeetingList(Request $request): JsonResponse
    {
        return $this->meetingService->getListDataForDatatable($request);
    }

    public function checkMeetingNo(Request $request): JsonResponse
    {
        $meeting = Meeting::where(['meeting_no' => $request->meeting_no]);
        if ($request->id) {
            $meeting->where('id', '!=', $request->id);
        }
        $meeting = $meeting->first();

        if ($meeting == null) {
            return response()->json(true);
        } else {
            return response()->json(__('generic.already_used'));
        }
    }

    public function meetingCommitteeConfig(Meeting $meeting): View
    {
        $this->authorize('updateCommitteeMember', $meeting);

        $committeeSetting = CommitteeSetting::where('committee_type_id', $meeting->committee_type_id)->first();
        $meetingCommittees = [];
        if ($committeeSetting) {
            $meetingCommittees = MeetingCommittee::where([
                'meeting_id' => $meeting->id,
                'committee_setting_id' => $committeeSetting->id,
            ])->first();
        }
        $notifications = Notification::where('meeting_id', $meeting->id)->get();

        return \view(self::VIEW_PATH . 'meeting-committee-config.edit-add', compact('meeting', 'committeeSetting', 'meetingCommittees','notifications'));
    }

    public function meetingCommitteeConfigStore(Request $request, Meeting $meeting)
    {
        $validatedData = $this->meetingService->meetingCommitteeConfigValidator($request, $meeting->id);
        $data = $validatedData->validate();

        try {
            $this->meetingService->createMeetingCommitteeConfig($meeting, $data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json([
                'message' => __('generic.meeting_committee_setup_failed'),
                'alertType' => 'error',
                'redirectTo' => route('admin.meeting_management.meetings.index'),
            ], 200);
        }

        return response()->json([
            'message' => __('generic.meeting_committee_setup_success'),
            'alertType' => 'success',
            'redirectTo' => route('admin.meeting_management.meetings.index'),
        ], 200);
    }

    public function resolutionFileUpload(Request $request, Meeting $meeting): JsonResponse
    {
        $this->authorize('uploadResolutionFile', $meeting);
        $validatedData = $this->meetingService->resolutionFileValidator($request, $meeting->id);

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();

        try {
            $this->meetingService->updateMeeting($data, $meeting);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.meeting_update_failed'),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('generic.meeting_update_success'),
            'alertType' => 'success',
            'redirectTo' => route('admin.meeting_management.meetings.index'),
        ]);
    }

    public function landlessMeetingList(Meeting $meeting)
    {
        return \view(self::VIEW_PATH . 'landless-meeting.browse', compact('meeting'));
    }

    public function landlessMeetingDatatable(Request $request, Meeting $meeting)
    {
        $this->authorize('updateMeetingLandless', $meeting);
        return $this->meetingService->getListDataForlandlessMeetingDatatable($request, $meeting);
    }

    public function landlessMeetingListUpdate(Request $request, Meeting $meeting): RedirectResponse
    {
        $this->authorize('updateMeetingLandless', $meeting);

        try {
            $this->meetingService->updateLandlessMeeting($meeting);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return redirect()->back()->with([
                'message' => __('generic.landless_meeting_update_failed'),
                'alert-type' => 'error',
            ]);
        }

        return redirect()->back()->with([
            'message' => __('generic.landless_meeting_update_success'),
            'alert-type' => 'success',
        ]);

    }

    public function worksheet(Meeting $meeting)
    {
        $this->authorize('viewWorksheet', $meeting);

        $meetingId = $meeting->id;
        $meeting = Meeting::select([
            'meetings.id as id',
            'meetings.meeting_date',
            'meetings.worksheet',
            'meeting_committees.meeting_id',
            'meeting_committees.meeting_id',
            'meeting_committees.member_config',
        ]);
        $meeting->leftJoin('meeting_committees', 'meeting_committees.meeting_id', '=', 'meetings.id');

        $meeting = $meeting->where('meetings.id', $meetingId)
            ->first();

        if (!empty($meeting['member_config'])) {
            $meetingPresident = collect(json_decode($meeting['member_config']))->filter(function ($item) {
                return $item->committee_designation_id == 'chairman';
            })->first()->name;
        } else {
            $meetingPresident = '...............';
        }

        $meetingDate = !empty($meeting['meeting_date']) ? $meeting['meeting_date'] : '..................';
        $meetingTime = '............. ঘটিকা';
        $meetingLoc = 'উপজেলা নির্বাহী অফিসারের সভাকক্ষ';

        $authUser = AuthHelper::getAuthUser();
        $jurisdictionConditions = Landless::getJurisditionConditions($authUser);

        $divisionBbsCode = (!empty($jurisdictionConditions) and !empty($jurisdictionConditions['landless.loc_division_bbs']))? $jurisdictionConditions['landless.loc_division_bbs']:null;
        $districtBbsCode = (!empty($jurisdictionConditions) and !empty($jurisdictionConditions['landless.loc_district_bbs']))? $jurisdictionConditions['landless.loc_district_bbs']:null;
        $upazilaBbsCode = (!empty($jurisdictionConditions) and !empty($jurisdictionConditions['landless.loc_upazila_bbs'])) ? $jurisdictionConditions['landless.loc_upazila_bbs']:null;

        $landless = $this->meetingService->conditionalLandlessList($meeting, false);

        $landlessNames = '';
        foreach ($landless as $key => $landlessName) {

            $landlessNames .= $landlessName->fullname . (count($landless) - 1 == $key ? '.' : ', ');
        }

        $upazila = (!empty($authUser->office->upazila_bbs_code) || !empty($districtBbsCode and $upazilaBbsCode)) ? $authUser->office->locUpazila($districtBbsCode, $upazilaBbsCode) : null;
        $district = (!empty($authUser->office->district_bbs_code) || !empty($districtBbsCode)) ? $authUser->office->locDistrict->title : null;

        $memberConfig = $meeting['member_config'] ? json_decode($meeting['member_config']):[];
        $presentedMembers = '';
        foreach ($memberConfig as $key => $member) {
            $presentedMembers .= (\App\Helpers\Classes\NumberToBanglaWord::engToBn($key + 1)) . "। " . $member->org_designation . ", $upazila,$district ।</br>";
        }

        $searchItems = [
            "{{meetingPresident}}",
            "{{meetingDate}}",
            "{{meetingTime}}",
            "{{meetingLoc}}",
            "{{presentedMembers}}",
            "{{upazila}}",
            "{{district}}",
            "{{landless}}",
        ];


        $replaceValues = [
            $meetingPresident,
            $meetingDate,
            $meetingTime,
            $meetingLoc,
            $presentedMembers,
            $upazila??"................",
            $district??"................",
            $landlessNames,
        ];
        $worksheetDetails = !empty($meeting['worksheet']) ?
            str_replace($searchItems, $replaceValues, $meeting['worksheet']) : '............';

        return view(self::VIEW_PATH . 'worksheet', compact('meeting', 'worksheetDetails'));
    }

    public function landlessPdf(Meeting $meeting)
    {
        $this->authorize('updateMeetingLandless', $meeting);

        $authUser = AuthHelper::getAuthUser();
        $jurisdictionConditions = Landless::getJurisditionConditions($authUser);
        $divisionBbsCode = (!empty($jurisdictionConditions) and !empty($jurisdictionConditions['landless.loc_division_bbs']))? $jurisdictionConditions['landless.loc_division_bbs']:null;
        $districtBbsCode = (!empty($jurisdictionConditions) and !empty($jurisdictionConditions['landless.loc_district_bbs']))? $jurisdictionConditions['landless.loc_district_bbs']:null;
        $upazilaBbsCode = (!empty($jurisdictionConditions) and !empty($jurisdictionConditions['landless.loc_upazila_bbs'])) ? $jurisdictionConditions['landless.loc_upazila_bbs']:null;

        $upazila = (!empty($authUser->office->upazila_bbs_code) || !empty($districtBbsCode and $upazilaBbsCode)) ? $authUser->office->locUpazila($districtBbsCode, $upazilaBbsCode) : "........";
        $district = (!empty($authUser->office->district_bbs_code) || !empty($districtBbsCode)) ? $authUser->office->locDistrict->title : "...........";

        $landless = $this->meetingService->conditionalLandlessList($meeting, true);

        $html = view(
            self::VIEW_PATH . 'landless-meeting.landless-pdf',
            compact('landless', 'upazila','district')
        )
            ->render();


        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => Config::get('pdf.font_path'),
            'fontdata' => Config::get('pdf.font_data'),
            'tempDir' => storage_path('tempdir'),
            'default_font' => 'kalpurush',
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output("landless-list-of-$meeting->title.pdf", 'D');
    }

    public function createLandAssignment(Meeting $meeting)
    {
        $division = LocDivision::where('bbs_code', Landless::CTG_BBS_CODE)->first();
        $district = LocDistrict::where([
            'division_bbs_code'=> Landless::CTG_BBS_CODE,
            'bbs_code'=> Landless::NOAKHALI_BBS_CODE,
        ])->first();

        $upazilas = LocUpazila::where([
            'division_bbs_code'=> Landless::CTG_BBS_CODE,
            'district_bbs_code'=> Landless::NOAKHALI_BBS_CODE,
        ])->get();

        $alreadyLandAssignedLandlessIds = LandAssignment::where('meeting_id', $meeting->id)->pluck('landless_application_id');

        $landlessApplications = Landless::select([
            'landless_applications.id',
            'landless_applications.application_number',
            'landless_applications.nothi_number',
            'landless_applications.fullname',
            'landless_applications.mobile',
            'landless_applications.identity_type',
            'landless_applications.identity_number',
            'landless_applications.date_of_birth',
            'landless_applications.landless_type',
            'landless_applications.gender',
            'landless_applications.father_name',
            'landless_applications.father_dob',
            'landless_applications.father_is_alive',
            'landless_applications.mother_name',
            'landless_applications.mother_dob',
            'landless_applications.status',
            'landless_meeting.meeting_id',
            'landless_meeting.landless_id as landless_id',
        ]);
        $landlessApplications = $landlessApplications->rightJoin('landless_meeting','landless_meeting.landless_id','=','landless_applications.id')
            ->where([
                'landless_meeting.meeting_id'=>$meeting->id,
                'landless_applications.status'=> Landless::STATUS_ACTIVE,
            ])
            ->whereNotIn('landless_meeting.landless_id', $alreadyLandAssignedLandlessIds)->get();

        return view(self::VIEW_PATH . 'land-assignment', compact('meeting','division','district', 'upazilas','landlessApplications'));
    }

    public function storeLandAssignment(Meeting $meeting, Request $request)
    {

        $validatedData = $this->meetingService->validatorLandAssignment($request, $meeting->id);
        if ($validatedData->fails()) {
            $errors = $validatedData->errors();
            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();
        $data['meeting_id'] = $meeting->id;
        $data['division_bbs_code'] = Landless::CTG_BBS_CODE;
        $data['district_bbs_code'] = Landless::NOAKHALI_BBS_CODE;

        /**
         * #############################
         * Start Check max land_assignment
         * #############################
         **/
        $dataCollection = collect($data['land_assignment']);
        $regEightLandArea = [];
        foreach($dataCollection as $k => $v) {
            $id = $v['eight_register_id'];
            $regEightLandArea[$id]['assigned_land_area'][] = $v['assigned_land_area'];
            $regEightLandArea[$id]['jl_number'] = $v['jl_number'];
        }

        foreach($regEightLandArea as $key => $value) {
            $regEightTotalLandArea = [
                'eight_register_id' => $key,
                'assigned_land_area' => array_sum($value['assigned_land_area']),
                'jl_number'=>$value['jl_number']
            ];


            $regEight = EightRegister::find($regEightTotalLandArea['eight_register_id']);
            $upazila = LocUpazila::where([
                'division_bbs_code'=> Landless::CTG_BBS_CODE,
                'district_bbs_code'=> Landless::NOAKHALI_BBS_CODE,
                'bbs_code'=> $regEight->upazila_bbs_code,
            ])->first();
            $jlNumberBn = NumberToBanglaWord::engToBn($regEight->jl_number);
            $remainingKhaslandAreaBn = NumberToBanglaWord::engToBn($regEight->remaining_khasland_area);

            if($regEightTotalLandArea['assigned_land_area']>$regEight->remaining_khasland_area){
                return response()->json([
                    'message' => __("$upazila->title উপজেলা জেল.এল-$jlNumberBn এর বণ্টনকৃত মোট জমির পরিমান অবশ্যই বিতরণযোগ জমি $remainingKhaslandAreaBn এর চেয়ে ছোট/সমান হতে হবে"),
                    'alertType' => 'error',
                ], 200);
            }
        }
        /**
         * #############################
         * End Check max land_assignment
         * #############################
         **/

        try {
            $landAssignment = $this->meetingService->createOrUpdateLandAssignment($data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.land_assignment_not_added'),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('generic.land_assignment_added'),
            'alertType' => 'success',
            'redirectTo' => route('admin.meeting_management.meetings.index'),
        ]);
    }

    public function checkUniqueCaseNumber(Request $request)
    {
        $caseNumberAlreadyAdded = LandAssignment::where('case_number', $request->case_number)->get()->count();

        if ($caseNumberAlreadyAdded==0) {
            return response()->json(true);
        } else {
            return response()->json(__('generic.already_used'));
        }
    }

    public function getApplicantList(Meeting $meeting)
    {
        $locUpazilas = LocUpazila::where([
            'division_bbs_code' => Landless::CTG_BBS_CODE, //20 for CTG division bbs code
            'district_bbs_code' => Landless::NOAKHALI_BBS_CODE, //75 for loc_district_bbs,
        ])->get();

        return view(self::VIEW_PATH . 'landless-list',compact('locUpazilas','meeting'));
    }

}
