<?php

namespace Modules\ScratchMap\App\Policies;

use App\Models\User;
use Modules\ScratchMap\App\Models\ScratchMap;

class ScratchMapPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_scratch_map');
    }

    /**
     * determine where the user can view models.
     *
     * @param User $user
     * @param ScratchMap $scratchMap
     * @return bool
     */
    public function view(User $user, ScratchMap $scratchMap): bool
    {
        return $user->hasPermission('view_single_scratch_map');
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_scratch_map');
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_scratch_map');
    }

    /**
     * @param User $user
     * @param ScratchMap $scratchMap
     * @return mixed
     */
    public function delete(User $user, ScratchMap $scratchMap)
    {
        return $user->hasPermission('delete_scratch_map');

    }

    /**
     * @param User $user
     * @param ScratchMap $scratchMap
     * @return mixed
     *
     */
    public function restore(User $user, ScratchMap $scratchMap)
    {
        return $user->hasPermission('restore_scratch_map');
    }

    /**
     * @param User $user
     * @param ScratchMap $scratchMap
     * @return mixed
     */
    public function forceDelete(User $user, ScratchMap $scratchMap)
    {
        return $user->hasPermission('force_delete_scratch_map');
    }
}
