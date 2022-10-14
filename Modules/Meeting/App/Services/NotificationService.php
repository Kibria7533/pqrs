<?php

namespace Modules\Meeting\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\CustomPHPMailerSetting;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Meeting\Models\CommitteeType;
use Modules\Meeting\Models\Meeting;
use Modules\Meeting\Models\Notification;
use Yajra\DataTables\Facades\DataTables;

class NotificationService
{
    public function createNotification(array $data, Meeting $meeting): Notification
    {
        $memberConfigs = collect($meeting->meetingCommittee->member_config);
        $memberConfigs = $memberConfigs->map(function ($memberConfig) use ($data){
            return [
                'name' => $memberConfig['name'],
                'email' => $memberConfig['email'],
                'mobile' => $memberConfig['mobile'],
                'org_designation' => $memberConfig['org_designation'],
                'org_designation_id' => $memberConfig['org_designation_id'],
                'committee_designation' => $memberConfig['committee_designation'],
                'committee_designation_id' => $memberConfig['committee_designation_id'],
                'is_send_email' => 0,
                'is_send_sms' => 0,
            ];
        });

        $data['meeting_committee_id'] = $meeting->meetingCommittee->id;
        $data['member_config'] = $memberConfigs->toArray();

        return Notification::create($data);
    }

