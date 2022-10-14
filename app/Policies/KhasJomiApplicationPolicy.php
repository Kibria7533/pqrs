<?php

namespace App\Policies;

use App\Models\User;
use App\Models\KhasJomiApplication;

class KhasJomiApplicationPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User  $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_khas_jomi_application');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User  $user
     * @param KhasJomiApplication $khasJomiApplication
     * @return mixed
     */
    public function view(User $user, KhasJomiApplication $khasJomiApplication): bool
    {
        return $user->hasPermission('view_single_khas_jomi_application');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User  $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_khas_jomi_application');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_khas_jomi_application');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param KhasJomiApplication $khasJomiApplication
     * @return mixed
     */
    public function delete(User $user, KhasJomiApplication $khasJomiApplication)
    {
        return $user->hasPermission('delete_khas_jomi_application');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param KhasJomiApplication $khasJomiApplication
     * @return mixed
     */
    public function restore(User $user, KhasJomiApplication $khasJomiApplication)
    {
        return $user->hasPermission('restore_khas_jomi_application');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param KhasJomiApplication $khasJomiApplication
     * @return mixed
     */
    public function forceDelete(User $user, KhasJomiApplication $khasJomiApplication)
    {
        return $user->hasPermission('force_delete_khas_jomi_application');
    }

}
