<?php

namespace Modules\Khotian\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\FileHandler;
use App\Helpers\Classes\NumberToBanglaWord;
use App\Http\Controllers\Controller;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocMouja;
use App\Models\LocUpazila;
use App\Models\Office;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Modules\Khotian\App\Models\MutedKhotian;
use Modules\Khotian\App\Models\MutedKhotianDump;
use Yajra\DataTables\Facades\DataTables;

class MutedKhotianApproveController extends Controller
{
    public function index()
    {
        $this->authorize('approveBatchEntry', app(MutedKhotian::class));
        $authUser = AuthHelper::getAuthUser();
        $userOffice = Office::where('id', $authUser->office_id)->first();
        $tables = MutedKhotianDump::getTableName(!empty($userOffice->division_bbs_code)?$userOffice->division_bbs_code:20);
        $khotianTalbe = $tables['khotian'];

        $locDivision = LocDivision::where('bbs_code', '=', 20)->first();
        $locDistrict = LocDistrict::where(['bbs_code' => 75, 'division_bbs_code' => 20])->first();
        return view('khotian::muted-khotian.approve-list', compact('locDivision', 'locDistrict','khotianTalbe'));
    }

    public function list(Request $request)
    {
        $this->authorize('approveBatchEntry', app(MutedKhotian::class));

        $authUser = Auth::user();
        $userOffice = Office::where('id', $authUser->office_id)->first();
        if (empty($userOffice->division_bbs_code)) {
            //return response()->json([], 500);
        }

        $mutedTables = MutedKhotianDump::getTableName(!empty($userOffice->division_bbs_code)?$userOffice->division_bbs_code:20);
        $mutedKhotianTalbe = $mutedTables['khotian'];

        $muetdKhotianModel = new MutedKhotian();
        $muetdKhotianModel->setTable($mutedKhotianTalbe);

        /** @var Builder $users */
        $mutedKhotians = $muetdKhotianModel->select([
            $mutedKhotianTalbe . '.id as id',
            $mutedKhotianTalbe . '.khotian_number',
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
        $mutedKhotians->leftJoin('loc_divisions', $mutedKhotianTalbe . '.division_bbs_code', '=', 'loc_divisions.bbs_code');
        $mutedKhotians->leftJoin('loc_districts', $mutedKhotianTalbe . '.district_bbs_code', '=', 'loc_districts.bbs_code');
        $mutedKhotians->leftJoin('loc_upazilas', $mutedKhotianTalbe . '.upazila_bbs_code', '=', 'loc_upazilas.bbs_code');
        $mutedKhotians->leftJoin('loc_all_moujas', function ($join) use ($userOffice, $mutedKhotianTalbe) {
            $join->on($mutedKhotianTalbe . '.division_bbs_code', '=', 'loc_all_moujas.division_bbs_code');
            $join->on($mutedKhotianTalbe . '.district_bbs_code', '=', 'loc_all_moujas.district_bbs_code');
            $join->on($mutedKhotianTalbe . '.upazila_bbs_code', '=', 'loc_all_moujas.upazila_bbs_code');
            $join->on($mutedKhotianTalbe . '.jl_number', '=', 'loc_all_moujas.brs_jl_no');
        });

        $mutedKhotians->where($mutedKhotianTalbe . '.division_bbs_code', !empty($userOffice->division_bbs_code)?$userOffice->division_bbs_code:20);
        $mutedKhotians->where($mutedKhotianTalbe . '.district_bbs_code', !empty($userOffice->district_bbs_code)?$userOffice->district_bbs_code:75);

        if(!empty($userOffice->upazila_bbs_code)){
            $mutedKhotians->where($mutedKhotianTalbe . '.upazila_bbs_code', $userOffice->upazila_bbs_code);
        }
        $mutedKhotians->where($mutedKhotianTalbe . '.is_entry', 1);
        $mutedKhotians->whereIn($mutedKhotianTalbe . '.status', [MutedKhotian::ON_PROGRESS, MutedKhotian::MODIFY]);
        $mutedKhotians->where($mutedKhotianTalbe . '.stage', MutedKhotian::STAGE_APPROVE);
        $mutedKhotians->where($mutedKhotianTalbe . '.send_to_index', 0);

        /**
         * searchBy Bn also
         **/
        $request->request->add(['search' => [
            "value" => !empty($request['search']['value']) ? bn2en($request['search']['value']) : '',
            "regex" => $request['search']['regex'],
        ]]);

        $mutedKhotians->groupBy($mutedKhotianTalbe . '.district_bbs_code', $mutedKhotianTalbe . '.upazila_bbs_code', $mutedKhotianTalbe . '.jl_number', $mutedKhotianTalbe . '.khotian_number');

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
                    return NumberToBanglaWord::engToBn($mutedKhotian->case_date);
                })
                ->editColumn('scan_copy', function (MutedKhotian $mutedKhotian) use ($authUser) {
                    $str = "";
                    if (!empty($mutedKhotian->scan_copy)) {
                        if (pathinfo($mutedKhotian->scan_copy, PATHINFO_EXTENSION) === 'pdf') {
                            $str .= '<a target="_blank" class="btn btn-info" href="' . (!empty($mutedKhotian->scan_copy) ? asset("storage/{$mutedKhotian->scan_copy}") : "") . '">
                                <i class="fa fa-eye"></i> দেখুন</a>';
                        } else {
                            $str .= '<a target="_blank" class="btn btn-info scan_copy_view" data-action="' . (!empty($mutedKhotian->scan_copy) ? asset("storage/{$mutedKhotian->scan_copy}") : "") . '">
                                <i class="fa fa-eye"></i> দেখুন</a>';
                        }
                    }
                    return $str;
                })
                ->addColumn('check', function (MutedKhotian $mutedKhotian) use ($authUser, &$srl) {
                    $srl++;
                    return '<input id="' . $srl . '" class="muted-khotian-id" type="checkbox" value="' . $mutedKhotian->id . '"/> <label style="padding:3px 15px;" for="' . $srl . '"> ' . NumberToBanglaWord::engToBn($srl) . '</label>';
                })
                ->addColumn('status', function (MutedKhotian $mutedKhotian) use ($authUser) {
                    $str = "";
                    if ($mutedKhotian->status == MutedKhotian::ON_PROGRESS) {
                        $str = "নতুন";
                    }
                    if ($mutedKhotian->status == MutedKhotian::MODIFY) {
                        $str = "পুনঃঅনুমোদন";
                    }
                    return $str;
                })
                ->addColumn('action', function (MutedKhotian $mutedKhotian) use ($authUser) {
                    $str = "<div class='btn-group'>";
                    $str .= ' <a class="btn btn-sm btn-warning view" href="' . route('admin.khotians.show', $mutedKhotian->id) . '"><i class="fas fa-eye"></i> ' . __('বিস্তারিত') . '</a>';
                    $str .= '<a class="btn btn-sm btn-info muted_khotian_history_log" data-action="' . route('admin.khotians.history_log', [$mutedKhotian->id, $mutedKhotian->khotian_number, 'type' => 'approve']) . '" ><i class="fa fa-history" aria-hidden="true"></i> লগ</a>';
                    if ($authUser->can('KhatianPreview', $mutedKhotian)) {
                        $str .= '<a target="_blank" href="' . route('admin.khotians.print', $mutedKhotian->id) . '" class="btn btn-info">
                                <i class="fa fa-print"></i> প্রিন্ট</a>';
                    }

                    $str .= "</div>";
                    return $str;
                })
                ->rawColumns(['status', 'action', 'check', 'scan_copy'])
                ->toJson();
        } catch (\Exception $ex) {
            return response()->json([]);
        }
    }

    public function store(Request $request, $id, $khotianNumber)
    {
        $authUser = Auth::user();
        $userOffice = Office::where('id', $authUser->office_id)->first();
        if (empty($userOffice->division_bbs_code)) {
            return Redirect::back()
                ->with([
                    'message' => 'দুঃখিত। অফিস খুঁজে পাওয়া যায়নি',
                    'alert-type' => 'error'
                ])->withInput();
        }

        try {
            DB::beginTransaction();

            $mutedTables = MutedKhotianDump::getTableName($userOffice->division_bbs_code);
            $mutedKhotianTable = $mutedTables['khotian'];
            $mutedKhotianOwnerTable = $mutedTables['khotian_owner'];
            $mutedKhotianDagTable = $mutedTables['khotian_dag'];
            $mutedKhotianIndexTable = $mutedTables['index'];
            $mutedKhotianEntryLogTalbe = $mutedTables['khotian_entry_log'];

            $muetdKhotianModel = new MutedKhotian();
            $muetdKhotianModel = $muetdKhotianModel->setTable($mutedKhotianTable);

            $mutedKhotianRow = $muetdKhotianModel->select([
                $mutedKhotianTable . '.id',
                $mutedKhotianTable . '.district_bbs_code',
                $mutedKhotianTable . '.upazila_bbs_code',
                $mutedKhotianTable . '.jl_number',
                $mutedKhotianTable . '.khotian_number',
                $mutedKhotianTable . '.batch_entry',
                DB::raw("group_concat(DISTINCT $mutedKhotianOwnerTable.owner_name) as owners"),
                DB::raw("group_concat(DISTINCT $mutedKhotianDagTable.dag_number) as dags")
            ])
                ->leftJoin($mutedKhotianDagTable, $mutedKhotianTable . '.id', '=', $mutedKhotianDagTable . '.muted_khotian_id')
                ->leftJoin($mutedKhotianOwnerTable, $mutedKhotianTable . '.id', '=', $mutedKhotianOwnerTable . '.muted_khotian_id')
                ->where([
                    $mutedKhotianTable . '.id' => $id,
                    $mutedKhotianTable . '.khotian_number' => $khotianNumber,
                    $mutedKhotianTable . '.division_bbs_code' => $userOffice->division_bbs_code,
                    $mutedKhotianTable . '.district_bbs_code' => $userOffice->district_bbs_code,
                    $mutedKhotianTable . '.upazila_bbs_code' => $userOffice->upazila_bbs_code,
                    $mutedKhotianTable . '.stage' => MutedKhotian::STAGE_APPROVE,
                    $mutedKhotianTable . '.send_to_index' => 0
                ])
                ->whereIn($mutedKhotianTable . '.status', [MutedKhotian::ON_PROGRESS, MutedKhotian::MODIFY])
                ->groupBy($mutedKhotianTable . '.khotian_number')
                ->first();

            if (empty($mutedKhotianRow)) {
                throw new \Exception('খতিয়ান খুঁজে পাওয়া যায়নি। অনুগ্রহ করে সঠিক পদক্ষেপ গ্রহণ করুন');
            }

            $isExistIndexRow = DB::table($mutedKhotianIndexTable)->where([
                'district_bbs_code' => $mutedKhotianRow->district_bbs_code,
                'upazila_bbs_code' => $mutedKhotianRow->upazila_bbs_code,
                'mouja_jl_code' => $mutedKhotianRow->jl_number,
                'khotian_no' => $mutedKhotianRow->khotian_number
            ])
                ->whereIn('system_type', ['emutation', 'emuted', 'eporcha'])
                ->first();

            if ($isExistIndexRow) {
                throw new \Exception('খতিয়ানটি পূর্বেই অন্তর্ভুক্ত করা রয়েছে!');
            }

            /** Generate Muted khotian entry log data **/
            $entryLogData = [
                'muted_khotian_id' => $id,
                'status' => $mutedKhotianRow->status,
                'stage' => $mutedKhotianRow->stage,
                'is_taken_action' => 2, //Normal Log (not return)
                'created_by' => $authUser->id,
                'created_at' => Carbon::now()
            ];

            /** Generate Muted Khotian Table Data**/
            $mutedKhotianRow->status = MutedKhotian::PUBLISHED;
            $mutedKhotianRow->stage = MutedKhotian::STAGE_ACTIVE;
            $mutedKhotianRow->is_approve = 1;
            $mutedKhotianRow->approve_by = $authUser->id;
            $mutedKhotianRow->approve_date = Carbon::now();
            $mutedKhotianRow->send_to_index = 1;

            /** Make index table data array **/
            $indexData = [
                'district_bbs_code' => $mutedKhotianRow->district_bbs_code,
                'upazila_bbs_code' => $mutedKhotianRow->upazila_bbs_code,
                'mouja_jl_code' => $mutedKhotianRow->jl_number,
                'system_type' => $mutedKhotianRow->system_type ?? 'eporcha',
                'system_entry_id' => $mutedKhotianRow->id,
                'khotian_no' => $mutedKhotianRow->khotian_number,
                'owner' => $mutedKhotianRow->owners,
                'address' => null,
                'dag' => $mutedKhotianRow->dags,
                'created_at' => Carbon::now()
            ];


            $mutedKhotianRow->update();

            DB::table($mutedKhotianEntryLogTalbe)->insert($entryLogData);

            $indexId = DB::table($mutedKhotianIndexTable)->insertGetId($indexData);
            DB::commit();

        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());

            return back()
                ->with([
                    'message' => $exception->getMessage(),
                    'alert-type' => 'error'
                ]);
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        return redirect()->route('admin.khotians.approve.index')
            ->with([
                'message' => __('অনুমোদন সফল হয়েছে'),
                'alert-type' => 'success'
            ]);
    }

    public function return(Request $request, $id, $khotianNumber)
    {
        $this->authorize('approveBatchEntry', app(MutedKhotian::class));

        $authUser = Auth::user();

        $userOffice = Office::where('id', $authUser->office_id)->first();

        if (empty($userOffice->division_bbs_code)) {
            return Redirect::back()
                ->with([
                    'message' => 'দুঃখিত। অফিস খুঁজে পাওয়া যায়নি',
                    'alert-type' => 'error'
                ])->withInput();
        }

        DB::beginTransaction();
        try {
            $mutedTables = MutedKhotianDump::getTableName($userOffice->division_bbs_code);
            $mutedKhotianTalbe = $mutedTables['khotian'];
            $mutedKhotianEntryLogTalbe = $mutedTables['khotian_entry_log'];

            $muetdKhotianModel = new MutedKhotian();
            $muetdKhotianModel = $muetdKhotianModel->setTable($mutedKhotianTalbe);
            $mutedKhotianRow = $muetdKhotianModel->where([
                'id' => $id,
                'khotian_number' => $khotianNumber,
                'division_bbs_code' => $userOffice->division_bbs_code,
                'district_bbs_code' => $userOffice->district_bbs_code,
                'upazila_bbs_code' => $userOffice->upazila_bbs_code,
                'stage' => MutedKhotian::STAGE_APPROVE
            ])
                ->whereIn('status', [MutedKhotian::ON_PROGRESS, MutedKhotian::MODIFY])
                ->first();

            if (empty($mutedKhotianRow)) {
                throw new \Exception('খতিয়ান খুঁজে পাওয়া যায়নি। অনুগ্রহ করে সঠিক পদক্ষেপ গ্রহণ করুন');
            }

            /** Generate Muted khotian entry log data **/
            $entryLogData = [
                'muted_khotian_id' => $id,
                'remark' => trim(strip_tags($request->remark)),
                'status' => $mutedKhotianRow->status,
                'stage' => $mutedKhotianRow->stage,
                'is_taken_action' => 0,
                'created_by' => $authUser->id,
                'created_at' => Carbon::now()
            ];

            /** Update Muted Khotian **/
            $mutedKhotianRow->stage = MutedKhotian::STAGE_WRITER;
            $mutedKhotianRow->status = MutedKhotian::MODIFY;
            $mutedKhotianRow->is_compare = null;
            $mutedKhotianRow->compare_by = null;
            $mutedKhotianRow->compare_date = null;
            $mutedKhotianRow->is_approve = null;
            $mutedKhotianRow->approve_by = null;
            $mutedKhotianRow->approve_date = null;
            if (!$mutedKhotianRow->update()) {
                throw new \Exception('খতিয়ান ফেরত পাঠানো বিফল হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন!');
            }

            DB::table($mutedKhotianEntryLogTalbe)->insert($entryLogData);

            DB::commit();

        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());

            return back()
                ->with([
                    'message' => $exception->getMessage(),
                    'alert-type' => 'error'
                ]);
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        return redirect()->route('admin.khotians.approve.index')
            ->with([
                'message' => __('ফেরত পাঠানো সফল হয়েছে'),
                'alert-type' => 'success'
            ]);
    }

    public function scanFileUpload(Request $request, $id)
    {
        $validatedData = $this->validateScanFile($request, $id);

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();
            return back()->with([
                'message' => __($errors->first()),
                'alert-type' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();

        $officeUser = Offices::getUserOffice();
        $MutedKhotianTables = MutedKhotianDump::getTableName($officeUser->division_bbs_code);
        $tableMutedKhotians = $MutedKhotianTables['khotian'];
        $tableMutedKhotianDags = $MutedKhotianTables['khotian_dag'];
        $tableMutedKhotianOwners = $MutedKhotianTables['khotian_owner'];

        $mutedKhotian = DB::table($tableMutedKhotians)->where('id', $id);
        $mutedKhotianRow = $mutedKhotian->first();

        if ($mutedKhotianRow->scan_copy && !empty($data['scan_copy'])) {
            FileHandler::deleteFile($mutedKhotianRow->scan_copy);
        }

        if (!empty($data['scan_copy'])) {
            $filename = FileHandler::storePhoto($data['scan_copy'], 'muted-khotians/division_' . $officeUser->division_bbs_code . '/district_' . $officeUser->district_bbs_code . '/upazila_' . $officeUser->upazila_bbs_code);
            $data['scan_copy'] = 'muted-khotians/division_' . $officeUser->division_bbs_code . '/district_' . $officeUser->district_bbs_code . '/upazila_' . $officeUser->upazila_bbs_code . '/' . $filename;
        } else {
            unset($data['scan_copy']);
        }
        if (!empty($data)) {
            $mutedKhotian->update($data);
            return back()->with([
                'message' => "খতিয়ানের স্ক্যান ফাইল প্রদান সফল হয়েছে",
                'alert-type' => 'success',
            ], 200);
        } else {
            return back()->with([
                'message' => "খতিয়ানের স্ক্যান ফাইল অপরিবর্তিত রয়েছে",
                'alert-type' => 'success',
            ], 200);
        }
    }

    public function validateScanFile(Request $request, $id = null): Validator
    {
        $rules = [
            'scan_copy' => 'nullable|max:2000|mimes:jpg,pdf',
        ];
        $customMessages = [
            'scan_copy.max' => "খতিয়ানের স্ক্যান ফাইল সাইজ সর্বোচ্চ 2Mb প্রদান করুন।",
            'scan_copy.mimes' => "খতিয়ানের স্ক্যান ফাইল এর ধরণ jpg/pdf প্রদান করুন।",
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
    }
}
