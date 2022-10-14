<?php

namespace Modules\Khotian\App\Policies;
use App\Models\User;
use App\Policies\BasePolicy;
use Modules\Khotian\App\Models\MutedKhotian;

class MutedKhotiansPolicy extends BasePolicy
{

    protected $tableName = '_khotians';

    public function browse(User $user, $model)
    {
        return $user->hasPermission('browse'.$this->tableName);
    }

    public function add(User $user, $model)
    {
        return $user->hasPermission('add'.$this->tableName);
    }

    public function update(User $user, $model)
    {
        return $user->hasPermission('update'.$this->tableName);
    }

    public function read(User $user, $model)
    {
        return $user->hasPermission('read'.$this->tableName);
    }

    public function delete(User $user, $model)
    {
        return $user->hasPermission('delete'.$this->tableName);
    }

    public function browseMutedBatchEntry(User $user)
    {
        return $user->hasPermission('browse_khotian_batch_entry');
    }

    public function addMutedBatchEntry(User $user)
    {
        return $user->hasPermission('add_khotian_batch_entry');
    }

    public function editMutedBatchEntry(User $user)
    {
        return $user->hasPermission('edit_khotian_batch_entry');
    }

    public function approveBatchEntry(User $user)
    {
        return $user->hasPermission('approve_khotian_batch_entry');
    }

    public function browseaAcLandApprovedKhotian(User $user, MutedKhotian $mutedKhotian)
    {
        return $user->hasPermission('browse_ac_land_approved_khotian');
    }
}
