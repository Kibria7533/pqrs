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
use Modules\Landless\App\Models\FileType;
use Yajra\DataTables\Facades\DataTables;

class FileTypeService
{
    public function createFileType(array $data): FileType
    {
        if(!empty($data['allow_format'])){
            $data['allow_format'] = implode(",",$data['allow_format']);
        }

        if(empty($data['order_number'])){
            $data['order_number'] = '9999';
        }

        return FileType::create($data);
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'title' => [
                'required',
                'string',
                'max: 191',
            ],
            'title_en' => [
                'nullable',
                'string',
                'max:191',
            ],
            'short_code' => [
                'required',
                'string',
            ],
            'allow_format' => [
                'required',
                'array',
                'min:1',
            ],
            'order_number' => [
                'nullable',
                'string',
            ],
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function updateFileType(array $data, FileType $fileType): bool
    {
        if(!empty($data['allow_format'])){
            $data['allow_format'] = implode(",",$data['allow_format']);
        }

        if(empty($data['order_number'])){
            $data['order_number'] = '9999';
        }

        return $fileType->update($data);
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder|FileType $fileTypes */
        $fileTypes = FileType::select([
            'file_types.id as id',
            'file_types.short_code',
            'file_types.title',
            'file_types.title_en',
            'file_types.allow_format',
            'file_types.order_number',
            'file_types.status',
            'file_types.created_by',
            'file_types.updated_by',
            'file_types.created_at',
            'file_types.updated_at',
        ]);

        return DataTables::eloquent($fileTypes)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (FileType $fileTypes) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $fileTypes)) {
                    $str .= '<a href="' . route('admin.file-types.show', $fileTypes->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }
                if ($authUser->can('update', $fileTypes)) {
                    $str .= '<a href="' . route('admin.file-types.edit', $fileTypes->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $fileTypes)) {
                    $str .= '<a href="#" data-action="' . route('admin.file-types.destroy', $fileTypes->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

    public function deleteFileType(FileType $fileType): bool
    {
        return $fileType->delete();
    }
}
