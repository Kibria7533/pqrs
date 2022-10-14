<?php

namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Designation;
use Yajra\DataTables\Facades\DataTables;

class DesignationService{
    public function deleteDesignation(Designation $designation): ?bool{
        return $designation->delete();
    }

    public function validator(array $postData, int $id = null): \Illuminate\Contracts\Validation\Validator{
        $rules = [
            'title' => ['required', 'string', 'max:191'],
            'title_en' => ['required', 'string', 'max:191'],
            'level' => 'required',
        ];
        return Validator::make($postData, $rules);
    }

    public function createDesignation(array $postData){
        return Designation::create($postData);
    }

    public function updateDesignation(Designation $designation, array $postData){
        return $designation->update($postData);
    }
    public function getListDataForDatatable(Request $request): JsonResponse{
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder $designations */

        $designations = Designation::select([
            'designations.id as id',
            'designations.title',
            'designations.title_en',
            'designations.level',
        ]);

        return DataTables::eloquent($designations)
            ->editColumn('title', static function (Designation $designation) {
                return Str::limit($designation->title, '20', '...');
            })
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Designation $designation) use ($authUser) {
                $str = '';
                if($authUser->can('view', $designation)) {
                    $str .= '<a href="' . route('admin.designations.show', $designation->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }
                if($authUser->can('update', $designation)) {
                    $str .= '<a href="' . route('admin.designations.edit', $designation->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if($authUser->can('delete', $designation)) {
                    $str .= '<a href="#" data-action="' . route('admin.designations.destroy', $designation->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

    public function syncRolePermission(Designation $designation, array $permissions): Designation{
        $designation->permissions()->sync($permissions);
        /** TODO: not a good idea */
        $designation->users()->pluck('id')->each(function ($userId) {
            Cache::forget('userwise_permissions_' . $userId);
        });

        return $designation;
    }
}
