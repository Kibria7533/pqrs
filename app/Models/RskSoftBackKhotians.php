<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;
use Modules\Khotian\App\Models\MutedKhotianDump;
use Module\Office\Models\Offices;
use PDO;

class RskSoftBackKhotians extends Model
{
    protected $connection = 'rsk_main_db';

    public static $surveyType = [
        1 => 'cs',
        2 => 'rs',
        3 => 'sa',
        4 => 'bs',
        5 => 'diara',
        6 => 'pt',
        7 => 'ct'
    ];
    protected $table = 'brs_khotian_owners';
    protected $guarded = [];

    const _CONNECTION_NAME = 'rsk_main_db';


    public function getDivisionID($divisionBBS){
        $sql = 'select id from dglr_divisions where division_bbs_code = ' . $divisionBBS;
        $users = null;
        try{
            $users = DB::connection(self::_CONNECTION_NAME )->select($sql);
        }catch (\Exception $e){
            if(empty($users)) return false;
        }

        if(empty($users)) return false;

        return $users[0]->id;
    }

    public function getRemotKhotian($district){
        $responseData = Curl::to('https://rsk.land.gov.bd/api/kdata/13')
            ->get();
        $response = json_decode($responseData, true);
        if(isset($response['status']) && $response['status'] == true){
            return $response['data'];
        }else{
            dd($responseData);
        }
        return [];
    }
    public function getKhotian($data){
        $response =  $this->listing($data);
        if($response['status'] == true){
            return $response['data'];
        }
        return [];
    }
    public function getKhotianBack($data){
            $divisionBBS = $data['division_bbs'];
            $districtBBS = $data['district_bbs'];
            $pageNo = $data['page_no'];
            $limit = 25;
            $offset = ($pageNo - 1) * $limit;
            if(empty($districtBBS)){
                return false;
            }
            $districtID = $this->getDistrictID($districtBBS);
            $sql = '
SELECT
	o.id,
	owner_dag.dags,
	GROUP_CONCAT( o.owner_address ) AS owner_address,
	SUBSTRING( m.dglr_code, - 2 ) AS jl,
	GROUP_CONCAT( o.owner_name ) AS owner_name,
	o.upazila_id,
	m.upazila_bbs_code,
	o.mouja_id,
	o.khotian_number
FROM
	brs'.$districtID.'_khotian_owners o
	INNER JOIN dglr_rs_mouja_details m ON m.id = o.mouja_id
	LEFT	JOIN (
	select `d`.`upazila_id` AS `upazila_id`,`d`.`mouja_id` AS `mouja_id`,`d`.`khotian_number` AS `khotian_number`,group_concat(`d`.`dag_number` separator \',\') AS `dags` from `brs'.$districtID.'_khotian_dags` `d` group by `d`.`upazila_id`,`d`.`mouja_id`,`d`.`khotian_number`
	) owner_dag
	ON  (owner_dag.upazila_id = o.upazila_id and owner_dag.mouja_id = o.mouja_id and owner_dag.khotian_number = o.khotian_number)
GROUP BY
	o.upazila_id, o.mouja_id, o.khotian_number
ORDER BY
	CAST( o.khotian_number AS UNSIGNED ) ASC
    LIMIT '.$limit.' offset ' . $offset;

            try{
                $owners = DB::connection(self::_CONNECTION_NAME )->select($sql);
            }catch (\Exception $e){
                Log::debug($e->getMessage());
                if(empty($owners)) return [];
            }

            $index = [];
            foreach ($owners as $key => $owner){
               $index[$owner->khotian_number] = [
                   'district_bbs_code' => $districtBBS,
                   'upazila_bbs_code' => $owner->upazila_bbs_code,
                   'system_entry_id' => $owner->id,
                   'address' => $owner->owner_address,
                   'owner' => $owner->owner_name,
                   'mouja_jl_code' => $owner->jl,
                   'khotian_no' => $owner->khotian_number,
                   'dag' => $owner->dags,
                   'created_at' => Carbon::now()->format('Y-m-d')
               ];
            }

            return $index;
    }

    public function getDags($districtID, $upazila_id, $mouja_id, $khotian_number){
        $sql = ' SELECT GROUP_CONCAT(d.dag_number) as dags, d.khotian_number FROM brs'.$districtID.'_khotian_dags d WHERE d.upazila_id = '.$upazila_id.' and d.mouja_id = '.$mouja_id.' and khotian_number = "'.$khotian_number.'"';
        $dags = [];
        try{
            $dags = DB::connection(self::_CONNECTION_NAME )->select($sql);
        }catch (\Exception $e){
            Log::debug($e->getMessage());
        }
        if(!empty($dags)){
            return $dags[0]->dags;
        }
        return $dags;
    }


    public function listing($data){
        $dataRes['status'] = false;
        $dataRes['code'] = '404';
        $dataRes['message'] = 'Unauthorized';
        $dataRes['data'] = [];

        $districtID = $data['district_id'];
        $pageNo = $data['page_no'];
        $limit = $data['limit'];
        $offset = ($pageNo - 1) * $limit;
        if(empty($districtID)){
            return $dataRes;
        }
        $sql = '
                    SELECT
                        o.id,
                        owner_dag.dags,
                        GROUP_CONCAT( o.owner_address ) AS owner_address,
                        SUBSTRING( m.dglr_code, - 2 ) AS jl,
                        GROUP_CONCAT( o.owner_name ) AS owner_name,
                        o.upazila_id,
                        m.upazila_bbs_code,
                        o.mouja_id,
                        o.khotian_number
                    FROM
                        brs'.$districtID.'_khotian_owners o
                        INNER JOIN dglr_rs_mouja_details m ON m.id = o.mouja_id
                        LEFT	JOIN (
                        select `d`.`upazila_id` AS `upazila_id`,`d`.`mouja_id` AS `mouja_id`,`d`.`khotian_number` AS `khotian_number`,group_concat(`d`.`dag_number`) AS `dags` from `brs'.$districtID.'_khotian_dags` `d` group by `d`.`upazila_id`,`d`.`mouja_id`,`d`.`khotian_number`
                        ) owner_dag
                        ON  (owner_dag.upazila_id = o.upazila_id and owner_dag.mouja_id = o.mouja_id and owner_dag.khotian_number = o.khotian_number)
                    GROUP BY
                        o.upazila_id, o.mouja_id, o.khotian_number
                    ORDER BY
                        CAST( o.khotian_number AS UNSIGNED ) ASC
                        LIMIT '.$limit.' offset ' . $offset;
        try{
            $q = DB::connection(self::_CONNECTION_NAME )->getPdo()->query($sql);
            $owners = $q->fetchAll(PDO::FETCH_ASSOC);
        }catch (\Exception $e){
            Log::debug($e->getMessage());
            return $dataRes;
        }
        $index = [];
        foreach ($owners as $key => $owner){
            $index['division'.$owner['division_bbs_code'].'_rs_khotian_indexs'][] = [
                'district_bbs_code' => $owner['district_bbs_code'],
                'upazila_bbs_code' => $owner['upazila_bbs_code'],
                'system_type' => 'rsk',
                'system_entry_id' => $owner['id'],
                'address' => $owner['owner_address'],
                'owner' => $owner['owner_name'],
                'mouja_jl_code' => $owner['jl'],
                'khotian_no' => $owner['khotian_number'],
                'dag' => $owner['dags'],
                'created_at' => date('Y-m-d')
            ];
        }
        $dataRes['status'] = true;
        $dataRes['code'] = '200';
        $dataRes['message'] = 'data fetch successfully';
        $dataRes['data'] = $index;

        return $dataRes;
    }

    public function getDistrictID($districtBBS){
        if (empty($districtBBS))
            return false;

        $sql = 'select id from dglr_districts where district_bbs_code = ' . $districtBBS;
        try{
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute($sql);
            $rows = $stmt->fetchAll('assoc');
        }catch (\Exception $e){
            return false;
        }

        if(empty($rows)) return false;

        return $rows[0]['id'];
    }


    public function batchKhotianPrint()
    {
        $input = $this->request->data;
        $this->layout = 'ajax';
        $batch_khotians = [];
        $items = [];
        $print_type = $input['print_type'];

        $khotian_table_name = 'brs_khotian_dags';
        $owner_table_name = 'brs_khotian_owners';
        $khotian_table = TableRegistry::get($khotian_table_name);
        $user = [];
        $userCode = empty($user['code']) ? '000': $user['code'];
        $ip = \Illuminate\Support\Facades\Request::ip();
        $formatedIpPartOne = '';
        $formatedIpPartTwo = '';
        if(!empty($ip)){
            $tmpIPArr = explode('.', $ip);

            foreach ($tmpIPArr as $key => $partOfIp){

                $length = strlen($partOfIp);
                switch ($length){
                    case 1:
                        $formated = '00'.$partOfIp;
                        break;
                    case 2:
                        $formated = '0'.$partOfIp;
                        break;
                    case 3:
                        $formated =  $partOfIp;
                        break;
                    default:
                        $formated = '000';
                        break;
                }
                if($key <= 1){
                    $formatedIpPartOne .= $formated;
                }else{
                    $formatedIpPartTwo .= $formated;
                }
            }
        }else{
            $formatedIpPartOne = '000000';
            $formatedIpPartTwo = '000000';
        }

        if (!empty($input['id']) && count($input['id']) > 0) {
            $items = $input['id'];
        } else {
            $items = $khotian_table->find('list', [
                'keyField' => 'id',
                'valueField' => 'khotian_number'
            ])
                ->order(['convert(`dag_number`, decimal)' => 'ASC'])
                ->where(['mouja_id' => $input['mouja_id']])
                ->toArray();
        }

        foreach ($items as $id) {
            //$i++;
            $owner_table = TableRegistry::get($owner_table_name);
            $owners = $owner_table->find('all')
                ->order(['owner_serial_id' => 'ASC'])
                ->select([
                    'id',
                    'owner_name',
                    'address_line_num',
                    'owner_address',
                    'owner_area',
                    'mokadoma_no',
                    'dhara_no',
                    'dhara_son'
                ])
                ->where(['mouja_id' => $input['mouja_id'], 'khotian_number' => $id])
                ->toArray();

            $khotian = $khotian_table->find('all')
                ->select(['brs_khotian_entries.is_special','brs_khotian_entries.computer_code','remarks', 'dag_number', 'agricultural_use', 'land_type_lt_id', 'total_dag_area', 'khotian_dag_portion', 'khotian_dag_area'])
                ->select(['land_type.lt_name'])
                ->order(['convert(`dag_number`, decimal)' => 'ASC'])
                ->where(['mouja_id' => $input['mouja_id'], 'khotian_number' => $id])
                ->leftJoin('land_type', "land_type.lt_id = " . $khotian_table_name . ".land_type_lt_id")
                ->leftJoin('brs_khotian_entries', "brs_khotian_entries.id = " . $khotian_table_name . ".brs_khotian_entry_id")
                ->toArray();

            $owner_table = TableRegistry::get('dglr_rs_mouja_details');
            //table header info
            $khotian_no = $id;
            $header_info = $owner_table->find('all')
                ->select(['dglr_rs_mouja_details.upazila_name', 'dglr_rs_mouja_details.resa_number', 'dglr_rs_mouja_details.district_name', 'dglr_rs_mouja_details.name_bd', 'dglr_rs_mouja_details.dglr_code'])
                ->select(['dglr_divisions.name_bn'])
                ->leftJoin('dglr_divisions', 'dglr_divisions.division_bbs_code = dglr_rs_mouja_details.division_bbs_code')
                ->where(['dglr_rs_mouja_details.id' => $input['mouja_id']])
                ->first();
            $khotian_details['owners'] = $owners;
            $khotian_details['khotian'] = $khotian;
            $khotian_details['header_info'] = $header_info;
            $khotian_details['khotian_no'] = $khotian_no;
            $batch_khotians[] = $khotian_details;

        }

        // $this->set('moujaDetailDataArr', array_shift($moujaDetailDataArr));
        $this->set(compact('batch_khotians', 'print_type', 'formatedIpPartOne', 'formatedIpPartTwo', 'userCode'));
    }

    // TODO: khatian print function (arman)
    public static function getKhatianprintJson($districtBBS, $upazilaBBS, $moujaJL, $khatianNumber){
        //print_r($input);die;
        $district_table_name = 'dglr_districts';
        $district_table = DB::connection(self::_CONNECTION_NAME)->table($district_table_name);
        $district = $district_table->where([
            'district_bbs_code' => $districtBBS
        ])->first();

        if(empty($district)){
            return [];
        }

        $khotian_table_name = 'brs' . $district->id . '_khotian_dags';
        $owner_table_name = 'brs' . $district->id . '_khotian_owners';
        $mouja_table_name = 'dglr_rs_mouja_details';
        $khotian_table = DB::connection(self::_CONNECTION_NAME)->table($khotian_table_name);
        $owner_table = DB::connection(self::_CONNECTION_NAME)->table($owner_table_name);
        $mouja_table = DB::connection(self::_CONNECTION_NAME)->table($mouja_table_name);

        $mouja = $mouja_table->where([
            'district_bbs_code' => (int) $districtBBS,
            'upazila_bbs_code' => (int) $upazilaBBS
        ])
            ->where(DB::raw('cast(SUBSTRING(dglr_code, -3) as unsigned)'), '=', $moujaJL)
            ->first();

        if(empty($mouja)){
            return [];
        }

        $owners = $owner_table->select('owner_name','address_line_num','owner_address','owner_area')
            ->where(['dglr_code' => $mouja->dglr_code, 'khotian_number'=> $khatianNumber, 'status' =>1 ])
            ->orderBy('owner_serial_id', 'ASC')
            ->get()->toArray();


        $khotian = $khotian_table
            ->select('remarks','dag_number','agricultural_use','land_type_lt_id','total_dag_area','khotian_dag_portion','khotian_dag_area', 'land_type.lt_name')
            ->where([ 'dglr_code'=>$mouja->dglr_code,'khotian_number'=> $khatianNumber, $khotian_table_name.'.status'=>1])
            ->leftJoin('land_type', "land_type.lt_id", "=", $khotian_table_name.".land_type_lt_id")
            ->orderBy(DB::raw('convert(`dag_number`, decimal)'), 'ASC')
            ->get()
            ->toArray();


        //table header info
        $header_info = DB::connection(self::_CONNECTION_NAME)->table($mouja_table_name)
            ->select(
                'dglr_rs_mouja_details.upazila_name',
                'dglr_rs_mouja_details.district_name',
                'dglr_rs_mouja_details.name_bd',
                'dglr_rs_mouja_details.id',
                'dglr_rs_mouja_details.dglr_code',
                'dglr_divisions.name_bn'
            )
            ->leftJoin('dglr_divisions','dglr_divisions.division_bbs_code', '=', 'dglr_rs_mouja_details.division_bbs_code')
            ->where('dglr_rs_mouja_details.dglr_code', $mouja->dglr_code)
            ->first();

        $data[] = [
            'owners' => $owners
            ,'khotian' => $khotian
            ,'header_info' => $header_info
            ,'khotian_no' => $khatianNumber
        ];

        return \json_decode(\json_encode($data), true);
    }

    public static function getKhatianByNumberOrDag($districtBBS, $upazilaBBS, $moujaJL, $khatianNumber, $dagNumber){
        $data = [];
        $district_table_name = 'dglr_districts';
        $district_table = DB::connection(self::_CONNECTION_NAME)->table($district_table_name);

        $district = $district_table->where([
            'district_bbs_code' => $districtBBS
        ])->first();

        if(empty($district)){
            throw new \Exception('district not found.');
        }

        $upazila_table_name = 'dglr_upazilas';
        $upazila_table = DB::connection(self::_CONNECTION_NAME)->table($upazila_table_name);

        $upazila = $upazila_table->where([
            'upazila_bbs_code' => (int) $upazilaBBS
        ])->first();

        if(empty($upazila)){
            throw new \Exception('upazila not found.');
        }

        $khotian_table_name = 'brs' . $district->id . '_khotian_dags';
        $owner_table_name = 'brs' . $district->id . '_khotian_owners';
        $mouja_table_name = 'dglr_rs_mouja_details';

        $khotian_table = DB::connection(self::_CONNECTION_NAME)->table($khotian_table_name);
        $owner_table = DB::connection(self::_CONNECTION_NAME)->table($owner_table_name);
        $mouja_table = DB::connection(self::_CONNECTION_NAME)->table($mouja_table_name);

        $mouja = $mouja_table->where([
            'district_bbs_code' => (int) $districtBBS,
            'upazila_bbs_code' => (int) $upazilaBBS
        ])
            ->where(DB::raw('cast(SUBSTRING(dglr_code, -3) as unsigned)'), '=', $moujaJL)
            ->first();

        if(empty($mouja)){
            throw new \Exception('mouja not found.');
        }

        // if dag find khatians
        $khatianOrDagNo = [];
        if(empty($khatianNumber) && !empty($dagNumber)){
            // searching dag number, find khatian number
            try {
                $khatiansNumbers = $khotian_table
                    ->select('khotian_number')
                    ->where(['mouja_id' => $mouja->id, 'dag_number' => $dagNumber, 'status' => 1])
                    ->groupBy('khotian_number')
                    ->get();
            }catch (\Exception $exception){

            }

            if(count($khatiansNumbers) === 0){
                return [];
            }

            $khatianQueryArr = [];
            foreach ($khatiansNumbers as $item){
                $khatianQueryArr[] = $item->khotian_number;
            }

        }else{
            $khatianQueryArr[] = $khatianNumber;
        }

        foreach ($khatianQueryArr as $singleKhatianNumber) {
            $khotian_table = DB::connection(self::_CONNECTION_NAME)->table($khotian_table_name);
            $owner_table = DB::connection(self::_CONNECTION_NAME)->table($owner_table_name);

            $owners = $owner_table->select('owner_name', 'address_line_num', 'owner_address', 'owner_area')
                ->where(['dglr_code' => $mouja->dglr_code, 'khotian_number' => $singleKhatianNumber, 'status' => 1])
                ->orderBy('owner_serial_id', 'ASC')
                ->get()->toArray();

            if(count($owners) === 0){
                return [];
            }

            $khotian = $khotian_table
                ->select('remarks', 'dag_number', 'agricultural_use', 'land_type_lt_id', 'total_dag_area', 'khotian_dag_portion', 'khotian_dag_area', 'land_type.lt_name')
                ->leftJoin('land_type', "land_type.lt_id", "=", $khotian_table_name . ".land_type_lt_id")
                ->where(['dglr_code' => $mouja->dglr_code, 'khotian_number' => $singleKhatianNumber, $khotian_table_name . '.status' => 1])
                ->orderBy(DB::raw('convert(`dag_number`, decimal)'), 'ASC')
                ->get()
                ->toArray();


            //table header info
            $header_info = DB::connection(self::_CONNECTION_NAME)->table($mouja_table_name)
                ->select(
                    'dglr_rs_mouja_details.upazila_name',
                    'dglr_rs_mouja_details.district_name',
                    'dglr_rs_mouja_details.name_bd',
                    'dglr_rs_mouja_details.id',
                    'dglr_rs_mouja_details.dglr_code',
                    'dglr_divisions.name_bn'
                )
                ->leftJoin('dglr_divisions', 'dglr_divisions.division_bbs_code', '=', 'dglr_rs_mouja_details.division_bbs_code')
                ->where('dglr_rs_mouja_details.dglr_code', $mouja->dglr_code)
                ->first();

            $data[] = [
                'owners' => $owners
                , 'khotian' => $khotian
                , 'header_info' => $header_info
                , 'khotian_no' => $singleKhatianNumber
            ];
            unset($owners,
                $khotian,
                $header_info
            );
        }

        return  $data;
    }
    public static function eng_to_bangla_code($input){
        $ban_number = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','');
        $eng_number = array(1,2,3,4,5,6,7,8,9,0,'');
        return str_replace($eng_number,$ban_number,$input);
    }

    // TODO: new print system for muted (arman)

    public static function getMutedKhatianprintJson($districtBBS, $upazilaBBS, $moujaJL, $khatianNumber){
        $district = LocDistrict::where([
            'bbs_code' => $districtBBS
        ])->first();

        if (empty($district)) {
            return [];
        }
        $divisionBBS = $district->division_bbs_code;

        // $khotian_table_name = 'brs' . $district->id . '_khotian_dags';
        $khotian_table_name = 'division' . $divisionBBS . '_muted_khotians';
        // $owner_table_name = 'brs' . $district->id . '_khotian_owners';
        $owner_table_name = 'division' . $divisionBBS . '_muted_khatian_owners';
        $dag_table_name = 'division' . $divisionBBS . '_muted_khatian_dags';
        // division30_muted_khatian_owners
        // $mouja_table_name = 'dglr_rs_mouja_details';
        /*$khotian_table = DB::connection(self::_CONNECTION_NAME)->table($khotian_table_name);
        $owner_table = DB::connection(self::_CONNECTION_NAME)->table($owner_table_name);
        $mouja_table = DB::connection(self::_CONNECTION_NAME)->table($mouja_table_name); */
        $khotian_table = DB::table('division' . $divisionBBS . '_muted_khotians');
        $owner_table = DB::table('division' . $divisionBBS . '_muted_khatian_owners');
        $dag_table = DB::table($dag_table_name);
        $mouja_table_name = DB::table('loc_all_moujas');


        $mouja = LocMouja::where([
            'district_bbs_code' => (int) $districtBBS,
            'upazila_bbs_code' => (int) $upazilaBBS
        ])
            ->where('brs_jl_no', '=', $moujaJL)
            ->first();

        if(empty($mouja)){
            return [];
        }

        $authUser = Auth::user();
        $isAclandUser = false;
        $getDistrictBBS = Office::select(['district_bbs_code', 'upazila_bbs_code'])
        ->where('id', $authUser->office_id)
        ->first();
        $districtBBS_get = $getDistrictBBS->district_bbs_code;
        $upazilaBBS_get = $getDistrictBBS->upazila_bbs_code;

        if (!empty($districtBBS_get) && !empty($upazilaBBS_get)) {
            $isAclandUser = true;
        }

        // removed address line number
        // $owners = $owner_table->select($owner_table_name.'.*') // main code
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
                /*$khotian_table_name.'.dglr_code' => $mouja->dglr_code, */
                $khotian_table_name . '.district_bbs_code' => $districtBBS,
                $khotian_table_name . '.upazila_bbs_code' => $upazilaBBS,
                $khotian_table_name . '.jl_number' => $moujaJL,
                $khotian_table_name . '.khotian_number' => $khatianNumber,
                $owner_table_name . '.status' => 1
            ])

