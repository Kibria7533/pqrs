<?php

namespace App\Http\Controllers\GeoLocations;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Http\Controllers\BaseController;
use App\Models\LocAllMouja;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocUnion;
use App\Models\LocUpazila;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class LocAllMoujaController extends BaseController
{
    private const VIEW_PATH = 'backend.geo-locations.loc-all-moujas.';

    public function __construct()
    {
        $this->authorizeResource(LocAllMouja::class);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $locDivisions = LocDivision::all();
        return view(self::VIEW_PATH . 'browse', compact('locDivisions'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $locUpazila = new LocUpazila();

        return view(self::VIEW_PATH . 'ajax.edit-add', compact('locUpazila'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->validator($request)->validate();

        if (!empty($validatedData['loc_division_id'])) {
            $locDivision = LocDivision::findOrFail($validatedData['loc_division_id']);
            $validatedData['division_bbs_code'] = $locDivision->bbs_code;
            $validatedData['division_name'] = str_replace(' ', '', $locDivision->title);
        }

        if (!empty($validatedData['loc_division_id']) && !empty($validatedData['loc_district_id'])) {
            $locDistrict = LocDistrict::where([
                'loc_division_id' => $validatedData['loc_division_id'],
                'id' => $validatedData['loc_district_id'],
            ])->first();
            $validatedData['district_bbs_code'] = $locDistrict->bbs_code;
            $validatedData['district_name'] = $locDistrict->title;
        }

        if (!empty($validatedData['loc_division_id']) && !empty($validatedData['loc_district_id']) && !empty($validatedData['loc_upazila_id'])) {
            $locUpazila = LocUpazila::where([
                'loc_division_id' => $validatedData['loc_division_id'],
                'loc_district_id' => $validatedData['loc_district_id'],
                'id' => $validatedData['loc_upazila_id'],
            ])->first();
            $validatedData['upazila_bbs_code'] = $locUpazila->bbs_code;
            $validatedData['upazila_name'] = $locUpazila->title;
        }

        try {
            LocAllMouja::create($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again') . $exception->getMessage(), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_created_successfully', ['object' => 'Mouja']), 'alert-type' => 'success']);

    }

    /**
     * @param LocUnion $locUnion
     * @return View
     */
    public function show(LocAllMouja $locAllMouja): View
    {
        return view(self::VIEW_PATH . 'ajax.read', compact('locAllMouja'));
    }

    /**
     * @param LocAllMouja $locAllMouja
     * @return View
     */
    public function edit(LocAllMouja $locAllMouja): View
    {
        $locDivision = LocDivision::where([
            'bbs_code' => $locAllMouja->division_bbs_code
        ])->first();

        $locDistrict = LocDistrict::where([
            'division_bbs_code' => $locAllMouja->division_bbs_code,
            'bbs_code' => $locAllMouja->district_bbs_code
        ])->first();

        $locUpazila = LocUpazila::where([
            'division_bbs_code' => $locAllMouja->division_bbs_code,
            'district_bbs_code' => $locAllMouja->district_bbs_code,
            'bbs_code' => $locAllMouja->upazila_bbs_code,
        ])->first();

        return view(self::VIEW_PATH . 'ajax.edit-add', compact('locAllMouja','locDivision','locDistrict','locUpazila'));
    }

    public function update(Request $request, LocAllMouja $locAllMouja): JsonResponse
    {
        $validatedData = $this->validator($request)->validate();

        if (!empty($validatedData['loc_division_id'])) {
            $locDivision = LocDivision::findOrFail($validatedData['loc_division_id']);
            $validatedData['division_bbs_code'] = $locDivision->bbs_code;
            $validatedData['division_name'] = str_replace(' ', '', $locDivision->title);
        }

        if (!empty($validatedData['loc_division_id']) && !empty($validatedData['loc_district_id'])) {
            $locDistrict = LocDistrict::where([
                'loc_division_id' => $validatedData['loc_division_id'],
                'id' => $validatedData['loc_district_id'],
            ])->first();
            $validatedData['district_bbs_code'] = $locDistrict->bbs_code;
            $validatedData['district_name'] = $locDistrict->title;
        }

        if (!empty($validatedData['loc_division_id']) && !empty($validatedData['loc_district_id']) && !empty($validatedData['loc_upazila_id'])) {
            $locUpazila = LocUpazila::where([
                'loc_division_id' => $validatedData['loc_division_id'],
                'loc_district_id' => $validatedData['loc_district_id'],
                'id' => $validatedData['loc_upazila_id'],
            ])->first();
            $validatedData['upazila_bbs_code'] = $locUpazila->bbs_code;
            $validatedData['upazila_name'] = $locUpazila->title;
        }

        try {
            $locAllMouja->update($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again') . $exception->getMessage(), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_updated_successfully', ['object' => 'Union']), 'alert-type' => 'success']);
    }

    /**
     * @param LocAllMouja $locAllMouja
     * @return RedirectResponse
     */
    public function destroy(LocAllMouja $locAllMouja): RedirectResponse
    {
        try {
            $locAllMouja->delete();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Union']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Request $request
     * @return Validator
     */
    public function validator(Request $request): Validator
    {
        return \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|max:191',
            'name_bd' => 'required|max:191',
            'loc_division_id' => 'required|exists:loc_divisions,id',
            'loc_district_id' => 'required|exists:loc_districts,id',
            'loc_upazila_id' => 'required|exists:loc_upazilas,id',
            'dglr_code' => 'string',
            'rsk_jl_no' => 'nullable|int',
            'cs_jl_no' => 'nullable|int',
            'sa_jl_no' => 'nullable|int',
            'rs_jl_no' => 'nullable|int',
            'pety_jl_no' => 'nullable|int',
            'diara_jl_no' => 'nullable|int',
            'bs_jl_no' => 'nullable|int',
            'city_jl_no' => 'nullable|int',
            'brs_jl_no' => 'nullable|int',
            'created_by' => 'nullable',
            'updated_by' => 'nullable',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder $locDivisions */
        $locAllMoujas = LocAllMouja::select([
            'loc_all_moujas.id',
            'loc_all_moujas.name',
            'loc_all_moujas.name_bd',
            'loc_all_moujas.dglr_code',
            'loc_all_moujas.created_at',
            'loc_all_moujas.updated_at',
            'loc_all_moujas.division_name',
            'loc_all_moujas.district_name',
            'loc_all_moujas.upazila_name',
            'loc_all_moujas.division_bbs_code',
            'loc_all_moujas.district_bbs_code',
            'loc_all_moujas.upazila_bbs_code',
        ]);

        /** relations */

        return DataTables::eloquent($locAllMoujas)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (LocAllMouja $locAllMouja) use ($authUser) {
                $str = '';

                if ($authUser->can('view', $locAllMouja)) {
                    $str .= '<a href="#" data-url="' . route('admin.loc-all-moujas.show', $locAllMouja->id) . '" class="btn btn-outline-info btn-sm dt-view"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $locAllMouja)) {
                    $str .= '<a href="#" data-url="' . route('admin.loc-all-moujas.edit', $locAllMouja->id) . '" class="btn btn-outline-warning btn-sm dt-edit"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $locAllMouja)) {
                    $str .= '<a href="#" data-action="' . route('admin.loc-all-moujas.destroy', $locAllMouja->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

}
