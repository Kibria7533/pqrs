<?php

namespace Modules\Landless\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use App\Helpers\Classes\Helper;
use App\Models\LandlessUser;
use App\Models\LocMouja;
use App\Models\Role;
use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;
use Modules\Landless\App\Models\Landless;
use Modules\Landless\App\Models\LandlessApplicationAttachment;
use Yajra\DataTables\Facades\DataTables;

class LandlessService
{
    public function createLandless(array $data)
    {

        $applicationNumber = $this->applicationNumberGenerate();

        $familyMembers = [];
        if (!empty($data['family_members'])) {
            $memberSl = 0;
            foreach ($data['family_members'] as $familyMember) {
                $familyMembers[$memberSl++] = [
                    'name' => $familyMember['name'],
                    'mobile' => $familyMember['mobile'],
                    'profession' => $familyMember['profession'],
                ];
            }
        }

        $references = [];
        if (!empty($data['references'])) {
            $referenceSl = 0;
            foreach ($data['references'] as $reference) {
                $references[$referenceSl++] = [
                    'name' => $reference['name'],
                    'mobile' => $reference['mobile'],
                    'profession' => $reference['profession'],
                ];
            }
        }

        $landlessApplicationData = [
            'application_number' => $applicationNumber,
            'nothi_number' => $data['nothi_number'],
            'fullname' => $data['fullname'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'identity_type' => $data['identity_type'],
            'identity_number' => $data['identity_number'],
            'date_of_birth' => $data['date_of_birth'],
            'landless_type' => $data['landless_type'],
            'gender' => $data['gender'],
            'father_name' => $data['father_name'],
            'father_dob' => $data['father_dob'],
            'father_is_alive' => $data['father_is_alive'],
            'mother_name' => $data['mother_name'],
            'mother_dob' => $data['mother_dob'],
            'mother_is_alive' => $data['mother_is_alive'],
            'spouse_name' => $data['spouse_name'],
            'spouse_dob' => $data['spouse_dob'],
            'spouse_father' => $data['spouse_father'],
            'spouse_mother' => $data['spouse_mother'],
            'loc_division_bbs' => $data['loc_division_bbs'],
            'loc_district_bbs' => $data['loc_district_bbs'],
            'loc_upazila_bbs' => $data['loc_upazila_bbs'],
            'loc_union_bbs' => $data['loc_union_bbs'],
            'jl_number' => $data['jl_number'],
            'village' => $data['village'],
            'family_members' => $familyMembers,
            'bosot_vita_details' => $data['bosot_vita_details'],
            'present_address' => $data['present_address'],
            'gurdian_khasland_details' => $data['gurdian_khasland_details'],
            'nodi_vanga_family_details' => $data['nodi_vanga_family_details'],
            'freedom_fighters_details' => $data['freedom_fighters_details'],
            'khasland_details' => $data['khasland_details'],
            'expected_lands' => $data['expected_lands'],
            'references' => $references,
            'application_received_date' => $data['application_received_date'],
            'receipt_number' => $data['receipt_number'],
            'source_type' => 'lrms',
            'status' => $data['status'],
            'stage' => $data['stage'],
            'previous_stage' => null,
        ];

        try {
            DB::beginTransaction();
            $landlessApplication = Landless::create($landlessApplicationData);
            if ($landlessApplication) {
                foreach ($data['attachments'] as $key => $attachment) {
                    if (!empty($attachment['attached_file'])) {
                        $filename = FileHandler::storePhoto($attachment['attached_file'], 'landless');
                        $attachmentData = [
                            'landless_application_id' => $landlessApplication->id,
                            'file_type_id' => $attachment['file_type_id'],
                            'title' => $attachment['title'],
                            'attachment_file' => 'landless/' . $filename,
                        ];

                        LandlessApplicationAttachment::create($attachmentData);
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }

    public function updateLandless(array $data, Landless $landless)
    {
        $familyMembers = [];
        if (!empty($data['family_members'])) {
            $memberSl = 0;
            foreach ($data['family_members'] as $familyMember) {
                $familyMembers[$memberSl++] = [
                    'name' => $familyMember['name'],
                    'mobile' => $familyMember['mobile'],
                    'profession' => $familyMember['profession'],
                ];
            }
        }

        $references = [];
        if (!empty($data['references'])) {
            $referenceSl = 0;
            foreach ($data['references'] as $reference) {
                $references[$referenceSl++] = [
                    'name' => $reference['name'],
                    'mobile' => $reference['mobile'],
                    'profession' => $reference['profession'],
                ];
            }
        }

        $landlessApplicationData = [
            'nothi_number' => $data['nothi_number'],
            'fullname' => $data['fullname'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'identity_type' => $data['identity_type'],
            'identity_number' => $data['identity_number'],
            'date_of_birth' => $data['date_of_birth'],
            'landless_type' => $data['landless_type'],
            'gender' => $data['gender'],
            'father_name' => $data['father_name'],
            'father_dob' => $data['father_dob'],
            'father_is_alive' => $data['father_is_alive'],
            'mother_name' => $data['mother_name'],
            'mother_dob' => $data['mother_dob'],
            'mother_is_alive' => $data['mother_is_alive'],
            'spouse_name' => $data['spouse_name'],
            'spouse_dob' => $data['spouse_dob'],
            'spouse_father' => $data['spouse_father'],
            'spouse_mother' => $data['spouse_mother'],
            'loc_division_bbs' => $data['loc_division_bbs'],
            'loc_district_bbs' => $data['loc_district_bbs'],
            'loc_upazila_bbs' => $data['loc_upazila_bbs'],
            'loc_union_bbs' => $data['loc_union_bbs'],
            'jl_number' => $data['jl_number'],
            'village' => $data['village'],
            'family_members' => $familyMembers,
            'bosot_vita_details' => $data['bosot_vita_details'],
            'present_address' => $data['present_address'],
            'gurdian_khasland_details' => $data['gurdian_khasland_details'],
            'nodi_vanga_family_details' => $data['nodi_vanga_family_details'],
            'freedom_fighters_details' => $data['freedom_fighters_details'],
            'khasland_details' => $data['khasland_details'],
            'expected_lands' => $data['expected_lands'],
            'references' => $references,
            'application_received_date' => $data['application_received_date'],
            'receipt_number' => $data['receipt_number'],
            'source_type' => 'lrms',
            'status' => $data['status'],
            //'stage' => $data['stage'],
            //'previous_stage' => null,
        ];

        try {
            DB::beginTransaction();
            $landlessApplication = $landless->update($landlessApplicationData);

            if ($landlessApplication) {
                $landlessApplicationAttachmentIds = LandlessApplicationAttachment::where('landless_application_id', $landless->id)->pluck('id')->toArray();

                foreach ($data['attachments'] as $key => $attachment) {
                    if (!empty($attachment['attachment_id']) && !empty($attachment['attached_file'])) {
                        $landlessAppplicationAttachment = LandlessApplicationAttachment::find($attachment['attachment_id']);

                        if ($landlessAppplicationAttachment->attachment_file) {
                            FileHandler::deleteFile($landlessAppplicationAttachment->attachment_file);
                        }

                        $filename = FileHandler::storePhoto($attachment['attached_file'], 'landless');
                        $attachmentData = [
                            'landless_application_id' => $landless->id,
                            'file_type_id' => $attachment['file_type_id'],
                            'title' => $attachment['title'],
                            'attachment_file' => 'landless/' . $filename,
                        ];

                        $landlessAppplicationAttachment->update($attachmentData);
                    }

                    if (!empty($attachment['attachment_id']) && empty($attachment['attached_file'])) {
                        $landlessAppplicationAttachment = LandlessApplicationAttachment::find($attachment['attachment_id']);
                        $attachmentData = [
                            'landless_application_id' => $landless->id,
                            'file_type_id' => $attachment['file_type_id'],
                            'title' => $attachment['title'],
                        ];
                        $landlessAppplicationAttachment->update($attachmentData);
                    }

                    if (empty($attachment['attachment_id']) && !empty($attachment['attached_file'])) {
                        $filename = FileHandler::storePhoto($attachment['attached_file'], 'landless');
                        $attachmentData = [
                            'landless_application_id' => $landless->id,
                            'file_type_id' => $attachment['file_type_id'],
                            'title' => $attachment['title'],
                            'attachment_file' => 'landless/' . $filename,
                        ];
                        LandlessApplicationAttachment::create($attachmentData);
                    }
                }

                $attachmentIds = [];
                foreach ($data['attachments'] as $index => $attachment) {
                    $attachmentIds[$index] = [
                        'attachment_id' => !empty($attachment['attachment_id']) ? (int)$attachment['attachment_id'] : null,
                    ];
                }

                $attachmentIds = collect($attachmentIds)->whereNotNull('attachment_id')->pluck('attachment_id')->toArray();
                $deletableIds = array_diff($landlessApplicationAttachmentIds, $attachmentIds);
                foreach ($deletableIds as $i => $deletableId) {
                    $landlessAppplicationAttachment = LandlessApplicationAttachment::find($deletableId);
                    FileHandler::deleteFile($landlessAppplicationAttachment->attachment_file);
                }
                LandlessApplicationAttachment::whereIn('id', $deletableIds)->delete();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }

    public function deleteLandless(Landless $landless): bool
    {
        return $landless->delete();
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'fullname' => 'required|string|max: 191',
            'mobile' => [
                'required',
                'string',
                'max: 20',
                'regex:/(^((?:\+88|88)?(01[3-9]\d{8}))$)|(^((\x{09EE}\x{09EE})|(\+\x{09EE}\x{09EE}))?[\x{09E6}-\x{09EF}]{11})$/u',
            ],
            'email' => 'nullable|string|max:191|email',
            'gender' => 'required|int',
            'status' => 'nullable|int',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function validateLandlessMultiApproveOrReject(Request $request): Validator
    {
        $rules = [
            'landless_ids' => [
                'bail', 'array', 'min:1'
            ],
            'landless_ids.*' => 'required|exists:landless_applications,id',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function approveSingleLandless(Landless $landless)
    {
        $data['status'] = Landless::STATUS_ACTIVE;
        $password = Helper::randomPassword(8, true);
        $role = Role::where('code', 'landless')->first();
        DB::beginTransaction();
        try {
            if ($landless->update($data)) {
                if (!empty($role) && !empty($landless->email)) {
                    $LandlessUserData = [
                        'landless_application_id' => $landless->id,
                        'user_type_id' => UserType::USER_TYPE_LANDLESS_USER_CODE,
                        'role_id' => $role->id,
                        'name' => $landless->fullname,
                        'email' => $landless->email,
                        'division_bbs_code' => $landless->loc_division_bbs,
                        'district_bbs_code' => $landless->loc_district_bbs,
                        'upazila_bbs_code' => $landless->loc_upazila_bbs,
                        'password' => Hash::make($password),//todo
                        'profile_pic' => 'users/default.png',
                    ];

                    if(!(LandlessUser::where('email', $landless->email)->first())){
                        LandlessUser::create($LandlessUserData);
                    }

                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            Log::debug($exception->getMessage());
        }
    }

    public function multiApproveLandless(array $landlessIds)
    {
        $role = Role::where('code', 'landless')->first();
        foreach ($landlessIds as $landlessId) {
            /**
             * @var Landless $landless
             */
            $landless = Landless::where('id', $landlessId)->first();

            $data['status'] = Landless::STATUS_ACTIVE;
            $password = Helper::randomPassword(8, true);

            DB::beginTransaction();
            try {
                if ($landless->update($data)) {
                    if (!empty($role) && !empty($landless->email)) {
                        $LandlessUserData = [
                            'landless_application_id' => $landless->id,
                            'user_type_id' => UserType::USER_TYPE_LANDLESS_USER_CODE,
                            'role_id' => $role->id,
                            'name' => $landless->fullname,
                            'email' => $landless->email,
                            'division_bbs_code' => $landless->loc_division_bbs,
                            'district_bbs_code' => $landless->loc_district_bbs,
                            'upazila_bbs_code' => $landless->loc_upazila_bbs,
                            'password' => Hash::make($password),
                            'profile_pic' => LandlessUser::DEFAULT_PROFILE_PIC,
                        ];

                        if(!(LandlessUser::where('email', $landless->email)->first())){
                            LandlessUser::create($LandlessUserData);
                        }
                    }
                }

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollback();
                Log::debug($exception->getMessage());
            }

        }
    }

    public function rejectSingleLandless(Landless $landless): bool
    {
        $data['status'] = Landless::STATUS_REJECT;

        return $landless->update($data);
    }

    public function rejectMultiLandless(array $landlessIds)
    {
        foreach ($landlessIds as $landlessId) {
            /**
             * @var Landless $landless
             */
            $landless = Landless::where('id', $landlessId)->first();
            $data['status'] = Landless::STATUS_REJECT;
            try {
                $landless->update($data);
            } catch (\Throwable $exception) {
                Log::debug($exception->getMessage());
            }
        }
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /**
         * @var Builder|Landless $landless
         */
        $landless = Landless::select(
            [
                'landless_applications.id as id',
                'landless_applications.fullname',
                'landless_applications.mobile',
                'landless_applications.email',
                'landless_applications.identity_number',
                'landless_applications.gender',
                'landless_applications.loc_division_bbs',
                'landless_applications.loc_district_bbs',
                'landless_applications.loc_upazila_bbs',
                'landless_applications.loc_union_bbs',
                'landless_applications.jl_number',
                'landless_applications.status',
                //'landless_applications.stage',
                DB::raw("DATE_FORMAT(landless_applications.created_at, '%d %M, %Y') as application_date"),
            ]
        );

        $jurisdictionConditions = Landless::getJurisditionConditions($authUser);

        $landless = $landless
            /*->whereIn('status', [Landless::STATUS_ON_PROGRESS, Landless::STATUS_DRAFT])
            ->whereIn('stage', [Landless::STAGE_INITIAL, Landless::STAGE_ACLAND_SENDING])*/
            ->where($jurisdictionConditions);

        return DataTables::eloquent($landless)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Landless $landless) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $landless)) {
                    $str .= '<a href="' . route('admin.landless.show', $landless->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.show_button_label') . '</a>';
                }

                if ($authUser->can('singleApprove', $landless) && ($landless->status == Landless::STATUS_ON_PROGRESS)) {
                    $str .= '<a href="#" data-action="' . route('admin.landless.approve', $landless->id) . '" class="btn btn-outline-success btn-sm approve"> <i class="fas fa-check-circle"></i> ' . __('generic.approve') . '</a>';
                }

                if ($authUser->can('singleReject', $landless) && ($landless->status == Landless::STATUS_ON_PROGRESS)) {
                    $str .= '<a href="#" data-action="' . route('admin.landless.reject', $landless->id) . '" class="btn btn-outline-danger btn-sm reject"> <i class="fas fa-times-circle"></i> ' . __('generic.reject') . '</a>';
                }

                if ($authUser->can('update', $landless) && ($landless->status == Landless::STATUS_DRAFT)) {
                    $str .= '<a href="' . route('admin.landless.edit', $landless->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }

                if ($authUser->can('delete', $landless) && ($landless->status == Landless::STATUS_DRAFT)) {
                    $str .= '<a href="#" data-action="' . route('admin.landless.destroy', $landless->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->addColumn('gender', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= !empty($landless->gender) ? __('generic.' . Landless::GENDER[$landless->gender]) : '';
                return $str;
            })
            ->addColumn('loc_upazila_title', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= !empty($landless->loc_upazila_bbs) ? __($landless->upazila($landless->loc_division_bbs, $landless->loc_district_bbs, $landless->loc_upazila_bbs)) : '';
                return $str;
            })
            ->addColumn('loc_union_title', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= !empty($landless->loc_union_bbs) ? __($landless->union($landless->loc_division_bbs, $landless->loc_district_bbs, $landless->loc_upazila_bbs, $landless->loc_union_bbs)) : '';
                return $str;
            })
            ->addColumn('mouja_name', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= !empty($landless->jl_number) ? __(LocMouja::getMouja($landless->loc_district_bbs, $landless->loc_upazila_bbs, $landless->jl_number, 'rs')->name_bd) : '';
                return $str;
            })

            ->addColumn('status_title', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= '<span class="badge badge-info w-100">'.( !empty(Landless::STATUS[$landless->status]) ?__('generic.'.Landless::STATUS[$landless->status]) : '').'</span>';
                return $str;
            })
            ->rawColumns(['action', 'loc_upazila_title', 'loc_union_title','mouja_name', 'status_title'])
            ->toJson();
    }

    public function getLandlessListDataForDatatable(Request $request,int $meetingId):jsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder $landless */
        $landless = Landless::select(
            [
                'landless_applications.id as id',
                'landless_applications.fullname',
                'landless_applications.mobile',
                'landless_applications.email',
                'landless_applications.identity_number',
                'landless_applications.gender',
                'landless_applications.loc_division_bbs',
                'landless_applications.loc_district_bbs',
                'landless_applications.loc_upazila_bbs',
                'landless_applications.loc_union_bbs',
                'landless_applications.jl_number',
                'landless_meeting.meeting_id',
                DB::raw("DATE_FORMAT(landless_applications.created_at, '%d %M, %Y') as application_date"),
            ]
        );
//Log::info('I am here',$request->toArray());

        Log::info($request->columns[3]["search"]["value"]);

        $jurisdictionConditions = Landless::getJurisditionConditions($authUser);

        $landless = $landless->where('status', Landless::STATUS_ACTIVE)
                             ->where('is_land_assigned', 0)
                             ->where($jurisdictionConditions);

        $landless->leftJoin("landless_meeting", function ($join) use ($meetingId) {
            $join->on('landless_applications.id', '=', 'landless_meeting.landless_id')
                ->where('landless_meeting.meeting_id',$meetingId);
        });

//        dd($landless->get());

        return DataTables::eloquent($landless)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Landless $landless) use ($meetingId, $authUser) {
                $str = '';
                if ($authUser->can('view', $landless)) {
                    $str .= '<a href="' . route('admin.landless.applicants.show', [$landless->id,$meetingId]) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.show_button_label') . '</a>';
                }

                if ($authUser->can('delete', $landless) && ($landless->meeting_id)) {
                    $str .= '<a href="#" data-action="' . route('admin.landless.reject.from.meeting', ['landlessId'=>$landless->id, 'meetingId'=>$meetingId]) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                if ($authUser->can('delete', $landless) && (!$landless->meeting_id)) {
                    $str .= '<a href="' . route('admin.landless.approve.to.meeting', ['landlessId'=>$landless->id, 'meetingId'=>$meetingId]) . '" class="btn btn-outline-success btn-sm add"> <i class="fas fa-add"></i> ' . __('generic.add_new_landless') . '</a>';
                }
                return $str;
            }))
            ->addColumn('gender', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= !empty($landless->gender) ? __('generic.' . Landless::GENDER[$landless->gender]) : '';
                return $str;
            })
            ->addColumn('loc_upazila_title', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= !empty($landless->loc_upazila_bbs) ? __($landless->upazila($landless->loc_division_bbs, $landless->loc_district_bbs, $landless->loc_upazila_bbs)) : '';
                return $str;
            })
            ->addColumn('loc_union_title', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= !empty($landless->loc_union_bbs) ? __($landless->union($landless->loc_division_bbs, $landless->loc_district_bbs, $landless->loc_upazila_bbs, $landless->loc_union_bbs)) : '';
                return $str;
            })

            ->rawColumns(['action', 'loc_upazila_title', 'loc_union_title', 'status_title'])
            ->toJson();
    }

    public function getListDataForAcLandApprovedDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Landless $smefRegistrations */
        $landless = Landless::select(
            [
                'landless_applications.id as id',
                'landless_applications.fullname',
                'landless_applications.mobile',
                'landless_applications.email',
                'landless_applications.identity_number',
                'landless_applications.gender',
                'landless_applications.loc_division_bbs',
                'landless_applications.loc_district_bbs',
                'landless_applications.loc_upazila_bbs',
                'landless_applications.loc_union_bbs',
                'landless_applications.created_at',
                DB::raw("DATE_FORMAT(landless_applications.created_at, '%d %M, %Y') as application_date"),
            ]
        );

        $jurisdictionConditions = Landless::getJurisditionConditions($authUser);

        $landless = $landless->where('status', Landless::STATUS_ACTIVE)
            ->where($jurisdictionConditions);

        return DataTables::eloquent($landless)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Landless $landless) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $landless)) {
                    $str .= '<a href="' . route('admin.landless.show', $landless->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.show_button_label') . '</a>';
                }
                if ($authUser->can('view', $landless)) {
                    $str .= '<a  href="' . route('admin.landless.kabuliat.show', $landless->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i>  ' . __('generic.kabuliat') . '</a>';
                }
                if ($authUser->can('viewReceiptNumber', $landless)) {
                    $str .= '<a href="' . route('admin.landless.receipt.view', $landless->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.receipt') . '</a>';
                }

                return $str;
            }))
            ->addColumn('gender', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= !empty($landless->gender) ? __('generic.' . Landless::GENDER[$landless->gender]) : '';
                return $str;
            })
            ->addColumn('loc_upazila_title', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= !empty($landless->loc_upazila_bbs) ? __($landless->upazila($landless->loc_division_bbs, $landless->loc_district_bbs, $landless->loc_upazila_bbs)) : '';
                return $str;
            })
            ->addColumn('loc_union_title', function (Landless $landless) use ($authUser) {
                $str = '';
                $str .= !empty($landless->loc_union_bbs) ? __($landless->union($landless->loc_division_bbs, $landless->loc_district_bbs, $landless->loc_upazila_bbs, $landless->loc_union_bbs)) : '';
                return $str;
            })
            ->rawColumns(['action', 'loc_upazila_title', 'loc_union_title'])
            ->toJson();
    }


    /**
     * request for nid verification [start]
     **/
    public function nidVerification(Request $request): JsonResponse
    {
        $user = [];
        if (!empty($request->nid) && !empty($request->date_of_birth)) {
            $nidInfo = $this->getOwnerInfoByNID($request->nid, $request->date_of_birth);
            //dd($nidInfo);
            if (empty($nidInfo) || !isset($nidInfo['message']) || $nidInfo['message'] !== 'SUCCESS') {
                return response()->json([], 200);
            }

            $user['name_bn'] = $nidInfo['data']['name'];
            $user['name'] = $nidInfo['data']['nameEn'];
            $user['father'] = $nidInfo['data']['father'];
            $user['mother'] = $nidInfo['data']['mother'];
            $user['gender'] = $nidInfo['data']['gender'];
            $user['nid'] = $nidInfo['data']['nationalId'];
            $user['address'] = 'বাসা/হোল্ডিং: ' . $nidInfo['data']['permanentAddress']['homeOrHoldingNo'] . ','
                . ' গ্রাম/রাস্তা: ' . (empty($nidInfo['data']['permanentAddress']['villageOrRoad']) ? ($nidInfo['data']['permanentAddress']['additionalVillageOrRoad'] ?? $nidInfo['data']['permanentAddress']['unionOrWard']) : $nidInfo['data']['permanentAddress']['villageOrRoad']) . ','
                . ' ডাকঘর: ' . $nidInfo['data']['permanentAddress']['postOffice']
                . ' - ' . $nidInfo['data']['permanentAddress']['postalCode']
                . ', ' . $nidInfo['data']['permanentAddress']['upozila']
                . ', ' . $nidInfo['data']['permanentAddress']['district'];

            $user['mobile'] = !empty($nidInfo['mobile']) ? $nidInfo['mobile'] : '';
        }

        return response()->json($user, 200);
    }


    public function getOwnerInfoByNID($nid, $birthdate, $returnJSON = false)
    {
        $config = config('app.idp_land_api');

        $birthdate = Carbon::parse($birthdate)->format('Y-m-d');
        // NEW USER NID
        $nidData = Curl::to($config['nid_url'])
            ->withHeader('Authorization: Bearer ' . $this->generateToken())
            ->withHeader('Content-Type: application/json')
            ->withData([
                "dateOfBirth" => $birthdate,
                "nid" => $nid
            ])
            ->asJsonRequest()
            ->asJsonResponse(!$returnJSON)
            ->post();

        if (!empty($nidData)) {
            if ($nidData['status'] == 200) {
                session(['userNidData' => $nidData]);
            }
        }

        return $nidData;
    }

    // get token
    private function generateToken()
    {
        $config = config('app.idp_land_api');
        $tokenResponseData = Curl::to($config['token_url'])
            ->withHeader('Authorization:Basic ' . base64_encode($config['client_id'] . ':' . $config['client_secret']))
            ->withHeader('Content-Type:application/x-www-form-urlencoded')
            ->withData([
                'grant_type' => $config['grant_type'],
                'scope' => $config['scope']
            ])
            ->asJsonResponse(true)
            ->post();

        return $tokenResponseData['access_token'];
    }

    /**
     * request for nid verification [end]
     **/

    /**
     * Generate Application Number
     **/
    private function applicationNumberGenerate(): string
    {
        $lastApplicationNumber = Landless::whereNotNull('application_number')->orderBy('application_number', 'desc')->first();

        if (!empty($lastApplicationNumber)) {
            $number = $lastApplicationNumber->application_number;
            return str_pad($number + 1, 8, "0", STR_PAD_LEFT);
        } else {
            return '00000001';
        }
    }


}
