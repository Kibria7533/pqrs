<?php

namespace App\Policies;

use App\Models\Designation;
use App\Models\User;

class DesignationPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User  $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_designation');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User  $user
     * @return mixed
     */
    public function view(User $user, Designation $designation): bool
    {
        return $user->hasPermission('view_single_designation');
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User  $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_designation');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_designation');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Designation $designation
     * @return mixed
     */
    public function delete(User $user, Designation $designation)
    {
        return $user->hasPermission('delete_designation');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Designation $designation
     * @return mixed
     */
    public function restore(User $user, Designation $designation)
    {
        return $user->hasPermission('restore_designation');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Designation $designation
     * @return mixed
     */
    public function forceDelete(User $user, Designation $designation)
    {
        return $user->hasPermission('force_delete_designation');
    }

    public function viewBachTrainee(User $user, Designation $designation): bool
    {
        return $user->hasPermission('view_designation_trainee');
    }
}
