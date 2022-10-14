<?php

namespace Modules\Meeting\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Role
 *
 * @property int $id
 */
class MeetingCommittee extends BaseModel
{
    /**
     * @var mixed
     */
    protected $guarded = [];
    //protected $table = "meeting_committees";

    protected $casts = [
        'member_config' => 'array',
    ];

    const STATUS = [
        1 => 'active',
        2 => 'in_progress',
        99 => 'cancelled',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_CANCELLED = 99;

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'id', 'meeting_id');
    }
}
