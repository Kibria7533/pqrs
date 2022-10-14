<?php

namespace Modules\Khotian\App\Models;

use App\Models\BaseModel;
use App\Models\LocUpazila;
use App\Models\LocAllMouja;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string attached_file
 */
class KhasLandKhotian extends BaseModel
{
    protected $guarded = [];
    protected $table = "division20_khotians";

    public function khaslandKhotianDags()
    {
        return $this->hasMany(KhasLandKhotianDag::class, 'muted_khotian_id', 'id');
    }



    public function getKhatianPrintJson($divisionBBS,$districtBBS, $upazilaBBS, $moujaJL, $khatianNumber){
    //   dd([$divisionBBS,$districtBBS, $upazilaBBS, $moujaJL, $khatianNumber]);
        $district =$districtBBS;
        if (
            empty($divisionBBS) ||
            empty($districtBBS) ||
            empty($upazilaBBS)  ||
            empty($moujaJL)     ||
            empty($khatianNumber)
        ) {
            return [];
        }

        $khotian_table_name = 'division20_khotians';
        $owner_table_name = 'division20_khatian_owners';
        $dag_table_name = 'division20_khatian_dags';
        $khotian_table = DB::table($khotian_table_name);
        $owner_table = DB::table($owner_table_name);
        $dag_table = DB::table($dag_table_name);
        $mouja_table_name = DB::table('loc_all_moujas');

        $mouja = LocAllMouja::where([
            'district_bbs_code' => (int) $districtBBS,
            'upazila_bbs_code' => (int) $upazilaBBS
        ])
            ->where(DB::raw('cast(SUBSTRING(dglr_code, -3) as unsigned)'), '=', $moujaJL)
            ->first();

        if(empty($mouja)){
            return [];
        }

        $owners = $owner_table
            ->select(
                $owner_table_name . '.khotian_number',
                $owner_table_name . '.id',
                $owner_table_name . '.owner_name',
                $owner_table_name . '.owner_address_pdf as owner_address',
                'owner_address as psudo_address',
                $owner_table_name . '.owner_area',
                $owner_table_name . '.owner_no',
                $owner_table_name . '.owner_group',
                $owner_table_name . '.guardian',
                $owner_table_name . '.mother_name',
                $owner_table_name . '.owner_mobile',
                $owner_table_name . '.identity_type'
            )

            ->leftJoin($khotian_table_name, $khotian_table_name . '.id', '=', $owner_table_name . '.muted_khotian_id')
            ->where([
                $khotian_table_name . '.district_bbs_code' => $districtBBS,
                $khotian_table_name . '.upazila_bbs_code' => $upazilaBBS,
                $khotian_table_name . '.jl_number' => $moujaJL,
                $khotian_table_name . '.khotian_number' => $khatianNumber,
                $owner_table_name . '.status' => 1
            ])

            ->orderBy($owner_table_name . '.owner_no', 'ASC')
            ->get()
            ->toArray();

        if (count($owners) > 1) {
            foreach ($owners as $key => $value) {
                // dump($key+1);
                $val = $key+1;
                if ($val != 1
                ) {
                    $owners[$key]->owner_name = eng_to_bangla_code($val) . ')&nbsp;' . $value->owner_name;
                } else {
                    $owners[$key]->owner_name = eng_to_bangla_code($val) . ')&nbsp;' . $value->owner_name;
                }
            }
        }
        //TODO: interchanged khotian dag_area to dag_portion
        $khotian = $khotian_table
            ->select(
                $dag_table_name . '.remark as remarks',
                $dag_table_name . '.dag_number',
                $dag_table_name . '.agricultural_use',
                $dag_table_name . '.agri_land_type as land_type_lt_id',
                $dag_table_name . '.total_dag_area',
                $dag_table_name . '.khotian_dag_portion as khotian_dag_area',
                $dag_table_name . '.khotian_dag_area as khotian_dag_portion',
                $dag_table_name . '.land_type as lt_name',
                $khotian_table_name . '.namjari_case_no',
                $khotian_table_name . '.revenue',
                $khotian_table_name . '.*'
            )
            ->leftJoin($dag_table_name, $dag_table_name . ".muted_khotian_id", "=", $khotian_table_name . ".id")
            ->where([

                $khotian_table_name . '.division_bbs_code' => $divisionBBS,
                $khotian_table_name . '.district_bbs_code' => $districtBBS,
                $khotian_table_name . '.upazila_bbs_code' => $upazilaBBS,
                $khotian_table_name . '.jl_number' => $moujaJL,
                $khotian_table_name . '.khotian_number' => $khatianNumber,
                // $khotian_table_name . '.status' => 1
            ])

            ->orderBy($dag_table_name . '.dag_number', 'ASC')
            ->get()
            ->toArray();
            // dd($khotian);
            foreach ($khotian as $key => $value) {
                $khotian[$key]->dag_number=bn2en($value->dag_number);
                $khotian[$key]->total_dag_area=bn2en($value->total_dag_area);
                if(strpos(bn2en($value->khotian_dag_area), ".")){
                    $khotian[$key]->khotian_dag_area=substr(bn2en($value->khotian_dag_area), 0, (strpos(bn2en($value->khotian_dag_area), ".")+5));
                }else{
                    $khotian[$key]->khotian_dag_area=bn2en($value->khotian_dag_area);
                }

                $khotian[$key]->khotian_dag_portion=bn2en($value->khotian_dag_portion);
                $khotian[$key]->khotian_number=bn2en($value->khotian_number);
                $khotian[$key]->dhara_no=bn2en($value->dhara_no);
                $khotian[$key]->total_land=bn2en($value->total_land);
                $khotian[$key]->remaining_land=bn2en($value->remaining_land);
            }

        $data[] = [
                'owners' => $owners, 'khotian' => $khotian, 'header_info' => $mouja, 'khotian_no' => $khatianNumber
            ];


        return \json_decode(\json_encode($data), true);
    }

}
