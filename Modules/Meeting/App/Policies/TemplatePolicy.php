<?php

namespace Modules\Meeting\App\Policies;

use App\Models\User;
use App\Policies\BasePolicy;
use Modules\Meeting\Models\Template;

class TemplatePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_template');
    }

    /**
     * @param User $user
     * @param Template $template
     * @return bool
     */
    public function view(User $user, Template $template): bool
    {
        return $user->hasPermission('view_single_template');
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_template');
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_template');
    }

    /**
     * @param User $user
     * @param Template $template
     * @return mixed
     */
    public function delete(User $user, Template $template)
    {
        return $user->hasPermission('delete_template');
    }
}
