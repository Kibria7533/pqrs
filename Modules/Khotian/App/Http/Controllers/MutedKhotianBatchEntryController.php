<?php

namespace Modules\Khotian\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\EnglishToBanglaDate;
use App\Helpers\Classes\FileHandler;
use App\Helpers\Classes\NumberToBanglaWord;
use App\Http\Controllers\Controller;
use App\Models\KhatianEntryRequest;
use App\Models\KhotianIndexs;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocMouja;
use App\Models\LocUpazila;
use App\Models\Office;
use App\Models\RskKhotians;
use App\Models\RskSoftBackKhotians;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Ixudra\Curl\Facades\Curl;
use Module\Office\Models\Offices;
use Modules\Application\Models\Applications;
use Modules\Khotian\App\Models\MutedKhotian;
use Modules\Khotian\App\Models\MutedKhotianDump;
use Modules\Landless\App\Models\Landless;
use Modules\UserCitizen\Models\UserCitizen;
use phpDocumentor\Reflection\Types\Self_;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class MutedKhotianBatchEntryController extends Controller
{
    const VIEW_PATH = 'khotian::muted-khotian.batch-entry.';

    public function index()
    {
        $this->authorize('browseMutedBatchEntry', app(MutedKhotian::class));
        $locDivision = LocDivision::where('bbs_code', '=', 20)->first();
        $locDistrict = LocDistrict::where(['bbs_code' => 75, 'division_bbs_code' => 20])->first();
        return view(self::VIEW_PATH . '.list', compact('locDivision', 'locDistrict'));
    }

    public function list(Request $request)
    {
        $authUser = Auth::user();
        $office = Office::where('id', $authUser->office_id)->first();

        if (empty($office)) {
            //return response()->json([], '200');
        }


        $divisionBBS = !empty($office->division_bbs_code)?$office->division_bbs_code:Landless::CTG_BBS_CODE;
        $districtBBS = !empty($office->district_bbs_code)?$office->district_bbs_code:Landless::NOAKHALI_BBS_CODE;
        $upazilaBBS = !empty($office->upazila_bbs_code)?$office->upazila_bbs_code:null;


        if ((empty($divisionBBS) || empty($districtBBS) || empty($upazilaBBS))) {
            //return response()->json([], '200');
        }

        $mutedTables = MutedKhotianDump::getTableName($divisionBBS);
        $mutedKhotianTalbe = $mutedTables['khotian'];

        $muetdKhotianModel = new MutedKhotian();
        $muetdKhotianModel->setTable($mutedKhotianTalbe);

        /** @var Builder $users */

        $mutedKhotians = $muetdKhotianModel->select([
            $mutedKhotianTalbe . '.id as id',
            $mutedKhotianTalbe . '.khotian_number',
            $mutedKhotianTalbe . '.division_bbs_code',
            $mutedKhotianTalbe . '.district_bbs_code',
            $mutedKhotianTalbe . '.upazila_bbs_code',
            'loc_divisions.title as division_name',
            'loc_districts.title as disrict_name',
            'loc_upazilas.title as upazila_name',
            'loc_all_moujas.name_bd as mouza_name',
            $mutedKhotianTalbe . '.dglr_code',
            $mutedKhotianTalbe . '.jl_number',
            $mutedKhotianTalbe . '.resa_no',
            $mutedKhotianTalbe . '.namjari_case_no',
            $mutedKhotianTalbe . '.case_date',
            $mutedKhotianTalbe . '.total_land',
            $mutedKhotianTalbe . '.scan_copy',
            $mutedKhotianTalbe . '.status'
        ]);

        /** relations */
        $mutedKhotians->join('loc_divisions', $mutedKhotianTalbe . '.division_bbs_code', '=', 'loc_divisions.bbs_code');
        $mutedKhotians->join('loc_districts', $mutedKhotianTalbe . '.district_bbs_code', '=', 'loc_districts.bbs_code');

        $mutedKhotians->join('loc_upazilas', function ($join) use ($mutedKhotianTalbe) {
            $join->on($mutedKhotianTalbe . '.division_bbs_code', '=', 'loc_upazilas.division_bbs_code');
            $join->on($mutedKhotianTalbe . '.district_bbs_code', '=', 'loc_upazilas.district_bbs_code');
        });

        $mutedKhotians->leftJoin('loc_all_moujas', function ($join) use ($mutedKhotianTalbe) {
            $join->on($mutedKhotianTalbe . '.division_bbs_code', '=', 'loc_all_moujas.division_bbs_code');
            $join->on($mutedKhotianTalbe . '.district_bbs_code', '=', 'loc_all_moujas.district_bbs_code');
            $join->on($mutedKhotianTalbe . '.upazila_bbs_code', '=', 'loc_all_moujas.upazila_bbs_code');
            $join->on($mutedKhotianTalbe . '.jl_number', '=', 'loc_all_moujas.rs_jl_no');
        });

        $mutedKhotians->where($mutedKhotianTalbe . '.division_bbs_code', 20);
        $mutedKhotians->where($mutedKhotianTalbe . '.district_bbs_code', 75);

        if(!empty($office->upazila_bbs_code)){
            $mutedKhotians->where($mutedKhotianTalbe . '.upazila_bbs_code', $office->upazila_bbs_code);
        }

        //$mutedKhotians->whereIn($mutedKhotianTalbe . '.status', [MutedKhotian::ON_PROGRESS, MutedKhotian::MODIFY, MutedKhotian::SAVE_AS_DRAFT]);
        //$mutedKhotians->where($mutedKhotianTalbe . '.stage', MutedKhotian::STAGE_WRITER);
        //$mutedKhotians->where($mutedKhotianTalbe . '.system_type', MutedKhotian::SYSTEM_TYPE_EPORCHA_BATCH);
        //$mutedKhotians->where($mutedKhotianTalbe . '.send_to_index', 0);
        $mutedKhotians->groupBy($mutedKhotianTalbe . '.district_bbs_code', $mutedKhotianTalbe . '.upazila_bbs_code', $mutedKhotianTalbe . '.jl_number', $mutedKhotianTalbe . '.khotian_number');

        //dd($mutedKhotians->get()->toArray());
        /**
         * Filter data
        **/
        /*if (isset($request['columns'])) {
            //dd($request['columns']);
            foreach ($request['columns'] as $index => $value) {
                $columnName = $value['data'];
                $columnValue = $value['search']['value'];

                if (!empty($columnValue)) {
                    switch ($columnName) {
                        case 'khotian_number':
                            $temp_columnValue=bn2en($columnValue);
                            $mutedKhotians->where($mutedKhotianTalbe.'.khotian_number', 'like', '%' . "$temp_columnValue" . '%');
                            break;
                        case 'mouza_name':
                            $moujaValue=trim(explode("-",$columnValue)[0]);
                            $mutedKhotians->where($mutedKhotianTalbe.'.jl_number', $moujaValue );
                            break;
                        default:
                            break;
                    }
                }
            }
        }*/

        try {
            return DataTables::eloquent($mutedKhotians)
                ->editColumn('khotian_number', function (MutedKhotian $mutedKhotian) use ($authUser) {
                    return NumberToBanglaWord::engToBn($mutedKhotian->khotian_number);
                })
                ->editColumn('dglr_code', function (MutedKhotian $mutedKhotian) use ($authUser) {
                    return NumberToBanglaWord::engToBn($mutedKhotian->dglr_code);
                })
                ->editColumn('jl_number', function (MutedKhotian $mutedKhotian) use ($authUser) {
                    return NumberToBanglaWord::engToBn($mutedKhotian->jl_number);
                })
                ->editColumn('resa_no', function (MutedKhotian $mutedKhotian) use ($authUser) {
                    return NumberToBanglaWord::engToBn($mutedKhotian->resa_no);
                })
                ->editColumn('case_date', function (MutedKhotian $mutedKhotian) use ($authUser) {
                    return EnglishToBanglaDate::dateFormatEnglishToBangla($mutedKhotian->case_date);
                })
                ->addColumn('check', function (MutedKhotian $mutedKhotian) use ($authUser, &$srl) {
                    $srl++;
                    return '<input id="' . $srl . '" class="muted-khotian-id" type="checkbox" value="' . $mutedKhotian->id . '"/> <label style="padding:3px 15px;" for="' . $srl . '"> ' . /*en2bn($srl)*/$srl . '</label>';
                })
                ->addColumn('status', function (MutedKhotian $mutedKhotian) use ($authUser) {
                    $status = '';
                    if ($mutedKhotian->status == MutedKhotian::ON_PROGRESS) {
                        $status = 'নতুন';

                    } elseif ($mutedKhotian->status == MutedKhotian::MODIFY) {
                        $status = 'সংশোধন প্রয়োজন';

                    } elseif ($mutedKhotian->status == MutedKhotian::SAVE_AS_DRAFT) {
                        $status = 'খসড়া';
                    }elseif ($mutedKhotian->status == MutedKhotian::STATUS_ACTIVE) {
                        $status = 'অনুমোদিত';
                    }

                    return $status;
                })

                ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (MutedKhotian $mutedKhotian) use ($authUser) {
                    $str = "";
                    if ($mutedKhotian->status == MutedKhotian::MODIFY) {
                        $str .= '<a class="btn btn-sm btn-warning text-white view" href="' . route('admin.khotians.batch-entry.show', $mutedKhotian->id) . '"><i class="fas fa-eye"></i>  ' . __('বিস্তারিত') . '</a>';
                        $str .= '<a class="btn btn-success" href="' . route('admin.khotians.batch-entry.edit', $mutedKhotian->id) . '"> <i class="fas fa-edit"></i> সংশোধন</a>';
                        $str .= '<a class="btn btn-sm btn-info muted_khotian_history_log" data-action="' . route('admin.khotians.history_log', [$mutedKhotian->id, $mutedKhotian->khotian_number, 'type' => 'compare']) . '" ><i class="fa fa-history" aria-hidden="true"></i> লগ</a>';

                    } elseif ($mutedKhotian->status == MutedKhotian::SAVE_AS_DRAFT) {
                        $str .= '<a class="btn btn-info btn-sm" href="' . route('admin.khotians.batch-entry.edit', $mutedKhotian->id) . '"><i class="fas fa-edit"></i> খসড়া সংশোধন</a>';

                    } elseif ($mutedKhotian->status == MutedKhotian::ON_PROGRESS) {
                        $str .= ' <a class="btn btn-sm btn-warning view" href="' . route('admin.khotians.batch-entry.show', $mutedKhotian->id) . '"><i class="voyager-eye"></i> ' . __('বিস্তারিত') . '</a>';
                        $str .= '<a class="btn btn-sm btn-info muted_khotian_history_log" data-action="' . route('admin.khotians.history_log', [$mutedKhotian->id, $mutedKhotian->khotian_number, 'type' => 'compare']) . '" ><i class="fa fa-history" aria-hidden="true"></i> লগ</a>';
                    }
                    $str .= "</div>";
                    return $str;
                }))
                ->rawColumns(['status', 'action', 'check'])
                ->toJson();
        } catch (\Exception $ex) {
            return response()->json([]);
        }
    }

    public function create(Request $request): View
    {
        $this->authorize('addMutedBatchEntry', app(MutedKhotian::class));

        $office = Office::getUserOffice();

        $locDivision = LocDivision::where('bbs_code', Landless::CTG_BBS_CODE)->first();

        $locDistrict = LocDistrict::where([
            'division_bbs_code'=>Landless::CTG_BBS_CODE,
            'bbs_code'=>Landless::NOAKHALI_BBS_CODE,
        ])->first();


        return view(Self::VIEW_PATH.'add', compact('locDivision', 'office', 'locDistrict'));
    }

    public function store(Request $request)
    {
        $this->authorize('addMutedBatchEntry', app(MutedKhotian::class));
        $request->request->add(['dhara_year' => bn2en($request->dhara_year)]);
        $request->request->add(['revenue' => bn2en($request->revenue)]);
        $total_area = 0;

        if (isset($request->owners['owner_area']) && count($request->owners['owner_area']) > 0) {
            foreach ($request->owners['owner_area'] as $key => $value) {
                $total_area = $total_area + $value;
            }
        }

        $data = [];
        if (empty($request->not_providable)) {
            $validatedData = $this->validateMutedKhotian($request);

            if ((int)$total_area !== 1) {
                return response()->json([
                    'message' => __('মালিকের সঠিক অংশ প্রদান করুন'),
                    'alertType' => 'error'
                ], 200);
            }

            if ($validatedData->fails()) {
                $errors = $validatedData->errors();
                return response()->json([
                    'message' => __($errors->first()),
                    'alertType' => 'error',
                ], 200);
            }

            $data = $validatedData->validate();

        } else {
            $data = $request->except('_token');
            if (empty($data['division_bbs_code'])) {
                return response()->json([
                    'message' => __('বিভাগ প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['district_bbs_code'])) {
                return response()->json([
                    'message' => __('জেলা প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['upazila_bbs_code'])) {
                return response()->json([
                    'message' => __('উপজেলা প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['loc_all_mouja_id'])) {
                return response()->json([
                    'message' => __('মৌজা প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['jl_number'])) {
                return response()->json([
                    'message' => __('জে.এল নং খুঁজে পাওয়া যায়নি! সঠিক মৌজা প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['khotian_number'])) {
                return response()->json([
                    'message' => __('খতিয়ান নং প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (
                empty($data['signature_one_name']) || empty($data['signature_one_date']) || empty($data['signature_one_designation']) ||
                empty($data['signature_two_name']) || empty($data['signature_two_date']) || empty($data['signature_two_designation']) ||
                empty($data['signature_three_name']) || empty($data['signature_three_date']) || empty($data['signature_three_designation']
                )) {
                return response()->json([
                    'message' => __('স্বাক্ষর সম্পর্কিত তথ্যসমূহ প্রদান করুন'),
                    'alertType' => 'error'
                ], 200);
            }

            if (empty($data['reasons'])) {
                return response()->json([
                    'message' => __('খতিয়ান প্রদানযোগ্য না হওয়ার কারন প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }

        }

        // TODO:added condition(arman)
        if ((int)$data['signature_three_designation'] !== array_search('সহকারী কমিশনার (ভূমি)', MutedKhotian::SIGNATURE_DESIGNATION)) {
            return response()->json([
                'message' => __('স্বাক্ষর সম্পর্কিত তথ্যসমূহ প্রদান করুন'),
                'alertType' => 'error'
            ], 200);
        }

        DB::beginTransaction();

        try {
            $authUser = Auth::user();
            $officeUser = Office::getUserOffice();
            $mutedKhotianTables = MutedKhotianDump::getTableName(!empty($officeUser->division_bbs_code)?$officeUser->division_bbs_code:20);
            $mutedKhotiansTable = $mutedKhotianTables['khotian'];
            $mutedKhotiansTableOwner = $mutedKhotianTables['khotian_owner'];
            $mutedKhotiansTableDag = $mutedKhotianTables['khotian_dag'];
            $mutedKhotianEntryLogTalbe = $mutedKhotianTables['khotian_entry_log'];

            if (!empty($data['scan_copy'])) {
                $filename = FileHandler::storePhoto($data['scan_copy'], 'muted-khotians/division_' . $data['division_bbs_code'] . '/district_' . $data['district_bbs_code'] . '/upazila_' . $data['upazila_bbs_code']);
                $data['scan_copy'] = 'muted-khotians/division_' . $data['division_bbs_code'] . '/district_' . $data['district_bbs_code'] . '/upazila_' . $data['upazila_bbs_code'] . '/' . $filename;
            }

            if (!empty($request->draft)) {
                $data['status'] = MutedKhotian::SAVE_AS_DRAFT;
                $data['stage'] = MutedKhotian::STAGE_WRITER;
            } else {
                $data['status'] = MutedKhotian::ON_PROGRESS;
                $data['stage'] = MutedKhotian::STAGE_APPROVE;
            }

            $mutedKhotianData = [
                'khotian_number' => $data['khotian_number'],
                'division_bbs_code' => $data['division_bbs_code'],
                'district_bbs_code' => $data['district_bbs_code'],
                'upazila_bbs_code' => $data['upazila_bbs_code'],
                'jl_number' => $data['jl_number'],
                'resa_no' => trim(strip_tags($data['resa_no'])),
                'base_survey_type' => null,
                'namjari_case_no' => trim(strip_tags($data['namjari_case_no'])),
                'case_date' => $data['case_date'],
                'revenue' => trim(strip_tags($data['revenue'])),
                'dcr_number' => trim(strip_tags($data['dcr_number'])),
                'has_dhara' => !empty($data['has_dhara']) ? $data['has_dhara'] : 0,
                'dhara_no' => !empty($data['dhara_no']) ? trim(strip_tags($data['dhara_no'])) : null,
                'dhara_year' => !empty($data['dhara_year']) ? $data['dhara_year'] : null,
                'mokoddoma_no' => $data['mokoddoma_no'],
                'is_entry' => !empty($request->draft) ? 0 : 1,
                'entry_by' => !empty($request->draft) ? null : $authUser->id,
                'entry_date' => !empty($request->draft) ? null : Carbon::now()->format('Y-m-d'),
                'scan_copy' => $data['scan_copy'] ?? null,
                'agoto_khotian_type' => $data['ref_khotian_type'] ?? null,
                'agoto_khotian_no' => $data['ref_khotian_number'] ? trim(strip_tags($data['ref_khotian_number'])) : null,
                'source_type' => MutedKhotian::SYSTEM_TYPE_EPORCHA_BATCH,
                'signature_one_name' => trim(strip_tags($data['signature_one_name'])),
                'signature_one_date' => $data['signature_one_date'],
                'signature_one_designation' => $data['signature_one_designation'],
                'signature_two_name' => trim(strip_tags($data['signature_two_name'])),
                'signature_two_date' => $data['signature_two_date'],
                'signature_two_designation' => $data['signature_two_designation'],
                'signature_three_name' => trim(strip_tags($data['signature_three_name'])),
                'signature_three_date' => $data['signature_three_date'],
                'signature_three_designation' => $data['signature_three_designation'],
                'status' => $data['status'],
                'stage' => $data['stage'],
                'system_type' => MutedKhotian::SYSTEM_TYPE_EPORCHA_BATCH,
                'batch_entry' => MutedKhotian::BATCH_ENTRY,
                'not_providable' => !empty($request->not_providable) ? 1 : 0,
                'reasons' => !empty($data['reasons']) ? json_encode($data['reasons']) : null,
                'created_by' => $authUser->id,
                'created_at' => Carbon::now(),
            ];

            $lastMutedKhotianId = DB::table($mutedKhotiansTable)->insertGetId($mutedKhotianData);

            $ownerSlNo = 0;
            if (!empty($data['owners'])) {
                foreach ($data['owners']['owner_no'] as $key => $value) {
                    $ownerData = [
                        'muted_khotian_id' => $lastMutedKhotianId,
                        'khotian_number' => $data['khotian_number'],
                        'owner_name' => $data['owners']['owner_name'][$key] ? trim(strip_tags($data['owners']['owner_name'][$key])) : null,
                        'owner_no' => ++$ownerSlNo,
                        'owner_group' => $data['owners']['owner_group'][$key] ?? null,
                        'owner_area' => $data['owners']['owner_area'][$key] ?? null,
                        'guardian_type' => $data['owners']['guardian_type'][$key] ? MutedKhotian::YES : MutedKhotian::NO,
                        'guardian' => $data['owners']['guardian'][$key] ? trim(strip_tags($data['owners']['guardian'][$key])) : null,
                        'mother_name' => $data['owners']['mother_name'][$key] ? trim(strip_tags($data['owners']['mother_name'][$key])) : null,
                        'owner_address' => $data['owners']['owner_address'][$key] ? trim(strip_tags($data['owners']['owner_address'][$key])) : null,
                        'owner_mobile' => $data['owners']['owner_mobile'][$key] ?? null,
                        'identity_type' => $data['owners']['identity_type'][$key],
                        'identity_number' => $data['owners']['identity_type'][$key] != 4 ? ($data['owners']['identity_number'][$key] ? trim(strip_tags($data['owners']['identity_number'][$key])) : null) : null,
                        'dob' => $data['owners']['dob'][$key] ?? null,
                        'created_by' => $authUser->id,
                        'created_at' => Carbon::now(),
                    ];

                    $ownerAddress = !empty($ownerData['owner_address']) ? str_replace(',', '<br/>', $ownerData['owner_address']) : null;
                    if ($ownerAddress) {
                        $ownerAddress .= '<br/>';
                    }
                    $ownerData['owner_address_pdf'] = $ownerData['guardian'] . '<br/>' . $ownerAddress;

                    DB::table($mutedKhotiansTableOwner)->insertGetId($ownerData);
                }
            }

            if (!empty($data['dags'])) {
                foreach ($data['dags']['dag_number'] as $key => $value) {
                    $dagData = [
                        'muted_khotian_id' => $lastMutedKhotianId,
                        'khotian_number' => $data['khotian_number'],
                        'dag_number' => $data['dags']['dag_number'][$key] ?? null,
                        'total_dag_area' => $data['dags']['total_dag_area'][$key] ?? null,
                        'khotian_dag_area' => $data['dags']['khotian_dag_area'][$key] ?? null,
                        'khotian_dag_portion' => $data['dags']['khotian_dag_portion'][$key] ?? null,
                        'land_owner_type_id' => $data['dags']['land_owner_type_id'][$key] ?? null,
                        'agricultural_use' => $data['dags']['agricultural_use'][$key] ? MutedKhotian::YES : MutedKhotian::NO,
                        'land_type_id' => $data['dags']['agricultural_use'][$key] ? $data['dags']['agri_land_type'][$key] : $data['dags']['non_agri_land_type'][$key],
                        'land_type' => $data['dags']['agricultural_use'][$key] ? $this->removeFirstString(MutedKhotian::LAND_TYPE[$data['dags']['agri_land_type'][$key]]) : $this->removeFirstString(MutedKhotian::LAND_TYPE[$data['dags']['non_agri_land_type'][$key]]),
                        'remark' => $data['dags']['remarks'][$key] ? trim(strip_tags($data['dags']['remarks'][$key])) : null,
                        'created_by' => $authUser->id,
                        'created_at' => Carbon::now(),
                    ];

                    DB::table($mutedKhotiansTableDag)->insertGetId($dagData);
                }
            }

            /** Generate Muted khotian entry log data **/
            if (!$request->draft) {
                $entryLogData = [
                    'muted_khotian_id' => $lastMutedKhotianId,
                    'status' => $mutedKhotianData['status'],
                    'stage' => $mutedKhotianData['stage'],
                    'is_taken_action' => 3, //3 = New Entry
                    'created_by' => $authUser->id,
                    'created_at' => Carbon::now()
                ];

                DB::table($mutedKhotianEntryLogTalbe)->insert($entryLogData);
            }


            DB::commit();
        } catch (\Throwable $exception) {

            dd($exception);
            DB::rollback();
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __('দুঃখিত! খতিয়ান সংরক্ষন করা সম্ভব হয় নাই'),
                'alertType' => 'error'
            ]);
        }

        if (!empty($request->draft)) {
            return response()->json([
                'message' => __('খতিয়ানটি সফলভাবে খসড়া করা হয়েছে!'),
                'alertType' => 'success',
                'redirectTo' => route('admin.khotians.batch-entry.index'),
            ], 200);
        } else {
            return response()->json([
                'message' => __('খতিয়ানটি সফলভাবে তুলনাকারির নিকট প্রেরণ করা হয়েছে!'),
                'alertType' => 'success',
                'redirectTo' => route('admin.khotians.batch-entry.index'),
            ], 200);
        }
    }

    public function show($id){
        $authUser = Auth::user();
        $office = Office::find($authUser['office_id']);
        $tableNames = \Modules\Khotian\App\Models\MutedKhotianDump::getTableName(!empty($office->division_bbs_code)?$office->division_bbs_code:20);
        $mutedKhotianTable = $tableNames['khotian'];

        $mutedKhotianRow = DB::table($mutedKhotianTable)->where('id', $id)->first();

        if(empty($mutedKhotianRow)){
            abort(404, "আপনার কার্যক্রম সম্পাদন করা সম্ভব নয়");
        }

        try{
            $application = null;
            $qr_code = null;
            switch ($mutedKhotianRow->system_type) {
                case 'eporcha_batch':
                case 'eporcha':
                    if ($mutedKhotianRow->not_providable !== 1) {
                        $batch_khotians = RskSoftBackKhotians::getMutedKhatianprintJsonForRequested(
                            $mutedKhotianRow->district_bbs_code,
                            $mutedKhotianRow->upazila_bbs_code,
                            $mutedKhotianRow->jl_number,
                            $mutedKhotianRow->khotian_number
                        );
                    } elseif ($mutedKhotianRow->not_providable === 1) {
                        $batch_khotians = RskSoftBackKhotians::nonProvidedPrintJson(
                            $mutedKhotianRow->district_bbs_code,
                            $mutedKhotianRow->upazila_bbs_code,
                            $mutedKhotianRow->jl_number,
                            $mutedKhotianRow->khotian_number,
                            $mutedKhotianRow->reasons
                        );
                    }
                    $print_type = 2;
                    $formatedIP = '';
                    $userCode = '';
                    $formatedIpPartOne = '66';
                    $formatedIpPartTwo = '44';
                    $record = $mutedKhotianRow;
                    if ($mutedKhotianRow->not_providable !== 1) {
                        return view(
                            'khotian::muted-khotian.read',
                            compact('batch_khotians', 'application', 'record', 'print_type', 'formatedIP', 'userCode', 'formatedIpPartOne', 'formatedIpPartTwo', 'qr_code')
                        );
                    } elseif ($mutedKhotianRow->not_providable === 1) {
                        return view(
                            'khotian::muted-khotian.muted-khotian-print-nonprovide',
                            compact('batch_khotians', 'application', 'record', 'print_type', 'formatedIP', 'userCode', 'formatedIpPartOne', 'formatedIpPartTwo', 'qr_code')
                        );
                    }
                    break;
                default:
                    abort(404, "আপনার কার্যক্রম সম্পাদন করা সম্ভব নয়");
            }
        }catch (\Exception $e){
            Log::debug($e->getMessage());
            dd($e);
        }
    }

    public function edit($id)
    {
        $this->authorize('editMutedBatchEntry', app(MutedKhotian::class));

        $office = Office::getUserOffice();
        $MutedKhotianTables = MutedKhotianDump::getTableName(!empty($office->division_bbs_code)?$office->division_bbs_code:20);
        $tableMutedKhotians = $MutedKhotianTables['khotian'];
        $tableMutedKhotianDags = $MutedKhotianTables['khotian_dag'];
        $tableMutedKhotianOwners = $MutedKhotianTables['khotian_owner'];

        $mutedKhotian = DB::table($tableMutedKhotians)->where(['id' => $id])->first();

        if (empty($mutedKhotian)) {
            abort(404, "অনুরোধকৃত খাতিয়ান খুঁজে পাওয়া যায়নি।");
        }


        if (!(($mutedKhotian->status == MutedKhotian::ON_PROGRESS || $mutedKhotian->status == MutedKhotian::MODIFY || $mutedKhotian->status == MutedKhotian::SAVE_AS_DRAFT) && ($mutedKhotian->stage == MutedKhotian::STAGE_WRITER))) {
            //miladul
            abort(404, "এই খতিয়ানটি সম্পাদনা অনুমোদিত নয়!");
        }

        dd('test');
        $mutedKhotianDags = DB::table($tableMutedKhotianDags)->where(['muted_khotian_id' => $mutedKhotian->id, 'khotian_number' => $mutedKhotian->khotian_number])->get();
        $mutedKhotianOwners = DB::table($tableMutedKhotianOwners)->where(['muted_khotian_id' => $mutedKhotian->id, 'khotian_number' => $mutedKhotian->khotian_number, 'status' => MutedKhotian::STATUS_ACTIVE])->get();

        $mutedKhotianDagsInfo = [];
        $dagNoCount = [];
        foreach ($mutedKhotianDags as $key => $value) {
            $mutedKhotianDagsInfo[$key] = (array)$value;
            $dagNoCount[$key] = $value->dag_number;
        }

        $mutedKhotianOwnersInfo = [];
        $onewsIdentityNumbers = [];
        $ownerAreaCount = 0;
        foreach ($mutedKhotianOwners as $key => $value) {
            $mutedKhotianOwnersInfo[$key] = (array)$value;
            $onewsIdentityNumbers[$key] = $value->identity_number;
            $ownerAreaCount += $value->owner_area;
        }

        $mouza = LocMouja::where([
            'division_bbs_code' => $mutedKhotian->division_bbs_code,
            'district_bbs_code' => $mutedKhotian->district_bbs_code,
            'upazila_bbs_code' => $mutedKhotian->upazila_bbs_code,
            'brs_jl_no' => $mutedKhotian->jl_number,
        ])->first();

        $mutedKhotianInfoData = [
            'division_bbs_code' => $mutedKhotian->division_bbs_code,
            'district_bbs_code' => $mutedKhotian->district_bbs_code,
            'upazila_bbs_code' => $mutedKhotian->upazila_bbs_code,
            'jl_number' => $mutedKhotian->jl_number,
            'khotian_number' => $mutedKhotian->khotian_number,
            'division_title' => $mouza->division_name ?? '',
            'district_title' => $mouza->district_name ?? '',
            'upazila_title' => $mouza->upazila_name ?? '',
            'mouja_title' => $mouza->name_bd ?? '',
            'dglr_code' => $mutedKhotian->dglr_code ?? '',
            'resa_no' => $mutedKhotian->resa_no ?? '',
            'namjari_case_no' => $mutedKhotian->namjari_case_no ?? '',
            'case_date' => $mutedKhotian->case_date ?? '',
            'has_dhara' => $mutedKhotian->has_dhara ?? 0,
            'dhara_no' => $mutedKhotian->dhara_no ?? '',
            'dhara_year' => $mutedKhotian->dhara_year ?? '',
            'mokoddoma_no' => $mutedKhotian->mokoddoma_no ?? '',
            'revenue' => $mutedKhotian->revenue ?? '',
            'dcr_number' => $mutedKhotian->dcr_number ?? '',
        ];


        $locDivisions = LocDivision::get();
        if(!empty($office->division_bbs_code)){
            $locDivisions = $locDivisions->where('bbs_code', $office->division_bbs_code);
        }
        return view(Self::VIEW_PATH.'edit', compact('locDivisions', 'mutedKhotian', 'mutedKhotianDagsInfo', 'mutedKhotianOwnersInfo', 'mutedKhotianInfoData', 'onewsIdentityNumbers', 'ownerAreaCount', 'dagNoCount','office'));
    }

    public function update(Request $request, int $id)
    {
        $this->authorize('editMutedBatchEntry', app(MutedKhotian::class));

        $request->request->add(['dhara_year' => bn2en($request->dhara_year)]);
        $request->request->add(['revenue' => bn2en($request->revenue)]);
        $total_area = 0;

        if (isset($request->owners['owner_area']) && count($request->owners['owner_area']) > 0) {
            foreach ($request->owners['owner_area'] as $key => $value) {
                $total_area = $total_area + $value;
            }
        }

        $data = [];
        if (empty($request->not_providable)) {
            $validatedData = $this->validateMutedKhotian($request, $id);

            if ((int)$total_area !== 1) {
                return response()->json([
                    'message' => __('মালিকের সঠিক অংশ প্রদান করুন'),
                    'alertType' => 'error'
                ], 200);
            }


            if ($validatedData->fails()) {
                $errors = $validatedData->errors();
                return response()->json([
                    'message' => __($errors->first()),
                    'alertType' => 'error',
                ], 200);
            }

            $data = $validatedData->validate();

        } else {
            $data = $request->except('_token');

            if (empty($data['division_bbs_code'])) {
                return response()->json([
                    'message' => __('বিভাগ প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['district_bbs_code'])) {
                return response()->json([
                    'message' => __('জেলা প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['upazila_bbs_code'])) {
                return response()->json([
                    'message' => __('উপজেলা প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['loc_all_mouja_id'])) {
                return response()->json([
                    'message' => __('মৌজা প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['jl_number'])) {
                return response()->json([
                    'message' => __('জে.এল নং খুঁজে পাওয়া যায়নি! সঠিক মৌজা প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['khotian_number'])) {
                return response()->json([
                    'message' => __('খতিয়ান নং প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
            if (
                empty($data['signature_one_name']) || empty($data['signature_one_date']) || empty($data['signature_one_designation']) ||
                empty($data['signature_two_name']) || empty($data['signature_two_date']) || empty($data['signature_two_designation']) ||
                empty($data['signature_three_name']) || empty($data['signature_three_date']) || empty($data['signature_three_designation'])
            ) {
                return response()->json([
                    'message' => __('স্বাক্ষর সম্পর্কিত তথ্যসমূহ প্রদান করুন'),
                    'alertType' => 'error'
                ], 200);
            }
            if (empty($data['reasons'])) {
                return response()->json([
                    'message' => __('খতিয়ান প্রদানযোগ্য না হওয়ার কারন প্রদান করুন!'),
                    'alertType' => 'error'
                ], 200);
            }
        }

        if ((int)$data['signature_three_designation'] !== array_search('সহকারী কমিশনার (ভূমি)', MutedKhotian::SIGNATURE_DESIGNATION)) {

            return response()->json([
                'message' => __('স্বাক্ষর সম্পর্কিত তথ্যসমূহ প্রদান করুন'),
                'alertType' => 'error'
            ], 200);
        }

        $authUser = Auth::user();
        $officeUser = Office::getUserOffice();
        $mutedKhotianTables = MutedKhotianDump::getTableName($officeUser->division_bbs_code);

        $mutedKhotiansTable = $mutedKhotianTables['khotian'];
        $mutedKhotiansTableOwner = $mutedKhotianTables['khotian_owner'];
        $mutedKhotiansTableDag = $mutedKhotianTables['khotian_dag'];

        $mutedKhotian = DB::table($mutedKhotiansTable)->where('id', $id);
        $mutedKhotianRow = $mutedKhotian->first();
        $ownerIds = DB::table($mutedKhotiansTableOwner)->where(['muted_khotian_id' => $id, 'status' => MutedKhotian::STATUS_ACTIVE])->pluck('id', 'id')->toArray();
        $dagIds = DB::table($mutedKhotiansTableDag)->where(['muted_khotian_id' => $id, 'status' => MutedKhotian::STATUS_ACTIVE])->pluck('id', 'id')->toArray();


        if ($request->next_stage === 'true') {
            $data['stage'] = MutedKhotian::STAGE_APPROVE;
            if ($mutedKhotianRow->status == MutedKhotian::SAVE_AS_DRAFT) {
                $data['status'] = MutedKhotian::ON_PROGRESS;
            } else {
                $data['status'] = $mutedKhotianRow->status;
            }
            $data['is_entry'] = 1;
        } else {
            $data['stage'] = $mutedKhotianRow->stage;
            $data['status'] = $mutedKhotianRow->status;
        }


        if ($mutedKhotianRow->scan_copy && !empty($data['scan_copy'])) {
            FileHandler::deleteFile($mutedKhotianRow->scan_copy);
        }

        if (!empty($data['scan_copy'])) {
            $filename = FileHandler::storePhoto($data['scan_copy'], 'muted-khotians/division_' . $data['division_bbs_code'] . '/district_' . $data['district_bbs_code'] . '/upazila_' . $data['upazila_bbs_code']);
            $data['scan_copy'] = 'muted-khotians/division_' . $data['division_bbs_code'] . '/district_' . $data['district_bbs_code'] . '/upazila_' . $data['upazila_bbs_code'] . '/' . $filename;
        } else {
            $data['scan_copy'] = $mutedKhotianRow->scan_copy;
        }

        try {
            $mutedKhotianData = [
                'division_bbs_code' => $data['division_bbs_code'],
                'district_bbs_code' => $data['district_bbs_code'],
                'upazila_bbs_code' => $data['upazila_bbs_code'],
                'jl_number' => $data['jl_number'],
                'khotian_number' => $data['khotian_number'],

                'resa_no' => trim(strip_tags($data['resa_no'])),
                'namjari_case_no' => trim(strip_tags($data['namjari_case_no'])),
                'case_date' => $data['case_date'],
                'revenue' => trim(strip_tags($data['revenue'])),
                'dcr_number' => trim(strip_tags($data['dcr_number'])),
                'has_dhara' => !empty($data['has_dhara']) ? $data['has_dhara'] : null,
                'dhara_no' => !empty($data['dhara_no']) ? trim(strip_tags($data['dhara_no'])) : null,
                'dhara_year' => !empty($data['dhara_year']) ? $data['dhara_year'] : null,
                'mokoddoma_no' => trim(strip_tags($data['mokoddoma_no'])),
                'is_entry' => $data['is_entry'] ?? 0,
                'entry_by' => !empty($data['is_entry']) ? $authUser->id : null,
                'entry_date' => !empty($data['is_entry']) ? Carbon::now()->format('Y-m-d') : null,
                'scan_copy' => $data['scan_copy'] ?? null,
                'agoto_khotian_type' => $data['ref_khotian_type'] ?? null,
                'agoto_khotian_no' => $data['ref_khotian_number'] ? trim(strip_tags($data['ref_khotian_number'])) : null,
                'source_type' => MutedKhotian::SOURCE_TYPE,
                'signature_one_name' => trim(strip_tags($data['signature_one_name'])),
                'signature_one_date' => $data['signature_one_date'] ?? null,
                'signature_one_designation' => $data['signature_one_designation'] ?? null,
                'signature_two_name' => trim(strip_tags($data['signature_two_name'])),
                'signature_two_date' => $data['signature_two_date'] ?? null,
                'signature_two_designation' => $data['signature_two_designation'] ?? null,
                'signature_three_name' => trim(strip_tags($data['signature_three_name'])),
                'signature_three_date' => $data['signature_three_date'] ?? null,
                'signature_three_designation' => $data['signature_three_designation'] ?? null,
                'status' => $data['status'],
                'stage' => $data['stage'],
                'system_type' => MutedKhotian::SYSTEM_TYPE,
                'batch_entry' => MutedKhotian::BATCH_ENTRY,
                'not_providable' => !empty($request->not_providable) ? 1 : 0,
                'reasons' => !empty($data['reasons']) ? json_encode($data['reasons']) : null,
                'updated_by' => $authUser->id,
                'updated_at' => Carbon::now(),
            ];


            DB::transaction(function () use ($request, $mutedKhotiansTable, $mutedKhotiansTableOwner, $mutedKhotiansTableDag, $mutedKhotianData, $data, $authUser, $mutedKhotian, $ownerIds, $dagIds, $id, $mutedKhotianRow) {
                $mutedKhotian->update($mutedKhotianData);

                $ownerData = [];
                $ownerSl = 0;
                if (!empty($data['owners'])) {
                    foreach ($data['owners']['owner_no'] as $key => $value) {
                        $ownerData = [
                            'owner_no' => ++$ownerSl,
                            'owner_name' => $data['owners']['owner_name'][$key] ? trim(strip_tags($data['owners']['owner_name'][$key])) : null,
                            'owner_group' => $data['owners']['owner_group'][$key] ?? null,
                            'owner_area' => $data['owners']['owner_area'][$key] ?? null,
                            'guardian_type' => $data['owners']['guardian_type'][$key] ? MutedKhotian::YES : MutedKhotian::NO,
                            'guardian' => $data['owners']['guardian'][$key] ? trim(strip_tags($data['owners']['guardian'][$key])) : null,
                            'mother_name' => $data['owners']['mother_name'][$key] ? trim(strip_tags($data['owners']['mother_name'][$key])) : null,
                            'owner_address' => $data['owners']['owner_address'][$key] ? trim(strip_tags($data['owners']['owner_address'][$key])) : null,
                            'owner_mobile' => $data['owners']['owner_mobile'][$key] ?? null,
                            'identity_type' => $data['owners']['identity_type'][$key],
                            'identity_number' => $data['owners']['identity_type'][$key] != 4 ? ($data['owners']['identity_number'][$key] ? trim(strip_tags($data['owners']['identity_number'][$key])) : null) : null,
                            'dob' => $data['owners']['dob'][$key] ?? null,
                            'updated_by' => $authUser->id,
                            'updated_at' => Carbon::now(),
                        ];

                        $ownerAddress = !empty($ownerData['owner_address']) ? str_replace(',', '<br/>', $ownerData['owner_address']) : null;
                        if ($ownerAddress) {
                            $ownerAddress .= '<br/>';
                        }
                        $ownerData['owner_address_pdf'] = $ownerData['guardian'] . '<br/>' . $ownerAddress;

                        $ownerId = !empty($data['owners']['owner_id'][$key]) ? $data['owners']['owner_id'][$key] : '';

                        if (!$ownerId) {
                            $ownerData['muted_khotian_id'] = $id;
                            $ownerData['khotian_number'] = $data['khotian_number'];
                            $ownerData['created_by'] = $authUser->id;
                            $ownerData['created_at'] = Carbon::now();
                            DB::table($mutedKhotiansTableOwner)->insert($ownerData);
                            continue;
                        }
                        if (!in_array($ownerId, $ownerIds)) {
                            throw new \Exception('মালিক খুঁজে পাওয়া যায়নি', $key);
                        }
                        DB::table($mutedKhotiansTableOwner)->where('id', $ownerId)->update($ownerData);

                        /**
                         * delete from array
                         **/
                        unset($ownerIds[$ownerId]);
                    }
                }

                /**
                 * delete owners if delete from frontend
                 **/
                foreach ($ownerIds as $key => $value) {
                    DB::table($mutedKhotiansTableOwner)->where('id', $value)->delete();
                }

                $dagData = [];
                if (!empty($data['dags'])) {
                    foreach ($data['dags']['dag_number'] as $key => $value) {
                        $dagData = [
                            'dag_number' => $data['dags']['dag_number'][$key] ?? null,
                            'total_dag_area' => $data['dags']['total_dag_area'][$key] ?? null,
                            'khotian_dag_area' => $data['dags']['khotian_dag_area'][$key] ?? null,
                            'khotian_dag_portion' => $data['dags']['khotian_dag_portion'][$key] ?? null,
                            'land_owner_type_id' => $data['dags']['land_owner_type_id'][$key] ?? null,
                            'agricultural_use' => $data['dags']['agricultural_use'][$key] ? MutedKhotian::YES : MutedKhotian::NO,
                            'land_type_id' => $data['dags']['agricultural_use'][$key] ? $data['dags']['agri_land_type'][$key] : $data['dags']['non_agri_land_type'][$key],
                            'land_type' => $data['dags']['agricultural_use'][$key] ? $this->removeFirstString(MutedKhotian::LAND_TYPE[$data['dags']['agri_land_type'][$key]]) : $this->removeFirstString(MutedKhotian::LAND_TYPE[$data['dags']['non_agri_land_type'][$key]]),
                            'remark' => $data['dags']['remarks'][$key] ? trim(strip_tags($data['dags']['remarks'][$key])) : null,
                            'updated_by' => $authUser->id,
                            'updated_at' => Carbon::now(),
                        ];

                        $dagId = !empty($data['dags']['dag_id'][$key]) ? $data['dags']['dag_id'][$key] : '';
                        if (!$dagId) {
                            $dagData['muted_khotian_id'] = $id;
                            $dagData['khotian_number'] = $data['khotian_number'];
                            $dagData['created_by'] = $authUser->id;
                            $dagData['created_at'] = Carbon::now();
                            DB::table($mutedKhotiansTableDag)->insert($dagData);
                            continue;
                        }
                        if (!in_array($dagId, $dagIds)) {
                            throw new \Exception('দাগ খুঁজে পাওয়া যায়নি');
                        }

                        $t = DB::table($mutedKhotiansTableDag)->where('id', $dagId)->update($dagData);

                        /**
                         * delete from array
                         **/
                        unset($dagIds[$dagId]);
                    }
                }

                /**
                 * delete dags if delete from frontend
                 **/
                foreach ($dagIds as $key => $value) {
                    DB::table($mutedKhotiansTableDag)->where('id', $value)->delete();
                }

            });

        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json([
                'message' => __($exception->getMessage()),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('খতিয়ানটি সফলভাবে সম্পাদন করা হয়েছে'),
            'alertType' => 'success',
            'redirectTo' => route('admin.khotians.batch-entry.index'),
        ], 200);
    }


    /** Helpers Methods **/
    public function validateMutedKhotian(Request $request, $id = null): Validator
    {
        $rules = [
            'khotian_number' => [
                'required',
                'string',
                Rule::unique('division' . $request->division_bbs_code . '_khotians')
                    ->where('district_bbs_code', $request->district_bbs_code)
                    ->where('upazila_bbs_code', $request->upazila_bbs_code)
                    ->where('jl_number', $request->jl_number)
                    ->where(function ($query) use ($id) {
                        if ($id) {
                            $query->where('id', '!=', $id);
                        }
                    })
            ],
            'jl_number' => 'required|int|min:1',
            'resa_no' => 'nullable|string',
            'namjari_case_no' => 'required|string',
            'case_date' => 'required|date|before:today+1',
            'has_dhara' => 'required|boolean',
            'dhara_no' => !empty($request->has_dhara) ? 'required|string' : 'nullable|string',
            'dhara_year' => !empty($request->has_dhara) ? 'required|numeric|min:1800|max:' . Carbon::now()->format('Y') : 'nullable|numeric|min:1800|max:' . Carbon::now()->format('Y'),
            'mokoddoma_no' => 'required|string',
            'revenue' => 'required|numeric|min:0',
            'dcr_number' => 'required|string',
            'upazila_name' => 'nullable|string',
            'district_name' => 'nullable|string',
            'division_bbs_code' => 'required|exists:loc_divisions,bbs_code',
            'district_bbs_code' => 'required|exists:loc_districts,bbs_code',
            'upazila_bbs_code' => 'required|exists:loc_upazilas,bbs_code',
            'loc_all_mouja_id' => 'required|int|min:1',
            'owners' => 'required|array|min:1',
            'owners.owner_no.*' => 'required|int|min:1',
            'owners.owner_name.*' => 'required|string',
            'owners.guardian_type.*' => 'required|int|between:0,1',//todo
            'owners.guardian.*' => 'required|string',
            'owners.mother_name.*' => 'nullable|string',
            //TODO:main code 'owners.owner_area.*' => 'required|numeric|gt:0|lte:1',
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
            'signature_one_name' => 'required|string',
            'signature_one_date' => 'required|date',
            'signature_one_designation' => 'required|int|min:1',
            'signature_two_name' => 'required|string',
            'signature_two_date' => 'required|date|after_or_equal:signature_one_date',
            'signature_two_designation' => 'required|int|min:1',
            'signature_three_name' => 'required|string',
            'signature_three_date' => 'required|date|after_or_equal:signature_two_date',
            'signature_three_designation' => 'required|int|min:1',
            'scan_copy' => 'required|max:2000|mimes:jpg,pdf',
            'ref_khotian_number' => 'required|string',
            'ref_khotian_type' => 'required|string',
        ];

        //when edit scan copy nullable
        if ($id) {
            $rules['scan_copy'] = 'nullable|max:2000|mimes:jpg,pdf';
        }

        $customMessages = [
            'owners.owner_group.*.min' => "মালিকের গ্রূপ কমপক্ষে ১ প্রদান করুন।",
            'owners.owner_group.*.max' => "মালিকের গ্রূপ সর্বোচ্চ ১২৭ প্রদান করুন।",
            'dags.dag_number.*.regex' => 'শুধুমাত্র সংখ্যা বা সংখ্যা সহ "/" স্পেশাল ক্যারেক্টর ব্যবহার করুন। [ উদাহরণ: ১ বা ১/১ ]',
            'dhara_year.min' => 'ধারার বছর সর্বনিন্ম ১৮০০ সাল প্রদান করুন।',
            'dhara_year.max' => 'ধারার বছর সর্বোচ্চ ' . Carbon::now()->format('Y') . ' সাল প্রদান করুন।',
            'scan_copy.max' => "খতিয়ানের স্ক্যান ফাইল সাইজ সর্বোচ্চ 2Mb প্রদান করুন।",
            'scan_copy.mimes' => "খতিয়ানের স্ক্যান ফাইল এর ধরণ jpg/pdf প্রদান করুন।",
            'khotian_number.unique' => "এই খতিয়ানটি ইতিমধ্যেই সিস্টেমে অন্তর্ভুক্ত করা হয়েছে!",
            'signature_two_date.after_or_equal' => "স্বাক্ষরের তারিখ ভুল হয়েছে।(স্বাক্ষরিত - ২)",
            'signature_three_date.after_or_equal' => "স্বাক্ষরের তারিখ ভুল হয়েছে।(স্বাক্ষরিত - ৩)",
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
    }

    public function validateNotProvidableMutedKhotian(Request $request, $id = null): Validator
    {
        $rules = [
            'khotian_number' => [
                'required',
                'integer',
                Rule::unique('division' . $request->division_bbs_code . '_khotians')
                    ->where('district_bbs_code', $request->district_bbs_code)
                    ->where('upazila_bbs_code', $request->upazila_bbs_code)
                    ->where('jl_number', $request->jl_number)
                    ->where(function ($query) use ($id) {
                        if ($id) {
                            $query->where('id', '!=', $id);
                        }
                    })
            ],
            'jl_number' => 'required|int|min:1',
            'division_bbs_code' => 'required|exists:loc_divisions,bbs_code',
            'district_bbs_code' => 'required|exists:loc_districts,bbs_code',
            'upazila_bbs_code' => 'required|exists:loc_upazilas,bbs_code',

            'not_providable' => 'required|boolean',
            'reasons' => 'required|array|min:1',
            'reasons.*' => 'int',
        ];
        $customMessages = [];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
    }

    /**
     * Remove landType number from string
     * input: 123-aaa-bbb-ccc
     * output: aaa-bbb-ccc
     **/
    public function removeFirstString($string)
    {
        return substr($string, strpos($string, "-") + 1);
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

    public function getDistricts(Request $request)
    {
        return LocDistrict::where('division_bbs_code', $request->division_bbs_code)->get();
    }

    public function getUpazilas(Request $request)
    {
        return LocUpazila::where('district_bbs_code', $request->district_bbs_code)->get();
    }

    public function getAllMoujas(Request $request): JsonResponse
    {
        $mouja = LocMouja::getMoujaOptions($request->district_bbs_code, $request->upazila_bbs_code, 'muted');
        return response()->json($mouja);
    }

    public function getMoujasDglrCode(Request $request): JsonResponse
    {
        $mouja = LocMouja::getMouja($request->district_bbs_code, $request->upazila_bbs_code, $request->brs_jl_no, 'muted');
        return response()->json($mouja);
    }

    public function historyLog($id, $type = 'entry')
    {
        $authUser = Auth::user();

        $userOffice = Office::where('id', $authUser->office_id)->first();

        if (empty($userOffice->division_bbs_code)) {
            return response()->json([], 500);
        }

        $mutedTables = \Modules\Khotian\App\Models\MutedKhotianDump::getTableName($userOffice->division_bbs_code);
        $mutedKhotianEntryLogTalbe = $mutedTables['khotian_entry_log'];

        $historyLogs = DB::table($mutedKhotianEntryLogTalbe)
            ->select($mutedKhotianEntryLogTalbe . '.*', 'users.name')
            ->where([$mutedKhotianEntryLogTalbe . '.muted_khotian_id' => $id])
            ->leftJoin('users', 'users.id', '=', $mutedKhotianEntryLogTalbe . '.created_by')
            ->orderBy('id', 'asc')
            ->get();

        return view('khotian::muted-khotian.history-log', compact('historyLogs'));
    }
}
