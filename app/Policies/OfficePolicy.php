<?php

namespace App\Policies;

use App\Models\Office;
use App\Models\Role;
use App\Models\User;

class OfficePolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_office');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Office $office
     * @return mixed
     */
    public function view(User $user, Office $office): bool
    {
        return $user->hasPermission('view_single_office');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_office');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_office');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Office $office
     * @return mixed
     */
    public function delete(User $user, Office $office): bool
    {
        return $user->hasPermission('delete_office');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Office $office
     * @return mixed
     */
    public function restore(User $user, Office $office): bool
    {
        return $user->hasPermission('restore_office');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Office $office
     * @return mixed
     */
    public function forceDelete(User $user, Office $office): bool
    {
        return $user->hasPermission('force_delete_office');
    }

    public function rolePermission(User $user, Office $office): bool
    {
        return $user->hasPermission('role_permission');
    }
}
