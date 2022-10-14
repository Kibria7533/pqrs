<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LocMouja extends Model
{
    protected $table = 'loc_all_moujas';

    /**
     * get the mouja details object
     * @param $bbs
     * @param $upozila_bbs
     * @param $mouja_jl
     * @param null $survey brs, bs, cs,sa, ...
     * @throws \Exception
     * @return LocMouja Object
     */
    public static function getMouja($bbs, $upozila_bbs, $mouja_jl, $survey = null)
    {
        if(!in_array($survey, ['brs', 'bs', 'cs', 'rs', 'sa', 'pety', 'diara','muted']) ){
            throw new \Exception('Invalid survey type');
        }

        if($survey === 'muted'){
            $survey='brs';
        }


        return LocMouja::where([
            'district_bbs_code' => $bbs,
            'upazila_bbs_code' => $upozila_bbs,
            $survey.'_jl_no' => $mouja_jl
        ])->first();

    }


    /**
     * get dropdown option for mouja
     * @param $bbs
     * @param $upozila_bbs
     * @param null $survey
     * @return LocMouja Array
     * @throws \Exception
     */

    public static function getMoujaOptions($bbs, $upozila_bbs, $survey = null)
    {

        if(!in_array($survey, ['brs', 'bs', 'cs', 'rs', 'sa', 'pety', 'diara','muted']) ){
            throw new \Exception('Invalid survey type');
        }

    /**
    CASE
        WHEN \''.$survey.'\' = \'rs\' AND rsk_jl_no > \'\' THEN rsk_jl_no
                WHEN  \''.$survey.'\' = \'rs\' AND rsk_jl_no = \'\' AND rs_jl_no > \'\'  THEN rs_jl_no
                ELSE '.$survey . '_jl_no
            END  as bbs_code'
        */

        if($survey === 'muted'){
            $survey='brs';
        }


        return LocMouja::select(DB::raw(
            'CONCAT('.$survey . '_jl_no, "-", name_bd) as title,
            `'.$survey . '_jl_no` as bbs_code'
            ))
            ->where([
                'district_bbs_code' => (int)$bbs,
                'upazila_bbs_code' => (int)$upozila_bbs
            ])
            ->where(function ($q) use ($survey){
                $q->where($survey.'_jl_no', '>', '');
            })
            ->orderByRaw('cast('.$survey.'_jl_no as unsigned) ASC')
            ->pluck('title', 'bbs_code');
    }


    public static function getMapMoujaOptions($bbs, $upozila_bbs, $survey = null)
    {

        if(!in_array($survey, ['brs', 'bs', 'cs', 'rs', 'sa', 'pety', 'diara']) ){
            throw new \Exception('Invalid survey type');
        }

        /**
        CASE
        WHEN \''.$survey.'\' = \'rs\' AND rsk_jl_no > \'\' THEN rsk_jl_no
        WHEN  \''.$survey.'\' = \'rs\' AND rsk_jl_no = \'\' AND rs_jl_no > \'\'  THEN rs_jl_no
        ELSE '.$survey . '_jl_no
        END  as bbs_code'
         */

        // Get Jl Codes of mouja map
        $moujaJlCodes = [];
        $jlCodes = DB::table('mouja_maps')
            ->where([
                'district_bbs_code' => $bbs,
                'upazila_bbs_code' => $upozila_bbs,
                'survey_type' => KhotianIndexs::$surveyType[$survey]
            ])
            ->groupBy('jl_code')
            ->pluck('jl_code');
        if (count($jlCodes) > 0) {
            $moujaJlCodes = $jlCodes;
        }

        return LocMouja::select(DB::raw(
            'CONCAT('.$survey . '_jl_no, "-", name_bd) as title,
            `'.$survey . '_jl_no` as bbs_code'
        ))
            ->where([
                'district_bbs_code' => $bbs,
                'upazila_bbs_code' => $upozila_bbs
            ])
            ->where(function ($q) use ($survey){
                $q->where($survey.'_jl_no', '>', '');
            })
            ->whereIn($survey.'_jl_no', $moujaJlCodes)
            ->orderByRaw('cast('.$survey.'_jl_no as unsigned) ASC')
            ->pluck('title', 'bbs_code');
    }
}
