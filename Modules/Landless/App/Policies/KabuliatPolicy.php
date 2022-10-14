<?php

namespace Modules\Landless\App\Policies;

use App\Models\User;
use Modules\Landless\App\Models\Kabuliat;

class KabuliatPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_kabuliat');
    }

    /**
     * determine where the user can view models.
     *
     * @param User $user
     * @param Kabuliat $kabuliat
     * @return bool
     */
    public function view(User $user, Kabuliat $kabuliat): bool
    {
        return $user->hasPermission('view_single_kabuliat');
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_kabuliat');
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_kabuliat');
    }

    /**
     * @param User $user
     * @param Kabuliat $kabuliat
     * @return mixed
     */
    public function delete(User $user, Kabuliat $kabuliat)
    {
        return $user->hasPermission('delete_kabuliat');

    }

    /**
     * @param User $user
     * @param Kabuliat $kabuliat
     * @return mixed
     *
     */
    public function restore(User $user, Kabuliat $kabuliat)
    {
        return $user->hasPermission('restore_kabuliats');
    }

    /**
     * @param User $user
     * @param Kabuliat $kabuliat
     * @return mixed
     */
    public function forceDelete(User $user, Kabuliat $kabuliat)
    {
        return $user->hasPermission('force_delete_kabuliats');
    }
}
