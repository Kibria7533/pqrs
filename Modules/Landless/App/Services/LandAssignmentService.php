<?php

namespace Modules\Landless\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use App\Models\LocMouja;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Landless\App\Models\LandAssignment;
use Modules\Landless\App\Models\Landless;
use Modules\Landless\App\Models\LandlessApplicationAttachment;
use Modules\ScratchMap\App\Models\ScratchMap;
use Yajra\DataTables\Facades\DataTables;

class LandAssignmentService
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
            'nothi_number' => 'required|string|unique:landless_applications,nothi_number,' . $id,
            'fullname' => 'required|string|max: 191',
            'mobile' => [
                'required',
                'string',
                'max: 20',
                'regex:/(^((?:\+88|88)?(01[3-9]\d{8}))$)|(^((\x{09EE}\x{09EE})|(\+\x{09EE}\x{09EE}))?[\x{09E6}-\x{09EF}]{11})$/u',
            ],
            'email' => 'nullable|string|max:191|email',
            'identity_type' => 'required|int|min:1',
            'identity_number' => 'nullable|string',
            'date_of_birth' => 'required|date',
            'landless_type' => 'required|int',
            'gender' => 'required|int',
            'father_name' => 'nullable|string|max: 100',
            'father_dob' => 'nullable|date',
            'father_is_alive' => 'nullable|boolean',
            'mother_name' => 'nullable|string|max: 100',
            'mother_dob' => 'nullable|date',
            'mother_is_alive' => 'nullable|boolean',
            'spouse_name' => 'nullable|string|max: 100',
            'spouse_dob' => 'nullable|date',
            'spouse_father' => 'nullable|string|max: 100',
            'spouse_mother' => 'nullable|string|max: 100',
            'loc_division_bbs' => 'required|exists:loc_divisions,bbs_code',
            'loc_district_bbs' => 'required|exists:loc_districts,bbs_code',
            'loc_upazila_bbs' => 'required|exists:loc_upazilas,bbs_code',
            'loc_union_bbs' => 'nullable|exists:loc_unions,bbs_code',
            'jl_number' => 'required|exists:loc_all_moujas,rs_jl_no',
            'village' => 'required|string|max: 191',
            'family_members' => 'required|array|min: 1',
            'family_members.*.name' => 'required|string',
            'family_members.*.mobile' => [
                'required',
                'string',
                'max: 20',
                'regex:/(^((?:\+88|88)?(01[3-9]\d{8}))$)|(^((\x{09EE}\x{09EE})|(\+\x{09EE}\x{09EE}))?[\x{09E6}-\x{09EF}]{11})$/u',
            ],
            'family_members.*.profession' => 'required|string',

            'attachments' => 'required|array|min: 1',//Todo
            'attachments.*.file_type_id' => 'required|int',
            'attachments.*.attached_file' => [
                $id ? 'nullable' : 'required',
                //'required',
                //'mimes:jpg,png,pdf',
                //'max:500',
                //'dimensions:width=370,height=70'
            ],
            'attachments.*.title' => 'nullable|string',

            'references' => 'required|array|min: 1',
            'references.*.name' => 'required|string',
            'references.*.mobile' => [
                'required',
                'string',
                'max: 20',
                'regex:/(^((?:\+88|88)?(01[3-9]\d{8}))$)|(^((\x{09EE}\x{09EE})|(\+\x{09EE}\x{09EE}))?[\x{09E6}-\x{09EF}]{11})$/u',
            ],
            'references.*.profession' => 'required|string',
            'bosot_vita_details' => 'nullable|string|max: 5000',
            'present_address' => 'nullable|string|max: 5000',
            'gurdian_khasland_details' => 'nullable|string|max: 5000',
            'nodi_vanga_family_details' => 'nullable|string|max: 5000',
            'freedom_fighters_details' => 'nullable|string|max: 5000',
            'khasland_details' => 'nullable|string|max: 5000',
            'expected_lands' => 'nullable|string|max: 100',
            'application_received_date' => 'nullable|date',
            'receipt_number' => 'nullable|string|max: 100',
            'status' => 'nullable|int',
        ];

        if ($request->identity_type == Landless::IDENTITY_TYPE_NID) {
            $rules['identity_number'] = [
                'required',
                'string',
                'regex:/(^[0-9]|[\x{09E6}-\x{09EF}]+$)/u',
            ];
        }
        if ($request->identity_type == Landless::IDENTITY_TYPE_NOT_AVAILABLE) {
            $rules['identity_number'] = [
                'nullable',
            ];
        }

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /**
         * @var Builder|LandAssignment $landAssignments
         */
        $landAssignments = LandAssignment::select(
            [
                'land_assignments.id as id',
                'land_assignments.meeting_id',
                'land_assignments.landless_application_id',
                'land_assignments.eight_register_id',
                'land_assignments.division_bbs_code',
                'land_assignments.district_bbs_code',
                'land_assignments.upazila_bbs_code',
                'land_assignments.jl_number',
                'land_assignments.khotian_number',
                'land_assignments.dag_number',
                'land_assignments.assigned_land_area',
                'land_assignments.assigned_land_side',
                'land_assignments.is_case_order_by_acland',
                'land_assignments.case_number',
                'land_assignments.is_scratch_map_created',
                'land_assignments.scratch_map_created_by',
                //'land_assignments.is_scratch_map_approved_by_kanungo',
                //'land_assignments.is_scratch_map_approved_by_acland',
                'land_assignments.is_jomabondi_order_by_acland',
                'land_assignments.is_jomabondi_fill_up_by_kanungo',
                'land_assignments.jomabondi_created_by',
                //'land_assignments.is_jomabondi_approved_by_surveyor',
                //'land_assignments.is_jomabondi_approved_by_tofsildar',
                //'land_assignments.is_jomabondi_approved_by_acland',
                //'land_assignments.is_approved_by_acland',
                //'land_assignments.is_approved_by_uno',
                //'land_assignments.is_approved_by_dc',
                'land_assignments.is_salami_received',
                'land_assignments.is_salami_receipt_provided',
                'land_assignments.is_order_kabuliat',
                'land_assignments.remark',
                'land_assignments.status',
                'land_assignments.stage',

                'landless_applications.fullname',
                'landless_applications.mobile',
                'landless_applications.email',
                'landless_applications.identity_number',
                'landless_applications.gender',
                'loc_divisions.title as division_title_bn',
                'loc_districts.title as district_title_bn',
                'loc_upazilas.title as upazila_title_bn',
                'loc_all_moujas.name_bd as mouja_name_bn',
            ]
        );

        $jurisdictionConditions = Landless::getJurisditionConditions($authUser);

        $landAssignments = $landAssignments->join('landless_applications', 'landless_applications.id', '=', 'land_assignments.landless_application_id')
            ->where($jurisdictionConditions);

        $landAssignments->join('loc_divisions', 'land_assignments.division_bbs_code', '=', 'loc_divisions.bbs_code');
        $landAssignments->join('loc_districts', 'land_assignments.district_bbs_code', '=', 'loc_districts.bbs_code');
        $landAssignments = $landAssignments->join('loc_upazilas', function ($join) use ($authUser) {
            $join->on('land_assignments.division_bbs_code', '=', 'loc_upazilas.division_bbs_code');
            $join->on('land_assignments.district_bbs_code', '=', 'loc_upazilas.district_bbs_code');
            $join->on('land_assignments.upazila_bbs_code', '=', 'loc_upazilas.bbs_code');
        });

        $landAssignments = $landAssignments->leftJoin('loc_all_moujas', function ($join) use ($authUser) {
            $join->on('land_assignments.division_bbs_code', '=', 'loc_all_moujas.division_bbs_code');
            $join->on('land_assignments.district_bbs_code', '=', 'loc_all_moujas.district_bbs_code');
            $join->on('land_assignments.upazila_bbs_code', '=', 'loc_all_moujas.upazila_bbs_code');
            $join->on('land_assignments.jl_number', '=', 'loc_all_moujas.brs_jl_no');
        });

        return DataTables::eloquent($landAssignments)
            ->addColumn('action', DatatableHelper::getActionButtonBlockDropDown(static function (LandAssignment $landAssignment) use ($authUser) {
                $str = '';

                if ($authUser->can('view', app(Landless::class))) {
                    $str .= '<a href="' . route('admin.landless.show', $landAssignment->landless_application_id) . '" class="btn btn-outline-info btn-sm mb-1"> <i class="fas fa-eye"></i> ' . __('generic.show_button_label') . '</a>';
                }

                if ($authUser->can('create', app(ScratchMap::class))) {
                    if ($landAssignment->stage == LandAssignment::STAGE_INITIAL) {
                        $str .= '<a href="' . route('admin.landless.show', $landAssignment->landless_application_id) . '" class="btn btn-outline-warning btn-sm mb-1"> <i class="fas fa-eye"></i> ' . __('generic.create_scratch_map') . '</a>';
                    }
                }

                if ($landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_CREATED_BY_SURVEYOR || $landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_CORRECTION_BY_SURVEYOR) {
                    if ($authUser->can('scratchMapApproveByKanungo', app(LandAssignment::class))) {
                        $str .= '<a href="#" data-action="' . route('admin.land-assignments.approve-scratch-map', $landAssignment->id) . '" class="btn btn-outline-success btn-sm mb-1 approve-scratch-map"> <i class="fas fa-eye"></i> ' . __('generic.approve_sratch_map') . '</a>';
                    }

                    if ($authUser->can('scratchMapRejectByKanungo', app(LandAssignment::class))) {
                        $str .= '<a href="#" data-action="' . route('admin.land-assignments.approve-scratch-map', $landAssignment->id) . '" class="btn btn-outline-danger btn-sm mb-1 reject-scratch-map"> <i class="fas fa-eye"></i> ' . __('generic.reject_sratch_map') . '</a>';
                    }
                }

                if ($landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_APPROVED_BY_KANUNGO) {
                    if ($authUser->can('scratchMapApproveByAcLand', app(LandAssignment::class))) {
                        $str .= '<a href="#" data-action="' . route('admin.land-assignments.approve-scratch-map', $landAssignment->id) . '" class="btn btn-outline-success btn-sm mb-1 approve-scratch-map"> <i class="fas fa-eye"></i> ' . __('generic.approve_sratch_map') . '</a>';
                    }

                    if ($authUser->can('scratchMapRejectByAcLand', app(LandAssignment::class))) {
                        $str .= '<a href="#" data-action="' . route('admin.land-assignments.approve-scratch-map', $landAssignment->id) . '" class="btn btn-outline-danger btn-sm mb-1 reject-scratch-map"> <i class="fas fa-eye"></i> ' . __('generic.reject_sratch_map') . '</a>';
                    }
                }

                if ($authUser->can('update', app(ScratchMap::class))) {
                    if ($landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_REJECTED_BY_KANUNGO || $landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_REJECTED_BY_ACLAND) {
                        $str .= '<a href="" class="btn btn-outline-warning btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.scratch_map_correction') . '</a>';
                    }
                }

                //TODO need jomabondi policy implement here
                if ($authUser->can('jomabondiFillUp', app(LandAssignment::class))) {
                    if ($landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_APPROVED_BY_ACLAND) {
                        $str .= '<a href="#" class="btn btn-outline-secondary btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.fill_up_jomabondi') . '</a>';
                    }
                }

                if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_CREATED_BY_KANUNGO || $landAssignment->stage == LandAssignment::STAGE_JOMABONDI_CORRECTION_BY_KANUNGO) {
                    if ($authUser->can('jomabondiApproveBySurveyor', app(LandAssignment::class))) {
                        $str .= '<a href="" class="btn btn-outline-success btn-sm mb-1 approve-jomabondi"> <i class="fas fa-eye"></i> ' . __('generic.approve_jomabondi') . '</a>';
                    }

                    if ($authUser->can('jomabondiRejectBySurveyor', app(LandAssignment::class))) {
                        $str .= '<a href="#" class="btn btn-outline-danger btn-sm mb-1 reject-scratch-map"> <i class="fas fa-eye"></i> ' . __('generic.reject_jomabondi') . '</a>';
                    }
                }

                if ($authUser->can('jomabondiCorrection', app(LandAssignment::class))) {
                    if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_REJECTED_BY_SURVEYOR || $landAssignment->stage == LandAssignment::STAGE_JOMABONDI_REJECTED_BY_ACLAND) {
                        $str .= '<a href="#" class="btn btn-outline-warning btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.jomabondi_correction') . '</a>';
                    }
                }

                if ($authUser->can('jomabondiApproveByTofsildar', app(LandAssignment::class))) {
                    if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_APPROVED_BY_SURVEYOR) {
                        $str .= '<a href="" class="btn btn-outline-secondary btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.jomabondi_tofsildar_send_to_acland') . '</a>';
                    }
                }


                if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_TOFSILDAR_SEND_TO_ACLAND) {
                    if ($authUser->can('jomabondiApproveByAcLand', app(LandAssignment::class))) {
                        $str .= '<a href="" class="btn btn-outline-success btn-sm mb-1 approve-jomabondi"> <i class="fas fa-eye"></i> ' . __('generic.approve_jomabondi') . '</a>';
                    }

                    if ($authUser->can('jomabondiRejectByAcLand', app(LandAssignment::class))) {
                        $str .= '<a href="#" class="btn btn-outline-danger btn-sm mb-1 reject-scratch-map"> <i class="fas fa-eye"></i> ' . __('generic.reject_jomabondi') . '</a>';
                    }
                }

                if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_APPROVED_BY_ACLAND) {
                    $str .= '<a href="" class="btn btn-outline-secondary btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.uno_approval') . '</a>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_APPROVED_BY_UNO) {
                    $str .= '<a href="" class="btn btn-outline-secondary btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.dc_approval') . '</a>';
                }


                return $str;
            }))
            ->addColumn('gender', function (LandAssignment $landAssignment) use ($authUser) {
                $str = '';
                $str .= !empty($landAssignment->gender) ? __('generic.' . Landless::GENDER[$landAssignment->gender]) : '';
                return $str;
            })
            ->addColumn('stage_title', function (LandAssignment $landAssignment) use ($authUser) {
                $statusMsg = '';
                if ($landAssignment->stage == LandAssignment::STAGE_INITIAL) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_scratch_map_create") . '</span>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_CREATED_BY_SURVEYOR || $landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_CORRECTION_BY_SURVEYOR) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_scratch_map_kanungo_approval") . '</span>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_APPROVED_BY_KANUNGO) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_scratch_map_acland_approval") . '</span>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_REJECTED_BY_KANUNGO || $landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_REJECTED_BY_ACLAND) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_scratch_map_correction") . '</span>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_SCRATCH_MAP_APPROVED_BY_ACLAND) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.jomabondi_ordered") . '</span>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_CREATED_BY_KANUNGO || LandAssignment::STAGE_JOMABONDI_CORRECTION_BY_KANUNGO) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_jomabondi_surveyor_approval") . '</span>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_REJECTED_BY_SURVEYOR || $landAssignment->stage == LandAssignment::STAGE_JOMABONDI_REJECTED_BY_ACLAND) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_jomabondi_correction") . '</span>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_APPROVED_BY_SURVEYOR) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_jomabondi_tofsildar_approval") . '</span>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_TOFSILDAR_SEND_TO_ACLAND) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_jomabondi_acland_approval") . '</span>';
                }
                if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_REJECTED_BY_SURVEYOR || $landAssignment->stage == LandAssignment::STAGE_JOMABONDI_REJECTED_BY_ACLAND) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_jomabondi_correction") . '</span>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_JOMABONDI_APPROVED_BY_ACLAND) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_uno_approval") . '</span>';
                }

                if ($landAssignment->stage == LandAssignment::STAGE_APPROVED_BY_UNO) {
                    $statusMsg = '<span class="badge badge-warning w-100 py-2">' . __("generic.waiting_for_dc_approval") . '</span>';
                }
                return $statusMsg;
            })
            ->addColumn('status_title', function (LandAssignment $landAssignment) use ($authUser) {
                $str = '';
                $str .= '<span class="badge badge-info w-100">' . (__(!empty(LandAssignment::STATUS[$landAssignment->status]) ? 'generic.' . LandAssignment::STATUS[$landAssignment->status] : '')) . '</span>';
                return $str;
            })
            ->rawColumns(['action', 'loc_upazila_title', 'loc_union_title', 'mouja_name', 'status_title', 'stage_title'])
            ->toJson();
    }

    public function scratchMapApproveByKanungoOrAcLand(LandAssignment $landAssignment): bool
    {
        $authUser = AuthHelper::getAuthUser();
        if ($authUser->isKanungoUser() && $landAssignment->is_scratch_map_created) {
            $data['is_scratch_map_approved_by_kanungo'] = 1;
        } else if ($authUser->isAcLandUser() && $landAssignment->is_scratch_map_approved_by_kanungo) {
            $data['is_scratch_map_approved_by_acland'] = 1;
        }

        return $landAssignment->update($data);
    }

}
