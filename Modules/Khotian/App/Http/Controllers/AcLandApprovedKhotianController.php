<?php

namespace Modules\Khotian\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\NumberToBanglaWord;
use App\Http\Controllers\Controller;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocMouja;
use App\Models\LocUpazila;
use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Khotian\App\Models\EightRegister;
use Modules\Khotian\App\Models\MutedKhotian;
use Modules\Khotian\App\Models\MutedKhotianDump;
use Modules\Khotian\App\Models\AcLandApprovedKhotian;
use Modules\Khotian\App\Services\AcLandApprovedKhotianService;
use Modules\Landless\App\Models\Landless;

class AcLandApprovedKhotianController extends Controller
{
    protected AcLandApprovedKhotianService $acLandApprovedKhotianService;
    private const VIEW_PATH = 'khotian::muted-khotian.ac-land-approved.';

    public function __construct(AcLandApprovedKhotianService $acLandApprovedKhotianService)
    {
        $this->acLandApprovedKhotianService = $acLandApprovedKhotianService;
        $this->authorizeResource(EightRegister::class);
    }

    public function index()
    {
        //$this->authorize('viewAny', EightRegister::class);
        $authUser = AuthHelper::getAuthUser();
        $userOffice = Office::where('id', $authUser->office_id)->first();
        $tables = MutedKhotianDump::getTableName($userOffice->division_bbs_code);
        $khotianTalbe = $tables['khotian'];


        try {
            $getDistrictBBS = Office::select(['district_bbs_code', 'upazila_bbs_code', 'division_bbs_code'])
                ->where('id', $authUser->office_id)
                ->first();
            $divisionBBS = $getDistrictBBS->divisionBBS;
            $districtBBS = $getDistrictBBS->district_bbs_code;

            $upazilas = LocUpazila::where('district_bbs_code', $districtBBS)
                ->where('status', 1)
                ->pluck('title', 'bbs_code');
            $upazilaBBS = $getDistrictBBS->upazila_bbs_code;
            $mouja = LocMouja::getMoujaOptions($districtBBS, $upazilaBBS, 'muted');// to get mouja values


        } catch (\Exception $exception) {

            Log::debug('Requested Khatian Index Error: ' . $exception->getMessage());
        }
        return view(self::VIEW_PATH . 'list', compact('districtBBS', 'upazilas', 'mouja', 'khotianTalbe'));
    }

    public function getDatatable(Request $request)
    {
        try {
            return $this->acLandApprovedKhotianService->getListDataForDatatable($request);
        } catch (\Exception $ex) {
            return response()->json([]);
        }
    }

    public function createPanel(Request $request, $khotianId)
    {
        $this->authorize('create', app(EightRegister::class));
        $authUser = AuthHelper::getAuthUser();
        $userOffice = Office::where('id', $authUser->office_id)->first();

        if (empty($userOffice->division_bbs_code)) {
            /*return response()->json([
                'message'=>"This page only for acland user"
            ], 500);*/

            abort(404);
        }

        $tables = MutedKhotianDump::getTableName(Landless::CTG_BBS_CODE);
        $khotianTalbe = $tables['khotian'];
        $khotianDagTalbe = $tables['khotian_dag'];
        $muetdKhotianModel = new MutedKhotian();
        $muetdKhotianModel->setTable($khotianTalbe);
        $khotian = $muetdKhotianModel->find($khotianId);

        $reg8Type = !empty($request->type) ? $request->type : null;
        $khotianDags = $muetdKhotianModel->setTable($khotianDagTalbe);
        $khotianDags = $khotianDags->where('muted_khotian_id', $khotianId)->get();


        $reg8Dags = EightRegister::where([
            'khotian_number' => $khotian->khotian_number,
            'division_bbs_code' => $khotian->division_bbs_code,
            'district_bbs_code' => $khotian->district_bbs_code,
            'upazila_bbs_code' => $khotian->upazila_bbs_code,
            'jl_number' => $khotian->jl_number,
            'register_type' => $reg8Type,
        ])->get();

        $reg8DagLandAlreadyEntry = EightRegister::where([
            'khotian_number' => $khotian->khotian_number,
            'division_bbs_code' => Landless::CTG_BBS_CODE,
            'district_bbs_code' => Landless::NOAKHALI_BBS_CODE,
            'upazila_bbs_code' => $khotian->upazila_bbs_code,
            'jl_number' => $khotian->jl_number,
        ])->pluck('dag_khasland_area', 'khotian_dag_id')->toArray();


        $upazila = LocUpazila::where([
            'division_bbs_code' => Landless::CTG_BBS_CODE,
            'district_bbs_code' => Landless::NOAKHALI_BBS_CODE,
            'bbs_code' => $userOffice->upazila_bbs_code,
        ])->first();

        $offices = Office::where([
            'division_bbs_code' => Landless::CTG_BBS_CODE,
            'district_bbs_code' => Landless::NOAKHALI_BBS_CODE,
            'upazila_bbs_code' => $userOffice->upazila_bbs_code,
            'jurisdiction' => 'union',
        ]);

        $reg8Status = null;
        if (count($reg8Dags)) {
            $reg8Status = $reg8Dags[0]['status'];
            $offices->where('id', $reg8Dags[0]['office_id']);
        }
        $offices = $offices->get();

        return view(self::VIEW_PATH . 'register-8.edit-add', compact('khotian', 'khotianDags', 'offices', 'upazila', 'reg8Type', 'reg8Dags', 'reg8Status', 'reg8DagLandAlreadyEntry'));
    }

