<?php

namespace App\Policies;

use App\Models\LocUnion;
use App\Models\User;

class LocUnionPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view_any_loc_union');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param LocUnion $locUnion
     * @return mixed
     */
    public function view(User $user, LocUnion $locUnion)
    {
        return $user->hasPermission('view_single_loc_union');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_loc_union');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param LocUnion $locUnion
     * @return mixed
     */
    public function update(User $user, LocUnion $locUnion)
    {
        return $user->hasPermission('update_loc_union');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param LocUnion $locUnion
     * @return mixed
     */
    public function delete(User $user, LocUnion $locUnion)
    {
        return $user->hasPermission('delete_loc_union');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param LocUnion $locUnion
     * @return mixed
     */
    public function restore(User $user, LocUnion $locUnion)
    {
        return $user->hasPermission('restore_loc_union');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param LocUnion $locUnion
     * @return mixed
     */
    public function forceDelete(User $user, LocUnion $locUnion)
    {
        return $user->hasPermission('force_delete_loc_union');
    }
}
