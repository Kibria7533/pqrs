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
 * @property string $dglr_code
 * @property int $upazila_bbs_code
 * @property int $division_bbs_code
 * @property string $name_bd
 * @property int $rsk_jl_no
 * @property int $cs_jl_no
 * @property int $sa_jl_no
 * @property int $rs_jl_no
 * @property int $pety_jl_no
 * @property int $diara_jl_no
 * @property int $bs_jl_no
 * @property int $city_jl_no
 * @property string $division_name
 * @property string $district_name
 * @property string $upazila_name
 * @property-read LocDivision division
 * @property-read LocDistrict district
 * @property-read LocDistrict upazila
 */
class LocAllMouja extends BaseModel
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
