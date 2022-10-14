<?php

namespace Modules\Meeting\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Meeting\Models\CommitteeSetting;
use Modules\Meeting\Models\CommitteeType;
use Yajra\DataTables\Facades\DataTables;

class CommitteeTypeService
{
    public function createCommitteeType(array $data): CommitteeType
    {
        return CommitteeType::create($data);
    }

    public function updateCommitteeType(array $data, CommitteeType $committeeType): bool
    {
        return $committeeType->update($data);
    }

    public function deleteCommitteeType(CommitteeType $committeeType): bool
    {
        return $committeeType->delete();
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'title' => 'required|string|max: 191',
            'title_en' => 'required|string|max:191',
            'office_type' => 'required|int|min:1',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function committeeSettingValidator(Request $request, $id = null): Validator
    {
        $rules = [
            'committee_type_id' => 'required|exists:committee_types,id',
            'number_of_member' => 'required|int',
            'min_attendance' => 'required|int',
            'member_config' => 'required|array|min:1',
            'member_config*org_designation' => 'required|string',
            'member_config*org_designation_id' => 'required|exists:designations,id',
            'member_config*committee_designation_id' => 'required|int',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        $committeeTypes = CommitteeType::select(
            [
                'committee_types.id as id',
                'committee_types.title',
                'committee_types.title_en',
                'committee_types.office_type',
                'committee_types.status'
            ]
        );

        $committeeTypes = $committeeTypes->whereIn('status', [CommitteeType::STATUS_ACTIVE]);

        return DataTables::eloquent($committeeTypes)
            ->addColumn('office_type', static function (CommitteeType $committeeType) use ($authUser) {
                $officeType = CommitteeType::OFFICE_TYPE[$committeeType->office_type];
                return $officeType;
            })
            ->addColumn('status', static function (CommitteeType $committeeType) use ($authUser) {
                $status = CommitteeType::STATUS[$committeeType->status];
                return $status;
            })
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (CommitteeType $committeeType) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $committeeType)) {
                    $str .= '<a href="' . route('admin.meeting_management.committee-types.show', $committeeType->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.show_button_label') . '</a>';
                }

                if ($authUser->can('update', $committeeType)) {
                    $str .= '<a href="' . route('admin.meeting_management.committee-types.edit', $committeeType->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }

                if ($authUser->can('committeeSetting', $committeeType)) {
                    $str .= '<a href="' . route('admin.meeting_management.committee-types.committee-setting.create', $committeeType->id) . '" class="btn btn-outline-primary btn-sm committee-setting"> <i class="fas fa-cogs"></i> ' . __('generic.committee_setting') . '</a>';
                }
                if ($authUser->can('delete', $committeeType)) {
                    $str .= '<a href="#" data-action="' . route('admin.meeting_management.committee-types.destroy', $committeeType->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

    public function createCommitteeSetting(CommitteeType $committeeType, array $data)
    {
        /**
         * member_config key serialized
        **/
        $index = 0;
        foreach ($data['member_config'] as $key=>$value){
            unset ($data['member_config'][$key]);

            $data['member_config'][$index] = $value;
            $index++;
        }

        return CommitteeSetting::updateOrCreate(
            ['committee_type_id' => $committeeType->id], $data
        );
    }
}
