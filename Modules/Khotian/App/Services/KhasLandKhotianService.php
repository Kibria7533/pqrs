<?php

namespace Modules\Khotian\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Models\BaseModel;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Modules\Khotian\App\Models\KhasLandKhotian;
use Modules\Khotian\App\Models\KhasLandKhotianDag;
use Modules\Khotian\App\Models\KhasLandKhotianOwner;
use Yajra\DataTables\Facades\DataTables;

class KhasLandKhotianService
{
    public function createKhasLandKhotian(array $data)
    {
        $owners = !empty($data['owners']) ? $data['owners'] : [];
        $dags = !empty($data['owners']) ? $data['dags'] : [];

        $khasLandKhotianData = [
            'khotian_number'=> !empty($data['khotian_number'])?$data['khotian_number']:'',
            'division_bbs_code'=> !empty($data['division_bbs_code'])?$data['division_bbs_code']:'',
            'district_bbs_code'=> !empty($data['district_bbs_code'])?$data['district_bbs_code']:'',
            'upazila_bbs_code'=> !empty($data['upazila_bbs_code'])?$data['upazila_bbs_code']:'',
            'dglr_code'=> !empty($data['dglr_code'])?$data['dglr_code']:'',
            'jl_number'=> !empty($data['jl_number'])?$data['jl_number']:'',
            'resa_no'=> !empty($data['resa_no'])?$data['resa_no']:'',
            'base_survey_type'=> !empty($data['base_survey_type'])?$data['base_survey_type']:null,
            'namjari_case_no'=> !empty($data['namjari_case_no'])?$data['namjari_case_no']:'',
            'case_date'=> !empty($data['case_date'])?$data['case_date']:null,
            'revenue'=> !empty($data['revenue'])?$data['revenue']:'',
            'dcr_number'=> !empty($data['dcr_number'])?$data['dcr_number']:'',
            'has_dhara'=> !empty($data['has_dhara'])?$data['has_dhara']:'',
            'dhara_no'=> !empty($data['dhara_no'])?$data['dhara_no']:'',
            'mokoddoma_no'=> !empty($data['mokoddoma_no'])?$data['mokoddoma_no']:'',
            'dhara_year'=> !empty($data['dhara_year'])?$data['dhara_year']:null,
            'scan_copy'=> !empty($data['scan_copy'])?$data['scan_copy']:null,
            'agoto_khotian_type'=> !empty($data['agoto_khotian_type'])?$data['agoto_khotian_type']:null,
            'agoto_khotian_no'=> !empty($data['agoto_khotian_no'])?$data['agoto_khotian_no']:null,
            'next_khatian_no'=> !empty($data['next_khatian_no'])?$data['next_khatian_no']:'',
            'total_land'=> !empty($data['total_land'])?$data['total_land']:'',
            'remaining_land'=> !empty($data['remaining_land'])?$data['remaining_land']:'',
            'source_type'=> 'eporcha',

            'signature_one_name'=> !empty($data['signature_one_name'])?$data['signature_one_name']:'',
            'signature_one_date'=> !empty($data['signature_one_date'])?$data['signature_one_date']:null,
            'signature_one_designation'=> !empty($data['signature_one_designation'])?$data['signature_one_designation']:null,
            'signature_two_name'=> !empty($data['signature_two_name'])?$data['signature_two_name']:'',
            'signature_two_date'=> !empty($data['signature_two_date'])?$data['signature_two_date']:null,
            'signature_two_designation'=> !empty($data['signature_two_designation'])?$data['signature_two_designation']:null,
            'signature_three_name'=> !empty($data['signature_three_name'])?$data['signature_three_name']:'',
            'signature_three_date'=> !empty($data['signature_three_date'])?$data['signature_three_date']:null,
            'signature_three_designation'=> !empty($data['signature_three_designation'])?$data['signature_three_designation']:null,
            'system_type'=> 'eporcha',
        ];

        DB::beginTransaction();

        try {
            $lastkhasLandKhotianId = DB::table('division20_khotians')->insertGetId($khasLandKhotianData);
            foreach ($owners as $key => $value) {
                $dob = !empty($value['dob']) ? ($this->isValidDate($value['dob']) ? $value['dob'] : null) : null;
                $ownersData['muted_khotian_id'] = $lastkhasLandKhotianId;
                $ownersData['khotian_number'] = !empty($data['khotian_number'])?$data['khotian_number']:'';
                $ownersData['owner_name'] = !empty($value['owner_name']) ? $value['owner_name'] : '';
                $ownersData['owner_no'] = !empty($value['owner_no']) ? $value['owner_no'] : '';
                $ownersData['owner_group'] = !empty($value['owner_group']) ? $value['owner_group'] : '';
                //$ownersData['owner_type_id'] = !empty($value['owner_type_id']) ? $value['owner_type_id'] : null;
                $ownersData['owner_area'] = !empty($value['owner_area']) ? $value['owner_area'] : '';
                $ownersData['guardian_type'] = !empty($value['guardian_type']) ? $value['guardian_type'] : null;
                $ownersData['guardian'] = !empty($value['guardian']) ? $value['guardian'] : '';
                $ownersData['mother_name'] = !empty($value['mother_name']) ? $value['mother_name'] : '';
                $ownersData['owner_address'] = !empty($value['owner_address']) ? $value['owner_address'] : '';
                $ownersData['owner_address_pdf'] = !empty($value['owner_address']) ? $value['owner_address'] : '';
                $ownersData['owner_mobile'] = !empty($value['owner_mobile']) ? $value['owner_mobile'] : '';
                $ownersData['identity_type'] = !empty($value['identity_type']) ? $value['identity_type'] : null;
                $ownersData['identity_number'] = !empty($value['identity_number']) ? $value['identity_number'] : '';
                $ownersData['dob'] = $dob;
                DB::table('division20_khatian_owners')->insert($ownersData);
            }

            foreach ($dags as $key => $value) {
                $dagsData['muted_khotian_id'] = $lastkhasLandKhotianId;
                $dagsData['khotian_number'] = !empty($data['khotian_number'])?$data['khotian_number']:'';
                $dagsData['dag_number'] = !empty($value['dag_number']) ? $value['dag_number'] : '';
                $dagsData['total_dag_area'] = !empty($value['total_dag_area']) ? $value['total_dag_area'] : '';
                $dagsData['khotian_dag_area'] = !empty($value['khotian_dag_area']) ? $value['khotian_dag_area'] : '';
                $dagsData['khotian_dag_portion'] = !empty($value['khotian_dag_portion']) ? $value['khotian_dag_portion'] : '';
                $dagsData['land_owner_type_id'] = !empty($value['land_owner_type_id']) ? $value['land_owner_type_id'] : null;
                $dagsData['agricultural_use'] = !empty($value['agricultural_use']) ? $value['agricultural_use'] : '';
                $dagsData['land_type_id'] = !empty($value['land_type_id']) ? $value['land_type_id'] : '';
                $dagsData['land_type'] = !empty($value['land_type']) ? $value['land_type'] : '';
                $dagsData['remark'] = !empty($value['remark']) ? $value['remark'] : '';
                DB::table('division20_khatian_dags')->insert($dagsData);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function validator($data)
    {
        $a = $data['khotian_info'];
        $b = $data['dags'];
        $c = $data['owners'];

        $data = array_merge($a, ['dags' => $b, 'owners' => $c]);

        $rules = [
            'khotian_number' => [
                'required',
                'integer',
                Rule::unique('division20_khotians')
                    ->where('district_bbs_code', $data['district_bbs_code'])
                    ->where('upazila_bbs_code', $data['upazila_bbs_code'])
                    ->where('jl_number', $data['jl_number'])
            ],
            'jl_number' => 'required|int|min:1',
            'resa_no' => 'nullable|string',
            'namjari_case_no' => 'nullable|string',
            'case_date' => 'nullable|date|before:today+1',
            'has_dhara' => 'nullable|boolean',
            'dhara_no' => !empty($data['has_dhara']) ? 'required|string' : 'nullable|string',
            'dhara_year' => !empty($data['has_dhara']) ? 'required|numeric|min:1800|max:' . Carbon::now()->format('Y') : 'nullable|numeric|min:1800|max:' . Carbon::now()->format('Y'),
            'mokoddoma_no' => 'nullable|string',
            'revenue' => 'nullable |string',
            'dcr_number' => 'nullable|string',
            'dglr_code' => 'nullable|string',
            'upazila_name' => 'nullable|string',
            'district_name' => 'nullable|string',
            'division_bbs_code' => 'required|exists:loc_divisions,bbs_code',
            'district_bbs_code' => 'required|exists:loc_districts,bbs_code',
            'upazila_bbs_code' => 'required|exists:loc_upazilas,bbs_code',
            'owners' => 'required|array|min:1',
            'owners.owner_no.*' => 'required|int|min:1',
            'owners.owner_name.*' => 'required|string',
            'owners.guardian_type.*' => 'required|int|between:0,1',//todo
            'owners.guardian.*' => 'required|string',
            'owners.mother_name.*' => 'nullable|string',
            'owners.owner_area.*' => 'required|numeric|gt:0|lte:1',
            'owners.owner_group.*' => 'nullable|numeric|min:1|max:127',
            'owners.owner_mobile.*' => [
                'nullable',
                'string',
                'regex:/(^((?:\+88|88)?(01[3-9]\d{8}))$)|(^((\x{09EE}\x{09EE})|(\+\x{09EE}\x{09EE}))?[\x{09E6}-\x{09EF}]{11})$/u',
            ],
            'owners.identity_type.*' => 'required|int|min:1',
            'owners.identity_number.*' => 'nullable|string',
            'owners.dob.*' => 'nullable|date',
            'owners.owner_address.*' => 'required|string',
            'dags' => 'required|array|min:1',
            'dags.dag_number.*' => [
                'required',
                'string',
                'regex:/^[0-9\/]*$/u',
            ],
            'dags.land_owner_type_id.*' => 'required|int|min:1',
            'dags.agricultural_use.*' => 'nullable|boolean',
            'dags.agri_land_type.*' => 'nullable|int|min:1',
            'dags.non_agri_land_type.*' => 'nullable|int|min:1',
            'dags.total_dag_area.*' => 'required|numeric|min:0',
            'dags.khotian_dag_portion.*' => 'nullable|numeric|gt:0',
            'dags.khotian_dag_area.*' => 'required|numeric|gt:0|lte:1',
            'dags.remarks.*' => 'nullable|string',
            'signature_one_name' => 'nullable|string',
            'signature_one_date' => 'nullable|date',
            'signature_one_designation' => 'nullable|string',
            'signature_two_name' => 'nullable|string',
            'signature_two_date' => 'nullable|date',
            'signature_two_designation' => 'nullable|string',
            'signature_three_name' => 'nullable|string',
            'signature_three_date' => 'nullable|date',
            'signature_three_designation' => 'nullable|string',
            'scan_copy' => 'nullable|max:2000|mimes:jpg,pdf',
            'agoto_khotian_no' => 'nullable|string',
            'agoto_khotian_type' => 'nullable|string',
        ];


        /*$validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            dd($validator);
        }else{
            dd('all is okay');
        }*/

        return \Illuminate\Support\Facades\Validator::make($data, $rules);
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /**
         * @var Builder|KhasLandKhotian $khasLandKhotians
         */
        $khasLandKhotians = KhasLandKhotian::select(
            [
                'division20_khotians.id as id',
                'division20_khotians.khotian_number',
                'division20_khotians.division_bbs_code',
                'division20_khotians.district_bbs_code',
                'division20_khotians.upazila_bbs_code',
                'division20_khotians.dglr_code',
                'division20_khotians.jl_number',
                'division20_khotians.resa_no',
                'division20_khotians.base_survey_type',
                'division20_khotians.namjari_case_no',
                'division20_khotians.case_date',
                'division20_khotians.revenue',
                'division20_khotians.dcr_number',
                'division20_khotians.has_dhara',
                'division20_khotians.dhara_no',
                'division20_khotians.mokoddoma_no',
                'division20_khotians.dhara_year',
                'division20_khotians.scan_copy',
                'division20_khotians.agoto_khotian_type',
                'division20_khotians.agoto_khotian_no',
                'division20_khotians.next_khatian_no',
                'division20_khotians.total_land',
                'division20_khotians.remaining_land',
                'division20_khotians.source_type',
                'division20_khotians.status',
                'division20_khotians.stage',
                'loc_all_moujas.name_bd as mouja_title_bn',
                //'loc_upazilas.title as loc_upazila_title_bn',
            ]
        );

        $khasLandKhotians->where('division20_khotians.batch_entry', '==', 0);
        $khasLandKhotians->leftJoin('loc_all_moujas', 'loc_all_moujas.dglr_code', '=','division20_khotians.dglr_code');

        return DataTables::eloquent($khasLandKhotians)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (KhasLandKhotian $khasLandKhotian) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $khasLandKhotian)) {
                    $str .= '<a href="' . route('admin.khotians.khasland-khotians.show', $khasLandKhotian->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.show_button_label') . '</a>';
                }

                if ($authUser->can('singleApprove', $khasLandKhotian) && $khasLandKhotian->status != BaseModel::STATUS_ACTIVE) {
                    $str .= '<a href="#" data-action="' . route('admin.khotians.khasland-khotians.approve', $khasLandKhotian->id) . '" class="btn btn-outline-success btn-sm approve"> <i class="fas fa-check-circle"></i> ' . __('generic.approve') . '</a>';
                }
                return $str;
            }))
            ->addColumn('loc_upazila_title', function (KhasLandKhotian $khasLandKhotian) {
                return !empty($khasLandKhotian->upazila->title)?$khasLandKhotian->upazila->title:'';
            })
            ->addColumn('jl_number_and_mouja', function (KhasLandKhotian $khasLandKhotian) {
                return $khasLandKhotian->jl_number . " - " . $khasLandKhotian->mouja_title_bn;
            })
            ->addColumn('status', function (KhasLandKhotian $khasLandKhotian) {
                $str = '';
                if (!empty($khasLandKhotian->status)) {
                    $str .= '<span  class="badge ' . ($khasLandKhotian->status == BaseModel::STATUS_ACTIVE ? 'badge-success' : 'badge-warning') . '" style="min-width: 86px;">' . (__('generic.' . $khasLandKhotian->status != 1 ? __('generic.active') : __('generic.inactive'))) . '</span>';
                }
                return $str;
            })
            ->rawColumns(['action', 'status', 'loc_upazila_title', 'jl_number_and_mouja'])
            ->toJson();
    }

    public function approveKhasLandKhotian($khaslandKhotian)
    {
        $data['status'] = BaseModel::STATUS_ACTIVE;
        return $khaslandKhotian->update($data);
    }

    function isValidDate($date): bool
    {
        $format = 'Y-m-d'; // Eg : 2014-09-24 10:19 PM
        $dateTime = DateTime::createFromFormat($format, $date);

        if ($dateTime instanceof DateTime && $dateTime->format('Y-m-d') == $date) {
            return true;
        }

        return false;
    }

    public function validateKhaslandKhotianApproveNow(Request $request): Validator
    {
        $rules = [
            'khasland_khotian_ids' => [
                'bail', 'array', 'min:1'
            ],
            'khasland_khotian_ids.*' => 'required|exists:division20_khotians,id',
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function khaslandKhotianApprove(array $khaslandKhotianIds)
    {
        foreach ($khaslandKhotianIds as $khaslandKhotianId) {

            /**
             * @var KhasLandKhotian $khaslandKhotian
             */
            $khaslandKhotian = KhasLandKhotian::where('id', $khaslandKhotianId)->first();

            $data['status'] = BaseModel::STATUS_ACTIVE;

            try {
                $khaslandKhotian->update($data);
            } catch (\Throwable $exception) {
                Log::debug($exception->getMessage());
            }
        }
    }

}
