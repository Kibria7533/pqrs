<?php

namespace Modules\Khotian\App\Models;

use App\Models\BaseModel;

/**
 * Class Test
 * @package Module\Khatian\App\Models
 * @property int register_type
 * @property int draft
 * @property int status
 */
class EightRegister extends BaseModel
{
    const PUBLISHED = 1;
    const ON_PROGRESS = 2;
    const APPROVED = 3;
    const MODIFY = 4;
    const SAVE_AS_DRAFT = 5;
    const INACTIVE = 99;

    protected $dates = ['created_at'];
    protected $guarded = ['id'];

    protected $table = "eight_registers";
}
