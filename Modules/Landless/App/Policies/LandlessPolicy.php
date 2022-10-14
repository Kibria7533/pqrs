<?php

namespace Modules\Landless\App\Policies;

use App\Models\User;
use App\Policies\BasePolicy;
use Modules\Landless\App\Models\Landless;

class LandlessPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_landless');
    }

    /**
     * determine where the user can view models.
     *
     * @param User $user
     * @param Landless $landless
     * @return bool
     */
    public function view(User $user, Landless $landless): bool
    {
        return $user->hasPermission('view_single_landless');
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_landless');
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('update_landless');
    }

    /**
     * @param User $user
     * @param Landless $landless
     * @return mixed
     */
    public function delete(User $user, Landless $landless)
    {
        return $user->hasPermission('delete_landless');

    }

    /**
     * @param User $user
     * @param Landless $landless
     * @return mixed
     *
     */
    public function restore(User $user, Landless $landless)
    {
        return $user->hasPermission('restore_landlesss');
    }

    /**
     * @param User $user
     * @param Landless $landless
     * @return mixed
     */
    public function forceDelete(User $user, Landless $landless)
    {
        return $user->hasPermission('force_delete_landlesss');
    }

    /**
     * @param User $user
     * @param Landless $landless
     * @return mixed
     */
    public function singleApprove(User $user, Landless $landless){
        return $user->hasPermission('single_approve_landless');
    }

    public function multiApprove(User $user){
        return $user->hasPermission('multi_approve_landless');
    }

    public function singleReject(User $user, Landless $landless){
        return $user->hasPermission('single_reject_landless');
    }

    public function multiReject(User $user){
        return $user->hasPermission('multi_reject_landless');
    }

    public function viewAnyLandlessUno(User $user){
        return $user->hasPermission('view_any_landless_uno');
    }

    public function singleApproveLandlessUno(User $user, Landless $landless){
        return $user->hasPermission('single_approve_landless_uno');
    }

    public function multiApproveLandlessUno(User $user){
        return $user->hasPermission('multi_approve_landless_uno');
    }

    public function singleRejectLandlessUno(User $user, Landless $landless){
        return $user->hasPermission('single_reject_landless_uno');
    }

    public function multiRejectLandlessUno(User $user){
        return $user->hasPermission('multi_reject_landless_uno');
    }

    public function viewAnyLandlessDc(User $user){
        return $user->hasPermission('view_any_landless_dc');
    }

    public function singleApproveLandlessDc(User $user, Landless $landless){
        return $user->hasPermission('single_approve_landless_dc');
    }

    public function multiApproveLandlessDc(User $user){
        return $user->hasPermission('multi_approve_landless_dc');
    }

    public function singleRejectLandlessDc(User $user, Landless $landless){
        return $user->hasPermission('single_reject_landless_dc');
    }

    public function multiRejectLandlessDc(User $user){
        return $user->hasPermission('multi_reject_landless_dc');
    }

    public function viewAnyLandlessApproved(User $user){
        return $user->hasPermission('view_any_landless_approved');
    }

    public function viewReceiptNumber(User $user){
        return $user->hasPermission('view_landless_receipt_number');
    }
}
