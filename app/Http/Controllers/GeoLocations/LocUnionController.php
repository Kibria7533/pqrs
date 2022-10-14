<?php

namespace App\Http\Controllers\GeoLocations;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Http\Controllers\BaseController;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class LocUnionController extends BaseController
{
    private const VIEW_PATH = 'backend.geo-locations.loc-unions.';

    public function __construct()
    {
        //$this->authorizeResource(LocUnion::class);
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
        }

        if (!empty($validatedData['loc_division_id']) && !empty($validatedData['loc_district_id'])) {
            $locDistrict = LocDistrict::where([
                'loc_division_id' => $validatedData['loc_division_id'],
                'id' => $validatedData['loc_district_id'],
            ])->first();
            $validatedData['district_bbs_code'] = $locDistrict->bbs_code;
        }

        if (!empty($validatedData['loc_division_id']) && !empty($validatedData['loc_district_id']) && !empty($validatedData['loc_upazila_id'])) {
            $locUpazila = LocUpazila::where([
                'loc_division_id' => $validatedData['loc_division_id'],
                'loc_district_id' => $validatedData['loc_district_id'],
                'id' => $validatedData['loc_upazila_id'],
            ])->first();
            $validatedData['upazila_bbs_code'] = $locUpazila->bbs_code;
        }

        try {
            LocUnion::create($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again').$exception->getMessage(), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_created_successfully', ['object' => 'Union']), 'alert-type' => 'success']);

    }

    /**
     * @param LocUnion $locUnion
     * @return View
     */
    public function show(LocUnion $locUnion): View
    {
        return view(self::VIEW_PATH . 'ajax.read', compact('locUnion'));
    }

    /**
     * @param LocUpazila $locUpazila
     * @return View
     */
    public function edit(LocUnion $locUnion): View
    {
        return view(self::VIEW_PATH . 'ajax.edit-add', compact('locUnion'));
    }

    public function update(Request $request, LocUnion $locUnion): JsonResponse
    {
        $validatedData = $this->validator($request)->validate();

        if (!empty($validatedData['loc_division_id'])) {
            $locDivision = LocDivision::findOrFail($validatedData['loc_division_id']);
            $validatedData['division_bbs_code'] = $locDivision->bbs_code;
        }

        if (!empty($validatedData['loc_division_id']) && !empty($validatedData['loc_district_id'])) {
            $locDistrict = LocDistrict::where([
                'loc_division_id' => $validatedData['loc_division_id'],
                'id' => $validatedData['loc_district_id'],
            ])->first();
            $validatedData['district_bbs_code'] = $locDistrict->bbs_code;
        }

        if (!empty($validatedData['loc_division_id']) && !empty($validatedData['loc_district_id']) && !empty($validatedData['loc_upazila_id'])) {
            $locUpazila = LocUpazila::where([
                'loc_division_id' => $validatedData['loc_division_id'],
                'loc_district_id' => $validatedData['loc_district_id'],
                'id' => $validatedData['loc_upazila_id'],
            ])->first();
            $validatedData['upazila_bbs_code'] = $locUpazila->bbs_code;
        }

        try {
            $locUnion->update($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again').$exception->getMessage(), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_updated_successfully', ['object' => 'Union']), 'alert-type' => 'success']);
    }

    /**
     * @param LocUpazila $locUpazila
     * @return RedirectResponse
     */
    public function destroy(LocUnion $locUnion): RedirectResponse
    {
        try {
            $locUnion->delete();
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
            'title_en' => 'required|max:191',
            'title' => 'required|max:191',
            'bbs_code' => 'required|max:4',
            'loc_division_id' => 'required|exists:loc_divisions,id',
            'division_bbs_code' => 'nullable',
            'loc_district_id' => 'required|exists:loc_districts,id',
            'district_bbs_code' => 'nullable',
            'loc_upazila_id' => 'required|exists:loc_upazilas,id',
            'upazila_bbs_code' => 'nullable',
            'status' => 'nullable',
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
        $locUnions = LocUnion::select([
            'loc_unions.id as id',
            'loc_unions.title_en',
            'loc_unions.title',
            'loc_unions.bbs_code',
            'loc_unions.created_at',
            'loc_unions.updated_at',
            'loc_unions.division_bbs_code as division_bbs_code',
            'loc_unions.district_bbs_code as district_bbs_code',
            'loc_unions.upazila_bbs_code as upazila_bbs_code',
            'loc_divisions.title as loc_divisions.title',
            'loc_districts.title as loc_districts.title',
            'loc_upazilas.title as loc_upazilas.title',
        ]);

        /** relations */

        $locUnions->join('loc_divisions', 'loc_unions.loc_division_id', '=', 'loc_divisions.id');
        $locUnions->join('loc_districts', 'loc_unions.loc_district_id', '=', 'loc_districts.id');
        $locUnions->join('loc_upazilas', 'loc_unions.loc_upazila_id', '=', 'loc_upazilas.id');

        return DataTables::eloquent($locUnions)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (LocUnion $locUnion) use ($authUser) {
                $str = '';

                if ($authUser->can('view', $locUnion)) {
                    $str .= '<a href="#" data-url="' . route('admin.loc-unions.show', $locUnion->id) . '" class="btn btn-outline-info btn-sm dt-view"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $locUnion)) {
                    $str .= '<a href="#" data-url="' . route('admin.loc-unions.edit', $locUnion->id) . '" class="btn btn-outline-warning btn-sm dt-edit"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $locUnion)) {
                    $str .= '<a href="#" data-action="' . route('admin.loc-unions.destroy', $locUnion->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

}
