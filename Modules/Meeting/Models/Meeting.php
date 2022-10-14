<?php

namespace Modules\Meeting\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Role
 *
 * @property int $id
 */
class Meeting extends BaseModel
{
    /**
     * @var mixed
     */
    protected $guarded = [];
    protected $table = "meetings";

    const STATUS = [
        1 => 'active',
        2 => 'in_progress',
        99 => 'cancelled',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_CANCELLED = 99;

    public function committeeType(): BelongsTo
    {
        return $this->belongsTo(CommitteeType::class, 'committee_type_id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class, 'template_id');
    }

    public function meetingCommittee(): HasOne
    {
        return $this->hasOne(MeetingCommittee::class, 'meeting_id');
    }
}
