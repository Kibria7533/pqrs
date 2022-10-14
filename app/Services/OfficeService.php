<?php


namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Models\Office;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OfficeService
{
    public function createOffice(array $data): Office
    {
        return Office::create($data);
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'name_bn' => [
                'required',
                'string',
                'max: 191',
            ],
            'name_en' => [
                'required',
                'string',
                'max:191',
            ],
            'office_type' => [
                'required',
                'int',
                'between:1,3',
            ],
            'jurisdiction' => [
                'required',
                'string',
            ],
            'division_bbs_code' => [
                'nullable',
                'int',
            ],
            'district_bbs_code' => [
                'nullable',
                'int',
            ],
            'upazila_bbs_code' => [
                'nullable',
                'int',
            ],
            'union_bbs_code' => [
                'nullable',
                'int',
            ],
            'dglr_code' => [
                'nullable',
                'int',
            ],
            'org_code' => [
                'nullable',
                'string',
            ],
        ];

        if (!empty($request->jurisdiction) && $request->jurisdiction == 'division') {
            $rules['division_bbs_code'] = [
                'required',
                'int',
            ];
        }

        if (!empty($request->jurisdiction) && $request->jurisdiction == 'district') {
            $rules['division_bbs_code'] = [
                'required',
                'int',
            ];
            $rules['district_bbs_code'] = [
                'required',
                'int',
            ];
        }
        if (!empty($request->jurisdiction) && $request->jurisdiction == 'upazila') {
            $rules['division_bbs_code'] = [
                'required',
                'int',
            ];
            $rules['district_bbs_code'] = [
                'required',
                'int',
            ];
            $rules['upazila_bbs_code'] = [
                'required',
                'int',
            ];
        }

        if (!empty($request->jurisdiction) && $request->jurisdiction == 'union') {
            $rules['division_bbs_code'] = [
                'required',
                'int',
            ];
            $rules['district_bbs_code'] = [
                'required',
                'int',
            ];
            $rules['upazila_bbs_code'] = [
                'required',
                'int',
            ];
            $rules['union_bbs_code'] = [
                'required',
                'int',
            ];
        }

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function updateOffice(array $data, Office $office): bool
    {
        return $office->update($data);
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder|Office $offices */
        $offices = Office::acl()->select([
            'offices.id as id',
            'offices.name_bn',
            'offices.name_en',
            'offices.org_code',
            'offices.office_type',
            'offices.jurisdiction',
            'offices.division_bbs_code',
            'offices.district_bbs_code',
            'offices.upazila_bbs_code',
            'offices.union_bbs_code',
            'offices.dglr_code',
            'offices.status',
            'offices.created_by',
            'offices.updated_by',
            'offices.created_at',
            'offices.updated_at',
            'offices.deleted_at',
        ]);
        //$offices->join('user_types', 'offices.user_type_id', '=', 'user_types.id');
        //$offices->leftJoin('institutes', 'offices.institute_id', '=', 'institutes.id');

        /*if ($request->input('user_type_id')) {
            $offices->where('offices.user_type_id', $request->input('user_type_id'));
        }
        if ($request->input('institute_id')) {
            $offices->where('offices.institute_id', $request->input('institute_id'));
        }*/

        return DataTables::eloquent($offices)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Office $office) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $office)) {
                    $str .= '<a href="' . route('admin.offices.show', $office->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }
                if ($authUser->can('update', $office)) {
                    $str .= '<a href="' . route('admin.offices.edit', $office->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $office)) {
                    $str .= '<a href="#" data-action="' . route('admin.offices.destroy', $office->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->editColumn('office_type', function (Office $office) {
                return !empty($office->office_type) ? __('generic.' . Office::OFFICE_TYPE[$office->office_type]) : '';
            })
            ->editColumn('jurisdiction', function (Office $office) {
                return !empty($office->jurisdiction) ? __('generic.' . Office::JURISDICTION[$office->jurisdiction]) : '';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getListDataForTrainerDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder|User $offices */
        $offices = User::select([
            'offices.id as id',
            'offices.name',
            'offices.user_type_id',
            'institutes.title as institute_title',
            'loc_districts.title as loc_district_name',
            'user_types.title as user_type_title',
            'offices.email',
            'offices.created_at',
            'offices.updated_at'
        ]);
        $offices->join('user_types', 'offices.user_type_id', '=', 'user_types.id');
        $offices->leftJoin('institutes', 'offices.institute_id', '=', 'institutes.id');
        $offices->leftJoin('loc_districts', 'offices.loc_district_id', '=', 'loc_districts.id');
        $offices->where('offices.user_type_id', '=', User::USER_TYPE_TRAINER_USER_CODE);

        if ($authUser->isUserBelongsToInstitute()) {
            $offices->where('offices.institute_id', $authUser->institute_id);
        }

        return DataTables::eloquent($offices)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (User $user) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $user)) {
                    $str .= '<a href="' . route('admin.offices.show', $user->id) . '" class="btn btn-outline-info btn-sm "> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $user) && $authUser->can('updateTrainer', $user)) {
                    $str .= '<a href="' . route('admin.offices.edit', $user->id) . '" class="btn btn-outline-warning btn-sm "> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $user)) {
                    $str .= '<a href="#" data-action="' . route('admin.offices.destroy', $user->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                if ($authUser->can('editTrainerInformation', $user)) {
                    $str .= '<a href="' . route('admin.trainers.additional-info', $user->id) . '" class="btn btn-outline-info btn-sm trainer-info"> <i class="fas fa-info"></i> ' . __('generic.additional_info_button_label') . '</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

    public function deleteOffice(Office $office): bool
    {
        return $office->delete();
    }
}
