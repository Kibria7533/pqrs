<?php

namespace Modules\Meeting\App\Policies;

use App\Models\User;
use App\Policies\BasePolicy;
use Modules\Meeting\Models\Meeting;

class MeetingPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_meeting');
    }

    /**
     * @param User $user
     * @param Meeting $meeting
     * @return bool
     */
    public function view(User $user, Meeting $meeting): bool
    {
        return $user->hasPermission('view_single_meeting');
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_meeting');
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_meeting');
    }

    /**
     * @param User $user
     * @param Meeting $meeting
     * @return mixed
     */
    public function delete(User $user, Meeting $meeting)
    {
        return $user->hasPermission('delete_meeting');
    }

    public function viewWorksheet(User $user, Meeting $meeting)
    {
        return $user->hasPermission('view_worksheet');
    }

    public function uploadResolutionFile(User $user, Meeting $meeting)
    {
        return $user->hasPermission('upload_resolution_file');
    }

    public function updateMeetingLandless(User $user, Meeting $meeting)
    {
        return $user->hasPermission('update_meeting_landless');
    }

    public function updateCommitteeMember(User $user, Meeting $meeting)
    {
        return $user->hasPermission('update_committee_member');
    }

    public function landAssignmentToLandless(User $user, Meeting $meeting)
    {
        return $user->hasPermission('land_assignment_to_landless');
    }
}
