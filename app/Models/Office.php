<?php

namespace App\Models;

use App\Traits\AuthenticatableUser;
use App\Traits\LocDistrictBelongsToRelation;
use App\Traits\LocDivisionBelongsToRelation;
use App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Module\Office\Models\Offices;

/**
 * App\Models\User
 *
 * @property int id
 * @property string name_bn
 * @property string name_en
 * @property int union_bbs_code
 */
class Office extends BaseModel
{
    use AuthenticatableUser, LocDistrictBelongsToRelation, LocDivisionBelongsToRelation, ScopeAclTrait, ScopeRowStatusTrait;

    protected $guarded = ['id'];

    public const OFFICE_TYPE = [
        1 => 'deputy_commissioner_office',
        2 => 'ac_land_office',
        3 => 'rrdc_office',
    ];

    public const DIVISION = 'division';
    public const DISTRICT = 'district';
    public const UPAZILA = 'upazila';
    public const UNION = 'union';

    public const JURISDICTION = [
        self::DIVISION => self::DIVISION,
        self::DISTRICT => self::DISTRICT,
        self::UPAZILA => self::UPAZILA,
        self::UNION => self::UNION
    ];

    public function locDivision(): BelongsTo
    {
        return $this->belongsTo(LocDivision::class, 'division_bbs_code', 'bbs_code');
    }

    public function locDistrict(): BelongsTo
    {
        return $this->belongsTo(locDistrict::class, 'district_bbs_code', 'bbs_code');
    }

    public function locUpazila($districtBbsCode,$upazilaBbsCode)
    {
        $upazila = locUpazila::where([
            'district_bbs_code'=>$districtBbsCode,
            'bbs_code'=>$upazilaBbsCode,
        ])->first();

        return $upazila->title??null;
    }

    public function locUnion($districtBbsCode,$upazilaBbsCode, $unionBbsCode)
    {
        $union = LocUnion::where([
            'district_bbs_code'=>$districtBbsCode,
            'upazila_bbs_code'=>$upazilaBbsCode,
            'bbs_code'=>$unionBbsCode,
        ])->first();

        return $union->title;
    }

    public static function getUserOffice(){
        $authUser = Auth::user();
        if(empty( $authUser->office_id)) return false;
        $office = Office::where(['id' => $authUser->office_id]);
        return $office->first();
    }

}
