<?php

namespace Modules\Khotian\App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string attached_file
 */
class KhasLandKhotianOwner extends BaseModel
{
    protected $guarded = [];
    protected $table = "khasland_khotian_owners";

    public function khaslandKhotian()
    {
        return $this->belongsTo(KhasLandKhotian::class, 'id', 'khasland_khotian_id');

    }

}
