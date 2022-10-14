<?php

namespace Modules\Meeting\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Meeting\Models\Template;
use Yajra\DataTables\Facades\DataTables;

class TemplateService
{
    public function createTemplate(array $data): Template
    {
        return Template::create($data);
    }

    public function updateTemplate(array $data, Template $template): bool
    {
        return $template->update($data);
    }

    public function deleteTemplate(Template $template): bool
    {
        return $template->delete();
    }

    public function validator(Request $request, int $id = null): Validator
    {
        $rules = [
            'title' => 'required|string|max: 191',
            'title_en' => 'required|string|max:191',
            'template_type' => 'required|int',
            'description' => 'required|string',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        $templates = Template::select(
            [
                'templates.id as id',
                'templates.title',
                'templates.title_en',
                'templates.template_type',
                'templates.description',
                'templates.status',
                'templates.created_by',
                'templates.updated_by',
                'templates.created_at',
                'templates.updated_at',
            ]
        );

        return DataTables::eloquent($templates)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Template $template) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $template)) {
                    $str .= '<a href="' . route('admin.meeting_management.templates.show', $template->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.show_button_label') . '</a>';
                }
                if ($authUser->can('update', $template)) {
                    $str .= '<a href="' . route('admin.meeting_management.templates.edit', $template->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }
                if ($authUser->can('delete', $template)) {
                    $str .= '<a href="#" data-action="' . route('admin.meeting_management.templates.destroy', $template->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->addColumn('template_type', static function (Template $template) use ($authUser) {
                return !empty($template->template_type) ? __('generic.' . Template::TEMPLATE_TYPE[$template->template_type]) : '';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

}