            ->orderBy($owner_table_name . '.owner_no', 'ASC')
            ->get()->toArray();

        if (count($owners) > 1) {
            foreach ($owners as $key => $value) {
                $val = $key + 1;
                if ($val != 1
                ) {
                    // $owners[$key]->owner_name='<br>'.self::eng_to_bangla_code($val).')&nbsp;'.$value->owner_name.'<br>'.$value->owner_address;
                    $owners[$key]->owner_name = self::eng_to_bangla_code($val) . ')&nbsp;' . $value->owner_name;
                } else {
                    // $owners[$key]->address_line_num=2;
                    $owners[$key]->owner_name = self::eng_to_bangla_code($val) . ')&nbsp;' . $value->owner_name;
                }
            }
        }

        /* $khotian = $khotian_table
            ->select('remarks', 'dag_number', 'agricultural_use', 'land_type_lt_id', 'total_dag_area', 'khotian_dag_portion', 'khotian_dag_area', 'land_type.lt_name')
            ->where(['dglr_code' => $mouja->dglr_code, 'khotian_number' => $khatianNumber, $khotian_table_name . '.status' => 1])
            ->leftJoin('land_type', "land_type.lt_id", "=", $khotian_table_name . ".land_type_lt_id")
            ->orderBy(DB::raw('convert(`dag_number`, decimal)'), 'ASC')
            ->get()
            ->toArray(); */
        $dag_number_value = $dag_table_name . '.dag_number';
        //TODO: interchanged khotian dag_area to dag_portion
        $khotian = $khotian_table
            // ->select('remarks','dag_number','agricultural_use','land_type_lt_id','total_dag_area','khotian_dag_portion','khotian_dag_area', 'land_type.lt_name')
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
                /*$khotian_table_name.'.dglr_code'=>$mouja->dglr_code,*/
                $khotian_table_name . '.district_bbs_code' => $districtBBS,
                $khotian_table_name . '.upazila_bbs_code' => $upazilaBBS,
                $khotian_table_name . '.jl_number' => $moujaJL,
                $khotian_table_name . '.khotian_number' => $khatianNumber,
                $khotian_table_name . '.status' => 1
            ])
            // ->orderBy(DB::raw('convert(`'.$dag_number_value.'`, decimal)'), 'ASC')
            ->orderBy($dag_table_name . '.dag_number', 'ASC')
            ->get()
            ->toArray();

            foreach ($khotian as $key => $value) {
                $khotian[$key]->dag_number=bn2en($value->dag_number);
                $khotian[$key]->total_dag_area=bn2en($value->total_dag_area);
                if(strpos(bn2en($value->khotian_dag_area), ".")){
                    // dd(substr(bn2en($value->khotian_dag_area), 0, (strpos(bn2en($value->khotian_dag_area), ".")+5)));
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

        //table header info

        /*$header_info = LocMouja::select(
                'upazila_name',
                'district_name',
                'name_bd',
                'id',
                'dglr_code',
                'division_name',
            )
             ->where(
                'dglr_code', $mouja->dglr_code
            )
            ->first();*/

        $data[] = [
                'owners' => $owners,
                'khotian' => $khotian,
                'header_info' => $mouja,
                'khotian_no' => $khatianNumber,
                'isAclandUser'=>$isAclandUser
            ];

        return \json_decode(\json_encode($data), true);
    }


    /** This method will update in future **/
    public static function getMutedKhatianprintJsonForRequested($districtBBS, $upazilaBBS, $moujaJL, $khatianNumber){

        $district = LocDistrict::where([
            'bbs_code' => $districtBBS
        ])->first();

        if (empty($district)) {
            return [];
        }

        $divisionBBS = $district->division_bbs_code;

        $mutedTables = MutedKhotianDump::getTableName($divisionBBS);
        $khotianTableName = $mutedTables['khotian'];
        $ownerTableName = $mutedTables['khotian_owner'];
        $dagTableName = $mutedTables['khotian_dag'];

        $mouja = LocMouja::where([
            'district_bbs_code' => (int)$districtBBS,
            'upazila_bbs_code' => (int)$upazilaBBS
        ])
            ->where('brs_jl_no', '=', $moujaJL)
            ->first();

        if (empty($mouja)) {
            return [];
        }

        $authUser = Auth::user();
        $isAclandUser = false;
        $getDistrictBBS = Office::select(['district_bbs_code', 'upazila_bbs_code'])
        ->where('id', $authUser->office_id)
        ->first();

        $districtBBS_get = !empty($getDistrictBBS->district_bbs_code)? $getDistrictBBS->district_bbs_code:75;
        $upazilaBBS_get = !empty($getDistrictBBS->upazila_bbs_code)?$getDistrictBBS->upazila_bbs_code:null;

        if (!empty($districtBBS_get) && !empty($upazilaBBS_get)) {
            $isAclandUser = true;
        }

        $owners = DB::table($ownerTableName)
            ->select(
                $ownerTableName . '.khotian_number',
                $ownerTableName . '.id',
                $ownerTableName . '.owner_address_pdf as owner_address',
                $ownerTableName . '.owner_name',
                'owner_address as psudo_address',
                $ownerTableName . '.owner_area',
                $ownerTableName . '.owner_no',
                $ownerTableName . '.owner_group',
                $ownerTableName . '.guardian',
                $ownerTableName . '.mother_name',
                $ownerTableName . '.owner_mobile',
                $ownerTableName . '.identity_type'
            )
            ->leftJoin($khotianTableName, $khotianTableName . '.id', '=', $ownerTableName . '.muted_khotian_id')
            ->where([
                $khotianTableName . '.district_bbs_code' => $districtBBS,
                $khotianTableName . '.upazila_bbs_code' => $upazilaBBS,
                $khotianTableName . '.jl_number' => $moujaJL,
                $ownerTableName . '.khotian_number' => $khatianNumber,
                $ownerTableName . '.status' => 1
            ])
            ->orderBy($ownerTableName . '.owner_no', 'ASC')
            ->get()->toArray();

        if (count($owners) > 1) {
            foreach ($owners as $key => $value) {
                //$test[$key] = $value;
                $val = $key + 1;
                if ($val != 1) {
                    $owners[$key]->owner_name = self::eng_to_bangla_code($val) . ')&nbsp;' . $value->owner_name;
                } else {
                    $owners[$key]->owner_name = self::eng_to_bangla_code($val) . ')&nbsp;' . $value->owner_name;
                }
            }
            //dd($test);
        }
        //TODO: interchanged khotian dag_area to dag_portion
        $khotian = DB::table($khotianTableName)
            ->select(
                $dagTableName . '.remark as remarks',
                $dagTableName . '.dag_number',
                $dagTableName . '.agricultural_use',
                $dagTableName . '.agri_land_type as land_type_lt_id',
                $dagTableName . '.total_dag_area',
                $dagTableName . '.khotian_dag_portion as khotian_dag_area',
                $dagTableName . '.khotian_dag_area as khotian_dag_portion',
                $dagTableName . '.land_type as lt_name',
                $khotianTableName . '.namjari_case_no',
                $khotianTableName . '.revenue',
                $khotianTableName . '.*'
            )
            ->leftJoin($dagTableName, $dagTableName . ".muted_khotian_id", "=", $khotianTableName . ".id")
            ->where([
                $khotianTableName . '.district_bbs_code' => $districtBBS,
                $khotianTableName . '.upazila_bbs_code' => $upazilaBBS,
                $khotianTableName . '.jl_number' => $moujaJL,
                $khotianTableName . '.khotian_number' => $khatianNumber,
                [$khotianTableName . '.status', '!=', 99]
            ])
            ->orderBy($dagTableName . '.dag_number', 'ASC')
            ->get()
            ->toArray();

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
            'owners' => $owners,
            'khotian' => $khotian,
            'header_info' => $mouja,
            'khotian_no' => $khatianNumber,
            'isAclandUser'=>$isAclandUser
        ];

        return \json_decode(\json_encode($data), true);
    }


    public static function nonProvidedPrintJson($districtBBS, $upazilaBBS, $moujaJL, $khatianNumber, $reasons)
    {
        $authUser = Auth::user();
        $isAclandUser=false;
        $getDistrictBBS = Office::select(['district_bbs_code', 'upazila_bbs_code'])
        ->where('id', $authUser->office_id)
        ->first();
        $districtBBS_get = !empty($getDistrictBBS->district_bbs_code)?$getDistrictBBS->district_bbs_code:75;
        // get upazilas by user district bbs code
        $upazilas = LocUpazila::where('district_bbs_code', $districtBBS)
        ->where('status', 1)
        ->pluck('title', 'bbs_code');
        $upazilaBBS_get = !empty($getDistrictBBS->upazila_bbs_code)?$getDistrictBBS->upazila_bbs_code:null;
       if(!empty($districtBBS_get) && !empty($upazilaBBS_get)){
        $isAclandUser=true;
       }

        $district = LocDistrict::where([
            'bbs_code' => $districtBBS
        ])->first();

        if (empty($district)) {
            return [];
        }
        $divisionBBS = $district->division_bbs_code;

        $mutedTables = MutedKhotianDump::getTableName($divisionBBS);
        $khotianTableName = $mutedTables['khotian'];
        $dagTableName = $mutedTables['khotian_dag'];

        $mouja = LocMouja::where([
            'district_bbs_code' => (int) $districtBBS,
            'upazila_bbs_code' => (int) $upazilaBBS
        ])
            ->where('brs_jl_no', '=', $moujaJL)
            ->first();

        if (empty($mouja)) {
            return [];
        }

        $khotian = DB::table($khotianTableName)
        ->select(
            $khotianTableName . '.*'
        )
        ->leftJoin($dagTableName, $dagTableName . ".muted_khotian_id", "=", $khotianTableName . ".id")
        ->where([
            $khotianTableName . '.district_bbs_code' => $districtBBS,
            $khotianTableName . '.upazila_bbs_code' => $upazilaBBS,
            $khotianTableName . '.jl_number' => $moujaJL,
            $khotianTableName . '.khotian_number' => $khatianNumber,
            [$khotianTableName . '.status', '!=', 99]
        ])
        ->orderBy($dagTableName . '.dag_number', 'ASC')
        ->get()
        ->toArray();

        $data[] = [
            'non_provide' => json_decode($reasons, true),
            'isAclandUser'=>$isAclandUser,
            'header_info' => $mouja, 'khotian_no' => $khatianNumber, 'jl_number' => $moujaJL,'khotian'=>$khotian

        ];

        return \json_decode(\json_encode($data), true);
    }


}


