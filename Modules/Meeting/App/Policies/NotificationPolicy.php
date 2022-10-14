<?php

namespace Modules\Meeting\App\Policies;

use App\Models\User;
use App\Policies\BasePolicy;
use Modules\Meeting\Models\Notification;

class NotificationPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_notification');
    }

    /**
     * @param User $user
     * @param Notification $notification
     * @return bool
     */
    public function view(User $user, Notification $notification): bool
    {
        return $user->hasPermission('view_single_notification');
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_notification');
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_notification');
    }

    /**
     * @param User $user
     * @param Notification $notification
     * @return mixed
     */
    public function delete(User $user, Notification $notification)
    {
        return $user->hasPermission('delete_notification');
    }

    public function sendEmail(User $user)
    {
        return $user->hasPermission('send_email_notification');
    }

    public function sendSms(User $user)
    {
        return $user->hasPermission('send_sms_notification');
    }


}
