<?php

namespace App\Policies;

use App\Models\LocAllMouja;
use App\Models\LocUnion;
use App\Models\User;

class LocAllMoujaPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view_any_loc_all_mouja');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param LocAllMouja $locAllMouja
     * @return mixed
     */
    public function view(User $user, LocAllMouja $locAllMouja)
    {
        return $user->hasPermission('view_single_loc_all_mouja');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_loc_all_mouja');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param LocAllMouja $locAllMouja
     * @return mixed
     */
    public function update(User $user, LocAllMouja $locAllMouja)
    {
        return $user->hasPermission('update_loc_all_mouja');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param LocAllMouja $locAllMouja
     * @return mixed
     */
    public function delete(User $user, LocAllMouja $locAllMouja)
    {
        return $user->hasPermission('delete_loc_all_mouja');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param LocAllMouja $locAllMouja
     * @return mixed
     */
    public function restore(User $user, LocAllMouja $locAllMouja)
    {
        return $user->hasPermission('restore_loc_all_mouja');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param LocAllMouja $locAllMouja
     * @return mixed
     */
    public function forceDelete(User $user, LocAllMouja $locAllMouja)
    {
        return $user->hasPermission('force_delete_loc_all_mouja');
    }
}
