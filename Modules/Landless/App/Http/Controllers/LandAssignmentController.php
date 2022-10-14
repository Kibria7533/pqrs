<?php

namespace Modules\Landless\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\LocDivision;
use App\Models\LocUpazila;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Landless\App\Models\FileType;
use Modules\Landless\App\Models\LandAssignment;
use Modules\Landless\App\Models\Landless;
use Modules\Landless\App\Services\LandAssignmentService;

class LandAssignmentController extends BaseController
{
    protected LandAssignmentService $landAssignmentService;
    private const VIEW_PATH = 'landless::backend.land-assignments.';

    public function __construct(LandAssignmentService $landAssignmentService)
    {
        $this->landAssignmentService = $landAssignmentService;
        $this->authorizeResource(LandAssignment::class);
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     **/
    public function index()
    {
        $locUpazilas = LocUpazila::where([
            'division_bbs_code' => Landless::CTG_BBS_CODE, //20 for CTG division bbs code
            'district_bbs_code' => Landless::NOAKHALI_BBS_CODE, //75 for loc_district_bbs,
        ])->get();
        return view(self::VIEW_PATH . 'browse', compact('locUpazilas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        $locDivisions = LocDivision::all();
        $fileTypes = FileType::all();
        return \view(self::VIEW_PATH . 'edit-add', compact('locDivisions', 'fileTypes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {

    }

    /**
     * Show the specified resource.
     * @param Landless $landless
     * @return Renderable
     */
    public function show(Landless $landless)
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @param Landless $landless
     * @return View
     */
    public function edit(Request $request, Landless $landless): View
    {

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Landless $landless
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Landless $landless): JsonResponse
    {

    }

    /**
     * Remove the specified resource from storage.
     * @param Landless $landless
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Landless $landless)
    {

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->landAssignmentService->getListDataForDatatable($request);
    }

    public function approveScratchMap(LandAssignment $landAssignment): RedirectResponse
    {
        $msg = 'generic.something_wrong_try_again';
        try {
            $authUser = AuthHelper::getAuthUser();
            /*if($authUser->isKanungoUser() || $authUser->isAcLandUser() && $landAssignment->is_scratch_map_created){
                $this->landAssignmentService->scratchMapApproveByKanungoOrAcLand($landAssignment);
            }*/

            //$authUser = AuthHelper::getAuthUser();




            if ($authUser->isKanungoUser() && $landAssignment->is_scratch_map_created) {
                $data['is_scratch_map_approved_by_kanungo'] = 1;
                $msg = 'generic.scratch_map_approved_by_kanungo';
            } else if ($authUser->isAcLandUser() && $landAssignment->is_scratch_map_approved_by_kanungo) {
                $data['is_scratch_map_approved_by_acland'] = 1;
                $data['is_jomabondi_order_by_acland'] = 1;
                $msg = 'generic.scratch_map_approved_by_acland';
            }else{
                return back()->with([
                    'message' => __($msg),
                    'alert-type' => 'error'
                ]);
            }

            $landAssignment->update($data);

        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __($msg),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __($msg),
            'alert-type' => 'success'
        ]);
    }

}
