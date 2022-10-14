<?php

namespace Modules\Khotian\App\Models;


use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MutedKhotianDump extends BaseModel
{
    const SUCCESS = 1;
    const PENDING = 2;
    const ERROR = 3;
    const DELETED = 99;

    protected $table = '';
    protected $dates = ['created_at'];
    protected $guarded = [];

    private $divisionBBS;
    private $districtBBS;
    private $upazialBBS;
    private $moujaJl;
    private $surveyType;

    public static function mutedKhotianValidation($khotian, $isManual = false)
    {
        //dd($khotian);
        $errorMessages = [];
        $khotianNumber = null;

        if ($isManual) {
            $khotianNumber = bn2en($khotian['khatian_no']);
        } else {
            $khotianNumber = bn2en($khotian['khotian_no']);
        }

        $emptyErrorMsg = '';
        if ($isManual) {
            if (empty($khotian['khatian_no'])) {
                $emptyErrorMsg .= 'Khotian number ';
            }
        } else {
            if (empty($khotian['khotian_no'])) {
                $emptyErrorMsg .= ', Khotian number ';
            }
        }
        if (empty($khotian['header_info']['division_bbs_code'])) {
            $emptyErrorMsg .= ', Division BBS code ';
        }
        if (empty($khotian['header_info']['district_bbs_code'])) {
            $emptyErrorMsg .= ', District BBS code ';
        }
        if (empty($khotian['header_info']['upazila_bbs_code'])) {
            $emptyErrorMsg .= ', Upazila BBS code ';
        }
        if (empty($khotian['header_info']['jl_number'])) {
            $emptyErrorMsg .= ', JL number code ';
        }
        if (empty($khotian['header_info']['dglr_code'])) {
            $emptyErrorMsg .= ', DGLR code ';
        }
        if (!empty($emptyErrorMsg)) {
            $emptyErrorMsg .= ' is empty!';
            $errorMessages[] = $emptyErrorMsg;
        }

        $isMatched = preg_match("/(^[0-9]*$)|(^[0-9]+[\/][0-9]+$)|(^[0-9]+[\-][0-9]+$)/", $khotianNumber);

        if ((!$isMatched) || $khotianNumber == 0 || $khotianNumber == '0') {
            $errorMessages[] = 'Khotian number is not correct';
        }

        /** Check dug number is empty/duplicate or not **/
        $dagNumbers = [];
        if (count($khotian['dags']) > 0) {
            foreach ($khotian['dags'] as $dag) {
                if (empty($dag['dag_number'])) {
                    $errorMessages[] = 'Dag number is empty.';
                    break;
                }

                $enDagNumber = bn2en($dag['dag_number']);
                if (in_array($enDagNumber, $dagNumbers)) {
                    $errorMessages[] = 'Dag number: ' . $dag['dag_number'] . ' is duplicate';
                    break;
                }
                $dagNumbers[] = $enDagNumber;


            }
        } else {
            $errorMessages[] = 'Dag not found';
        }

        /** Check owners is empty/duplicate or not **/
        $ownerNames = [];
        $totalArea = 0;
        if (count($khotian['owners']) > 0) {
            foreach ($khotian['owners'] as $owner) {
                if (empty($owner['owner_name'])) {
                    $errorMessages[] = 'Owner name is empty.';
                    break;
                }

                $ownerArea = null;
                if(empty($owner['owner_area'])){
                    $errorMessages[] = 'Owner area is empty.';
                    break;
                }
                $ownerArea = bn2en($owner['owner_area']);

                if($ownerArea == 0){
                    $errorMessages[] = 'Owner area is empty.';
                }

                if (!is_numeric($ownerArea)) {
                    $errorMessages[] = 'Owner Area should be numeric';
                    break;
                }

                $ownerName = $owner['owner_name'];
                $ownerAddress = !empty($owner['owner_address']) ? $owner['owner_address'] : '';
                if (array_key_exists($ownerName, $ownerNames) && ($ownerAddress == $ownerNames[$ownerName])) {
                    $errorMessages[] = 'Owner name: ' . $ownerName . ' is duplicate';
                    break;
                }
                $ownerNames[$ownerName] = $ownerAddress;
                $totalArea += $ownerArea;
            }
        } else {
            $errorMessages[] = 'Owner not found';
        }

        if($totalArea != 1){
            $errorMessages[] = 'Total owner area should be 1';
        }

        $divisionBbs = $khotian['header_info']['division_bbs_code'];
        $districtBbs = $khotian['header_info']['district_bbs_code'];
        $upazilaBbs = $khotian['header_info']['upazila_bbs_code'];
        $jlNumber = $khotian['header_info']['jl_number'];
        $namjariCaseNo = null;
        if ($isManual) {
            $namjariCaseNo = $singleKhatian['header_info']['namjari_case_no'] ?? null;
        } else {
            $namjariCaseNo = $singleKhatian['header_info']['case_number'] ?? null;
        }

        $khotianDump = new MutedKhotianDump();
        $mutedKhotianTable = $khotianDump->getTableName($divisionBbs, 'khotian');
        if (empty($mutedKhotianTable)) {
            $errorMessages[] = 'Khotian Tables not found';
        }

        /*** Check khotian is duplicate or not ***/
        $isKhotianExist = DB::table($mutedKhotianTable)->where([
            'district_bbs_code' => $districtBbs,
            'upazila_bbs_code' => $upazilaBbs,
            'jl_number' => $jlNumber,
            'khotian_number' => $khotianNumber,
        ])->first();

        if ($isKhotianExist) {
            $errorMessages[] = 'Khotian is already exist';
        }

        /*** Check Case Number is duplicate or not ***/
        if ($namjariCaseNo) {
            $isCaseExit = DB::table($mutedKhotianTable)->where([
                'namjari_case_no' => $namjariCaseNo
            ])->first();

            if ($isCaseExit) {
                $errorMessages[] = 'Case number is already exist';
            }
        }

        return $errorMessages;
    }

    public function setTableName(String $tableName)
    {
        $this->table = $tableName;
    }

    public static function getTableName($divisionBbs, $type = false)
    {
        $tables = [];
        if (!$type) {
            $tables['khotian'] = 'division' . $divisionBbs . '_khotians';
            $tables['khotian_dag'] = 'division' . $divisionBbs . '_khatian_dags';
            $tables['khotian_owner'] = 'division' . $divisionBbs . '_khatian_owners';
            $tables['khotian_log'] = 'division' . $divisionBbs . '_khatian_logs';
            $tables['khotian_entry_log'] = 'division' . $divisionBbs . '_khatian_entry_logs';
            $tables['index'] = 'division' . $divisionBbs . '_rs_khotian_indexs';

            return $tables;
        }

        if ($type == 'khotian') {
            return 'division' . $divisionBbs . '_muted_khotians';
        }
        if ($type == 'khotian_dag') {
            return 'division' . $divisionBbs . '_muted_khatian_dags';
        }
        if ($type == 'khotian_owner') {
            return 'division' . $divisionBbs . '_muted_khatian_owners';
        }
        if ($type == 'khotian_log') {
            return 'division' . $divisionBbs . '_muted_khatian_logs';
        }
        if ($type == 'index') {
            return 'division' . $divisionBbs . '_rs_khotian_indexs';
        }

        return false;
    }
}
