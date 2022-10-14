<?php

namespace Modules\Meeting\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Landless\App\Models\Landless;

/**
 * App\Models\Role
 *
 * @property int $id
 */
class LandlessMeeting extends BaseModel
{
    /**
     * @var mixed
     */
    protected $guarded = [];
    protected $table = "landless_meeting";
    public $timestamps = false;

    public function landless(): BelongsTo
    {
        return $this->belongsTo(Landless::class);
    }

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }
}
