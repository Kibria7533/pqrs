<?php

namespace Modules\Meeting\Models;

/**
 * Class BaseModel
 * @package Module\ModuleTemplate\App\Models
 */
class CommitteeSetting extends BaseModel
{
    protected $guarded = ['id'];
    protected $casts = [
        'member_config' => 'array',
    ];
}
