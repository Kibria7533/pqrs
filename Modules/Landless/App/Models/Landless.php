<?php

namespace Modules\Landless\App\Models;

use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocUnion;
use App\Models\LocUpazila;
use App\Models\Office;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


/**
 * App\Models\Role
 *
 * @property int $id
 * @property int status
 * @property int stage
 * @property int identity_type
 */
class Landless extends BaseModel
{
    protected $guarded = [];
    protected $table = "landless_applications";

    protected $casts = [
        'family_members' => 'array',
        'references' => 'array',
    ];

    public const IDENTITY_TYPE = [
        1 => 'birth_reg_number',
        2 => 'nid_number',
        3 => 'not_available',
    ];

    public const IDENTITY_TYPE_BIRTH_REG = 1;
    public const IDENTITY_TYPE_NID = 2;
    public const IDENTITY_TYPE_NOT_AVAILABLE = 3;

    public const LANDLESS_TYPE = [
        1 => 'নদী ভাংগা পরিবার',
        2 => 'অধিগ্রহনের ফলে ভূমিহীন হইয়া পড়িয়াছে এমন পরিবার',
        3 => 'সম পুত্রসহ বিধবা বা স্বামী পরিত্যক্ত পরিবার',
        4 => '০.১০ ডপ এর বেশী জমি নাই',
        5 => 'বন্দোবস্ত'
    ];

    public const GENDER = [
        1 => 'male',
        2 => 'female',
        3 => 'others',
    ];
    public const FILE_TYPE = [
        1 => 'freedom_fighter_certificate',
        2 => 'union_word_or_municipality',
        3 => 'others',
    ];
    public const IS_ALIVE = [
        1 => 'alive',
        0 => 'dead',
    ];

    public const SAVE_AS_DRAFT = 5;
    public const CTG_BBS_CODE = 20;
    public const NOAKHALI_BBS_CODE = 75;

    public const STATUS = [
        2 => 'initial',
        3 => 'on_progress',
        4 => 'recycle',
        5 => 'draft',
        6 => 'reject',
        1 => 'active',
        98 => 'inactive',
        99 => 'deleted',
    ];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INITIAL = 2;
    public const STATUS_ON_PROGRESS = 3;
    public const STATUS_ON_RECYCLE = 4;
    public const STATUS_DRAFT = 5;
    public const STATUS_REJECT = 6;
    public const STATUS_INACTIVE = 98;
    public const STATUS_DELETED = 99;

    public const STAGE = [
        1 => 'acive',
        2 => 'acland_office',//acland_sending
        3 => 'acland_approved',//uno
        4 => 'uno_approved',
        5 => 'dc_office',//dc
        6 => 'dc_approved',//dc
        7 => 'acland_office_receiving',//acland_receiving
        8 => 'kobuliat_ordered',
        9 => 'mutation',
        10 => 'tax_holding',
        98 => 'inactive',
        99 => 'deleted'
    ];
    public const STAGE_ACTIVE = 1;
    public const STAGE_INITIAL = 2;
    public const STAGE_ACLAND_SENDING = 3;
    public const STAGE_UNO = 4;
    public const STAGE_UNO_APPROVED = 44;
    public const STAGE_DC = 5;
    public const STAGE_ACLAND_RECEIVING = 6;
    public const STAGE_KABULIAT = 7;
    public const STAGE_MUTATION = 8;
    public const STAGE_TAX_HOLDING = 9;
    public const STAGE_INACTIVE = 98;
    public const STAGE_DELETED = 99;


    //TODO
    public function upazila($div_bbs, $dis_bbs, $upazila_bbs)
    {
        $locUpazila = LocUpazila::where([
            'division_bbs_code' => $div_bbs,
            'district_bbs_code' => $dis_bbs,
            'bbs_code' => $upazila_bbs,
        ])->first();

        if (!empty($locUpazila)) {
            return Session::get('locale') == 'bn' ? $locUpazila->title : $locUpazila->title_en;
        }
    }

    //TODO
    public function union($div_bbs, $dis_bbs, $upazila_bbs, $union_bbs)
    {
        $locUnion = LocUnion::where([
            'division_bbs_code' => $div_bbs,
            'district_bbs_code' => $dis_bbs,
            'upazila_bbs_code' => $upazila_bbs,
            'bbs_code' => $union_bbs,
        ])->first();

        if (!empty($locUnion)) {
            return Session::get('locale') == 'bn' ? $locUnion->title : $locUnion->title_en;
        }
    }

