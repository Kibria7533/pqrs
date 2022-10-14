<?php

namespace Modules\Landless\App\Http\Frontend\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\LocDivision;
use App\Models\LocUpazila;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Landless\App\Models\Landless;
use Modules\Landless\App\Services\LandlessService;

class LandlessController extends BaseController
{
    protected LandlessService $landlessService;
    private const VIEW_PATH = 'landless::frontend.landless.';

    public function __construct(LandlessService $landlessService)
    {
        $this->landlessService = $landlessService;
    }


    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        $locDivisions = LocDivision::all();

        return \view(self::VIEW_PATH . 'landless-application', compact('locDivisions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->landlessService->validator($request);

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();

        $data['status'] == Landless::STATUS_ON_PROGRESS;
        $data['stage '] = Landless::STAGE_ACLAND_SENDING;

        $data['loc_division_bbs'] = Landless::CTG_BBS_CODE;
        $data['loc_district_bbs'] = Landless::NOAKHALI_BBS_CODE;

        $upazila = LocUpazila::where([
            'division_bbs_code' => Landless::CTG_BBS_CODE,
            'district_bbs_code' => Landless::NOAKHALI_BBS_CODE,
            'bbs_code' => $data['loc_upazila_bbs'],
        ])->first();

        if (empty($upazila)) {
            return response()->json([
                'message' => 'Upazila not found',
                'alertType' => 'error',
            ], 200);
        }

        if(empty(AuthHelper::getAuthUser())){
            $data['created_by'] = null;
        }

        try {
            $this->landlessService->createLandless($data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.landless_not_added'),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('generic.landless_added'),
            'alertType' => 'success',
            'redirectTo' => route('landless.landless-application'),
        ]);
    }

}
