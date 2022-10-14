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
class KhasLandKhotianDag extends BaseModel
{
    protected $guarded = [];
    protected $table = "division20_khatian_dags";

    public function khaslandKhotian()
    {
        return $this->belongsTo(KhasLandKhotian::class, 'id', 'muted_khotian_id');

    }

}