    public function store(Request $request, $khotianId)
    {
        //dd($request->all());
        /**
         * Custom Validation
         **/
        if (!empty($request->khotian_dag)) {
            $reg8Type = !empty($request->type) ? $request->type : null;

            foreach ($request->khotian_dag as $key => $value) {
                $khotianDag = DB::table('division20_khatian_dags')
                    ->where('id', '=', $value['khotian_dag_id'])
                    ->first();

                $khotianDagArea = NumberToBanglaWord::engToBn($khotianDag->khotian_dag_portion);
                $sl = NumberToBanglaWord::engToBn($key);

                if ($khotianDag->khotian_dag_portion < $value['dag_khasland_area']) {
                    return response()->json([
                        'message' => __("প্রাপ্ত মোট খাস জমি [সারি-$sl] অবশ্যই দাগে মোট জমি $khotianDagArea এর চেয়ে ছোট অথবা সমান হতে হবে"),
                        'alertType' => 'error',
                    ], 200);
                }

                $reg8Dags = EightRegister::where('khotian_dag_id', $value['khotian_dag_id'])
                    ->whereNotIn('register_type', [$reg8Type])
                    ->get()->toArray();

                if (!empty($reg8Dags)) {
                    $sumRegisterKhaslandArea = array_sum(array_column($reg8Dags, 'register_khasland_area', 'id'));
                    $remainingRegisterKhaslandArea = NumberToBanglaWord::engToBn($value['dag_khasland_area'] - $sumRegisterKhaslandArea);
                    if ($value['register_khasland_area'] > $value['dag_khasland_area'] - $sumRegisterKhaslandArea) {
                        return response()->json([
                            'message' => __("রেজিস্টার অংশভুক্ত খাস জমি [সারি-$sl] অবশ্যই $remainingRegisterKhaslandArea এর চেয়ে ছোট অথবা সমান হতে হবে"),
                            'alertType' => 'error',
                        ], 200);
                    }
                } else {
                    $remainingRegisterKhaslandArea = NumberToBanglaWord::engToBn($value['dag_khasland_area']);
                    if ($value['dag_khasland_area'] < $value['register_khasland_area']) {
                        return response()->json([
                            'message' => __("রেজিস্টার অংশভুক্ত খাস জমি [সারি-$sl] অবশ্যই $remainingRegisterKhaslandArea এর চেয়ে ছোট অথবা সমান হতে হবে"),
                            'alertType' => 'error',
                        ], 200);
                    }
                }
            }
        }

        $validatedData = $this->acLandApprovedKhotianService->registerEightValidator($request);

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();

        try {
            $this->acLandApprovedKhotianService->createEightRegister($request, $khotianId, $data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json([
                'message' => __('generic.something_wrong_try_again') . $exception->getMessage(),
                'alertType' => 'error'
            ]);
        }
        return response()->json([
            'message' => __('Register-8 table updated successfully'),
            'alertType' => 'success',
            'redirectTo' => route('admin.khotians.acland-approved.index'),
        ]);

    }

    public function details(Request $request, $khotianId)
    {
        $authUser = AuthHelper::getAuthUser();
        $userOffice = Office::where('id', $authUser->office_id)->first();
        $tables = MutedKhotianDump::getTableName($userOffice->division_bbs_code);
        $khotianTalbe = $tables['khotian'];
        $khotianDagTalbe = $tables['khotian_dag'];
        $muetdKhotianModel = new MutedKhotian();
        $muetdKhotianModel->setTable($khotianTalbe);
        $khotian = $muetdKhotianModel->find($khotianId);
        $khotianDags = $muetdKhotianModel->setTable($khotianDagTalbe);
        $khotianDags = $khotianDags->where('muted_khotian_id', $khotianId)->get();

        return view(self::VIEW_PATH . 'register-8.details', compact('khotian'));

    }

    public function approve(Request $request, $khotianId): RedirectResponse
    {
        $this->authorize('approve', app(EightRegister::class));

        try {
            $this->acLandApprovedKhotianService->approveEightRegister($request, $khotianId);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again') . $exception->getMessage(),
                'alertType' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('Register-8 table approve successfully'),
            'alert-type' => 'success',
        ]);

    }

