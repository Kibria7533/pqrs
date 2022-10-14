<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;


/**
 * App\Models\Role
 *
 * @property int $id
 * @property string code
 * @property string title
 * @property string description
 * @property-read Collection|Permission[] permissions
 * @property-read int|null permissions_count
 */
class KhasJomiApplication extends BaseModel
{
    protected $guarded = [];
}
