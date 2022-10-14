<?php

namespace Modules\ScratchMap\App\Policies;

use App\Policies\MasterBasePolicy;

abstract class BasePolicy extends MasterBasePolicy
{
    public function before($user, $ability)
    {
        return parent::before($user, $ability);
    }
}
