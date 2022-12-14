<?php

namespace App\Traits;

use App\Helpers\Classes\AuthHelper;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ScopeInstituteAclTrait
 * @package App\Traits\ModelTraits
 * @method static Builder|$this acl()
 */
trait ScopeAclTrait
{
    /**
     * @param Builder $query
     * @param string|null $alias
     * @return Builder
     */
    public function scopeAcl(Builder $query, string $alias = null): Builder
    {
        if (empty($alias)) {
            $alias = $this->getTable() . '.';
        }

        if (AuthHelper::checkAuthUser()) {
            $authUser = AuthHelper::getAuthUser();
        }

        return $query;
    }
}