    public function deleteMeeting(Meeting $meeting): bool
    {
        return $meeting->delete();
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Meeting $smefRegistrations */
        $meetings = Meeting::select(
            [
                'meetings.id as id',
                'meetings.title',
                'meetings.meeting_no',
                'meetings.meeting_type',
                DB::raw("DATE_FORMAT(meetings.meeting_date, '%d %M, %Y') as meeting_date"),
                'meetings.committee_type_id',
                'meetings.status',
                'committee_types.office_type',
            ]
        );

        $meetings = $meetings->join('committee_types', 'committee_types.id', '=', 'meetings.committee_type_id')
            ->whereIn('meetings.status', [Meeting::STATUS_ACTIVE]);

        if ($authUser->isUnoUser()) {
            $meetings = $meetings->where('committee_types.office_type', CommitteeType::OFFICE_TYPE_UPAZILA);
        }
        if ($authUser->isDcUser()) {
            $meetings = $meetings->where('committee_types.office_type', CommitteeType::OFFICE_TYPE_DC);
        }

        return DataTables::eloquent($meetings)
            ->addColumn('action', DatatableHelper::getActionButtonBlockDropDown(static function (Meeting $meeting) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $meeting)) {
                    $str .= '<a href="' . route('admin.meeting_management.meetings.show', $meeting->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.show_button_label') . '</a>';
                }

                if ($authUser->can('viewWorksheet', $meeting)) {
                    $str .= '<a href="' . route('admin.meeting_management.meetings.worksheet', $meeting->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.worksheet') . '</a>';
                }

                if ($authUser->can('update', $meeting)) {
                    $str .= '<a href="' . route('admin.meeting_management.meetings.edit', $meeting->id) . '" class="btn btn-outline-primary btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }

                if ($authUser->can('updateMeetingLandless', $meeting)) {
                    $str .= '<a data-meeting-id="' . $meeting->id . '" data-meeting-title="' . $meeting->title . '" href="#" data-action="' . route('admin.meeting_management.meetings.landless-meeting-list-update', $meeting->id) . '" class="btn btn-outline-dark btn-sm landless-meeting-list"> <i class="fas fa-list"></i> ' . __('generic.landless_meeting_list') . '</a>';
                }

                if ($authUser->can('uploadResolutionFile', $meeting)) {
                    $str .= '<a href="#" data-action="' . route('admin.meeting_management.meetings.resolution-file-upload', $meeting->id) . '" class="btn btn-outline-success btn-sm upload-resolution"> <i class="fas fa-upload"></i> ' . __('generic.upload_resolution_file') . '</a>';
                }

                if ($authUser->can('updateCommitteeMember', $meeting)) {
                    $str .= '<a href="' . route('admin.meeting_management.meetings.meeting-committee-config', $meeting->id) . '" class="btn btn-outline-primary btn-sm"> <i class="fas fa-cogs"></i> ' . __('generic.meeting_committee') . '</a>';
                }

                if ($authUser->can('delete', $meeting)) {
                    $str .= '<a href="#" data-action="' . route('admin.meeting_management.meetings.destroy', $meeting->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->addColumn('committee_type', static function (Meeting $meeting) use ($authUser) {
                return !empty($meeting->committee_type_id) ? $meeting->committeeType->title : '';
            })
            ->addColumn('status', static function (Meeting $meeting) use ($authUser) {
                return !empty($meeting->status) ? __('generic.' . Meeting::STATUS[$meeting->status]) : '';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'is_email_enable' => 'nullable|boolean',
            'is_sms_enable' => 'nullable|boolean',
            'email_notification_body' => 'nullable|string',
            'sms_notification_body' => 'nullable|string',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function mailSendWithUpdateNotification(Notification $notification)
    {
        $memberConfigs = !empty($notification->member_config)? $notification->member_config:[];

        foreach ($memberConfigs as $key=>$memberConfig){
            if(!empty($memberConfig['email'])){
                try {
                    $toEmail = $memberConfig['email'];
                    $subject = $notification->meeting->title;
                    $mailBody    = !empty($notification->email_notification_body) ? $notification->email_notification_body: "Custom Mail body message";
                    $fileAttachments = null;

                    $phpmailer = CustomPHPMailerSetting::mailServerSetup();
                    $send = CustomPHPMailerSetting::customMailSender($phpmailer,$toEmail,$subject,$mailBody, $fileAttachments);
                    if($send){
                        $data['member_config'][$key] = [
                            'name' => $memberConfig['name'],
                            'email' => $memberConfig['email'],
                            'mobile' => $memberConfig['mobile'],
                            'org_designation' => $memberConfig['org_designation'],
                            'org_designation_id' => $memberConfig['org_designation_id'],
                            'committee_designation' => $memberConfig['committee_designation'],
                            'committee_designation_id' => $memberConfig['committee_designation_id'],
                            'is_send_email' => 1,
                            'is_send_sms' => $memberConfig['is_send_sms'],
                        ];
                        $notification->update($data);
                    }

                }catch (\Throwable $exception) {
                    Log::debug($exception->getMessage());
                    Log::debug($exception->getTraceAsString());
                }
            }
        }

    }

    public function smsSendWithUpdateNotification(Notification $notification)
    {
        $memberConfigs = !empty($notification->member_config)? $notification->member_config:[];

        foreach ($memberConfigs as $key=>$memberConfig){

            if(!empty($memberConfig['mobile'])){
                try {
                    $toMobile = $memberConfig['mobile'];
                    $mailBody    = !empty($notification->sms_notification_body) ? $notification->sms_notification_body: "Custom SMS body message";

                    $send = Helper::sendSms($toMobile, $mailBody);
                    if($send){
                        $data['member_config'][$key] = [
                            'name' => $memberConfig['name'],
                            'email' => $memberConfig['email'],
                            'mobile' => $memberConfig['mobile'],
                            'org_designation' => $memberConfig['org_designation'],
                            'org_designation_id' => $memberConfig['org_designation_id'],
                            'committee_designation' => $memberConfig['committee_designation'],
                            'committee_designation_id' => $memberConfig['committee_designation_id'],
                            'is_send_email' => $memberConfig['is_send_email'],
                            'is_send_sms' => 1,
                        ];

                        $notification->update($data);
                    }
                }catch (\Throwable $exception) {
                    Log::debug($exception->getMessage());
                    Log::debug($exception->getTraceAsString());
                }
            }
        }

    }

}
