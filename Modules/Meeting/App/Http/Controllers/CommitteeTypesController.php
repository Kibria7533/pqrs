<?php

namespace Modules\Meeting\App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\BaseModel;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Meeting\App\Services\CommitteeTypeService;
use Modules\Meeting\Models\CommitteeSetting;
use Modules\Meeting\Models\CommitteeType;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommitteeTypesController extends BaseController
{
    const VIEW_PATH = 'meeting::backend.committee-types.';

    protected CommitteeTypeService $committeeTypeService;

    public function __construct(CommitteeTypeService $committeeTypeService)
    {
        $this->committeeTypeService = $committeeTypeService;
        $this->authorizeResource(CommitteeType::class);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view(self::VIEW_PATH . 'index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view(self::VIEW_PATH . 'create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->committeeTypeService->validator($request);

            if ($validatedData->fails()) {
                $errors = $validatedData->errors();

                return response()->json([
                    'message' => __($errors->first()),
                    'alertType' => 'error',
                ], 200);
            }

            $data = $validatedData->validate();

            $data['status'] = BaseModel::STATUS_ACTIVE;

            $this->committeeTypeService->createCommitteeType($data);

            return response()->json([
                'message' => __('generic.committee_type_added'),
                'alertType' => 'success',
                'redirectTo' => route('admin.meeting_management.committee-types.index'),
            ]);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.committee_type_not_added'),
                'alertType' => 'error',
            ], 200);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(committeeType $committeeType)
    {
        $committeeSetting = CommitteeSetting::where('committee_type_id', $committeeType->id)->first();
        return view(self::VIEW_PATH . 'read', compact('committeeType', 'committeeSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param committeeType $committeeType
     * @return Renderable
     */
    public function edit(committeeType $committeeType)
    {
        return view(self::VIEW_PATH . 'edit', compact('committeeType'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param committeeType $committeeType
     * @return Renderable
     */
    public function update(Request $request, committeeType $committeeType)
    {
        try {
            $validatedData = $this->committeeTypeService->validator($request);

            if ($validatedData->fails()) {
                $errors = $validatedData->errors();

                return response()->json([
                    'message' => __($errors->first()),
                    'alertType' => 'error',
                ], 200);
            }

            $data = $validatedData->validate();

            $this->committeeTypeService->updateCommitteeType($data, $committeeType);

            return response()->json([
                'message' => __('generic.committee_type_updated'),
                'alertType' => 'success',
                'redirectTo' => route('admin.meeting_management.committee-types.index'),
            ]);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.committee_type_update_failed'),
                'alertType' => 'error',
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param committeeType $committeeType
     * @return Renderable
     */
    public function destroy(committeeType $committeeType)
    {
        try {
            $this->committeeTypeService->deleteCommitteeType($committeeType);

            return redirect(route('admin.meeting_management.committee-types.index'))->with([
                'message' => __('generic.committee_type_deleted'),
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());

            return redirect(route('admin.meeting_management.committee-types.index'))->with([
                'message' => __('generic.committee_type_delete_failed'),
                'alert-type' => 'error',
            ]);

        }
    }

    public function getCommitteeTypeList(Request $request): JsonResponse
    {
        return $this->committeeTypeService->getListDataForDatatable($request);
    }

    public function committeeSettingCreate(CommitteeType $committeeType)
    {
        $this->authorize('committeeSetting', $committeeType);
        $designations = DB::table('designations')->get();
        $committeeSetting = CommitteeSetting::where('committee_type_id', $committeeType->id)->first();

        $lastKeyOfMemberConfig = 0;

        if(!empty($committeeSetting) && count($committeeSetting->member_config)>0){
            $memberConfig = $committeeSetting->member_config;
            end($memberConfig);
            $lastKeyOfMemberConfig = key($memberConfig);
        }

        return view(self::VIEW_PATH . 'committee-setting.edit-add', compact('committeeType', 'designations','committeeSetting', 'lastKeyOfMemberConfig'));
    }

    public function committeeSettingStore(Request $request, CommitteeType $committeeType)
    {
        $validatedData = $this->committeeTypeService->committeeSettingValidator($request, $committeeType->id);
        $data = $validatedData->validate();

        try{
            $this->committeeTypeService->createCommitteeSetting($committeeType, $data);
        }catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json([
                'message' => __('generic.committee_setting_configured_failed'),
                'alertType' => 'error',
                'redirectTo' => route('admin.meeting_management.committee-types.index'),
            ], 200);
        }

        return response()->json([
            'message' => __('generic.committee_setting_configured_success'),
            'alertType' => 'success',
            'redirectTo' => route('admin.meeting_management.committee-types.index'),
        ], 200);

    }
}
