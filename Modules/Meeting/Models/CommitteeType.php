<?php

namespace Modules\Meeting\Models;

/**
 * Class BaseModel
 * @package Module\Meeting\App\Models
 */
class CommitteeType extends BaseModel
{
    protected $guarded = [];

    const OFFICE_TYPE = [
        1 => 'dc_office',
        2 => 'upazila_office',
    ];

    const OFFICE_TYPE_DC = 1;
    const OFFICE_TYPE_UPAZILA = 2;

    const MEETING_DESIGNATIONS = [
        'chairman' => 'সভাপতি',
        'vice_chairman' => 'সহ-সভাপতি',
        'member_secretary' => 'সদস্য সচিব',
        'secretary' => 'সম্পাদক',
        'member' => 'সদস্য'
    ];


}
