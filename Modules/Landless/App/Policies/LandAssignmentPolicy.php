<?php

namespace Modules\Landless\App\Policies;

use App\Models\User;
use App\Policies\BasePolicy;
use Modules\Landless\App\Models\LandAssignment;

class LandAssignmentPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_land_assignment');
    }

    /**
     * determine where the user can view models.
     * @param User $user
     * @param LandAssignment $landAssignment
     * @return bool
     */
    public function view(User $user, LandAssignment $landAssignment): bool
    {
        return $user->hasPermission('view_single_land_assignment');
    }

    /**
     * Determine whether the user can create models.
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_land_assignment');
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_land_assignment');
    }

    /**
     * @param User $user
     * @param LandAssignment $landAssignment
     * @return mixed
     */
    public function delete(User $user, LandAssignment $landAssignment)
    {
        return $user->hasPermission('delete_land_assignment');

    }

    /**
     * @param User $user
     * @param LandAssignment $landAssignment
     * @return mixed
     *
     */
    public function restore(User $user, LandAssignment $landAssignment)
    {
        return $user->hasPermission('restore_landlesss');
    }

    /**
     * @param User $user
     * @param LandAssignment $landAssignment
     * @return mixed
     */
    public function forceDelete(User $user, LandAssignment $landAssignment)
    {
        return $user->hasPermission('force_delete_landlesss');
    }

    public function scratchMapApproveByKanungo(User $user)
    {
        return $user->hasPermission('scratch_map_approve_by_kanungo');
    }

    public function scratchMapRejectByKanungo(User $user)
    {
        return $user->hasPermission('scratch_map_reject_by_kanungo');
    }

    public function scratchMapApproveByAcLand(User $user)
    {
        return $user->hasPermission('scratch_map_approve_by_ac_land');
    }
    public function scratchMapRejectByAcLand(User $user)
    {
        return $user->hasPermission('scratch_map_reject_by_ac_land');
    }

    public function scratchMapCorrection(User $user)
    {
        return $user->hasPermission('scratch_map_correction');
    }

    public function jomabondiFillUp(User $user)
    {
        return $user->hasPermission('jomabondi_fill_up');
    }

    public function jomabondiApproveBySurveyor(User $user)
    {
        return $user->hasPermission('jomabondi_approve_by_surveyor');
    }

    public function jomabondiRejectBySurveyor(User $user)
    {
        return $user->hasPermission('jomabondi_reject_by_surveyor');
    }


    public function jomabondiApproveByAcLand(User $user)
    {
        return $user->hasPermission('jomabondi_approve_by_ac_land');
    }

    public function jomabondiRejectByAcland(User $user)
    {
        return $user->hasPermission('jomabondi_reject_by_ac_land');
    }

    public function jomabondiCorrection(User $user)
    {
        return $user->hasPermission('jomabondi_correction');
    }

    public function jomabondiApproveByTofsildar(User $user)
    {
        return $user->hasPermission('jomabondi_approve_by_tofsildar');
    }
}
