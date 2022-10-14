<?php

namespace App\Policies;

use App\Models\User;
use Modules\Landless\App\Models\FileType;

class FileTypePolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_file_type');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param FileType $fileType
     * @return mixed
     */
    public function view(User $user, FileType $fileType): bool
    {
        return $user->hasPermission('view_single_file_type');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_file_type');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_file_type');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param FileType $fileType
     * @return mixed
     */
    public function delete(User $user, FileType $fileType): bool
    {
        return $user->hasPermission('delete_file_type');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param FileType $fileType
     * @return mixed
     */
    public function restore(User $user, FileType $fileType): bool
    {
        return $user->hasPermission('restore_file_type');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param FileType $fileType
     * @return mixed
     */
    public function forceDelete(User $user, FileType $fileType): bool
    {
        return $user->hasPermission('force_delete_file_type');
    }
}
