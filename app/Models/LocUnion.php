<?php

namespace App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\LocDistrictBelongsToRelation;
use App\Traits\LocDivisionBelongsToRelation;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * App\Models\LocUpazila
 *
 * @property int $id
 * @property string $title
 * @property int $loc_division_id
 * @property int $loc_district_id
 * @property bool $is_sadar_upazila
 * @property-read int|null $loc_unions_count
 * @property-read LocDivision division
 * @property-read LocDistrict district
 */
class LocUnion extends BaseModel
{
    use  ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait, LocDivisionBelongsToRelation, LocDistrictBelongsToRelation;

    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(LocDivision::class, 'loc_division_id');
    }

    /**
     * @return BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(LocDistrict::class, 'loc_district_id');
    }

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(LocUpazila::class, 'loc_upazila_id');
    }
}
