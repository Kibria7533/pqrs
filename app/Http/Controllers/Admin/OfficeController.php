<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocUnion;
use App\Models\LocUpazila;
use App\Models\Office;
use App\Services\OfficeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class OfficeController extends BaseController
{
    const  VIEW_PATH = "master::backend.office.";

    protected OfficeService $officeService;

    public function __construct(OfficeService $officeService)
    {
        $this->officeService = $officeService;
        $this->authorizeResource(Office::class);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $locDivisions = LocDivision::get();
        return \view(self::VIEW_PATH . 'edit-add', compact('locDivisions'));
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->officeService->validator($request)->validate();

        try {
            $this->officeService->createOffice($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json([
                'message' => __('generic.office_not_added'),
                'alertType' => 'error',
                'redirectTo' => route('admin.offices.create'),
            ]);
        }

        return response()->json([
            'message' => __('generic.office_added'),
            'alertType' => 'success',
            'redirectTo' => route('admin.offices.create'),
        ]);
    }

    /**
     * @param Office $office
     * @param Request $request
     * @return View
     */
    public function show(Office $office, Request $request): View
    {
        return \view(self::VIEW_PATH . 'read', compact('office'));
    }

    /**
     * @param Office $office
     * @return View
     */
    public function edit(Office $office): View
    {
        $locDivisions = LocDivision::get();
        $locDistricts = LocDistrict::where('division_bbs_code', $office->division_bbs_code)->get();
        $locUpazilas = LocUpazila::where(['division_bbs_code' => $office->division_bbs_code, 'district_bbs_code' => $office->district_bbs_code])->get();
        $locUnions = LocUnion::where(['division_bbs_code' => $office->division_bbs_code, 'district_bbs_code' => $office->district_bbs_code, 'upazila_bbs_code' => $office->upazila_bbs_code])->get();

        return \view(self::VIEW_PATH . 'edit-add', compact('office', 'locDivisions', 'locDistricts', 'locUpazilas', 'locUnions'));
    }

    /**
     * @param Office $office
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Office $office, Request $request): JsonResponse
    {
        $validatedData = $this->officeService->validator($request, $office->id)->validate();
        if (!empty($request->jurisdiction) && $request->jurisdiction == 'division') {
            $validatedData['district_bbs_code'] = null;
            $validatedData['upazila_bbs_code'] = null;
            $validatedData['union_bbs_code'] = null;
        }
        if (!empty($request->jurisdiction) && $request->jurisdiction == 'district') {
            $validatedData['upazila_bbs_code'] = null;
            $validatedData['union_bbs_code'] = null;
        }
        if (!empty($request->jurisdiction) && $request->jurisdiction == 'upazila') {
            $validatedData['union_bbs_code'] = null;
        }

        DB::beginTransaction();
        try {
            $this->officeService->updateOffice($validatedData, $office);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error',
                'redirectTo' => route('admin.offices.index'),
            ]);
        }

        return response()->json([
            'message' => __('generic.object_updated_successfully', ['object' => __('generic.office')]),
            'alertType' => 'success',
            'redirectTo' => route('admin.offices.index'),
        ]);

    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param Office $office
     */
    public function destroy(Office $office)
    {
        try {
            $this->officeService->deleteOffice($office);
        } catch (\Exception $exception) {
            return redirect(route('admin.offices.index'))->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error',
            ]);
        }

        return redirect(route('admin.offices.index'))->with([
            'message' => __('generic.object_deleted_successfully', ['object' => __('generic.office')]),
            'alert-type' => 'success',
        ]);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->officeService->getListDataForDatatable($request);
    }
}
