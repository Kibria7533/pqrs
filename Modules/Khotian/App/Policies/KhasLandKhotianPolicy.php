<?php

namespace Modules\Khotian\App\Policies;

use App\Models\User;
use App\Policies\BasePolicy;
use Modules\Khotian\App\Models\KhasLandKhotian;

class KhasLandKhotianPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_khasland_khotian');
    }

    /**
     * determine where the user can view models.
     *
     * @param User $user
     * @param KhasLandKhotian $khasLandKhotian
     * @return bool
     */
    public function view(User $user, KhasLandKhotian $khasLandKhotian): bool
    {
        return $user->hasPermission('view_single_khasland_khotian');
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_khasland_khotian');
    }

    public function singleApprove(User $user)
    {
        return $user->hasPermission('single_approve_khasland_khotian');
    }

    public function multiApprove(User $user)
    {
        return $user->hasPermission('multi_approve_khasland_khotian');
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_khasland_khotian');
    }

    /**
     * @param User $user
     * @param KhasLandKhotian $khasLandKhotian
     * @return mixed
     */
    public function delete(User $user, KhasLandKhotian $khasLandKhotian)
    {
        return $user->hasPermission('delete_khasland_khotian');

    }

    /**
     * @param User $user
     * @param KhasLandKhotian $khasLandKhotian
     * @return mixed
     *
     */
    public function restore(User $user, KhasLandKhotian $khasLandKhotian)
    {
        return $user->hasPermission('restore_khasland_khotians');
    }

    /**
     * @param User $user
     * @param KhasLandKhotian $khasLandKhotian
     * @return mixed
     */
    public function forceDelete(User $user, KhasLandKhotian $khasLandKhotian)
    {
        return $user->hasPermission('force_delete_khasland_khotians');
    }
}
