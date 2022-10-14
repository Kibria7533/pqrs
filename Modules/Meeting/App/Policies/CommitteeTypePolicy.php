<?php

namespace Modules\Meeting\App\Policies;

use App\Models\User;
use App\Policies\BasePolicy;
use Modules\Meeting\Models\CommitteeType;

class CommitteeTypePolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_committee_type');
    }

    /**
     * @param User $user
     * @param CommitteeType $committeeType
     * @return bool
     */
    public function view(User $user, CommitteeType $committeeType): bool
    {
        return $user->hasPermission('view_single_committee_type');
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_committee_type');
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_committee_type');
    }

    /**
     * @param User $user
     * @param CommitteeType $committeeType
     * @return mixed
     */
    public function delete(User $user, CommitteeType $committeeType)
    {
        return $user->hasPermission('delete_committee_type');

    }

    public function committeeSetting(User $user, CommitteeType $committeeType)
    {
        return $user->hasPermission('committee_setting_committee_type');

    }

}
