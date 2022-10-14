<?php


namespace Modules\Meeting\App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Modules\Meeting\App\Services\NotificationService;
use Modules\Meeting\Models\Meeting;
use Modules\Meeting\Models\Notification;
use Modules\Meeting\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class MeetingsController
 * @package Modules\Landless\App\Http\Controllers
 */
class NotificationController extends BaseController
{
    const VIEW_PATH = 'meeting::backend.notifications.';

    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->authorizeResource(Notification::class);
    }

    public function index()
    {
        return view(self::VIEW_PATH . 'browse');
    }

    public function create(Meeting $meeting): View
    {
        $smsTemplates = Template::where('template_type', Template::TEMPLATE_TYPE_SMS)->get();
        $emailTemplates = Template::where('template_type', Template::TEMPLATE_TYPE_EMAIL)->get();

        return \view(self::VIEW_PATH . 'add-notification', compact('smsTemplates', 'emailTemplates', 'meeting'));
    }

    public function store(Request $request, Meeting $meeting)
    {
        $validatedData = $this->notificationService->validator($request);
        if ($validatedData->fails()) {
            $errors = $validatedData->errors();
            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        $data = $validatedData->validate();
        $data['meeting_id'] = $meeting->id;

        DB::beginTransaction();
        try {
            $notification = $this->notificationService->createNotification($data, $meeting);

            if ($request->is_email_enable) {
                $this->notificationService->mailSendWithUpdateNotification($notification);
            }

            if ($request->is_sms_enable) {
                $this->notificationService->smsSendWithUpdateNotification($notification);
            }

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.notification_not_send_successful'),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('generic.notification_send_successful'),
            'alertType' => 'success',
            'redirectTo' => route('admin.meeting_management.meetings.index'),
        ]);
    }

}