    public function reject(Request $request, $khotianId): RedirectResponse
    {
        $this->authorize('approve', app(EightRegister::class));

        try {
            $this->acLandApprovedKhotianService->rejectEightRegister($request, $khotianId);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again') . $exception->getMessage(),
                'alertType' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('Register-8 table rejected successfully'),
            'alert-type' => 'error',
        ]);

    }

    public function checkDagKhasLandArea(Request $request, $khotianId, $dagId): \Illuminate\Http\JsonResponse
    {
        $khotianDag = DB::table('division20_khatian_dags')
            ->where('id', '=', $dagId)
            ->first();

        $khotianDagPortion = $khotianDag->khotian_dag_portion;
        $dagKhaslandArea = $request->khotian_dag[$request->key]['dag_khasland_area'];

        $khotianDagArea = NumberToBanglaWord::engToBn($khotianDagPortion);
        if ($khotianDagPortion >= $dagKhaslandArea) {
            return response()->json(true);
        }

        return response()->json(__("অবশ্যই দাগে মোট জমি $khotianDagArea এর চেয়ে ছোট/সমান হতে হবে!"));

    }

    public function checkRegisterKhaslandArea(Request $request, $dagId): \Illuminate\Http\JsonResponse
    {
        $reg8Type = !empty($request->type) ? $request->type : null;

        $reg8Dags = EightRegister::where('khotian_dag_id', '=', $dagId)
            ->whereNotIn('register_type', [$reg8Type])
            ->get()->toArray();

        if (empty($request->dag_khasland_area)) {
            return response()->json(__("প্রাপ্ত মোট খাস জমি ঘরটি অবশ্যই পূরণ করতে হবে।"));
        }


        if (!empty($reg8Dags)) {
            $sumRegisterKhaslandArea = array_sum(array_column($reg8Dags, 'register_khasland_area', 'id'));
            $dagKhaslandArea = collect(array_column($reg8Dags, 'dag_khasland_area', 'id'))->first();
            $remainingRegisterKhaslandArea = (double)($dagKhaslandArea - $sumRegisterKhaslandArea);

            //dd(bccomp($request->khotian_dag[$request->key]['register_khasland_area'], $remainingRegisterKhaslandArea, 2));
            //dd((double)$request->khotian_dag[$request->key]['register_khasland_area']- $remainingRegisterKhaslandArea);
            /*dd((double)$request->khotian_dag[$request->key]['register_khasland_area'] + 100 > $remainingRegisterKhaslandArea + 100);
            dd($remainingRegisterKhaslandArea + 100 < (double)$request->khotian_dag[$request->key]['register_khasland_area'] + 100);*/
            if ((double)$request->khotian_dag[$request->key]['register_khasland_area'] + 100 > $remainingRegisterKhaslandArea + 100) {
                if ($remainingRegisterKhaslandArea) {
                    return response()->json(__("রেজিস্টার অংশভুক্ত খাস জমি অবশ্যই $remainingRegisterKhaslandArea এর চেয়ে ছোট অথবা সমান হতে হবে"));
                } else {
                    return response()->json(__("ইতিমধ্যে সমস্ত রেজিস্টার অংশভুক্ত খাস জমি  আপডেট করা হয়েছে"));
                }
            } else {
                return response()->json(true);
            }
        } else {
            /**
             * add 100 for
            **/
            $remainingRegisterKhaslandArea = NumberToBanglaWord::engToBn($request->dag_khasland_area);
            if ((double)$request->khotian_dag[$request->key]['register_khasland_area']+100 > $request->dag_khasland_area+100) {
                return response()->json(__("রেজিস্টার অংশভুক্ত খাস জমি অবশ্যই $remainingRegisterKhaslandArea এর চেয়ে ছোট অথবা সমান হতে হবে"));
            } else {
                return response()->json(true);
            }
        }

    }

    public function report(Request $request)
    {
        $authUser = AuthHelper::getAuthUser();
        $userOffice = Office::where('id', $authUser->office_id)->first();
        $locDivision = LocDivision::where('bbs_code', '=', 20)->first();
        $locDistrict = LocDistrict::where(['bbs_code' => 75, 'division_bbs_code' => 20])->first();
        $locUpazilas = LocUpazila::where(['division_bbs_code' => 20, 'district_bbs_code' => 75]);

        $locUpazila = null;
        if (!empty($userOffice->upazila_bbs_code)) {
            $locUpazila = $locUpazilas->where(['bbs_code' => $userOffice->upazila_bbs_code])->first();
        } else {
            $locUpazilas = $locUpazilas->get();
        }

        return view(self::VIEW_PATH . 'register-8.report', compact('userOffice', 'locDivision', 'locDistrict', 'locUpazilas', 'locUpazila'));

    }

    public function reportDetails(Request $request)
    {
        $locDivision = LocDivision::where('bbs_code', '=', 20)->first();
        $locDistrict = LocDistrict::where(['bbs_code' => 75, 'division_bbs_code' => 20])->first();
        $locUpazilas = LocUpazila::where(['division_bbs_code' => 20, 'district_bbs_code' => 75]);

        $eightRegisters = EightRegister::select([
            'eight_registers.id',
            'eight_registers.register_type',
            'eight_registers.khotian_dag_id',
            'eight_registers.khotian_number',
            'eight_registers.division_bbs_code',
            'eight_registers.district_bbs_code',
            'eight_registers.upazila_bbs_code',
            'eight_registers.jl_number',
            'eight_registers.office_id',
            'eight_registers.dag_number',
            'eight_registers.khotian_dag_area',
            'eight_registers.dag_khasland_area',
            'eight_registers.register_khasland_area',
            'eight_registers.remaining_khasland_area',
            'eight_registers.provided_khasland_area',
            'eight_registers.details',
            'eight_registers.register_entry_date',
            'eight_registers.visit_date',
            'eight_registers.register_12_case_number',
            'eight_registers.register_12_distribution_date',
            'eight_registers.remark',
            'eight_registers.status',
            'eight_registers.created_by',
            'eight_registers.updated_by',
            'eight_registers.created_at',
            'eight_registers.updated_at',
            'division20_khatian_dags.land_type',
        ]);

        $eightRegisters = $eightRegisters->join('division20_khatian_dags', 'eight_registers.khotian_dag_id', '=', 'division20_khatian_dags.id');


        $eightRegisters->where([
            'eight_registers.division_bbs_code' => 20,
            'eight_registers.district_bbs_code' => 75,
        ]);

        $headerInfo = [
            'division_bbs_code' => 20,
            'division' => $locDivision->title,
            'district_bbs_code' => 75,
            'district' => $locDistrict->title,
            'register_type' => !empty($request->register_type) ? $request->register_type : null,
            'mouja' => !empty($request->mouja_name) ? $request->mouja_name : null,
        ];

        if (!empty($request->upazila_bbs_code)) {
            $eightRegisters = $eightRegisters->where('eight_registers.upazila_bbs_code', $request->upazila_bbs_code);
            $headerInfo['upazila_bbs_code'] = $request->upazila_bbs_code;
            $headerInfo['upazila'] = $locUpazilas->first()->title;;
        }

        if (!empty($request->jl_number)) {
            $eightRegisters = $eightRegisters->where('eight_registers.jl_number', $request->jl_number);
        }

        if (!empty($request->register_type)) {
            $eightRegisters = $eightRegisters->where('eight_registers.register_type', $request->register_type);
        }

        if (!empty($request->khotian_number)) {
            $eightRegisters = $eightRegisters->where('eight_registers.khotian_number', $request->khotian_number);
        }

        $eightRegisters = $eightRegisters->get()->toArray();


        return response()->json([
            'data' => $eightRegisters,
            'header' => $headerInfo,
        ]);

    }

    public function getRegisterEightData(Request $request)
    {
        $conditions = $request->all();
        $conditions['status'] = 1;
        $conditions['register_type'] = 2;

        return EightRegister::where($conditions)->get()->toArray();

    }
}
