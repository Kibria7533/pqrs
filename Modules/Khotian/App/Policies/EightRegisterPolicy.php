<?php

namespace Modules\Khotian\App\Policies;
use App\Models\User;
use App\Policies\BasePolicy;
use Modules\Khotian\App\Models\EightRegister;

class EightRegisterPolicy extends BasePolicy
{
    protected $tableName = 'register_eight';

    public function viewAny(User $user)
    {
        return $user->hasPermission('view_any_'.$this->tableName);
    }

    public function view(User $user, EightRegister $eightRegister): bool
    {
        return $user->hasPermission('view_single'.$this->tableName);
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_'.$this->tableName);
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_'.$this->tableName);
    }

    /**
     * @param User $user
     * @param EightRegister $eightRegister
     * @return mixed
     */
    public function delete(User $user, EightRegister $eightRegister)
    {
        return $user->hasPermission('delete_'.$this->tableName);

    }

    /**
     * @param User $user
     * @param EightRegister $eightRegister
     * @return mixed
     *
     */
    public function restore(User $user, EightRegister $eightRegister)
    {
        return $user->hasPermission('restore_'.$this->tableName);
    }

    /**
     * @param User $user
     * @param EightRegister $eightRegister
     * @return mixed
     */
    public function forceDelete(User $user, EightRegister $eightRegister)
    {
        return $user->hasPermission('force_delete_'.$this->tableName);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function save(User $user)
    {
        return $user->hasPermission('save_'.$this->tableName);
    }

    public function saveAsDraft(User $user)
    {
        return $user->hasPermission('save_as_draft_'.$this->tableName);
    }

    public function approve(User $user)
    {
        return $user->hasPermission('approve_'.$this->tableName);
    }

    public function reject(User $user)
    {
        return $user->hasPermission('reject_'.$this->tableName);
    }

}
