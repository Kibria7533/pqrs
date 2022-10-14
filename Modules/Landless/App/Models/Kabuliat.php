<?php

namespace Modules\Landless\App\Models;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string attached_file
 */
class Kabuliat extends BaseModel
{
    protected $guarded = [];
    //protected $table = "kabuliats";

    public const SAVE_AS_DRAFT = 5;
    public const STATUS_ACTIVE = 1;
    public const CTG_BBS_CODE = 20;
    public const NOAKHALI_BBS_CODE = 75;
    public const STATUS = [
        1 => 'active',
        5 => 'save_as_draft',
    ];



}
