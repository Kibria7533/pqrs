<?php

namespace Modules\Khotian\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\NumberToBanglaWord;
use App\Models\Office;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Khotian\App\Models\EightRegister;
use Modules\Khotian\App\Models\MutedKhotian;
use Modules\Khotian\App\Models\MutedKhotianDump;
use PhpParser\Builder;
use Yajra\DataTables\Facades\DataTables;

class AcLandApprovedKhotianService
{
    public function createEightRegister(Request $request, $khotianId, array $data)
    {
        $allData = $data['khotian_dag'];

        $authUser = AuthHelper::getAuthUser();
        $userOffice = Office::where('id', $authUser->office_id)->first();
        $tables = MutedKhotianDump::getTableName($userOffice->division_bbs_code);
        $khotianTalbe = $tables['khotian'];
        $khotianDagTalbe = $tables['khotian_dag'];
        $muetdKhotianModel = new MutedKhotian();
        $muetdKhotianModel->setTable($khotianTalbe);
        $khotian = $muetdKhotianModel->find($khotianId);

        foreach ($allData as $key => $value) {

            $data = [
                'register_type' => $request->register_type,
                'office_id' => $request->office_id,
                'khotian_dag_id' => $value['khotian_dag_id'],
                'khotian_number' => $khotian->khotian_number,
                'division_bbs_code' => $khotian->division_bbs_code,
                'district_bbs_code' => $khotian->district_bbs_code,
                'upazila_bbs_code' => $khotian->upazila_bbs_code,
                'jl_number' => $khotian->jl_number,
                'dag_number' => $value['dag_number'],
                'khotian_dag_area' => NumberToBanglaWord::bnToEn($value['khotian_dag_area']),
                'dag_khasland_area' =>  NumberToBanglaWord::bnToEn($value['dag_khasland_area']),
                'register_khasland_area' =>  NumberToBanglaWord::bnToEn($value['register_khasland_area']),
                'remaining_khasland_area' =>  NumberToBanglaWord::bnToEn($value['register_khasland_area']),
                'details' => $value['details'],
                'register_entry_date' => $value['register_entry_date'],
                'visit_date' => $value['visit_date'],
                'register_12_case_number' => $value['register_12_case_number'],
                'register_12_distribution_date' => $value['register_12_distribution_date'],
                'remark' => $value['remark'],
                'status' => !empty($request->save_as) ? EightRegister::SAVE_AS_DRAFT : EightRegister::ON_PROGRESS,
            ];

            EightRegister::updateOrCreate(
                [
                    'khotian_number' => $khotian->khotian_number,
                    'division_bbs_code' => $khotian->division_bbs_code,
                    'district_bbs_code' => $khotian->district_bbs_code,
                    'upazila_bbs_code' => $khotian->upazila_bbs_code,
                    'jl_number' => $khotian->jl_number,
                    'register_type' => $request->register_type,
                    'khotian_dag_id' => $value['khotian_dag_id'],
                    'dag_number' => $value['dag_number'],
                ], $data
            );
        }

    }