    public static function getJurisditionConditions($authUser, $type = null)
    {
        $conditions = [];

        if ($authUser->isSuperUser()) {
            return $conditions;
        }

        if ((empty($authUser->office_id)) || $authUser->office_id == 0) {
            return [
                'landless_applications.loc_division_bbs' => 'no_data'
            ];
        }


        $office = DB::table('offices')
            ->where(['id' => $authUser->office_id])
            ->first();

        if ($office->jurisdiction == Office::DIVISION) {

            $conditions = [
                'landless_applications.loc_division_bbs' => $office->division_bbs_code
            ];
        }

        if ($office->jurisdiction == Office::DISTRICT) {
            $conditions = [
                'landless_applications.loc_division_bbs' => $office->division_bbs_code,
                'landless_applications.loc_district_bbs' => $office->district_bbs_code,
            ];
        }

        if ($office->jurisdiction == Office::UPAZILA) {
            $conditions = [
                'landless_applications.loc_division_bbs' => $office->division_bbs_code,
                'landless_applications.loc_district_bbs' => $office->district_bbs_code,
                'landless_applications.loc_upazila_bbs' => $office->upazila_bbs_code,
            ];
        }

        if ($office->jurisdiction == Office::UNION) {
            $conditions = [
                'landless_applications.loc_division_bbs' => $office->division_bbs_code,
                'landless_applications.loc_district_bbs' => $office->district_bbs_code,
                'landless_applications.loc_upazila_bbs' => $office->upazila_bbs_code,
                'landless_applications.loc_union_bbs' => $office->union_bbs_code,
            ];
        }

        return $conditions;

    }

    public static function getBbsCodeConditions($authUser, $tableName=null, $type = null)
    {
        $conditions = [];

        if ($authUser->isSuperUser()) {
            return $conditions;
        }

        if ((empty($authUser->office_id)) || $authUser->office_id == 0) {
            return [
                'landless_applications.loc_division_bbs' => 'no_data'
            ];
        }


        $office = DB::table('offices')
            ->where(['id' => $authUser->office_id])
            ->first();

        if ($office->jurisdiction == Office::DIVISION) {

            $conditions = [
                $tableName.'.loc_division_bbs' => $office->division_bbs_code
            ];
        }

        if ($office->jurisdiction == Office::DISTRICT) {
            $conditions = [
                $tableName.'.loc_division_bbs' => $office->division_bbs_code,
                $tableName.'.loc_district_bbs' => $office->district_bbs_code,
            ];
        }

        if ($office->jurisdiction == Office::UPAZILA) {
            $conditions = [
                $tableName.'.loc_division_bbs' => $office->division_bbs_code,
                $tableName.'.loc_district_bbs' => $office->district_bbs_code,
                $tableName.'.loc_upazila_bbs' => $office->upazila_bbs_code,
            ];
        }

        if ($office->jurisdiction == Office::UNION) {
            $conditions = [
                $tableName.'.loc_division_bbs' => $office->division_bbs_code,
                $tableName.'.loc_district_bbs' => $office->district_bbs_code,
                $tableName.'.loc_upazila_bbs' => $office->upazila_bbs_code,
                $tableName.'.loc_union_bbs' => $office->union_bbs_code,
            ];
        }

        return $conditions;

    }

    public static function getAuthUpazilaBbsCode($authUser)
    {
        $office = Office::find($authUser->office_id);
        return !empty($office) ? $office->upazila_bbs_code : '';

    }

    public static function division($divBbs)
    {
        return LocDivision::where([
            'bbs_code' => $divBbs,
        ])->first();
    }

    public static function district($locDivisionBbs, $locDistrictBbs)
    {
        return LocDistrict::where([
            'division_bbs_code' => $locDivisionBbs,
            'bbs_code' => $locDistrictBbs,
        ])->first();
    }

    public static function locUpazila($locDivisionBbs, $locDistrictBbs, $locUpazilaBbs)
    {
        return LocUpazila::where([
            'division_bbs_code' => $locDivisionBbs,
            'district_bbs_code' => $locDistrictBbs,
            'bbs_code' => $locUpazilaBbs,
        ])->first();
    }
}
