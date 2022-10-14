<?php

namespace Modules\Meeting\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Modules\Khotian\App\Models\EightRegister;
use Modules\Landless\App\Models\LandAssignment;
use Modules\Landless\App\Models\Landless;
use Modules\Meeting\Models\CommitteeType;
use Modules\Meeting\Models\LandlessMeeting;
use Modules\Meeting\Models\Meeting;
use Modules\Meeting\Models\MeetingCommittee;
use Yajra\DataTables\Facades\DataTables;

class MeetingService
{
    public function createMeeting(array $data): Meeting
    {
        if (!empty($data['resolution_file'])) {
            $filename = FileHandler::storePhoto($data['resolution_file'], 'meetings');
            $data['resolution_file'] = 'meetings/' . $filename;
        }

        $meeting = Meeting::create($data);

        if ($meeting) {
            $this->updateLandlessMeeting($meeting);
        }

        return $meeting;
    }

    public function updateMeeting(array $data, Meeting $meeting)
    {
        if ($meeting->resolution_file && !empty($data['resolution_file'])) {
            FileHandler::deleteFile($meeting->resolution_file);
        }

        if (!empty($data['resolution_file'])) {
            $filename = FileHandler::storePhoto($data['resolution_file'], 'meetings');
            $data['resolution_file'] = 'meetings/' . $filename;
        } else {
            unset($data['resolution_file']);
        }

        $meeting->update($data);

        if ($meeting) {
            $this->updateLandlessMeeting($meeting);
        }

    }

