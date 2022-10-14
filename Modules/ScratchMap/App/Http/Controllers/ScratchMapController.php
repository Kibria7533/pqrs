<?php

namespace Modules\ScratchMap\App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Landless\App\Models\Kabuliat;
use Modules\ScratchMap\App\Models\ScratchMap;
use Modules\ScratchMap\App\Services\ScratchMapService;

class ScratchMapController extends BaseController
{
    protected ScratchMapService $scratchMapService;
    private const VIEW_PATH = 'scratch-map::backend.scratch-maps.';

    public function __construct(ScratchMapService $scratchMapService)
    {
        $this->scratchMapService = $scratchMapService;
        $this->authorizeResource(ScratchMap::class);
    }


    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        return view(self::VIEW_PATH . 'browse');
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return \view(self::VIEW_PATH . 'edit-add');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        //$request->request->add(['case_year' => bn2en($request->case_year)]);
        $validatedData = $this->kabuliatService->validator($request);

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();

        if (!empty($request->save_as_draft) && $request->save_as_draft == Kabuliat::SAVE_AS_DRAFT) {
            $data['status'] = Kabuliat::SAVE_AS_DRAFT;
        }else{
            $data['status'] = Kabuliat::STATUS_ACTIVE;
        }

        try {
            $this->kabuliatService->createKabuliat($data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.kabuliat_not_added'),
                'alertType' => 'error',
            ], 200);
        }
        return response()->json([
            'message' => __('generic.kabuliat_added'),
            'alertType' => 'success',
            'redirectTo' => route('admin.kabuliats.index'),
        ]);
    }

    /**
     * Show the specified resource.
     * @param Kabuliat $kabuliat
     * @return Renderable
     */
    public function show(Kabuliat $kabuliat)
    {
        return view(self::VIEW_PATH . 'read', compact('kabuliat'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @param Kabuliat $kabuliat
     * @return View
     */
    public function edit(Request $request, Kabuliat $kabuliat): View
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('kabuliat'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Kabuliat $kabuliat
     * @return JsonResponse
     */
    public function update(Request $request, Kabuliat $kabuliat): JsonResponse
    {
        $validatedData = $this->kabuliatService->validator($request);

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();
            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();

        if (!empty($request->save_as_draft) && $request->save_as_draft == Kabuliat::SAVE_AS_DRAFT) {
            $data['status'] = Kabuliat::SAVE_AS_DRAFT;
        }else{
            $data['status'] = Kabuliat::STATUS_ACTIVE;
        }

        try {
            $this->kabuliatService->updateKabuliat($data, $kabuliat);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.kabuliat_not_updated'),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('generic.kabuliat_updated'),
            'alertType' => 'success',
            'redirectTo' => route('admin.kabuliats.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Kabuliat $kabuliat
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Kabuliat $kabuliat)
    {
        try {
            $this->kabuliatService->deleteKabuliat($kabuliat);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());

            return redirect(route('admin.kabuliats.index'))->with([
                'message' => __('generic.kabuliat_not_removed'),
                'alert-type' => 'error',
            ]);

        }

        return redirect(route('admin.kabuliats.index'))->with([
            'message' => __('generic.kabuliat_removed'),
            'alert-type' => 'success',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->kabuliatService->getListDataForDatatable($request);
    }


}