    public function registerEightValidator(Request $request): Validator
    {
        $authUser = AuthHelper::getAuthUser();
        $userOffice = Office::where('id', $authUser->office_id)->first();
        $tables = MutedKhotianDump::getTableName($userOffice->division_bbs_code);
        $khotianTalbe = $tables['khotian'];
        $khotianDagTalbe = $tables['khotian_dag'];

        $rules = [
            'register_type' => 'required|int',
            'office_id' => 'required|int|exists:offices,id',
            'khotian_dag' => 'required|array|min:1',
            'khotian_dag.*.khotian_dag_id' => 'required|exists:'.$khotianDagTalbe.',id',
            'khotian_dag.*.dag_number' => 'required|exists:'.$khotianDagTalbe.',dag_number',
            'khotian_dag.*.khotian_dag_area' => 'required|string',
            'khotian_dag.*.dag_khasland_area' => 'required|string',
            'khotian_dag.*.register_khasland_area' => 'required|string',
            'khotian_dag.*.details' => 'required|string',
            'khotian_dag.*.register_entry_date' => 'required|date|date_format:Y-m-d',
            'khotian_dag.*.visit_date' => 'nullable|date|date_format:Y-m-d',
            'khotian_dag.*.register_12_case_number' => 'required|string',
            'khotian_dag.*.register_12_distribution_date' => 'required|date|date_format:Y-m-d',
            'khotian_dag.*.remark' => 'nullable|string',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {

        /**
         * searchBy Bn also
        **/
        $request->request->add(['search' => [
            "value" => !empty($request['search']['value']) ? bn2en($request['search']['value']):'',
            "regex" => $request['search']['regex'],
        ]]);

        $authUser = AuthHelper::getAuthUser();
        $userOffice = Office::where('id', $authUser->office_id)->first();

        if (empty($userOffice->division_bbs_code)) {
            return response()->json([], 500);
        }

        $tables = MutedKhotianDump::getTableName($userOffice->division_bbs_code);
        $khotianTalbe = $tables['khotian'];
        $muetdKhotianModel = new MutedKhotian();
        $muetdKhotianModel->setTable($khotianTalbe);

        /** @var Builder $users */
        $khotians = $muetdKhotianModel->select([
            $khotianTalbe . '.id as id',
            $khotianTalbe . '.khotian_number',
            'loc_divisions.title as division_name',
            'loc_districts.title as disrict_name',
            'loc_upazilas.title as upazila_name',
            'loc_all_moujas.name_bd as mouza_name',
            $khotianTalbe . '.dglr_code',
            $khotianTalbe . '.jl_number',
            $khotianTalbe . '.resa_no',
            $khotianTalbe . '.namjari_case_no',
            $khotianTalbe . '.case_date',
            $khotianTalbe . '.total_land',
            $khotianTalbe . '.scan_copy',
            $khotianTalbe . '.status'
        ]);

        /** relations */
        $khotians->leftJoin('loc_divisions', $khotianTalbe . '.division_bbs_code', '=', 'loc_divisions.bbs_code');
        $khotians->leftJoin('loc_districts', $khotianTalbe . '.district_bbs_code', '=', 'loc_districts.bbs_code');
        $khotians->leftJoin('loc_upazilas', $khotianTalbe . '.upazila_bbs_code', '=', 'loc_upazilas.bbs_code');
        $khotians->leftJoin('loc_all_moujas', function ($join) use ($userOffice, $khotianTalbe) {
            $join->on($khotianTalbe . '.division_bbs_code', '=', 'loc_all_moujas.division_bbs_code');
            $join->on($khotianTalbe . '.district_bbs_code', '=', 'loc_all_moujas.district_bbs_code');
            $join->on($khotianTalbe . '.upazila_bbs_code', '=', 'loc_all_moujas.upazila_bbs_code');
            $join->on($khotianTalbe . '.jl_number', '=', 'loc_all_moujas.brs_jl_no');
        });
        $khotians->where($khotianTalbe . '.division_bbs_code', $userOffice->division_bbs_code);
        $khotians->where($khotianTalbe . '.district_bbs_code', $userOffice->district_bbs_code);
        $khotians->where($khotianTalbe . '.upazila_bbs_code', $userOffice->upazila_bbs_code);
        $khotians->where($khotianTalbe . '.status', MutedKhotian::PUBLISHED);

        $khotians->groupBy($khotianTalbe . '.district_bbs_code', $khotianTalbe . '.upazila_bbs_code', $khotianTalbe . '.jl_number', $khotianTalbe . '.khotian_number');

        return DataTables::eloquent($khotians)
            ->editColumn('khotian_number', function (MutedKhotian $khotian) use ($authUser) {
                return NumberToBanglaWord::engToBn($khotian->khotian_number);
            })
            ->editColumn('dglr_code', function (MutedKhotian $khotian) use ($authUser) {
                return NumberToBanglaWord::engToBn($khotian->dglr_code);
            })
            ->editColumn('jl_number', function (MutedKhotian $khotian) use ($authUser) {
                return NumberToBanglaWord::engToBn($khotian->jl_number);
            })
            ->editColumn('resa_no', function (MutedKhotian $khotian) use ($authUser) {
                return NumberToBanglaWord::engToBn($khotian->resa_no);
            })
            ->editColumn('case_date', function (MutedKhotian $khotian) use ($authUser) {
                return NumberToBanglaWord::engToBn($khotian->case_date);
            })
            ->addColumn('action', DatatableHelper::getActionButtonBlockDropDown(function (MutedKhotian $khotian) use ($authUser) {
                $str = "";
                if ($authUser->can('create', app(EightRegister::class))) {
                    $str .= ' <a class="btn btn-sm btn-warning" href="' . route('admin.khotians.register-eight.create', $khotian->id) . '?type=1"><i class="fas fa-plus-circle"></i> ' . __('জনগণের ব্যবহৃত বন্দোবস্তযোগ্য নহে') . '</a>';
                    $str .= '<a class="btn btn-sm btn-info" href="' . route('admin.khotians.register-eight.create', $khotian->id) . '?type=2"><i class="fas fa-plus-circle"></i> '. __('বন্দোবস্তযোগ্য').'</a>';
                    $str .= ' <a class="btn btn-sm btn-warning view" href="' . route('admin.khotians.register-eight.create', $khotian->id) . '?type=3"><i class="fas fa-plus-circle"></i> ' . __('ক্রীত, পুনঃগ্রহনকৃত ও পরিব্যক্ত') . '</a>';
                    $str .= '<a class="btn btn-sm btn-info" href="' . route('admin.khotians.register-eight.create', $khotian->id) . '?type=4"><i class="fas fa-plus-circle"></i> '. __('সিকস্তি জমি').'</a>';
                    //$str .= '<a class="btn btn-sm btn-info" href="' . route('admin.khotians.update-on-register-8.details', $khotian->id) . '"><i class="fas fa-eye"></i> '. __('View Details').'</a>';
                }
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

    public function approveEightRegister(Request $request, $khotianId):bool
    {
        $authUser = AuthHelper::getAuthUser();
        $userOffice = Office::where('id', $authUser->office_id)->first();
        $tables = MutedKhotianDump::getTableName($userOffice->division_bbs_code);
        $khotianTalbe = $tables['khotian'];
        $khotianDagTalbe = $tables['khotian_dag'];
        $muetdKhotianModel = new MutedKhotian();
        $muetdKhotianModel->setTable($khotianTalbe);
        $khotian = $muetdKhotianModel->find($khotianId);

        $reg8Type = !empty($request->type) ? $request->type : null;

        $reg8Dags = EightRegister::where([
            'khotian_number' => $khotian->khotian_number,
            'division_bbs_code' => $khotian->division_bbs_code,
            'district_bbs_code' => $khotian->district_bbs_code,
            'upazila_bbs_code' => $khotian->upazila_bbs_code,
            'jl_number' => $khotian->jl_number,
            'register_type' => $reg8Type,
        ])->get();

        foreach ($reg8Dags as $key=>$reg8Dag){
            EightRegister::where('id', $reg8Dag->id)->update(['status' => EightRegister::PUBLISHED]);
        }

        return true;
    }

    public function rejectEightRegister(Request $request, $khotianId):bool
    {
        $authUser = AuthHelper::getAuthUser();
        $userOffice = Office::where('id', $authUser->office_id)->first();
        $tables = MutedKhotianDump::getTableName($userOffice->division_bbs_code);
        $khotianTalbe = $tables['khotian'];
        $khotianDagTalbe = $tables['khotian_dag'];
        $muetdKhotianModel = new MutedKhotian();
        $muetdKhotianModel->setTable($khotianTalbe);
        $khotian = $muetdKhotianModel->find($khotianId);

        $reg8Type = !empty($request->type) ? $request->type : null;

        $reg8Dags = EightRegister::where([
            'khotian_number' => $khotian->khotian_number,
            'division_bbs_code' => $khotian->division_bbs_code,
            'district_bbs_code' => $khotian->district_bbs_code,
            'upazila_bbs_code' => $khotian->upazila_bbs_code,
            'jl_number' => $khotian->jl_number,
            'register_type' => $reg8Type,
        ])->get();

        foreach ($reg8Dags as $key=>$reg8Dag){
            EightRegister::where('id', $reg8Dag->id)->update(['status' => EightRegister::MODIFY]);
        }
        return true;
    }
}
