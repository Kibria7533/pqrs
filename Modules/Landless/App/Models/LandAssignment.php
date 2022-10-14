<?php

namespace Modules\Landless\App\Models;

/**
 * Modules\Landless\App\Models\LalandeAssignment
 * @property int id
 * @property int landless_application_id
 * @property int is_scratch_map_created
 * @property int is_scratch_map_approved_by_kanungo
 * @property int is_scratch_map_approved_by_acland
 * @property int is_jomabondi_order_by_acland
 * @property int is_jomabondi_fill_up_by_kanungo
 * @property int is_jomabondi_approved_by_surveyor
 * @property int is_jomabondi_approved_by_tofsildar
 * @property int is_jomabondi_approved_by_acland
 * @property int is_approved_by_acland
 * @property int is_approved_by_uno
 * @property int is_approved_by_dc
 * @property int status
 * @property int stage
 * @property int identity_type
 */
class LandAssignment extends BaseModel
{
    protected $table = "land_assignments";
    protected $guarded = ['id'];

    public const STATUS = [
        1 => 'active',
        2 => 'initial',
        3 => 'in_progress',
        50 => 'approved_by_uno',
        51 => 'approved_by_dc',
        52 => 'rejected_by_uno',
        53 => 'rejected_by_dc',
        98 => 'inactive',
        99 => 'deleted',
    ];

    public const STAGE_ACTIVE = 1;
    public const STAGE_INITIAL = 2;
    public const STAGE_SCRATCH_MAP_CREATED_BY_SURVEYOR = 30;
    public const STAGE_SCRATCH_MAP_APPROVED_BY_KANUNGO = 31;
    public const STAGE_SCRATCH_MAP_APPROVED_BY_ACLAND = 32;
    public const STAGE_SCRATCH_MAP_REJECTED_BY_KANUNGO = 33;
    public const STAGE_SCRATCH_MAP_REJECTED_BY_ACLAND = 34;
    public const STAGE_SCRATCH_MAP_CORRECTION_BY_SURVEYOR = 35;

    public const STAGE_JOMABONDI_CREATED_BY_KANUNGO = 40;
    public const STAGE_JOMABONDI_APPROVED_BY_SURVEYOR = 41;
    public const STAGE_JOMABONDI_TOFSILDAR_SEND_TO_ACLAND = 42;
    public const STAGE_JOMABONDI_APPROVED_BY_ACLAND = 43;
    public const STAGE_JOMABONDI_REJECTED_BY_SURVEYOR = 44;
    public const STAGE_JOMABONDI_REJECTED_BY_ACLAND = 45;
    public const STAGE_JOMABONDI_CORRECTION_BY_KANUNGO = 46;

    public const STAGE_APPROVED_BY_UNO = 50;
    public const STAGE_APPROVED_BY_DC = 51;
    public const STAGE_REJECTED_BY_UNO = 52;
    public const STAGE_REJECTED_BY_DC = 53;

    public const STAGE_INACTIVE = 98;
    public const STAGE_DELETED = 99;

    public const STAGE = [
        1 => 'active',
        2 => 'initial',
        30 => 'scratch_map_created_by_surveyor',
        31 => 'scratch_map_approved_by_kanungo',
        32 => 'scratch_map_approved_by_acland',
        33 => 'scratch_map_rejected_by_kanungo',
        34 => 'scratch_map_rejected_by_acland',
        35 => 'scratch_map_correction_by_surveyor',

        40 => 'jomabondi_created_by_kanungo',
        41 => 'jomabondi_approved_by_surveyor',
        42 => 'jomabondi_tofsildar_send_to_acland',
        43 => 'jomabondi_approved_by_acland',
        44 => 'jomabondi_reject_by_surveyor',
        45 => 'jomabondi_reject_by_acland',
        46 => 'jomabondi_correction_by_kanungo',

        50 => 'approved_by_uno',
        51 => 'approved_by_dc',
        52 => 'rejected_by_uno',
        53 => 'rejected_by_dc',

        98 => 'inactive',
        99 => 'deleted',
    ];



}
