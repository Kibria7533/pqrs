<?php

namespace Modules\Meeting\Models;

/**
 * Class BaseModel
 */
class Template extends BaseModel
{
    protected $guarded = [];

    const TEMPLATE_TYPE = [
        1 => 'meeting',
        2 => 'sms',
        3 => 'email'
    ];

    const TEMPLATE_TYPE_MEETING = 1;
    const TEMPLATE_TYPE_SMS = 2;
    const TEMPLATE_TYPE_EMAIL = 3;


}