    public function deleteMeeting(Meeting $meeting): bool
    {
        return $meeting->delete();
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Meeting $smefRegistrations */
        $meetings = Meeting::select(
            [
                'meetings.id as id',
                'meetings.title',
                'meetings.meeting_no',
                'meetings.meeting_type',
                DB::raw("DATE_FORMAT(meetings.meeting_date, '%d %M, %Y') as meeting_date"),
                'meetings.committee_type_id',
                'meetings.status',
                'committee_types.office_type',
            ]
        );

        $meetings = $meetings->join('committee_types', 'committee_types.id', '=', 'meetings.committee_type_id')
            ->whereIn('meetings.status', [Meeting::STATUS_ACTIVE]);

        if ($authUser->isAcLandUser()) {
            $meetings = $meetings->where('committee_types.office_type', CommitteeType::OFFICE_TYPE_UPAZILA);
        }

        if ($authUser->isDcUser()) {
            $meetings = $meetings->where('committee_types.office_type', CommitteeType::OFFICE_TYPE_DC);
        }

        return DataTables::eloquent($meetings)
            ->addColumn('action', DatatableHelper::getActionButtonBlockDropDown(static function (Meeting $meeting) use ($authUser) {

                $str = '';
                if ($authUser->can('view', $meeting)) {
                    $str .= '<a href="' . route('admin.meeting_management.meetings.show', $meeting->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.show_button_label') . '</a>';
                }

                if ($authUser->can('viewWorksheet', $meeting)) {
                    $str .= '<a href="' . route('admin.meeting_management.meetings.worksheet', $meeting->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.worksheet') . '</a>';
                }

                if ($authUser->can('update', $meeting)) {
                    $str .= '<a href="' . route('admin.meeting_management.meetings.edit', $meeting->id) . '" class="btn btn-outline-primary btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }

                if ($authUser->can('updateMeetingLandless', $meeting)) {
                    $str .= '<a href="' . route('admin.meeting_management.landless-applicants-list', $meeting->id) . '" class="btn btn-outline-dark btn-sm"> <i class="fas fa-list"></i> ' . __('generic.landless_meeting_list') . '</a>';
                }

                /**
                 * Land assign btn
                 **/
                if ($authUser->can('landAssignmentToLandless', $meeting)) {
                    $str .= '<a href="' . route('admin.meeting_management.meetings.land-assignment.create', $meeting->id) . '" class="btn btn-outline-dark btn-sm"> <i class="fas fa-map-signs"></i> ' . __('generic.land_assignment') . '</a>';
                }

                if ($authUser->can('uploadResolutionFile', $meeting)) {
                    $str .= '<a href="#" data-action="' . route('admin.meeting_management.meetings.resolution-file-upload', $meeting->id) . '" class="btn btn-outline-success btn-sm upload-resolution"> <i class="fas fa-upload"></i> ' . __('generic.upload_resolution_file') . '</a>';
                }

                if ($authUser->can('updateCommitteeMember', $meeting)) {
                    $str .= '<a href="' . route('admin.meeting_management.meetings.meeting-committee-config', $meeting->id) . '" class="btn btn-outline-primary btn-sm"> <i class="fas fa-cogs"></i> ' . __('generic.meeting_committee') . '</a>';
                }

                if ($authUser->can('delete', $meeting)) {
                    $str .= '<a href="#" data-action="' . route('admin.meeting_management.meetings.destroy', $meeting->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->addColumn('committee_type', static function (Meeting $meeting) use ($authUser) {
                return !empty($meeting->committee_type_id) ? $meeting->committeeType->title : '';
            })
            ->addColumn('status', static function (Meeting $meeting) use ($authUser) {
                return !empty($meeting->status) ? __('generic.' . Meeting::STATUS[$meeting->status]) : '';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getListDataForlandlessMeetingDatatable(Request $request, Meeting $meeting): JsonResponse
    {
        $landless = $this->conditionalLandlessList($meeting, false);

        $view = view('meeting::backend.meetings.utils.landless-meeting-list', compact('landless', 'meeting'))->render();


        return response()->json(
            [
                'success' => true,
                'data' => $view,
            ]
        );
    }

    public function createMeetingCommitteeConfig(Meeting $meeting, array $data)
    {
        return MeetingCommittee::updateOrCreate(
            ['meeting_id' => $meeting->id], $data
        );
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'title' => 'required|string|max: 191',
            'meeting_no' => 'required|string|unique:meetings,meeting_no,' . $id, //rules 'email' => 'unique:users,email_address,' . $userId,
            'meeting_type' => 'nullable|int|min:1',
            'committee_type_id' => 'required|int|min:1|exists:committee_types,id',
            'meeting_date' => 'required|date',
            'template_id' => 'required|int|exists:templates,id',
            'resolution_file' => 'nullable|mimes:jpg,pdf|max:500',
            'worksheet' => 'nullable|string',
        ];


        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function validatorLandAssignment(Request $request, $meetingId = null): Validator
    {
        $rules = [
            'land_assignment' => 'required|array|min: 1',
            'land_assignment.*.landless_application_id' => [
                'required',
                'int',
                Rule::exists('landless_meeting', 'landless_id')->where(function ($query) use ($meetingId) {
                    $query->where('meeting_id', $meetingId);
                })
            ],
            'land_assignment.*.upazila_bbs_code' => 'required|int|exists:loc_upazilas,bbs_code',
            'land_assignment.*.jl_number' => 'required|int',
            'land_assignment.*.khotian_number' => 'required|string',
            'land_assignment.*.dag_number' => 'required|string',
            'land_assignment.*.eight_register_id' => 'required|int|exists:eight_registers,id',
            'land_assignment.*.assigned_land_area' => 'required|numeric|min:0|not_in:0',
            'land_assignment.*.case_number' => 'required|string|unique:land_assignments,case_number,' /*. $landAssignmentId*/,
            'land_assignment.*.remark' => 'nullable|string',
        ];


        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function resolutionFileValidator(Request $request, $id = null): Validator
    {
        $rules = [
            'resolution_file' => 'required|mimes:jpg,pdf|max:500',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function meetingCommitteeConfigValidator(Request $request, $id = null): Validator
    {
        $rules = [
            'meeting_id' => 'required|exists:meetings,id',
            'committee_setting_id' => 'required|exists:committee_settings,id',
            'member_config' => 'required|array|min:1',

            'member_config*org_designation_id' => 'required|exists:designations,id',
            'member_config*org_designation' => 'required|string',
            'member_config*committee_designation_id' => 'required|int',
            'member_config*committee_designation' => 'required|string',
            'member_config*name' => 'required|string',
            'member_config*mobile' => 'required|string',
            'member_config*email' => 'nullable|email',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function updateLandlessMeeting(Meeting $meeting)
    {
        DB::beginTransaction();

        try {
            $authUser = AuthHelper::getAuthUser();
            $jurisdictionConditions = Landless::getJurisditionConditions($authUser);

            $stage = [];//TODO supper admin view stage

            if ($authUser->isAcLandUser()) {
                $stage = [Landless::STAGE_UNO, Landless::STAGE_UNO_APPROVED];
            }

            if ($authUser->isDcUser()) {
                $stage = Landless::STAGE_DC;
            }

            $landless = Landless::where('status', Landless::STATUS_ON_PROGRESS)
                ->whereIn('stage', $stage)
                ->where($jurisdictionConditions)->get();

            $landLessListOnMeeting = LandlessMeeting::where('meeting_id', $meeting->id)->pluck('landless_id');

            foreach ($landless as $application) {
                $landlessMeetingData = [
                    'meeting_id' => $meeting->id,
                    'landless_id' => $application->id,
                ];

                LandlessMeeting::updateOrCreate(
                    ['meeting_id' => $meeting->id, 'landless_id' => $application->id], $landlessMeetingData
                );
            }

            $deleteLandlessItems = $landLessListOnMeeting->diff($landless->pluck('id'));
            LandlessMeeting::where('meeting_id', $meeting->id)->whereIn('landless_id', $deleteLandlessItems)->delete();

            DB::commit();
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            DB::rollback();
        }
    }

    public function conditionalLandlessList(Meeting $meeting, bool $landlessListedIncluded = null): array
    {
        $authUser = AuthHelper::getAuthUser();
        $jurisdictionConditions = Landless::getJurisditionConditions($authUser);

        $divisionBbsCode = (!empty($jurisdictionConditions) and !empty($jurisdictionConditions['landless_applications.loc_division_bbs'])) ? $jurisdictionConditions['landless_applications.loc_division_bbs'] : null;
        $districtBbsCode = (!empty($jurisdictionConditions) and !empty($jurisdictionConditions['landless_applications.loc_district_bbs'])) ? $jurisdictionConditions['landless_applications.loc_district_bbs'] : null;
        $upazilaBbsCode = (!empty($jurisdictionConditions) and !empty($jurisdictionConditions['landless_applications.loc_upazila_bbs'])) ? $jurisdictionConditions['landless_applications.loc_upazila_bbs'] : null;


        $divisionCondition = !empty($divisionBbsCode) ? "landless_applications.loc_division_bbs = $divisionBbsCode" : 1;
        $districtCondition = !empty($districtBbsCode) ? "landless_applications.loc_district_bbs = $districtBbsCode" : 1;
        $upazilaCondition = !empty($upazilaBbsCode) ? "landless_applications.loc_upazila_bbs = $upazilaBbsCode" : 1;

        $geoLocationCondition = "$divisionCondition and $districtCondition and $upazilaCondition";

        $status = Landless::STATUS_ACTIVE;
        //$stage = 1;//TODO supper admin view stage

        if ($authUser->isAcLandUser()) {
            //$stage = Landless::STAGE_UNO;
            //$stage = "landless_applications.stage=" . Landless::STAGE_UNO . " OR landless_applications.stage=" . Landless::STAGE_UNO_APPROVED;
        }

        if ($authUser->isDcUser()) {
            //$stage = Landless::STAGE_DC;
            //$stage = "landless_applications.stage=" . Landless::STAGE_DC;
        }

        $landlessListedIncludedCondition = $landlessListedIncluded ? "virtualTable.meeting_id=$meeting->id" : "virtualTable.meeting_id IS NULL or virtualTable.meeting_id=$meeting->id";

        return DB::select("SELECT landless_id,fullname, landless_id, meeting_id,landlessMeeting_id, father_name, present_address,status
                                                FROM (
                                                SELECT landless_applications.id as landlessId,
                                                       landless_applications.fullname,
                                                       landless_applications.father_name,
                                                       landless_applications.present_address,
                                                       landless_meeting.id as landlessMeeting_id,
                                                       landless_meeting.meeting_id as meeting_id,
                                                       landless_meeting.landless_id,
                                                       landless_applications.status,
                                                      FROM `landless_applications` LEFT JOIN landless_meeting ON landless_applications.id = landless_meeting.landless_id
                                                      where landless_applications.status = $status
                                                      and $geoLocationCondition
                                                      ) as virtualTable
                                                where $landlessListedIncludedCondition");
    }

    public function createOrUpdateLandAssignment(array $data)
    {

        DB::beginTransaction();
        try {
            foreach ($data['land_assignment'] as $key => $value) {
                $landAssignmentData = [
                    "meeting_id" => $data['meeting_id'],
                    "landless_application_id" => $value['landless_application_id'],
                    "eight_register_id" => $value['eight_register_id'],
                    "division_bbs_code" => $data['division_bbs_code'],
                    "district_bbs_code" => $data['district_bbs_code'],
                    "upazila_bbs_code" => $value['upazila_bbs_code'],
                    "jl_number" => $value['jl_number'],
                    "khotian_number" => $value['khotian_number'],
                    "dag_number" => $value['dag_number'],
                    "assigned_land_area" => $value['assigned_land_area'],
                    "is_case_order_by_acland" => !empty($value['case_number'])?1:0,
                    "case_number" => !empty($value['case_number'])?$value['case_number']:null,
                    "remark" => $value['remark'],
                ];

                LandAssignment::create($landAssignmentData);
                $eightRegister = EightRegister::find($value['eight_register_id']);
                $eightRegister->decrement('remaining_khasland_area', $value['assigned_land_area']);
                $eightRegister->increment('provided_khasland_area', $value['assigned_land_area']);
                Landless::find($value['landless_application_id'])->update(['is_land_assigned' => 1]);
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            DB::rollback();
        }
    }
}
