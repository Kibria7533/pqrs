<?php

namespace Modules\Landless\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Modules\Landless\App\Models\Kabuliat;
use Modules\Landless\App\Models\Landless;
use Yajra\DataTables\Facades\DataTables;

class KabuliatService
{
    public function createKabuliat(array $data): Kabuliat
    {
        $data['reg_no'] = trim(strip_tags($data['reg_no']));
        $data['case_no'] = trim(strip_tags($data['case_no']));
        $data['form_no'] = trim(strip_tags($data['form_no']));
        $data['committee_name'] = trim(strip_tags($data['committee_name']));
        $data['order_no'] = trim(strip_tags($data['order_no']));
        $data['order_no'] = trim(strip_tags($data['order_no']));

        return Kabuliat::create($data);
    }

    public function updateKabuliat(array $data, Kabuliat $kabuliat): bool
    {
        $data['reg_no'] = trim(strip_tags($data['reg_no']));
        $data['case_no'] = trim(strip_tags($data['case_no']));
        $data['form_no'] = trim(strip_tags($data['form_no']));
        $data['committee_name'] = trim(strip_tags($data['committee_name']));
        $data['order_no'] = trim(strip_tags($data['order_no']));
        $data['order_no'] = trim(strip_tags($data['order_no']));

        return $kabuliat->update($data);
    }

    public function deleteKabuliat(Kabuliat $kabuliat): bool
    {
        return $kabuliat->delete();
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'case_no' => 'required|string|max: 191',
            'case_year' => 'required|digits:4|integer|min:1800|max:'.(date('Y')),
            'case_date' => 'required|date|date_format:Y-m-d',
            'form_no' => 'required|string|max: 191',
            'form_date' => 'required|date|date_format:Y-m-d',
            'committee_name' => 'required|string|max:191',
            'meeting_date' => 'required|date|date_format:Y-m-d',
            'ulao_proposal_date' => 'required|date|date_format:Y-m-d',
            'order_no' => 'required|string|max:191',
            'order_date' => 'required|date|date_format:Y-m-d',
            'reg_no' => 'required|string|max:191',
            'reg_date' => 'required|date|date_format:Y-m-d',
            'ulao_return_date' => 'required|date|date_format:Y-m-d',
            'handover_date' => 'required|date|date_format:Y-m-d',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Kabuliat $smefRegistrations */
        $kabuliats = Kabuliat::select(
            [
                'kabuliats.id',
                'kabuliats.reg_no',
                'kabuliats.reg_date',
                'kabuliats.case_no',
                'kabuliats.case_year',
                'kabuliats.case_date',
                'kabuliats.form_no',
                'kabuliats.form_date',
                'kabuliats.committee_name',
                'kabuliats.meeting_date',
                'kabuliats.ulao_proposal_date',
                'kabuliats.ulao_return_date',
                'kabuliats.order_no',
                'kabuliats.order_date',
                'kabuliats.handover_date',
                'kabuliats.created_by',
                'kabuliats.updated_by',
                'kabuliats.status',
                'kabuliats.created_at',
                'kabuliats.updated_at',
            ]
        );

        return DataTables::eloquent($kabuliats)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Kabuliat $kabuliat) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $kabuliat)) {
                    $str .= '<a href="' . route('admin.kabuliats.show', $kabuliat->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.show_button_label') . '</a>';
                }

                if ($authUser->can('update', $kabuliat)) {
                    $str .= '<a href="' . route('admin.kabuliats.edit', $kabuliat->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }

                if ($authUser->can('delete', $kabuliat)) {
                    $str .= '<a href="#" data-action="' . route('admin.kabuliats.destroy', $kabuliat->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->addColumn('case_no_and_year', function (Kabuliat $kabuliat){
                return $kabuliat->case_no.', '.$kabuliat->case_year;
            })
            ->addColumn('status', function (Kabuliat $kabuliat){
                $str = '';
                if(!empty($kabuliat->status)){
                    $str .= '<span  class="badge '.($kabuliat->status==Kabuliat::STATUS_ACTIVE?'badge-success':'badge-warning').'" style="min-width: 86px;">' . (__('generic.'.Kabuliat::STATUS[$kabuliat->status])) . '</span>';
                }
                return $str;
            })
            ->rawColumns(['action','case_no_and_year','status'])
            ->toJson();
    }
}
