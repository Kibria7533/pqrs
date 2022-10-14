<?php

namespace App\Http\Controllers\Portal;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\LocDivision;
use App\Models\Office;
use App\Services\LandlessApplicationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modules\Landless\App\Models\FileType;
use Modules\Landless\App\Models\Landless;

class LandlessApplicationController extends BaseController
{
    protected LandlessApplicationService $landlessApplicationService;
    private const VIEW_PATH = 'landless::frontend.landless.';
    public function __construct(LandlessApplicationService $landlessApplicationService)
    {
        $this->landlessApplicationService = $landlessApplicationService;

    }

    /**
     * Show the application dashboard.
     * @return View
     */
    public function application(): View
    {
        $locDivisions = LocDivision::all();
        $fileTypes = FileType::all();
        return \view(self::VIEW_PATH . 'application', compact('locDivisions','fileTypes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {

        $validatedData = $this->landlessApplicationService->validator($request);

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();
        $data['status'] = Landless::STATUS_ON_PROGRESS;

        try {
            $this->landlessApplicationService->createLandless($data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('User Not Added'),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('User Added Successfully'),
            'alertType' => 'success',
            'redirectTo' => route('landless.application'),
        ]);
    }
}
