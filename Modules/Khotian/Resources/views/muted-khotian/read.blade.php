@extends('master::layouts.master')
@php
    $title =  __('আবেদনের বিস্তারিত');
    $designations = \Modules\Khotian\App\Models\MutedKhotian::SIGNATURE_DESIGNATION;
    $isAclandUser = $batch_khotians[0]['isAclandUser'];
    use Illuminate\Support\Facades\File;
@endphp
@section('title', $title)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">
                            <i class="voyager-bookmark"></i> {{ __('খতিয়ানের বিস্তারিত') }}
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-info pull-right" type="button" onclick="print_rpt()" href="#">
                                প্রিন্ট <i class="fa fa-print"></i>
                            </button>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">

                        @if (!$isAclandUser)
                            <div class="container" style="background: #fff;">
                                <div style="text-align: center;clear: both;position: relative;margin: 22px 0px;">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="PrintArea" style="margin-left: 36px">
                                            <?php
                                            $breakingAt = 30;
                                            $lineBreak[0] = '';
                                            $lineBreak[1] = '<br>';
                                            $lineBreak[2] = '<br><br>';
                                            $lineBreak[3] = '<br><br><br>';
                                            $lineBreak[4] = '<br><br><br><br>';
                                            $lineBreak[5] = '<br><br><br><br><br>';
                                            $lineBreak[6] = '<br><br><br><br><br><br>';
                                            $lineBreak[7] = '<br><br><br><br><br><br><br>';
                                            $lineBreak[8] = '<br><br><br><br><br><br><br><br>';
                                            $lineBreak[9] = '<br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[10] = '<br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[11] = '<br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[12] = '<br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[13] = '<br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[14] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[15] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[16] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[17] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[18] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[19] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[20] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[21] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[22] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[23] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[24] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[25] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[26] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[27] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[28] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[29] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[30] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[31] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[32] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[33] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[34] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[35] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[36] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[37] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[38] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[39] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                            $lineBreak[40] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

                                            $per_page_line_number = 22;

                                            $border_right = ' border-right:1px solid; ';
                                            $border_bottom = ' border-bottom:1px solid;';
                                            $border_top = ' border-top:1px solid;';
                                            $border_left = ' border-left:1px solid;';

                                            if (isset($print_type) && !empty($print_type) && $print_type == 1) {
                                                $border_right = ' border-right:none!important;';
                                                $border_bottom = ' border-bottom:none!important;';
                                                $border_top = ' border-bottom:none!important;';
                                                $border_left = ' border-left: none!important;';
                                            }
                                            function getLines($text, $char = 20)
                                            {
                                                $newtext = mb_wordwrap($text, $char, "<br>");
                                                $arr = explode("<br>", $newtext);
                                                return count($arr);
                                            }

                                            function mb_wordwrap($str, $width = 75, $break = "<br>", $cut = true)
                                            {
                                                $lines = explode($break, $str);
                                                foreach ($lines as &$line) {
                                                    if (mb_strlen($line) <= $width)
                                                        continue;
                                                    $words = explode(' ', $line);
                                                    $line = '';
                                                    $actual = '';
                                                    foreach ($words as $word) {
                                                        if (mb_strlen($actual . $word) <= $width)
                                                            $actual .= $word . ' ';
                                                        else {
                                                            if ($actual != '')
                                                                $line .= rtrim($actual) . $break;
                                                            $actual = $word;
                                                            if ($cut) {
                                                                while (mb_strlen($actual) > $width) {
                                                                    $line .= mb_substr($actual, 0, $width) . $break;
                                                                    $actual = mb_substr($actual, $width);
                                                                }
                                                            }
                                                            $actual .= ' ';
                                                        }
                                                    }
                                                    $line .= trim($actual);
                                                }
                                                return implode($break, $lines);
                                            }

                                            function pageSeparate($string, $separator, $perpage)
                                            {
                                                $remove_string_last_separator = rtrim($string, $separator);
                                                $string_lines_array = explode($separator, $remove_string_last_separator);
                                                return array_chunk($string_lines_array, $perpage);
                                            }

                                            function pageSeparateOnNl($string, $separator, $perpage)
                                            {
                                                $remove_string_last_separator = rtrim($string, $separator);
                                                $string_lines_array = explode('<br>', $remove_string_last_separator);
                                                $datas = array_chunk($string_lines_array, $perpage);
                                                $output = [];
                                                foreach ($datas as $key => $data) {
                                                    $output[$key] = implode('<br>', $data);
                                                }
                                                return $output;
                                            }
                                            function margePage(&$overAllPages, $landownerLineArr, $pageNumber)
                                            {
                                                foreach ($landownerLineArr as $ownerBlockLine) {
                                                    $overAllPages[$pageNumber][] = $ownerBlockLine;
                                                }
                                            }
                                            ?>

                                            <?php
                                            foreach($batch_khotians as $rootPage => $aKhotian){
                                            $jl_number = '';
                                            $dcr_number = '';
                                            $resa_no = '';
                                            $owners = "";
                                            $khotian = "";
                                            $header_info = "";
                                            $khotian_no = "";
                                            $pages_number_array = array();

                                            $owners = $aKhotian['owners'];
                                            $khotian = $aKhotian['khotian'];
                                            $header_info = $aKhotian['header_info'];
                                            $khotian_no = $aKhotian['khotian_no'];

                                            // Arrange the data of owners
                                            $totalEkor = null;
                                            $ownerAngsho = [];
                                            $totalEkorLocal = null;
                                            $pageAngsho = 0;
                                            $total_ongsho = 0;
                                            $owner_data = '';
                                            $owner_ongsho = '';
                                            $address_line_num = 0;
                                            $pre_parent_name = false;
                                            $pre_address_only = false;
                                            $pre_owner_address = false;
                                            $pre_owner_address_holder = false;
                                            $pre_owner_address_break = [];
                                            $pre_owner_data = [];
                                            $mokadoma_no = '';
                                            $dhara_no = '';
                                            $dhara_son = '';
                                            $ownerRowId = 0;
                                            $tmp = '';
                                            foreach ($owners as $key => &$singleOwner) {
                                                $tmpAddress = $singleOwner['owner_address'];
                                                $tmpName = $singleOwner['owner_name'];

                                                $tmpAddress = preg_replace("#<br\s?/?>#", "<br>", $tmpAddress);
                                                $tmpName = preg_replace("#<br\s?/?>#", "<br>", $tmpName);

                                                $tmpAddress = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $tmpAddress);
                                                $tmpName = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $tmpName);

                                                $tmpName = mb_wordwrap($tmpName, 34, '<br>', false);
                                                $tmpAddress = mb_wordwrap($tmpAddress, 34, '<br>', false);
                                                $tmpAddressLine = getLines($tmpAddress, 34, '<br>', false);
                                                $tmp = $tmpAddress;
                                                $singleOwner['address_line_num'] = $tmpAddressLine;
                                                $singleOwner['owner_address'] = $tmpAddress;
                                                $singleOwner['owner_name'] = $tmpName;

                                                $tmpParentData = explode('<br>', $tmpAddress);
                                                $singleOwner['parent_name'] = $tmpParentData[0];
                                                unset($tmpParentData[0]);

                                                $addressTMP = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', implode('<br>', $tmpParentData));
                                                $addressTMP = preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $addressTMP); // remove leading multiple br
                                                $singleOwner['address_only'] = $addressTMP;
                                            }

                                            $hasLine = [];
                                            $ownerPageArr = [];
                                            $lastOwnerAddress = null;
                                            foreach ($owners as $key => $owner) {
                                                //$ownerCountLine = getLines($owner['owner_name'], 30, '<br>', false);
                                                $ownerCountLine = getLines($owner['owner_name'], 34, '<br>', false);
                                                $address_entry = false;
                                                $angshoBreak = 1;

                                                if (empty($ownerRowId) && !empty($owner['id'])) {
                                                    $ownerRowId = $owner['id'];
                                                }

                                                if ($pre_address_only !== false) {
                                                    if ($pre_parent_name != $owner['parent_name']) {
                                                        if ($pre_address_only != $owner['address_only']) {
                                                            $owner_data .= '<br>' . $pre_parent_name;
                                                            $owner_data .= '<br>' . $pre_address_only;
                                                            $isPrintedHr = false;
                                                            if (!empty($pre_owner_data['owner_group_id']) && $pre_owner_data['owner_group_id'] != $owner['owner_group_id'] && !in_array($pre_owner_data['owner_group_id'], $hasLine)) {
                                                                $hasLine[] = $pre_owner_data['owner_group_id'];
                                                                $isPrintedHr = true;
                                                                $owner_data .= '<hr class="hr"/>';
                                                                //$owner_data .= '<span style="margin: 0px; padding: 0px; border-top: 1px solid #323232; width: 97%;"></span>';
                                                            }

                                                            $owner_data .= '<br>' . $owner['owner_name'];
                                                            $angshoBreak = getLines($pre_parent_name, 34, '<br>', false) + getLines($pre_address_only, 34, '<br>', false);
                                                            $pre_owner_data = $owner;
                                                            $pre_address_only = $owner['address_only'];
                                                            $pre_parent_name = $owner['parent_name'];
                                                            $address_entry = true;
                                                        } else {
                                                            $owner_data .= '<br>' . $pre_parent_name;
                                                            $owner_data .= '<br>' . $owner['owner_name'];
                                                            $angshoBreak = getLines($pre_parent_name, 34, '<br>', false);
                                                            $pre_parent_name = $owner['parent_name'];
                                                            $address_entry = true;

                                                        }
                                                    } else {
                                                        $owner_data .= '<br>' . $owner['owner_name'];
                                                        $lastOwnerAddress = $owner['address_only'];
                                                    }
                                                } else {
                                                    $pre_address_only = $owner['address_only'];
                                                    $pre_parent_name = $owner['parent_name'];
                                                    $owner_data .= $owner['owner_name'];
                                                    $pre_owner_address_holder = '';
                                                    $pre_owner_data = $owner;
                                                }
                                                if (empty($mokadoma_no) && !empty($owner['mokadoma_no'])) {
                                                    $mokadoma_no = $owner['mokadoma_no'];
                                                }
                                                if (empty($dhara_no) && !empty($owner['dhara_no'])) {
                                                    $dhara_no = $owner['dhara_no'];
                                                }
                                                if (empty($dhara_son) && !empty($owner['dhara_son'])) {
                                                    $dhara_son = $owner['dhara_son'];
                                                }
                                                if ($owner['owner_area'] == '1') {
                                                    $owner_area = '১.০০০';
                                                } else {
                                                    $owner_area = explode('.', $owner['owner_area']);
                                                    if (isset($owner_area[1]) && strlen($owner_area[1]) == 1)
                                                        $owner_area = $owner['owner_area'] . '০০';
                                                    elseif (isset($owner_area[1]) && strlen($owner_area[1]) == 2)
                                                        $owner_area = $owner['owner_area'] . '০';
                                                    elseif (isset($owner_area[1]) && strlen($owner_area[1]) == 3)
                                                        $owner_area = $owner['owner_area'];
                                                    else
                                                        $owner_area = $owner['owner_area'];
                                                }

                                                if ($address_entry && isset($angshoBreak)) {
                                                    $owner_ongsho .= $lineBreak[$angshoBreak] . '<span class="paddTwo">' . $owner_area . '</span>' . '<br>' . $lineBreak[($ownerCountLine - 1)];
                                                } else {
                                                    $owner_ongsho .= $owner_area . $lineBreak[($ownerCountLine - 1)] . '<br>';
                                                }

                                                $total_ongsho = $total_ongsho + $owner['owner_area'];
                                            }

                                            if ($pre_address_only !== false && empty($pre_address_only)) {
                                                $pre_address_only = $lastOwnerAddress;
                                            }
                                            if ($pre_address_only !== false || !empty($pre_parent_name)) {
                                                $owner_data .= '<br>' . $pre_parent_name;
                                                $string = preg_replace('#(( ){0,}<br( {0,})(/{0,1})>){1,}$#i', '', $owner_data);
                                                $owner_data = $string . '<br>' . preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $pre_address_only); // remove leading multiple br
                                            }

                                            $jl_number = '';
                                            $dcr_number = '';
                                            $resa_no = '';
                                            $case_no = '';
                                            $dag_no = '';
                                            $krishi = '';
                                            $non_krishi = '';
                                            $total_dag_area_ekor = '';
                                            $total_dag_area_shotangso = '';
                                            $khotian_dag_portion = '';
                                            $total_dag_portion_ekor = '';
                                            $total_dag_portion_shotangso = '';
                                            $remarks = '';
                                            $total_khotian_dag_portion = 0;
                                            $isSpecial = empty($khotian[0]['brs_khotian_entries']['is_special']) ? '' : $khotian[0]['brs_khotian_entries']['is_special'];
                                            $computerCode = empty($khotian[0]['brs_khotian_entries']['computer_code']) ? '' : $khotian[0]['brs_khotian_entries']['computer_code'];
                                            $dagsAreaByRows = null;

                                            foreach ($khotian as $rowCnt => $row) {
                                                $krishiLines = 0;
                                                $okrishiLines = 0;
                                                $dagParts = explode('/', $row['dag_number']);
                                                $case_no = empty($row['namjari_case_no']) ? '' : $row['namjari_case_no'];
                                                $resa_no = empty($row['resa_no']) ? '' : $row['resa_no'];
                                                $dcr_number = empty($row['dcr_number']) ? '' : $row['dcr_number'];
                                                $jl_number = empty($row['jl_number']) ? '' : $row['jl_number'];
                                                if (!empty($dagParts[1])) {
                                                    $partOne = '<span class="dagUnderline">' . substr(trim($dagParts[1]), 0, 5) . '</span><br>';
                                                    $partTwo = substr(trim($dagParts[0]), 0, 5) . '<br>';

                                                    $dag_no .= $partOne . $partTwo;
                                                    $dagLine = 2; //wordwrap($row['dag_number'], 5, "<br>", true);
                                                } else {
                                                    $dag_no .= substr(trim($row['dag_number']), 0, 5) . '<br>';
                                                    $dagLine = 1;
                                                }
                                                if ($row['agricultural_use'] == 0 || $row['agricultural_use'] == '') {
                                                    $krishi .= '<br>';
                                                    $non_krishi .= mb_wordwrap($row['lt_name'], 13) . '<br>';
                                                    $okrishiLines = getLines($row['lt_name'], 13);
                                                } else {
                                                    $krishi .= mb_wordwrap($row['lt_name'], 13) . '<br>';
                                                    $non_krishi .= '<br>';
                                                    $krishiLines = getLines($row['lt_name'], 13);
                                                }
                                                $dag_area = explode('.', $row['total_dag_area']);
                                                if ($row['khotian_dag_portion'] != 1) {
                                                    $total_dag_area_ekor .= ($dag_area[0] > 0 ? $dag_area[0] : '') . '<br>'; // if 0 show empty
                                                    if (isset($dag_area[1])) {
                                                        if (strlen($dag_area[1]) == 1) {
                                                            $total_dag_area_shotangso .= $dag_area[1] . '০০০' . '<br>';
                                                        } elseif (strlen($dag_area[1]) == 2) {
                                                            $total_dag_area_shotangso .= $dag_area[1] . '০০' . '<br>';
                                                        } elseif (strlen($dag_area[1]) == 3) {
                                                            $total_dag_area_shotangso .= $dag_area[1] . '০' . '<br>';
                                                        } else {
                                                            $total_dag_area_shotangso .= $dag_area[1] . '<br>';
                                                        }
                                                    } else {
                                                        if (!empty($dag_area[0])) {
                                                            $total_dag_area_shotangso .= '0000<br>';
                                                        }
                                                    }
                                                } else {
                                                    $total_dag_area_ekor .= '<br>';
                                                    $total_dag_area_shotangso .= '<br>';
                                                }
                                                if ($row['khotian_dag_portion'] == '1') {
                                                    $khotian_dag_portion .= '<span class="oneOne">1.000</span>' . '<br>';
                                                } else {
                                                    $khotian_dag_portion_arr = explode('.', $row['khotian_dag_portion']);
                                                    if (isset($khotian_dag_portion_arr[1]) && strlen($khotian_dag_portion_arr[1]) == 1)
                                                        $khotian_dag_portion .= $row['khotian_dag_portion'] . '00' . '<br>';
                                                    elseif (isset($khotian_dag_portion_arr[1]) && strlen($khotian_dag_portion_arr[1]) == 2)
                                                        $khotian_dag_portion .= $row['khotian_dag_portion'] . '0' . '<br>';
                                                    else
                                                        $khotian_dag_portion .= $row['khotian_dag_portion'] . '<br>';
                                                }
                                                $dag_portion = explode('.', $row['khotian_dag_area']);
                                                $dagsAreaByRows .= $row['khotian_dag_area'] . '<br>';
                                                $total_dag_portion_ekor .= ($dag_portion[0] > 0 ? $dag_portion[0] : '') . '<br>'; // if 0 show empty
                                                if (isset($dag_portion[1])) {
                                                    if (strlen($dag_portion[1]) == 1) {
                                                        $total_dag_portion_shotangso .= $dag_portion[1] . '০০০' . '<br>';
                                                    } elseif (strlen($dag_portion[1]) == 2) {
                                                        $total_dag_portion_shotangso .= $dag_portion[1] . '০০' . '<br>';
                                                    } elseif (strlen($dag_portion[1]) == 3) {
                                                        $total_dag_portion_shotangso .= $dag_portion[1] . '০' . '<br>';
                                                    } else {
                                                        $total_dag_portion_shotangso .= $dag_portion[1] . '<br>';
                                                    }
                                                } else {
                                                    $total_dag_portion_shotangso .= '0000<br>';
                                                }
                                                $remarkTextWithoutLatBr = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $row['remarks']);
                                                $tmpTxt = preg_replace("#<br\s?/?>#", "<br>", $remarkTextWithoutLatBr);
                                                $remarkTxt = mb_wordwrap($tmpTxt, 28, "<br>");
                                                $remarks .= $remarkTxt . '<br>';
                                                $remarkSize = getLines($remarkTxt, 28);
                                                $size = $remarkSize > $okrishiLines ? $remarkSize : $okrishiLines;
                                                $size = $size > $krishiLines ? $size : $krishiLines;
                                                $size = $size > $dagLine ? $size : $dagLine;
                                                $total_khotian_dag_portion += $row['khotian_dag_area'];

                                                if ($size > 1) {
                                                    if ($remarkSize < $size) {
                                                        $remarks .= $lineBreak[$size - $remarkSize];
                                                    }
                                                    $dagLineAppendNumber = $size - $dagLine;
                                                    $dag_no .= $lineBreak[$dagLineAppendNumber];
                                                    $krishi .= $lineBreak[$size - ($krishiLines > 0 ? $krishiLines : 1)];
                                                    $non_krishi .= $lineBreak[$size - ($okrishiLines > 0 ? $okrishiLines : 1)];
                                                    $total_dag_area_shotangso .= $lineBreak[$size - 1];
                                                    $total_dag_area_ekor .= $lineBreak[$size - 1];
                                                    $total_dag_portion_ekor .= $lineBreak[$size - 1];
                                                    $khotian_dag_portion .= $lineBreak[$size - 1];
                                                    $total_dag_portion_shotangso .= $lineBreak[$size - 1];
                                                    $dagsAreaByRows .= $lineBreak[$size - 1];
                                                }
                                            }

                                            $total_khotian_dag_portion = explode('.', $total_khotian_dag_portion);
                                            $owner_data = str_replace('<br/>', '<br>', $owner_data);
                                            $owner_data_by_land_owner = explode('<end/>', $owner_data);
                                            $remove_string_last_separator = rtrim($owner_ongsho, '<br>');
                                            $owner_ongsho_pages = explode('<br>', $remove_string_last_separator);
                                            $ownerAngsho = [];
                                            $pageAngsho = 0;
                                            $ownerAngshoTrackerKey = 0;
                                            $overAllPages = [];
                                            $currentPage = 0;
                                            foreach ($owner_data_by_land_owner as $LKey => $landowner) {
                                                $landowner = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $landowner);
                                                $landownerLineArr = explode('<br>', $landowner);
                                                $currentPageSize = count($landownerLineArr);
                                                if (empty($overAllPages[$currentPage])) {
                                                    if ($currentPageSize > $per_page_line_number) {
                                                        $tmpKey = 1;
                                                        foreach ($landownerLineArr as $key => $item) {
                                                            $overAllPages[$currentPage][] = $item;
                                                            $ownerAngsho[] = empty($owner_ongsho_pages[$ownerAngshoTrackerKey]) ? '' : $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                            $ownerAngshoTrackerKey++;
                                                            if (($tmpKey % ($per_page_line_number) == 0)) {
                                                                $currentPage++;
                                                            }
                                                            $tmpKey++;
                                                        }
                                                    } else {
                                                        $overAllPages[$currentPage] = $landownerLineArr;
                                                        for ($ownerAngshoTrackerKey; $ownerAngshoTrackerKey < $currentPageSize; $ownerAngshoTrackerKey++) {
                                                            $ownerAngsho[] = empty($owner_ongsho_pages[$ownerAngshoTrackerKey]) ? '' : $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                        }
                                                    }

                                                } else {
                                                    $currentPageSize = count($overAllPages[$currentPage]);
                                                    $newOwnerBlockSize = count($landownerLineArr);
                                                    $totalElements = $currentPageSize + $newOwnerBlockSize;
                                                    if ($totalElements > $per_page_line_number) {
                                                        for ($currentPageSize; $currentPageSize < $per_page_line_number; $currentPageSize++) {
                                                            $overAllPages[$currentPage][] = '<br>';
                                                            $ownerAngsho[] = '<br>';
                                                        }
                                                        $currentPage++;
                                                        foreach ($landownerLineArr as $tmpKey => $ownerBlockLine) {
                                                            $overAllPages[$currentPage][] = $ownerBlockLine;
                                                            $ownerAngsho[] = $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                            $ownerAngshoTrackerKey++;
                                                        }
                                                    } else {
                                                        foreach ($landownerLineArr as $tmpKey => $ownerBlockLine) {
                                                            $overAllPages[$currentPage][] = $ownerBlockLine;
                                                            $ownerAngsho[] = $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                            $ownerAngshoTrackerKey++;
                                                        }
                                                    }
                                                }
                                            }
                                            $owner_data_pages = $overAllPages;
                                            array_push($pages_number_array, count($owner_data_pages));
                                            $owner_ongsho_pages = array_chunk($ownerAngsho, $per_page_line_number);
                                            array_push($pages_number_array, count($owner_ongsho_pages));
                                            $secondPartExtraLine = 1;
                                            $dag_no_pages = pageSeparateOnNl($dag_no, '<br>', $per_page_line_number + $secondPartExtraLine);
                                            array_push($pages_number_array, count($dag_no_pages));
                                            $krishi_pages = pageSeparateOnNl($krishi, '<br>', $per_page_line_number + $secondPartExtraLine);
                                            array_push($pages_number_array, count($krishi_pages));
                                            $non_krishi_pages = pageSeparateOnNl($non_krishi, '<br>', $per_page_line_number + $secondPartExtraLine);
                                            array_push($pages_number_array, count($non_krishi_pages));
                                            $total_dag_area_ekor_pages = pageSeparateOnNl($total_dag_area_ekor, '<br>', $per_page_line_number + $secondPartExtraLine);
                                            array_push($pages_number_array, count($total_dag_area_ekor_pages));
                                            $total_dag_area_shotangso_pages = pageSeparateOnNl($total_dag_area_shotangso, '<br>', $per_page_line_number + $secondPartExtraLine);
                                            array_push($pages_number_array, count($total_dag_area_shotangso_pages));
                                            $khotian_dag_portion_pages = pageSeparateOnNl($khotian_dag_portion, '<br>', $per_page_line_number + $secondPartExtraLine);
                                            array_push($pages_number_array, count($khotian_dag_portion_pages));
                                            $total_dag_portion_ekor_pages = pageSeparateOnNl($total_dag_portion_ekor, '<br>', $per_page_line_number + $secondPartExtraLine);
                                            array_push($pages_number_array, count($total_dag_portion_ekor_pages));
                                            $total_dag_portion_shotangso_pages = pageSeparateOnNl($total_dag_portion_shotangso, '<br>', $per_page_line_number + $secondPartExtraLine);
                                            array_push($pages_number_array, count($total_dag_portion_shotangso_pages));
                                            $remarks_pages = pageSeparate($remarks, '<br>', $per_page_line_number + $secondPartExtraLine);
                                            array_push($pages_number_array, count($remarks_pages));
                                            $dagsAreaByRowsPages = pageSeparate($dagsAreaByRows, '<br>', $per_page_line_number + $secondPartExtraLine);
                                            array_push($pages_number_array, count($dagsAreaByRowsPages));
                                            $countOfLoop = max($pages_number_array);
                                            if(isset($owners) && isset($khotian)){
                                            for ($i = 0; $i < $countOfLoop; $i++) { ?>
                                            <?php
                                            if (isset($dagsAreaByRowsPages[$i])) {
                                                foreach ($dagsAreaByRowsPages[$i] as $ekor) {
                                                    if (is_numeric($ekor)) {
                                                        $totalEkor += $ekor;
                                                    }
                                                }
                                            }
                                            $totalEkorLocal = explode('.', $totalEkor);
                                            if (isset($owner_ongsho_pages[$i])) {
                                                foreach ($owner_ongsho_pages[$i] as $angshoFragment) {
                                                    $angshoFragment = bn2en($angshoFragment);
                                                    $angshoFragmentNumber = filter_var($angshoFragment, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                                                    if (is_numeric($angshoFragmentNumber)) {
                                                        $pageAngsho += $angshoFragmentNumber;
                                                    }
                                                }
                                            }

                                            $computerCodeLatest = '';
                                            $timeObj = \Illuminate\Support\Carbon::now();
                                            $timeObj->modify('+14 minutes');
                                            $datePartOne = $timeObj->format('md'); // month and day
                                            $datePartTwo = $timeObj->format('Y');
                                            $time = $timeObj->format('His');
                                            $randomNumber = rand(10, 99);
                                            $gel = substr($header_info['dglr_code'], -3);
                                            if (empty($gel)) {
                                                $gel = '000';
                                            } elseif (strlen($gel) == 1) {
                                                $gel = '00' . $gel;
                                            } elseif (strlen($gel) == 2) {
                                                $gel = '0' . $gel;
                                            }

                                            $computerCodeLatest = $randomNumber . $datePartOne . $userCode . $time . $gel . $formatedIpPartOne . '-' . $ownerRowId . $datePartTwo . $formatedIpPartTwo;
                                            ?>

                                            <div style="position: relative">
                                                <?php if(!empty($application->status) && $application->status == 2){ ?>
                                                <div
                                                    style='width: 80%; position: absolute; top: 300px; left: 10%; color: #00000030; font-size: 3em; display: block; font-weight: bolder; '>
                                                    <div style='position: relative'><span
                                                            style='float: left'>সরকারি ব্যবহারের জন্য</span><span
                                                            style='float: right'>সরকারি ব্যবহারের জন্য</span></div>
                                                </div>
                                                <?php } ?>
                                                <table class="htable" border="0" style="margin-top: 2px;">
                                                    <tr>
                                                        <td colspan="4" align="left" style="border:1px">বাংলাদেশ ফর্ম নং ৫৪৬২ (সংশোধিত)&nbsp;
                                                        </td>
                                                        <td colspan="6" align="center" style="border:1px;">
                                                            <h2 style="padding-bottom: 0px; margin-top: 15px; margin-left: -85px; font-size: 29px;">
                                                                খতিয়ান নং- <span
                                                                    class=""><?php echo eng_to_bangla_code($record->khotian_number); ?></span>
                                                            </h2>
                                                        </td>
                                                        <td colspan="4"
                                                            style="font-size: 15px; border:0px;text-align: right;padding-right: 6px;vertical-align: middle;"
                                                            class="nikosh">

                                                            <?= __('নামজারি মামলা  <span style="font-size: 15px;">নংঃ</span> ' . $case_no)?>
                                                            <p style="font-size: 15px;padding-left: 20px"> <?= __('ডি সি আর   <span style="font-size: 15px;">নংঃ</span> ' . eng_to_bangla_code($dcr_number) ?? '')?>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="border:1px; font-size: 16px; padding-bottom: 15px;">
                                                            বিভাগঃ <?php echo $header_info['name_bn'] ?? $header_info['division_name'];  ?></td>
                                                        <td colspan="2" style="border:1px;  font-size: 16px; padding-bottom: 15px;">
                                                            জেলাঃ <?php echo $header_info['district_name']; ?></td>
                                                        <td colspan="3"
                                                            style="border:1px;  font-size: 16px; padding-bottom: 15px; max-width: 120px;">
                                                            উপজেলা/থানাঃ <?php echo $header_info['upazila_name']; ?></td>
                                                        <td colspan="3"
                                                            style="border:1px;  font-size: 16px; padding-bottom: 15px; min-width: 170px;">
                                                            মৌজাঃ <?php echo $header_info['name_bd']; ?></td>
                                                        <td colspan="2" style="border:1px; padding-bottom: 15px;  font-size: 16px;">জে, এল,
                                                            নংঃ <?php echo eng_to_bangla_code($jl_number); ?></td>
                                                        <td colspan="2" style="border:0px;  font-size: 15px; padding-bottom: 15px;">রেঃ সাঃ
                                                            নংঃ <?= !empty($resa_no) ? eng_to_bangla_code($resa_no) : '&nbsp;' ?> </td>
                                                    </tr>
                                                </table>
                                                <table class="table" border="0" cellpadding="0" cellspacing="0" class="pp"
                                                       id="table_<?= $i ?>"
                                                       style="vertical-align:top; height: 17cm; margin-bottom: 0px;">
                                                    <thead>
                                                    <tr bgcolor="#EFF2F7" style="vertical-align:top;">
                                                        <td colspan="1"
                                                            style="width: 232px; text-align: center;vertical-align:middle;border-left:1px solid;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                            মালিক, অকৃষি প্রজা বা ইজারাদারের<br>
                                                            নাম ও ঠিকানা<br></td>
                                                        <td colspan="1"
                                                            style="width: 49px; text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                            অংশ
                                                            &nbsp;
                                                        </td>
                                                        <td colspan="1"
                                                            style="width: 80px; text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                            রাজস্ব<br></td>
                                                        <td colspan="1"
                                                            style="width: 46px;text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                            দাগ নং<br></td>
                                                        <td colspan="2" rowspan="1"
                                                            style="text-align: center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                                                            width="98px">
                                                            জমির শ্রেণী
                                                        </td>
                                                        <td colspan="2" rowspan="1"
                                                            style="text-align:center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                                                            width="87px">
                                                            দাগের মোট পরিমাণ
                                                        </td>
                                                        <td colspan="1"
                                                            style="width: 150px;font-size:11px; text-align: center; vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                            দাগের মধ্যে
                                                            অত্র <br>খতিয়ানের অংশ
                                                        </td>
                                                        <td colspan="2" rowspan="1"
                                                            style="font-size: 11px; text-align:center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                                                            width="87px">
                                                            অংশানুযায়ী জমির<br>
                                                            পরিমাণ
                                                        </td>
                                                        <td colspan="1"
                                                            style="width: 172px;text-align: center; vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                            দখল বিষয়ক বা অন্যান্য<br>
                                                            বিশেষ মন্তব্য<br></td>
                                                    </tr>
                                                    <tr bgcolor="#b0c4de">
                                                        <td colspan="1" rowspan="2"
                                                            style="width: 212px;text-align: center;vertical-align:middle;border-top:1px solid;border-right:1px solid;border-left:1px solid;  border-bottom: 1px solid">
                                                            &nbsp;১
                                                        </td>
                                                        <td colspan="1" rowspan="2"
                                                            style="width: 49px;text-align: center;  vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                            ২
                                                        </td>
                                                        <td colspan="1" rowspan="2"
                                                            style="width: 38px;text-align: center;  vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                            ৩
                                                        </td>
                                                        <td colspan="1" rowspan="2"
                                                            style="width: 77px;text-align: center;  vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                            ৪
                                                        </td>
                                                        <td style="width: 41.57px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;"
                                                        >
                                                            কৃষি<br></td>
                                                        <td style="width: 45.35px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                            অকৃষি<br></td>
                                                        <td
                                                            style="width: 41.57px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                            একর<br></td>
                                                        <td
                                                            style="width: 45.35px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                            শতাংশ<br></td>
                                                        <td colspan="1" rowspan="2"
                                                            style="width: 70px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                            ৭
                                                        </td>
                                                        <td
                                                            style="width: 41.57px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                            একর<br></td>
                                                        <td
                                                            style="width: 45.35px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                            শতাংশ<br></td>
                                                        <td colspan="1" rowspan="2"
                                                            style="width: 172px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                            ৯
                                                        </td>
                                                    </tr>
                                                    <tr bgcolor="#b0c4de" style="border: none">
                                                        <td width="45px"
                                                            style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">
                                                            ৫ (ক)
                                                        </td>
                                                        <td width="45px"
                                                            style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">
                                                            ৫(খ)
                                                        </td>
                                                        <td width="41.57px"
                                                            style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">
                                                            ৬ (ক)
                                                        </td>
                                                        <td width="45.35px"
                                                            style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">
                                                            ৬ (খ)
                                                        </td>
                                                        <td width="41.57px"
                                                            style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">
                                                            ৮ (ক)
                                                        </td>
                                                        <td width="45.35px"
                                                            style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">
                                                            ৮ (খ)
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="">
                                                    <tr class="custom-border">
                                                        <td style="width: 212px; border-top: none; text-align: left; <?= $border_left ?> <?= $border_right ?> padding-left:7px;"
                                                            valign="top">
                                                            <?php  if( $i == 0 && $khotian_no != 1 ): ?>
                                                            <p style="padding: 2px 0px 0px 0px;margin: 0px;">মালিক</p>
                                                            <?php endif; ?>
                                                            <?php  if( $i == 0 && $khotian_no == 1 ): ?>
                                                            <p style="padding: 2px 0px 0px 0px;margin: 0px;"><br></p>
                                                            <?php endif; ?>
                                                            <?php
                                                            if (isset($owner_data_pages[$i])) {
                                                                echo implode('<br>', $owner_data_pages[$i]);
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="border-top: none; text-align: left; padding-left: 4px;vertical-align:top;<?= $border_right ?>">
                                                            <?php  if( $i == 0): ?>
                                                            <p style="padding: 2px 0px 0px 0px;margin: 0px;">&nbsp;</p>
                                                            <?php endif; ?>
                                                            <?php
                                                            if (isset($owner_data_pages[$i])) {
                                                                echo eng_to_bangla_code(implode('<br>', $owner_ongsho_pages[$i]));
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>"> <?php

                                                            if ($i == 0 && isset($khotian[0]['revenue'])) {
                                                                echo '<br>' . eng_to_bangla_code($khotian[0]['revenue']) . '/-';
                                                            }
                                                            ?> </td>
                                                        <td style="padding-left: 4px; border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                            <?php
                                                            if (isset($dag_no_pages[$i])) {
                                                                echo eng_to_bangla_code($dag_no_pages[$i]);
                                                            }
                                                            ?>
                                                        </td>

                                                        <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>white-space: normal;">
                                                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                            <?php
                                                            if (isset($krishi_pages[$i])) {
                                                                echo $krishi_pages[$i];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="border-top: none; text-align: center;vertical-align:top; <?= $border_right ?> white-space: normal;">
                                                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                            <?php
                                                            if (isset($non_krishi_pages[$i])) {
                                                                echo $non_krishi_pages[$i];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                            <?php
                                                            if (isset($total_dag_area_ekor_pages[$i])) {
                                                                echo eng_to_bangla_code($total_dag_area_ekor_pages[$i]);
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                            <?php
                                                            if (isset($total_dag_area_shotangso_pages[$i])) {
                                                                echo eng_to_bangla_code($total_dag_area_shotangso_pages[$i]);
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                            <?php
                                                            if (isset($khotian_dag_portion_pages[$i])) {
                                                                echo eng_to_bangla_code($khotian_dag_portion_pages[$i]);
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                            <?php
                                                            if (isset($total_dag_portion_ekor_pages[$i])) {
                                                                echo eng_to_bangla_code($total_dag_portion_ekor_pages[$i]);
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                            <?php
                                                            if (isset($total_dag_portion_shotangso_pages[$i])) {
                                                                echo eng_to_bangla_code($total_dag_portion_shotangso_pages[$i]);
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="border-top: none; text-align: center;vertical-align:top;word-break:break-all; <?= $border_right ?>">
                                                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>

                                                            <pre style="
                                        text-align: center;
                                        border: none;
                                        padding: inherit;
                                        font-size: inherit;
                                        line-height: inherit;
                                        margin: 0px;
                                        color: inherit;
                                        background-color: inherit;
                                        border-radius: inherit;
                                        font-size: 13px;
                                        font-family:kalpurush;
                                    "><?php
                                                                if (isset($remarks_pages[$i])) {
                                                                    echo implode('<br>', $remarks_pages[$i]);
                                                                }
                                                                ?></pre>
                                                        </td>
                                                    </tr>


                                                    </tbody>
                                                    <tfoot>
                                                    <tr bgcolor="#CCCCCC" style="height: 1.2cm">
                                                        <td rowspan="1"
                                                            style="font-size:12px; <?= $border_left ?> <?= $border_right ?> <?= $border_top ?> padding-left:5px;border-bottom:1px solid; font-style: italic">
                                                            <?= !empty($khotian[0]['dhara_no']) ? eng_to_bangla_code($khotian[0]['dhara_no']) . ' ' : '..........' ?>
                                                            ধারামতে নোট বা পরিবর্তন
                                                            <b>মায় মোকদ্দমা
                                                                নং</b><?= !empty($khotian[0]['mokoddoma_no']) ? ' ' . eng_to_bangla_code($khotian[0]['mokoddoma_no']) . ' ' : '.........' ?>
                                                            এবং
                                                            <b>সন</b><?= !empty($khotian[0]['dhara_year']) ? ' ' . eng_to_bangla_code($khotian[0]['dhara_year']) : '.........' ?>
                                                        </td>
                                                        <td style="text-align:center;<?= $border_right ?> <?= $border_top ?> border-bottom:1px solid;"><?php
                                                            echo eng_to_bangla_code(number_format($pageAngsho, 3));
                                                            ?></td>
                                                        <td style="font-size: 15px; text-align: right;vertical-align:middle;<?= $border_right ?> <?= $border_top ?> border-bottom:1px solid;padding-right:5px;"
                                                            colspan="7">

                                                            <span style="float: right;"> মোট জমিঃ</span>
                                                        </td>
                                                        <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid; text-align: center;"
                                                            valign="top">
                                                            <?php
                                                            if (isset($totalEkorLocal[0])) {
                                                                echo eng_to_bangla_code($totalEkorLocal[0]);
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid; text-align: left;"
                                                            valign="top">
                                                            <?php
                                                            $totalEkorLocal[2] = '';
                                                            if (isset($totalEkorLocal[1])) {
                                                                if (isset($totalEkorLocal[1]) && strlen($totalEkorLocal[1]) == 1) {
                                                                    $totalEkorLocal[2] .= $totalEkorLocal[1] . '000'; //added (arman)
                                                                    $totalEkorLocal[1] .= '০০০';
                                                                } elseif (isset($totalEkorLocal[1]) && strlen($totalEkorLocal[1]) == 2) {
                                                                    $totalEkorLocal[2] .= $totalEkorLocal[1] . '00'; //added (arman)
                                                                    $totalEkorLocal[1] .= '০০';
                                                                } elseif (isset($totalEkorLocal[1]) && strlen($totalEkorLocal[1]) == 3) {
                                                                    $totalEkorLocal[2] .= $totalEkorLocal[1] . '0'; //added (arman)
                                                                    $totalEkorLocal[1] .= '০';
                                                                }
                                                                echo eng_to_bangla_code($totalEkorLocal[1]);
                                                            } else {
                                                                echo eng_to_bangla_code('0000');
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid;">
                                                            <?php
                                                            $totalValue = isset($totalEkorLocal[0]) ? $totalEkorLocal[0] : '0';
                                                            $totalValue .= isset($totalEkorLocal[2]) ? '.' . $totalEkorLocal[2] : '0000';
                                                            echo 'কথায়:' . \App\Helpers\Classes\NumberToBanglaWord::numToWord(isset($totalEkor) ? (float)$totalEkor : 0) . 'একর মাত্র ।';
                                                            ?>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6"
                                                            style="text-align: right; vertical-align: middle"><?= !empty($computerCodeLatest) ? 'কম্পিউটার কোডঃ ' . eng_to_bangla_code($computerCodeLatest) : '&nbsp' ?></td>
                                                    </tr>
                                                    <tr style="border: none;">
                                                        <td colspan="6" style="border: none;">&nbsp;</td>
                                                    </tr>
                                                    @if(isset($application) && !empty($application->applicant_name))
                                                        <tr style="border: none; display: none;">
                                                            <td colspan="6" style="border: none;">আবেদনকারীর
                                                                নাম: {{$application->applicant_name}} |
                                                                আবেদন নং
                                                                - {{eng_to_bangla_code($application->application_display_code)}}</td>
                                                            <td colspan="6" style="border: none;">&nbsp;</td>
                                                        </tr>
                                                    @endif
                                                    </tfoot>
                                                </table>
                                                <tr>
                                                    <td style="font-family: nikoshBAN;">
                                                        <?php echo eng_to_bangla_code($khotian[0][
                                                        'signature_one_date']); ?> <br>
                                                        <?php echo
                                                            '(' . $khotian[0]['signature_one_name'] . ')'; ?> <br>
                                                        <?php echo !empty($designations[$khotian[0][
                                                        'signature_one_designation']]) ?
                                                            $designations[$khotian[0]['signature_one_designation']]:
                                                            $khotian[0]['signature_one_designation']; ?> <br>
                                                        <?php echo
                                                        'উপজেলা ভূমি অফিস'; ?> <br>
                                                        {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}

                                                    </td>
                                                    <td style="font-family: nikoshBAN;">
                                                        <?php echo eng_to_bangla_code($khotian[0][
                                                        'signature_two_date']); ?> <br>
                                                        <?php echo
                                                            '(' . $khotian[0]['signature_two_name'] . ')'; ?> <br>
                                                        <?php echo !empty($designations[$khotian[0][
                                                        'signature_two_designation']])?
                                                            $designations[$khotian[0]['signature_two_designation']]
                                                            :$khotian[0]['signature_two_designation']; ?> <br>
                                                        <?php echo
                                                        'উপজেলা ভূমি অফিস'; ?> <br>
                                                        {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}

                                                    </td>
                                                    <td style="font-family: nikoshBAN;">
                                                        <?php echo eng_to_bangla_code($khotian[0][
                                                        'signature_three_date']); ?> <br>
                                                        <?php echo
                                                            '(' . $khotian[0]['signature_three_name'] . ')'; ?> <br>
                                                        <?php echo !empty($designations[$khotian[0][
                                                        'signature_three_designation']])?
                                                            $designations[$khotian[0]['signature_three_designation']]
                                                            :$khotian[0]['signature_three_designation']; ?> <br>
                                                        <?php echo
                                                        'উপজেলা ভূমি অফিস'; ?> <br>
                                                        {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}

                                                    </td>
                                                </tr>
                                                </table> --}}
                                                @if ($isAclandUser)
                                                    <table class="d" style='width: 1090px; margin: 0 auto;text-align:center'>
                                                        <tr style='line-height:100px;'>
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদন যোগ্য</td>
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদন যোগ্য</td>
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">মঞ্জর</td>
                                                        </tr>

                                                        <tr>
                                                            <td style="font-family: nikoshBAN;">
                                                                <?php echo eng_to_bangla_code($khotian[0]['signature_one_date']); ?> <br>
                                                                <?php echo '(' . $khotian[0]['signature_one_name'] . ')'; ?> <br>
                                                                {{ !empty($designations[$khotian[0]['signature_one_designation']]) ? $designations[$khotian[0]['signature_one_designation']]: $khotian[0]['signature_one_designation'] }}
                                                                <br>
                                                                <?php echo 'উপজেলা ভূমি অফিস'; ?> <br>
                                                                {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}
                                                            </td>
                                                            <td style="font-family: nikoshBAN;">
                                                                <?php echo eng_to_bangla_code($khotian[0]['signature_two_date']); ?> <br>
                                                                <?php echo '(' . $khotian[0]['signature_two_name'] . ')'; ?> <br>
                                                                <?php echo !empty($designations[$khotian[0]['signature_two_designation']]) ? $designations[$khotian[0]['signature_two_designation']] : $khotian[0]['signature_two_designation']; ?>
                                                                <br>
                                                                <?php echo 'উপজেলা ভূমি অফিস'; ?> <br>
                                                                {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}
                                                            </td>
                                                            <td style="font-family: nikoshBAN;">
                                                                <?php echo eng_to_bangla_code($khotian[0]['signature_three_date']); ?> <br>
                                                                <?php echo '(' . $khotian[0]['signature_three_name'] . ')'; ?> <br>
                                                                <?php echo !empty($designations[$khotian[0]['signature_three_designation']]) ? $designations[$khotian[0]['signature_three_designation']] : $khotian[0]['signature_three_designation'] ?>
                                                                <br>
                                                                <?php echo 'উপজেলা ভূমি অফিস'; ?> <br>
                                                                {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}
                                                            </td>
                                                        </tr>
                                                        {{--<tr>
                                                            <td><img src="<?php echo '/storage/qr/'. $qr_code; ?>" style="margin-left:132% "
                                                                     width="140" height="140"/></td>
                                                        </tr>--}}
                                                    </table>
                                                @elseif (!$isAclandUser)
                                                    <table class="d" style='width: 1090px; margin:0 auto'>
                                                        <tr style='line-height:100px;text-align:center'>
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">নকলকারী</td>
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">যাচাইকারী</td>
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">তুলনাকারী</td>
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদনকারী</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" rowspan="3" style="vertical-align: middle;"><img
                                                                    src="<?php echo '/storage/qr/'. $qr_code; ?>" style="margin-left:40% "
                                                                    width="140" height="140"/></td>
                                                        </tr>
                                                    </table>
                                                @endif
                                            </div>
                                            @if ($i !== $countOfLoop)

                                                <div style="page-break-after: always;"></div>
                                            @endif

                                            <?php
                                            }
                                            }
                                            else
                                            {
                                            ?>
                                            <div class="alert alert-warning alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                <strong>Warning!</strong> Owner not Found.
                                            </div>

                                            <?php
                                            }
                                            }
                                            if($print_type == 1):
                                            ?>
                                            <style>
                                                .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th {
                                                    border-top: none;
                                                }
                                            </style>
                                            <?php
                                            endif;
                                            ?>
                                            <style>
                                                html, body, div {
                                                    font-family: kalpurush;
                                                }

                                                .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                                    padding: 2px;
                                                    vertical-align: middle;
                                                }

                                                .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                                    padding: 2px;
                                                }

                                                @page {
                                                    size: A4 landscape;
                                                    margin-left: 3.5cm;
                                                    margin-top: 1cm;
                                                    margin-bottom: 0px;
                                                }

                                                .oneOne {
                                                    padding-left: 1.5px;
                                                }

                                                .dagUnderline {
                                                    border-bottom: 1px solid;
                                                }

                                                .table > tbody > tr > td {
                                                    padding-top: 0px !important;
                                                }

                                                .paddTwo {
                                                    padding: 0px 0px 0px 0px;
                                                }

                                                hr {
                                                    margin: 0px;
                                                    padding: 0px 0px 2px 0px;
                                                    border-top: 1px solid #323232;
                                                    width: 97%;
                                                    display: inline-block;
                                                }

                                                hr:first-child {
                                                    margin-top: 2px !important;
                                                    padding-bottom: 0px !important;
                                                }

                                                /* TODO: added (arman) */
                                                .d {
                                                    table-layout: fixed;
                                                    width: 100%;
                                                }
                                            </style>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($isAclandUser)
                            <?php
                            $extension = '';
                            if ($record->scan_copy) {
                                $extension = pathinfo(asset("storage/" . $record->scan_copy), PATHINFO_EXTENSION);
                            }
                            ?>
                            @if ($extension === 'pdf')
                                <div class="container" style="background: #fff;">
                                    <div style="text-align: center;clear: both;position: relative;margin: 22px 0px;">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-lg-7">
                                            <div id="PrintArea" style="margin-left: 36px">
                                                <?php
                                                $breakingAt = 30;
                                                $lineBreak[0] = '';
                                                $lineBreak[1] = '<br>';
                                                $lineBreak[2] = '<br><br>';
                                                $lineBreak[3] = '<br><br><br>';
                                                $lineBreak[4] = '<br><br><br><br>';
                                                $lineBreak[5] = '<br><br><br><br><br>';
                                                $lineBreak[6] = '<br><br><br><br><br><br>';
                                                $lineBreak[7] = '<br><br><br><br><br><br><br>';
                                                $lineBreak[8] = '<br><br><br><br><br><br><br><br>';
                                                $lineBreak[9] = '<br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[10] = '<br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[11] = '<br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[12] = '<br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[13] = '<br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[14] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[15] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[16] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[17] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[18] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[19] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[20] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[21] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[22] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[23] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[24] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[25] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[26] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[27] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[28] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[29] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[30] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[31] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[32] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[33] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[34] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[35] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[36] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[37] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[38] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[39] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                $lineBreak[40] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

                                                $per_page_line_number = 22;

                                                $border_right = ' border-right:1px solid; ';
                                                $border_bottom = ' border-bottom:1px solid;';
                                                $border_top = ' border-top:1px solid;';
                                                $border_left = ' border-left:1px solid;';

                                                if (isset($print_type) && !empty($print_type) && $print_type == 1) {
                                                    $border_right = ' border-right:none!important;';
                                                    $border_bottom = ' border-bottom:none!important;';
                                                    $border_top = ' border-bottom:none!important;';
                                                    $border_left = ' border-left: none!important;';
                                                }
                                                function getLines($text, $char = 20)
                                                {
                                                    $newtext = mb_wordwrap($text, $char, "<br>");
                                                    $arr = explode("<br>", $newtext);
                                                    return count($arr);
                                                }

                                                function mb_wordwrap($str, $width = 75, $break = "<br>", $cut = true)
                                                {
                                                    $lines = explode($break, $str);
                                                    foreach ($lines as &$line) {
                                                        if (mb_strlen($line) <= $width)
                                                            continue;
                                                        $words = explode(' ', $line);
                                                        $line = '';
                                                        $actual = '';
                                                        foreach ($words as $word) {
                                                            if (mb_strlen($actual . $word) <= $width)
                                                                $actual .= $word . ' ';
                                                            else {
                                                                if ($actual != '')
                                                                    $line .= rtrim($actual) . $break;
                                                                $actual = $word;
                                                                if ($cut) {
                                                                    while (mb_strlen($actual) > $width) {
                                                                        $line .= mb_substr($actual, 0, $width) . $break;
                                                                        $actual = mb_substr($actual, $width);
                                                                    }
                                                                }
                                                                $actual .= ' ';
                                                            }
                                                        }
                                                        $line .= trim($actual);
                                                    }
                                                    return implode($break, $lines);
                                                }

                                                function pageSeparate($string, $separator, $perpage)
                                                {
                                                    $remove_string_last_separator = rtrim($string, $separator);
                                                    $string_lines_array = explode($separator, $remove_string_last_separator);
                                                    return array_chunk($string_lines_array, $perpage);
                                                }

                                                function pageSeparateOnNl($string, $separator, $perpage)
                                                {
                                                    $remove_string_last_separator = rtrim($string, $separator);
                                                    $string_lines_array = explode('<br>', $remove_string_last_separator);
                                                    $datas = array_chunk($string_lines_array, $perpage);
                                                    $output = [];
                                                    foreach ($datas as $key => $data) {
                                                        $output[$key] = implode('<br>', $data);
                                                    }
                                                    return $output;
                                                }
                                                function margePage(&$overAllPages, $landownerLineArr, $pageNumber)
                                                {
                                                    foreach ($landownerLineArr as $ownerBlockLine) {
                                                        $overAllPages[$pageNumber][] = $ownerBlockLine;
                                                    }
                                                }
                                                ?>
                                                <?php
                                                foreach($batch_khotians as $rootPage => $aKhotian){
                                                $jl_number = '';
                                                $dcr_number = '';
                                                $resa_no = '';
                                                $owners = "";
                                                $khotian = "";
                                                $header_info = "";
                                                $khotian_no = "";
                                                $pages_number_array = array();
                                                $owners = $aKhotian['owners'];
                                                $khotian = $aKhotian['khotian'];
                                                $header_info = $aKhotian['header_info'];
                                                $khotian_no = $aKhotian['khotian_no'];
                                                $totalEkor = null;
                                                $ownerAngsho = [];
                                                $totalEkorLocal = null;
                                                $pageAngsho = 0;
                                                $total_ongsho = 0;
                                                $owner_data = '';
                                                $owner_ongsho = '';
                                                $address_line_num = 0;
                                                $pre_parent_name = false;
                                                $pre_address_only = false;
                                                $pre_owner_address = false;
                                                $pre_owner_address_holder = false;
                                                $pre_owner_address_break = [];
                                                $pre_owner_data = [];
                                                $mokadoma_no = '';
                                                $dhara_no = '';
                                                $dhara_son = '';
                                                $ownerRowId = 0;
                                                $tmp = '';
                                                foreach ($owners as $key => &$singleOwner) {
                                                    $tmpAddress = $singleOwner['owner_address'];
                                                    $tmpName = $singleOwner['owner_name'];
                                                    $tmpAddress = preg_replace("#<br\s?/?>#", "<br>", $tmpAddress);
                                                    $tmpName = preg_replace("#<br\s?/?>#", "<br>", $tmpName);
                                                    $tmpAddress = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $tmpAddress);
                                                    $tmpName = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $tmpName);
                                                    $tmpName = mb_wordwrap($tmpName, 34, '<br>', false);
                                                    $tmpAddress = mb_wordwrap($tmpAddress, 34, '<br>', false);
                                                    $tmpAddressLine = getLines($tmpAddress, 34, '<br>', false);
                                                    $tmp = $tmpAddress;
                                                    $singleOwner['address_line_num'] = $tmpAddressLine;
                                                    $singleOwner['owner_address'] = $tmpAddress;
                                                    $singleOwner['owner_name'] = $tmpName;
                                                    $tmpParentData = explode('<br>', $tmpAddress);
                                                    $singleOwner['parent_name'] = $tmpParentData[0];
                                                    unset($tmpParentData[0]);
                                                    $addressTMP = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', implode('<br>', $tmpParentData));
                                                    $addressTMP = preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $addressTMP); // remove leading multiple br
                                                    $singleOwner['address_only'] = $addressTMP;
                                                }
                                                $hasLine = [];
                                                $ownerPageArr = [];
                                                $lastOwnerAddress = null;
                                                foreach ($owners as $key => $owner) {
                                                    //$ownerCountLine = getLines($owner['owner_name'], 30, '<br>', false);
                                                    $ownerCountLine = getLines($owner['owner_name'], 34, '<br>', false);
                                                    $address_entry = false;
                                                    $angshoBreak = 1;
                                                    if (empty($ownerRowId) && !empty($owner['id'])) {
                                                        $ownerRowId = $owner['id'];
                                                    }

                                                    if ($pre_address_only !== false) {
                                                        if ($pre_parent_name != $owner['parent_name']) {
                                                            if ($pre_address_only != $owner['address_only']) {
                                                                // print full parent and address
                                                                $owner_data .= '<br>' . $pre_parent_name;
                                                                $owner_data .= '<br>' . $pre_address_only;
                                                                $isPrintedHr = false;
                                                                if (!empty($pre_owner_data['owner_group_id']) && $pre_owner_data['owner_group_id'] != $owner['owner_group_id'] && !in_array($pre_owner_data['owner_group_id'], $hasLine)) {
                                                                    $hasLine[] = $pre_owner_data['owner_group_id'];
                                                                    $isPrintedHr = true;
                                                                    $owner_data .= '<hr class="hr"/>';
                                                                }

                                                                $owner_data .= '<br>' . $owner['owner_name'];
                                                                $angshoBreak = getLines($pre_parent_name, 34, '<br>', false) + getLines($pre_address_only, 34, '<br>', false);
                                                                $pre_owner_data = $owner;
                                                                $pre_address_only = $owner['address_only'];
                                                                $pre_parent_name = $owner['parent_name'];
                                                                $address_entry = true;
                                                            } else {
                                                                $owner_data .= '<br>' . $pre_parent_name;
                                                                $owner_data .= '<br>' . $owner['owner_name'];
                                                                $angshoBreak = getLines($pre_parent_name, 34, '<br>', false);
                                                                $pre_parent_name = $owner['parent_name'];
                                                                $address_entry = true;

                                                            }
                                                        } else {
                                                            $owner_data .= '<br>' . $owner['owner_name'];
                                                            $lastOwnerAddress = $owner['address_only'];
                                                        }
                                                    } else {
                                                        $pre_address_only = $owner['address_only'];
                                                        $pre_parent_name = $owner['parent_name'];
                                                        $owner_data .= $owner['owner_name'];
                                                        $pre_owner_address_holder = '';
                                                        $pre_owner_data = $owner;
                                                    }

                                                    if (empty($mokadoma_no) && !empty($owner['mokadoma_no'])) {
                                                        $mokadoma_no = $owner['mokadoma_no'];
                                                    }
                                                    if (empty($dhara_no) && !empty($owner['dhara_no'])) {
                                                        $dhara_no = $owner['dhara_no'];
                                                    }
                                                    if (empty($dhara_son) && !empty($owner['dhara_son'])) {
                                                        $dhara_son = $owner['dhara_son'];
                                                    }

                                                    if ($owner['owner_area'] == '1') {
                                                        $owner_area = '১.০০০';
                                                    } else {
                                                        $owner_area = explode('.', $owner['owner_area']);
                                                        if (isset($owner_area[1]) && strlen($owner_area[1]) == 1)
                                                            $owner_area = $owner['owner_area'] . '০০';
                                                        elseif (isset($owner_area[1]) && strlen($owner_area[1]) == 2)
                                                            $owner_area = $owner['owner_area'] . '০';
                                                        elseif (isset($owner_area[1]) && strlen($owner_area[1]) == 3)
                                                            $owner_area = $owner['owner_area'];
                                                        else
                                                            $owner_area = $owner['owner_area'];
                                                    }

                                                    if ($address_entry && isset($angshoBreak)) {
                                                        $owner_ongsho .= $lineBreak[$angshoBreak] . '<span class="paddTwo">' . $owner_area . '</span>' . '<br>' . $lineBreak[($ownerCountLine - 1)];
                                                    } else {
                                                        $owner_ongsho .= $owner_area . $lineBreak[($ownerCountLine - 1)] . '<br>';
                                                    }

                                                    $total_ongsho = $total_ongsho + $owner['owner_area'];
                                                }

                                                if ($pre_address_only !== false && empty($pre_address_only)) {
                                                    $pre_address_only = $lastOwnerAddress;
                                                }
                                                if ($pre_address_only !== false || !empty($pre_parent_name)) {
                                                    $owner_data .= '<br>' . $pre_parent_name;
                                                    $string = preg_replace('#(( ){0,}<br( {0,})(/{0,1})>){1,}$#i', '', $owner_data);
                                                    $owner_data = $string . '<br>' . preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $pre_address_only); // remove leading multiple br
                                                }
                                                $jl_number = '';
                                                $dcr_number = '';
                                                $resa_no = '';
                                                $case_no = '';
                                                $dag_no = '';
                                                $krishi = '';
                                                $non_krishi = '';
                                                $total_dag_area_ekor = '';
                                                $total_dag_area_shotangso = '';
                                                $khotian_dag_portion = '';
                                                $total_dag_portion_ekor = '';
                                                $total_dag_portion_shotangso = '';
                                                $remarks = '';
                                                $total_khotian_dag_portion = 0;
                                                $isSpecial = empty($khotian[0]['brs_khotian_entries']['is_special']) ? '' : $khotian[0]['brs_khotian_entries']['is_special'];
                                                $computerCode = empty($khotian[0]['brs_khotian_entries']['computer_code']) ? '' : $khotian[0]['brs_khotian_entries']['computer_code'];
                                                $dagsAreaByRows = null;

                                                foreach ($khotian as $rowCnt => $row) {
                                                    $krishiLines = 0;
                                                    $okrishiLines = 0;
                                                    $dagParts = explode('/', $row['dag_number']);
                                                    $case_no = empty($row['namjari_case_no']) ? '' : $row['namjari_case_no'];
                                                    $resa_no = empty($row['resa_no']) ? '' : $row['resa_no'];
                                                    $dcr_number = empty($row['dcr_number']) ? '' : $row['dcr_number'];
                                                    $jl_number = empty($row['jl_number']) ? '' : $row['jl_number'];
                                                    if (!empty($dagParts[1])) {
                                                        $partOne = '<span class="dagUnderline">' . substr(trim($dagParts[1]), 0, 5) . '</span><br>';
                                                        $partTwo = substr(trim($dagParts[0]), 0, 5) . '<br>';

                                                        $dag_no .= $partOne . $partTwo;
                                                        $dagLine = 2;
                                                    } else {
                                                        $dag_no .= substr(trim($row['dag_number']), 0, 5) . '<br>';
                                                        $dagLine = 1;
                                                    }
                                                    if ($row['agricultural_use'] == 0 || $row['agricultural_use'] == '') {
                                                        $krishi .= '<br>';
                                                        $non_krishi .= mb_wordwrap($row['lt_name'], 13) . '<br>';
                                                        $okrishiLines = getLines($row['lt_name'], 13);
                                                    } else {
                                                        $krishi .= mb_wordwrap($row['lt_name'], 13) . '<br>';
                                                        $non_krishi .= '<br>';
                                                        $krishiLines = getLines($row['lt_name'], 13);
                                                    }
                                                    $dag_area = explode('.', $row['total_dag_area']);
                                                    if ($row['khotian_dag_portion'] != 1) {
                                                        $total_dag_area_ekor .= ($dag_area[0] > 0 ? $dag_area[0] : '') . '<br>'; // if 0 show empty
                                                        if (isset($dag_area[1])) {
                                                            if (strlen($dag_area[1]) == 1) {
                                                                $total_dag_area_shotangso .= $dag_area[1] . '০০০' . '<br>';
                                                            } elseif (strlen($dag_area[1]) == 2) {
                                                                $total_dag_area_shotangso .= $dag_area[1] . '০০' . '<br>';
                                                            } elseif (strlen($dag_area[1]) == 3) {
                                                                $total_dag_area_shotangso .= $dag_area[1] . '০' . '<br>';
                                                            } else {
                                                                $total_dag_area_shotangso .= $dag_area[1] . '<br>';
                                                            }
                                                        } else {
                                                            if (!empty($dag_area[0])) {
                                                                $total_dag_area_shotangso .= '0000<br>';
                                                            }
                                                        }
                                                    } else {
                                                        $total_dag_area_ekor .= '<br>';
                                                        $total_dag_area_shotangso .= '<br>';
                                                    }
                                                    if ($row['khotian_dag_portion'] == '1') {
                                                        $khotian_dag_portion .= '<span class="oneOne">1.000</span>' . '<br>';
                                                    } else {
                                                        $khotian_dag_portion_arr = explode('.', $row['khotian_dag_portion']);
                                                        if (isset($khotian_dag_portion_arr[1]) && strlen($khotian_dag_portion_arr[1]) == 1)
                                                            $khotian_dag_portion .= $row['khotian_dag_portion'] . '00' . '<br>';
                                                        elseif (isset($khotian_dag_portion_arr[1]) && strlen($khotian_dag_portion_arr[1]) == 2)
                                                            $khotian_dag_portion .= $row['khotian_dag_portion'] . '0' . '<br>';
                                                        else
                                                            $khotian_dag_portion .= $row['khotian_dag_portion'] . '<br>';
                                                    }
                                                    $dag_portion = explode('.', $row['khotian_dag_area']);
                                                    $dagsAreaByRows .= $row['khotian_dag_area'] . '<br>';
                                                    $total_dag_portion_ekor .= ($dag_portion[0] > 0 ? $dag_portion[0] : '') . '<br>'; // if 0 show empty
                                                    if (isset($dag_portion[1])) {
                                                        if (strlen($dag_portion[1]) == 1) {
                                                            $total_dag_portion_shotangso .= $dag_portion[1] . '০০০' . '<br>';
                                                        } elseif (strlen($dag_portion[1]) == 2) {
                                                            $total_dag_portion_shotangso .= $dag_portion[1] . '০০' . '<br>';
                                                        } elseif (strlen($dag_portion[1]) == 3) {
                                                            $total_dag_portion_shotangso .= $dag_portion[1] . '০' . '<br>';
                                                        } else {
                                                            $total_dag_portion_shotangso .= $dag_portion[1] . '<br>';
                                                        }
                                                    } else {
                                                        $total_dag_portion_shotangso .= '0000<br>';
                                                    }
                                                    $remarkTextWithoutLatBr = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $row['remarks']);
                                                    $tmpTxt = preg_replace("#<br\s?/?>#", "<br>", $remarkTextWithoutLatBr);
                                                    $remarkTxt = mb_wordwrap($tmpTxt, 28, "<br>");
                                                    $remarks .= $remarkTxt . '<br>';
                                                    $remarkSize = getLines($remarkTxt, 28);
                                                    $size = $remarkSize > $okrishiLines ? $remarkSize : $okrishiLines;
                                                    $size = $size > $krishiLines ? $size : $krishiLines;
                                                    $size = $size > $dagLine ? $size : $dagLine;
                                                    $total_khotian_dag_portion += $row['khotian_dag_area'];

                                                    if ($size > 1) {
                                                        if ($remarkSize < $size) {
                                                            $remarks .= $lineBreak[$size - $remarkSize];
                                                        }
                                                        $dagLineAppendNumber = $size - $dagLine;
                                                        $dag_no .= $lineBreak[$dagLineAppendNumber];
                                                        $krishi .= $lineBreak[$size - ($krishiLines > 0 ? $krishiLines : 1)];
                                                        $non_krishi .= $lineBreak[$size - ($okrishiLines > 0 ? $okrishiLines : 1)];
                                                        $total_dag_area_shotangso .= $lineBreak[$size - 1];
                                                        $total_dag_area_ekor .= $lineBreak[$size - 1];
                                                        $total_dag_portion_ekor .= $lineBreak[$size - 1];
                                                        $khotian_dag_portion .= $lineBreak[$size - 1];
                                                        $total_dag_portion_shotangso .= $lineBreak[$size - 1];
                                                        $dagsAreaByRows .= $lineBreak[$size - 1];
                                                    }
                                                }

                                                $total_khotian_dag_portion = explode('.', $total_khotian_dag_portion);
                                                $owner_data = str_replace('<br/>', '<br>', $owner_data);
                                                $owner_data_by_land_owner = explode('<end/>', $owner_data);
                                                $remove_string_last_separator = rtrim($owner_ongsho, '<br>');
                                                $owner_ongsho_pages = explode('<br>', $remove_string_last_separator);
                                                $ownerAngsho = [];
                                                $pageAngsho = 0;
                                                $ownerAngshoTrackerKey = 0;
                                                $overAllPages = [];
                                                $currentPage = 0;

                                                foreach ($owner_data_by_land_owner as $LKey => $landowner) {
                                                    $landowner = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $landowner);
                                                    $landownerLineArr = explode('<br>', $landowner);
                                                    $currentPageSize = count($landownerLineArr);
                                                    if (empty($overAllPages[$currentPage])) {
                                                        if ($currentPageSize > $per_page_line_number) {
                                                            $tmpKey = 1;
                                                            foreach ($landownerLineArr as $key => $item) {
                                                                $overAllPages[$currentPage][] = $item;
                                                                $ownerAngsho[] = empty($owner_ongsho_pages[$ownerAngshoTrackerKey]) ? '' : $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                                $ownerAngshoTrackerKey++;
                                                                if (($tmpKey % ($per_page_line_number) == 0)) {
                                                                    $currentPage++;
                                                                }
                                                                $tmpKey++;
                                                            }
                                                        } else {
                                                            $overAllPages[$currentPage] = $landownerLineArr;
                                                            for ($ownerAngshoTrackerKey; $ownerAngshoTrackerKey < $currentPageSize; $ownerAngshoTrackerKey++) {
                                                                $ownerAngsho[] = empty($owner_ongsho_pages[$ownerAngshoTrackerKey]) ? '' : $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                            }
                                                        }
                                                    } else {
                                                        $currentPageSize = count($overAllPages[$currentPage]);
                                                        $newOwnerBlockSize = count($landownerLineArr);
                                                        $totalElements = $currentPageSize + $newOwnerBlockSize;
                                                        if ($totalElements > $per_page_line_number) {
                                                            for ($currentPageSize; $currentPageSize < $per_page_line_number; $currentPageSize++) {
                                                                $overAllPages[$currentPage][] = '<br>';
                                                                $ownerAngsho[] = '<br>';
                                                            }
                                                            $currentPage++;
                                                            foreach ($landownerLineArr as $tmpKey => $ownerBlockLine) {
                                                                $overAllPages[$currentPage][] = $ownerBlockLine;
                                                                $ownerAngsho[] = $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                                $ownerAngshoTrackerKey++;
                                                            }
                                                        } else {
                                                            foreach ($landownerLineArr as $tmpKey => $ownerBlockLine) {
                                                                $overAllPages[$currentPage][] = $ownerBlockLine;
                                                                $ownerAngsho[] = $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                                $ownerAngshoTrackerKey++;
                                                            }
                                                        }
                                                    }
                                                }
                                                $owner_data_pages = $overAllPages;
                                                array_push($pages_number_array, count($owner_data_pages));
                                                $owner_ongsho_pages = array_chunk($ownerAngsho, $per_page_line_number);
                                                array_push($pages_number_array, count($owner_ongsho_pages));
                                                $secondPartExtraLine = 1;
                                                $dag_no_pages = pageSeparateOnNl($dag_no, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                array_push($pages_number_array, count($dag_no_pages));
                                                $krishi_pages = pageSeparateOnNl($krishi, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                array_push($pages_number_array, count($krishi_pages));
                                                $non_krishi_pages = pageSeparateOnNl($non_krishi, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                array_push($pages_number_array, count($non_krishi_pages));
                                                $total_dag_area_ekor_pages = pageSeparateOnNl($total_dag_area_ekor, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                array_push($pages_number_array, count($total_dag_area_ekor_pages));
                                                $total_dag_area_shotangso_pages = pageSeparateOnNl($total_dag_area_shotangso, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                array_push($pages_number_array, count($total_dag_area_shotangso_pages));
                                                $khotian_dag_portion_pages = pageSeparateOnNl($khotian_dag_portion, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                array_push($pages_number_array, count($khotian_dag_portion_pages));
                                                $total_dag_portion_ekor_pages = pageSeparateOnNl($total_dag_portion_ekor, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                array_push($pages_number_array, count($total_dag_portion_ekor_pages));
                                                $total_dag_portion_shotangso_pages = pageSeparateOnNl($total_dag_portion_shotangso, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                array_push($pages_number_array, count($total_dag_portion_shotangso_pages));
                                                $remarks_pages = pageSeparate($remarks, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                array_push($pages_number_array, count($remarks_pages));
                                                $dagsAreaByRowsPages = pageSeparate($dagsAreaByRows, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                array_push($pages_number_array, count($dagsAreaByRowsPages));
                                                $countOfLoop = max($pages_number_array);
                                                if(isset($owners) && isset($khotian)){
                                                for ($i = 0; $i < $countOfLoop; $i++) { ?>
                                                <?php
                                                if (isset($dagsAreaByRowsPages[$i])) {
                                                    foreach ($dagsAreaByRowsPages[$i] as $ekor) {
                                                        if (is_numeric($ekor)) {
                                                            $totalEkor += $ekor;
                                                        }
                                                    }
                                                }
                                                $totalEkorLocal = explode('.', $totalEkor);
                                                if (isset($owner_ongsho_pages[$i])) {
                                                    foreach ($owner_ongsho_pages[$i] as $angshoFragment) {
                                                        $angshoFragment = bn2en($angshoFragment);
                                                        $angshoFragmentNumber = filter_var($angshoFragment, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                                                        if (is_numeric($angshoFragmentNumber)) {
                                                            $pageAngsho += $angshoFragmentNumber;
                                                        }
                                                    }
                                                }
                                                $computerCodeLatest = '';
                                                $timeObj = \Illuminate\Support\Carbon::now();
                                                $timeObj->modify('+14 minutes');
                                                $datePartOne = $timeObj->format('md'); // month and day
                                                $datePartTwo = $timeObj->format('Y');
                                                $time = $timeObj->format('His');
                                                $randomNumber = rand(10, 99);
                                                $gel = substr($header_info['dglr_code'], -3);
                                                if (empty($gel)) {
                                                    $gel = '000';
                                                } elseif (strlen($gel) == 1) {
                                                    $gel = '00' . $gel;
                                                } elseif (strlen($gel) == 2) {
                                                    $gel = '0' . $gel;
                                                }
                                                $computerCodeLatest = $randomNumber . $datePartOne . $userCode . $time . $gel . $formatedIpPartOne . '-' . $ownerRowId . $datePartTwo . $formatedIpPartTwo;
                                                ?>
                                                <div style="position: relative">
                                                    <?php if(!empty($application->status) && $application->status == 2){ ?>
                                                    <div
                                                        style='width: 80%; position: absolute; top: 300px; left: 10%; color: #00000030; font-size: 3em; display: block; font-weight: bolder; '>
                                                        <div style='position: relative'><span
                                                                style='float: left'>সরকারি ব্যবহারের জন্য</span><span
                                                                style='float: right'>সরকারি ব্যবহারের জন্য</span></div>
                                                    </div>
                                                    <?php } ?>
                                                    <table class="htable" border="0" style="margin-top: 2px;">
                                                        <tr>
                                                            <td colspan="4" align="left" style="border:1px">বাংলাদেশ ফর্ম নং ৫৪৬২ (সংশোধিত)&nbsp;
                                                            </td>
                                                            <td colspan="6" align="center" style="border:1px;">
                                                                <h2 style="padding-bottom: 0px; margin-top: 15px; margin-left: -85px; font-size: 29px;">
                                                                    খতিয়ান নং- <span
                                                                        class=""><?php echo eng_to_bangla_code($record->khotian_number); ?></span>
                                                                </h2>
                                                            </td>
                                                            <td colspan="4"
                                                                style="font-size: 15px; border:0px;text-align: right;padding-right: 6px;vertical-align: middle;"
                                                                class="nikosh">

                                                                <?= __('নামজারি মামলা  <span style="font-size: 15px;">নংঃ</span> ' . $case_no)?>
                                                                <p style="font-size: 15px;padding-left: 20px"> <?= __('ডি সি আর   <span style="font-size: 15px;">নংঃ</span> ' . eng_to_bangla_code($dcr_number) ?? '')?>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="border:1px; font-size: 16px; padding-bottom: 15px;">
                                                                বিভাগঃ <?php echo $header_info['name_bn'] ?? $header_info['division_name'];  ?></td>
                                                            <td colspan="2" style="border:1px;  font-size: 16px; padding-bottom: 15px;">
                                                                জেলাঃ <?php echo $header_info['district_name']; ?></td>
                                                            <td colspan="3"
                                                                style="border:1px;  font-size: 16px; padding-bottom: 15px; max-width: 120px;">
                                                                উপজেলা/থানাঃ <?php echo $header_info['upazila_name']; ?></td>
                                                            <td colspan="3"
                                                                style="border:1px;  font-size: 16px; padding-bottom: 15px; min-width: 170px;">
                                                                মৌজাঃ <?php echo $header_info['name_bd']; ?></td>
                                                            <td colspan="2" style="border:1px; padding-bottom: 15px;  font-size: 16px;">জে,
                                                                এল,
                                                                নংঃ <?php echo eng_to_bangla_code($jl_number); ?></td>
                                                            <td colspan="2" style="border:0px;  font-size: 15px; padding-bottom: 15px;">রেঃ
                                                                সাঃ
                                                                নংঃ <?= !empty($resa_no) ? eng_to_bangla_code($resa_no) : '&nbsp;' ?> </td>
                                                        </tr>
                                                    </table>

                                                    <table class="table" border="0" cellpadding="0" cellspacing="0" class="pp"
                                                           id="table_<?= $i ?>"
                                                           style="vertical-align:top; height: 17cm; margin-bottom: 0px;">
                                                        <thead>
                                                        <tr bgcolor="#EFF2F7" style="vertical-align:top;">
                                                            <td colspan="1"
                                                                style="width: 232px; text-align: center;vertical-align:middle;border-left:1px solid;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                মালিক, অকৃষি প্রজা বা ইজারাদারের<br>
                                                                নাম ও ঠিকানা<br></td>
                                                            <td colspan="1"
                                                                style="width: 49px; text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                অংশ
                                                                &nbsp;
                                                            </td>
                                                            <td colspan="1"
                                                                style="width: 80px; text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                রাজস্ব<br></td>
                                                            <td colspan="1"
                                                                style="width: 46px;text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                দাগ নং<br></td>
                                                            <td colspan="2" rowspan="1"
                                                                style="text-align: center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                                                                width="98px">
                                                                জমির শ্রেণী
                                                            </td>
                                                            <td colspan="2" rowspan="1"
                                                                style="text-align:center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                                                                width="87px">
                                                                দাগের মোট পরিমাণ
                                                            </td>
                                                            <td colspan="1"
                                                                style="width: 150px;font-size:11px; text-align: center; vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                দাগের মধ্যে
                                                                অত্র <br>খতিয়ানের অংশ
                                                            </td>
                                                            <td colspan="2" rowspan="1"
                                                                style="font-size: 11px; text-align:center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                                                                width="87px">
                                                                অংশানুযায়ী জমির<br>
                                                                পরিমাণ
                                                            </td>
                                                            <td colspan="1"
                                                                style="width: 172px;text-align: center; vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                দখল বিষয়ক বা অন্যান্য<br>
                                                                বিশেষ মন্তব্য<br></td>
                                                        </tr>
                                                        <tr bgcolor="#b0c4de">
                                                            <td colspan="1" rowspan="2"
                                                                style="width: 212px;text-align: center;vertical-align:middle;border-top:1px solid;border-right:1px solid;border-left:1px solid;  border-bottom: 1px solid">
                                                                &nbsp;১
                                                            </td>
                                                            <td colspan="1" rowspan="2"
                                                                style="width: 49px;text-align: center;  vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                                ২
                                                            </td>
                                                            <td colspan="1" rowspan="2"
                                                                style="width: 38px;text-align: center;  vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                                ৩
                                                            </td>
                                                            <td colspan="1" rowspan="2"
                                                                style="width: 77px;text-align: center;  vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                                ৪
                                                            </td>
                                                            <td style="width: 41.57px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;"
                                                            >
                                                                কৃষি<br></td>
                                                            <td style="width: 45.35px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                                অকৃষি<br></td>
                                                            <td
                                                                style="width: 41.57px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                                একর<br></td>
                                                            <td
                                                                style="width: 45.35px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                                শতাংশ<br></td>
                                                            <td colspan="1" rowspan="2"
                                                                style="width: 70px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                                ৭
                                                            </td>
                                                            <td
                                                                style="width: 41.57px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                                একর<br></td>
                                                            <td
                                                                style="width: 45.35px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                                শতাংশ<br></td>
                                                            <td colspan="1" rowspan="2"
                                                                style="width: 172px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                                ৯
                                                            </td>
                                                        </tr>
                                                        <tr bgcolor="#b0c4de" style="border: none">
                                                            <td width="45px"
                                                                style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">
                                                                ৫ (ক)
                                                            </td>
                                                            <td width="45px"
                                                                style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">
                                                                ৫(খ)
                                                            </td>
                                                            <td width="41.57px"
                                                                style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">
                                                                ৬ (ক)
                                                            </td>
                                                            <td width="45.35px"
                                                                style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">
                                                                ৬ (খ)
                                                            </td>
                                                            <td width="41.57px"
                                                                style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">
                                                                ৮ (ক)
                                                            </td>
                                                            <td width="45.35px"
                                                                style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">
                                                                ৮ (খ)
                                                            </td>
                                                        </tr>
                                                        </thead>
                                                        <tbody style="">


                                                        <tr class="custom-border">
                                                            <td style="width: 212px; border-top: none; text-align: left; <?= $border_left ?> <?= $border_right ?> padding-left:7px;"
                                                                valign="top">
                                                                <?php  if( $i == 0 && $khotian_no != 1 ): ?>
                                                                <p style="padding: 2px 0px 0px 0px;margin: 0px;">মালিক</p>
                                                                <?php endif; ?>
                                                                <?php  if( $i == 0 && $khotian_no == 1 ): ?>
                                                                <p style="padding: 2px 0px 0px 0px;margin: 0px;"><br></p>
                                                                <?php endif; ?>
                                                                <?php
                                                                if (isset($owner_data_pages[$i])) {
                                                                    echo implode('<br>', $owner_data_pages[$i]);
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="border-top: none; text-align: left; padding-left: 4px;vertical-align:top;<?= $border_right ?>">
                                                                <?php  if( $i == 0): ?>
                                                                <p style="padding: 2px 0px 0px 0px;margin: 0px;">&nbsp;</p>
                                                                <?php endif; ?>
                                                                <?php
                                                                if (isset($owner_data_pages[$i])) {
                                                                    echo eng_to_bangla_code(implode('<br>', $owner_ongsho_pages[$i]));
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>"> <?php

                                                                if ($i == 0 && isset($khotian[0]['revenue'])) {
                                                                    echo '<br>' . eng_to_bangla_code($khotian[0]['revenue']) . '/-';
                                                                }
                                                                ?> </td>
                                                            <td style="padding-left: 4px; border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                <?php
                                                                if (isset($dag_no_pages[$i])) {
                                                                    echo eng_to_bangla_code($dag_no_pages[$i]);
                                                                }
                                                                ?>
                                                            </td>

                                                            <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>white-space: normal;">
                                                                <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                <?php
                                                                if (isset($krishi_pages[$i])) {
                                                                    echo $krishi_pages[$i];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="border-top: none; text-align: center;vertical-align:top; <?= $border_right ?> white-space: normal;">
                                                                <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                <?php
                                                                if (isset($non_krishi_pages[$i])) {
                                                                    echo $non_krishi_pages[$i];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                <?php
                                                                if (isset($total_dag_area_ekor_pages[$i])) {
                                                                    echo eng_to_bangla_code($total_dag_area_ekor_pages[$i]);
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                <?php
                                                                if (isset($total_dag_area_shotangso_pages[$i])) {
                                                                    echo eng_to_bangla_code($total_dag_area_shotangso_pages[$i]);
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                <?php
                                                                if (isset($khotian_dag_portion_pages[$i])) {
                                                                    echo eng_to_bangla_code($khotian_dag_portion_pages[$i]);
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                <?php
                                                                if (isset($total_dag_portion_ekor_pages[$i])) {
                                                                    echo eng_to_bangla_code($total_dag_portion_ekor_pages[$i]);
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                <?php
                                                                if (isset($total_dag_portion_shotangso_pages[$i])) {
                                                                    echo eng_to_bangla_code($total_dag_portion_shotangso_pages[$i]);
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="border-top: none; text-align: center;vertical-align:top;word-break:break-all; <?= $border_right ?>">
                                                                <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                <pre style="
                                            text-align: center;
                                            border: none;
                                            padding: inherit;
                                            font-size: inherit;
                                            line-height: inherit;
                                            margin: 0px;
                                            color: inherit;
                                            background-color: inherit;
                                            border-radius: inherit;
                                            font-size: 13px;
                                            font-family:kalpurush;
                                        "><?php
                                                                    if (isset($remarks_pages[$i])) {
                                                                        echo implode('<br>', $remarks_pages[$i]);
                                                                    }
                                                                    ?></pre>
                                                            </td>
                                                        </tr>


                                                        </tbody>
                                                        <tfoot>
                                                        <tr bgcolor="#CCCCCC" style="height: 1.2cm">
                                                            <td rowspan="1"
                                                                style="font-size:12px; <?= $border_left ?> <?= $border_right ?> <?= $border_top ?> padding-left:5px;border-bottom:1px solid; font-style: italic">
                                                                <?= !empty($khotian[0]['dhara_no']) ? eng_to_bangla_code($khotian[0]['dhara_no']) . ' ' : '..........' ?>
                                                                ধারামতে নোট বা পরিবর্তন
                                                                <b>মায় মোকদ্দমা
                                                                    নং</b><?= !empty($khotian[0]['mokoddoma_no']) ? ' ' . eng_to_bangla_code($khotian[0]['mokoddoma_no']) . ' ' : '.........' ?>
                                                                এবং
                                                                <b>সন</b><?= !empty($khotian[0]['dhara_year']) ? ' ' . eng_to_bangla_code($khotian[0]['dhara_year']) : '.........' ?>
                                                            </td>
                                                            <td style="text-align:center;<?= $border_right ?> <?= $border_top ?> border-bottom:1px solid;"><?php
                                                                echo eng_to_bangla_code(number_format($pageAngsho, 3));
                                                                ?></td>
                                                            <td style="font-size: 15px; text-align: right;vertical-align:middle;<?= $border_right ?> <?= $border_top ?> border-bottom:1px solid;padding-right:5px;"
                                                                colspan="7">
                                                                <span style="float: right;"> মোট জমিঃ</span>
                                                            </td>
                                                            <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid; text-align: center;"
                                                                valign="top">
                                                                <?php
                                                                if (isset($totalEkorLocal[0])) {
                                                                    echo eng_to_bangla_code($totalEkorLocal[0]);
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid; text-align: left;"
                                                                valign="top">
                                                                <?php
                                                                $totalEkorLocal[2] = '';
                                                                if (isset($totalEkorLocal[1])) {
                                                                    if (isset($totalEkorLocal[1]) && strlen($totalEkorLocal[1]) == 1) {
                                                                        $totalEkorLocal[2] .= $totalEkorLocal[1] . '000'; //added (arman)
                                                                        $totalEkorLocal[1] .= '০০০';
                                                                    } elseif (isset($totalEkorLocal[1]) && strlen($totalEkorLocal[1]) == 2) {
                                                                        $totalEkorLocal[2] .= $totalEkorLocal[1] . '00'; //added (arman)

                                                                        $totalEkorLocal[1] .= '০০';
                                                                    } elseif (isset($totalEkorLocal[1]) && strlen($totalEkorLocal[1]) == 3) {
                                                                        $totalEkorLocal[2] .= $totalEkorLocal[1] . '0'; //added (arman)
                                                                        $totalEkorLocal[1] .= '০';
                                                                    }
                                                                    echo eng_to_bangla_code($totalEkorLocal[1]);
                                                                } else {
                                                                    echo eng_to_bangla_code('0000');
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid;">
                                                                <?php
                                                                $totalValue = isset($totalEkorLocal[0]) ? $totalEkorLocal[0] : '0';
                                                                $totalValue .= isset($totalEkorLocal[2]) ? '.' . $totalEkorLocal[2] : '0000';

                                                                echo 'কথায়:' . \App\Helpers\Classes\NumberToBanglaWord::numToWord(isset($totalEkor) ? (float)$totalEkor : 0) . 'একর মাত্র ।';
                                                                ?>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6"
                                                                style="text-align: right; vertical-align: middle"><?= !empty($computerCodeLatest) ? 'কম্পিউটার কোডঃ ' . eng_to_bangla_code($computerCodeLatest) : '&nbsp' ?></td>
                                                        </tr>
                                                        <tr style="border: none;">
                                                            <td colspan="6" style="border: none;">&nbsp;</td>
                                                        </tr>
                                                        @if(isset($application) && !empty($application->applicant_name))
                                                            <tr style="border: none; display: none;">
                                                                <td colspan="6" style="border: none;">আবেদনকারীর
                                                                    নাম: {{$application->applicant_name}} |
                                                                    আবেদন নং
                                                                    - {{eng_to_bangla_code($application->application_display_code)}}</td>
                                                                <td colspan="6" style="border: none;">&nbsp;</td>
                                                            </tr>
                                                        @endif
                                                        </tfoot>
                                                    </table>

                                                    @if ($isAclandUser)
                                                        <table class="d" style='margin: 0 auto;text-align:center'>
                                                            <tr style='line-height:100px;'>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদন যোগ্য</td>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদন যোগ্য</td>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">মঞ্জর</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-family: nikoshBAN;">
                                                                    <?php echo eng_to_bangla_code($khotian[0]['signature_one_date']); ?><br>
                                                                    <?php echo '(' . $khotian[0]['signature_one_name'] . ')'; ?> <br>
                                                                    {{ !empty($designations[$khotian[0]['signature_one_designation']]) ? $designations[$khotian[0]['signature_one_designation']]: $khotian[0]['signature_one_designation'] }}
                                                                    <br>
                                                                    <?php echo 'উপজেলা ভূমি অফিস'; ?> <br>
                                                                    {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}
                                                                </td>
                                                                <td style="font-family: nikoshBAN;">
                                                                    <?php echo eng_to_bangla_code($khotian[0]['signature_two_date']); ?><br>
                                                                    <?php echo '(' . $khotian[0]['signature_two_name'] . ')'; ?> <br>
                                                                    <?php echo !empty($designations[$khotian[0]['signature_two_designation']]) ? $designations[$khotian[0]['signature_two_designation']] : $khotian[0]['signature_two_designation']; ?>
                                                                    <br>
                                                                    <?php echo 'উপজেলা ভূমি অফিস'; ?> <br>
                                                                    {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}

                                                                </td>
                                                                <td style="font-family: nikoshBAN;">
                                                                    <?php echo eng_to_bangla_code($khotian[0]['signature_three_date']); ?>
                                                                    <br>
                                                                    <?php echo '(' . $khotian[0]['signature_three_name'] . ')'; ?> <br>
                                                                    <?php echo !empty($designations[$khotian[0]['signature_three_designation']]) ? $designations[$khotian[0]['signature_three_designation']] : $khotian[0]['signature_three_designation'] ?>
                                                                    <br>
                                                                    <?php echo 'উপজেলা ভূমি অফিস'; ?> <br>
                                                                    {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}
                                                                </td>
                                                            </tr>
                                                            {{--<tr>
                                                                <td><img src="<?php echo '/storage/qr/'. $qr_code; ?>"
                                                                         style="margin-left:132% " width="140" height="140"/></td>
                                                            </tr>--}}
                                                        </table>
                                                    @elseif (!$isAclandUser)
                                                        <table class="d" style='width: 1090px; margin:0 auto'>
                                                            <tr style='line-height:100px;text-align:center'>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">নকলকারী</td>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">যাচাইকারী</td>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">তুলনাকারী</td>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদনকারী</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" rowspan="3" style="vertical-align: middle;"><img
                                                                        src="<?php echo '/storage/qr/'. $qr_code; ?>"
                                                                        style="margin-left:40% " width="140" height="140"/></td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                </div>
                                                @if ($i !== $countOfLoop)
                                                    <div style="page-break-after: always;"></div>
                                                @endif
                                                <?php
                                                }
                                                }
                                                else
                                                {
                                                ?>
                                                <div class="alert alert-warning alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Warning!</strong> Owner not Found.
                                                </div>
                                                <?php
                                                }
                                                }
                                                if($print_type == 1):
                                                ?>
                                                <style>
                                                    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th {
                                                        border-top: none;
                                                    }
                                                </style>
                                                <?php
                                                endif;
                                                ?>
                                                <style>
                                                    html, body, div {
                                                        font-family: kalpurush;
                                                    }

                                                    .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                                        padding: 2px;
                                                        vertical-align: middle;
                                                    }

                                                    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                                        padding: 2px;
                                                    }

                                                    @page {
                                                        size: A4 landscape;
                                                        margin-left: 3.5cm;
                                                        margin-top: 1cm;
                                                        margin-bottom: 0px;
                                                    }

                                                    .oneOne {
                                                        padding-left: 1.5px;
                                                    }

                                                    .dagUnderline {
                                                        border-bottom: 1px solid;
                                                    }

                                                    .table > tbody > tr > td {
                                                        padding-top: 0px !important;
                                                    }

                                                    .paddTwo {
                                                        padding: 0px 0px 0px 0px;
                                                    }

                                                    hr {
                                                        margin: 0px;
                                                        padding: 0px 0px 2px 0px;
                                                        border-top: 1px solid #323232;
                                                        width: 97%;
                                                        display: inline-block;
                                                    }

                                                    hr:first-child {
                                                        margin-top: 2px !important;
                                                        padding-bottom: 0px !important;
                                                    }

                                                    /* TODO: added (arman) */
                                                    .d {
                                                        table-layout: fixed;
                                                        width: 100%;
                                                    }

                                                    #pdfIframe {
                                                        margin-left: -13px;
                                                    }
                                                </style>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-5" style="border-style: ridge; max-height: 50rem">
                                            <iframe id="pdfIframe" src="{{ asset("storage/".$record->scan_copy)}}" frameborder="0"
                                                    style="background: #FFFFFF;" width="108%" height="100%"
                                                    allowtransparency="true"></iframe>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="ba-slider">
                                    @if($record->scan_copy)
                                        <div class="row">
                                            <div class="col-md-6" style="margin-bottom: 0px !important">
                                                <h3 style="text-align: center;
                        padding: 2px 0 0 0;
                        background: green;
                        color: #fff;
                        padding: 7px; width: 100%">খতিয়ানের স্ক্যান কপি</h3>
                                            </div>
                                            <div class="col-md-6" style="margin-bottom: 0px !important">
                                                <h4 style="
                        text-align: center;
                        padding: 2px 0 0 0;
                        background: green;
                        color: #fff;
                        padding: 7px;
                        width: 102%;
                    ">তৈরিকৃত খতিয়ানের কপি</h4>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="container" style="background: #fff;">
                                        <div style="text-align: center;clear: both;position: relative;margin: 22px 0px;">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="PrintArea" style="margin-left: 36px">
                                                    <?php
                                                    $breakingAt = 30;
                                                    $lineBreak[0] = '';
                                                    $lineBreak[1] = '<br>';
                                                    $lineBreak[2] = '<br><br>';
                                                    $lineBreak[3] = '<br><br><br>';
                                                    $lineBreak[4] = '<br><br><br><br>';
                                                    $lineBreak[5] = '<br><br><br><br><br>';
                                                    $lineBreak[6] = '<br><br><br><br><br><br>';
                                                    $lineBreak[7] = '<br><br><br><br><br><br><br>';
                                                    $lineBreak[8] = '<br><br><br><br><br><br><br><br>';
                                                    $lineBreak[9] = '<br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[10] = '<br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[11] = '<br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[12] = '<br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[13] = '<br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[14] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[15] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[16] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[17] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[18] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[19] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[20] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[21] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[22] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[23] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[24] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[25] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[26] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[27] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[28] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[29] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[30] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[31] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[32] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[33] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[34] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[35] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[36] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[37] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[38] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[39] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                                    $lineBreak[40] = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

                                                    $per_page_line_number = 22;
                                                    $border_right = ' border-right:1px solid; ';
                                                    $border_bottom = ' border-bottom:1px solid;';
                                                    $border_top = ' border-top:1px solid;';
                                                    $border_left = ' border-left:1px solid;';

                                                    if (isset($print_type) && !empty($print_type) && $print_type == 1) {
                                                        $border_right = ' border-right:none!important;';
                                                        $border_bottom = ' border-bottom:none!important;';
                                                        $border_top = ' border-bottom:none!important;';
                                                        $border_left = ' border-left: none!important;';
                                                    }
                                                    function getLines($text, $char = 20)
                                                    {
                                                        $newtext = mb_wordwrap($text, $char, "<br>");
                                                        $arr = explode("<br>", $newtext);
                                                        return count($arr);
                                                    }

                                                    function mb_wordwrap($str, $width = 75, $break = "<br>", $cut = true)
                                                    {
                                                        $lines = explode($break, $str);
                                                        foreach ($lines as &$line) {
                                                            if (mb_strlen($line) <= $width)
                                                                continue;
                                                            $words = explode(' ', $line);
                                                            $line = '';
                                                            $actual = '';
                                                            foreach ($words as $word) {
                                                                if (mb_strlen($actual . $word) <= $width)
                                                                    $actual .= $word . ' ';
                                                                else {
                                                                    if ($actual != '')
                                                                        $line .= rtrim($actual) . $break;
                                                                    $actual = $word;
                                                                    if ($cut) {
                                                                        while (mb_strlen($actual) > $width) {
                                                                            $line .= mb_substr($actual, 0, $width) . $break;
                                                                            $actual = mb_substr($actual, $width);
                                                                        }
                                                                    }
                                                                    $actual .= ' ';
                                                                }
                                                            }
                                                            $line .= trim($actual);
                                                        }
                                                        return implode($break, $lines);
                                                    }

                                                    function pageSeparate($string, $separator, $perpage)
                                                    {
                                                        $remove_string_last_separator = rtrim($string, $separator);
                                                        $string_lines_array = explode($separator, $remove_string_last_separator);
                                                        return array_chunk($string_lines_array, $perpage);
                                                    }

                                                    function pageSeparateOnNl($string, $separator, $perpage)
                                                    {
                                                        $remove_string_last_separator = rtrim($string, $separator);
                                                        $string_lines_array = explode('<br>', $remove_string_last_separator);
                                                        $datas = array_chunk($string_lines_array, $perpage);
                                                        $output = [];
                                                        foreach ($datas as $key => $data) {
                                                            $output[$key] = implode('<br>', $data);
                                                        }
                                                        return $output;
                                                    }
                                                    function margePage(&$overAllPages, $landownerLineArr, $pageNumber)
                                                    {
                                                        foreach ($landownerLineArr as $ownerBlockLine) {
                                                            $overAllPages[$pageNumber][] = $ownerBlockLine;
                                                        }
                                                    }
                                                    ?>

                                                    <?php
                                                    foreach($batch_khotians as $rootPage => $aKhotian){
                                                    $jl_number = '';
                                                    $dcr_number = '';
                                                    $resa_no = '';
                                                    $owners = "";
                                                    $khotian = "";
                                                    $header_info = "";
                                                    $khotian_no = "";
                                                    $pages_number_array = array();
                                                    $owners = $aKhotian['owners'];
                                                    $khotian = $aKhotian['khotian'];
                                                    $header_info = $aKhotian['header_info'];
                                                    $khotian_no = $aKhotian['khotian_no'];
                                                    $totalEkor = null;
                                                    $ownerAngsho = [];
                                                    $totalEkorLocal = null;
                                                    $pageAngsho = 0;
                                                    $total_ongsho = 0;
                                                    $owner_data = '';
                                                    $owner_ongsho = '';
                                                    $address_line_num = 0;
                                                    $pre_parent_name = false;
                                                    $pre_address_only = false;
                                                    $pre_owner_address = false;
                                                    $pre_owner_address_holder = false;
                                                    $pre_owner_address_break = [];
                                                    $pre_owner_data = [];
                                                    $mokadoma_no = '';
                                                    $dhara_no = '';
                                                    $dhara_son = '';
                                                    $ownerRowId = 0;
                                                    $tmp = '';

                                                    foreach ($owners as $key => &$singleOwner) {
                                                        $tmpAddress = $singleOwner['owner_address'];
                                                        $tmpName = $singleOwner['owner_name'];
                                                        $tmpAddress = preg_replace("#<br\s?/?>#", "<br>", $tmpAddress);
                                                        $tmpName = preg_replace("#<br\s?/?>#", "<br>", $tmpName);
                                                        $tmpAddress = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $tmpAddress);
                                                        $tmpName = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $tmpName);
                                                        $tmpName = mb_wordwrap($tmpName, 34, '<br>', false);
                                                        $tmpAddress = mb_wordwrap($tmpAddress, 34, '<br>', false);
                                                        $tmpAddressLine = getLines($tmpAddress, 34, '<br>', false);
                                                        $tmp = $tmpAddress;
                                                        $singleOwner['address_line_num'] = $tmpAddressLine;
                                                        $singleOwner['owner_address'] = $tmpAddress;
                                                        $singleOwner['owner_name'] = $tmpName;
                                                        $tmpParentData = explode('<br>', $tmpAddress);
                                                        $singleOwner['parent_name'] = $tmpParentData[0];
                                                        unset($tmpParentData[0]);
                                                        $addressTMP = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', implode('<br>', $tmpParentData));
                                                        $addressTMP = preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $addressTMP); // remove leading multiple br
                                                        $singleOwner['address_only'] = $addressTMP;
                                                    }

                                                    $hasLine = [];
                                                    $ownerPageArr = [];
                                                    $lastOwnerAddress = null;
                                                    foreach ($owners as $key => $owner) {
                                                        $ownerCountLine = getLines($owner['owner_name'], 34, '<br>', false);
                                                        $address_entry = false;
                                                        $angshoBreak = 1;
                                                        if (empty($ownerRowId) && !empty($owner['id'])) {
                                                            $ownerRowId = $owner['id'];
                                                        }

                                                        if ($pre_address_only !== false) {
                                                            if ($pre_parent_name != $owner['parent_name']) {
                                                                if ($pre_address_only != $owner['address_only']) {
                                                                    $owner_data .= '<br>' . $pre_parent_name;
                                                                    $owner_data .= '<br>' . $pre_address_only;
                                                                    $isPrintedHr = false;
                                                                    if (!empty($pre_owner_data['owner_group_id']) && $pre_owner_data['owner_group_id'] != $owner['owner_group_id'] && !in_array($pre_owner_data['owner_group_id'], $hasLine)) {
                                                                        $hasLine[] = $pre_owner_data['owner_group_id'];
                                                                        $isPrintedHr = true;
                                                                        $owner_data .= '<hr class="hr"/>';
                                                                    }
                                                                    $owner_data .= '<br>' . $owner['owner_name'];
                                                                    $angshoBreak = getLines($pre_parent_name, 34, '<br>', false) + getLines($pre_address_only, 34, '<br>', false);
                                                                    $pre_owner_data = $owner;
                                                                    $pre_address_only = $owner['address_only'];
                                                                    $pre_parent_name = $owner['parent_name'];
                                                                    $address_entry = true;
                                                                } else {
                                                                    $owner_data .= '<br>' . $pre_parent_name;
                                                                    $owner_data .= '<br>' . $owner['owner_name'];
                                                                    $angshoBreak = getLines($pre_parent_name, 34, '<br>', false);
                                                                    $pre_parent_name = $owner['parent_name'];
                                                                    $address_entry = true;
                                                                }
                                                            } else {
                                                                $owner_data .= '<br>' . $owner['owner_name'];
                                                                $lastOwnerAddress = $owner['address_only'];
                                                            }
                                                        } else {
                                                            $pre_address_only = $owner['address_only'];
                                                            $pre_parent_name = $owner['parent_name'];
                                                            $owner_data .= $owner['owner_name'];
                                                            $pre_owner_address_holder = '';
                                                            $pre_owner_data = $owner;
                                                        }
                                                        if (empty($mokadoma_no) && !empty($owner['mokadoma_no'])) {
                                                            $mokadoma_no = $owner['mokadoma_no'];
                                                        }
                                                        if (empty($dhara_no) && !empty($owner['dhara_no'])) {
                                                            $dhara_no = $owner['dhara_no'];
                                                        }
                                                        if (empty($dhara_son) && !empty($owner['dhara_son'])) {
                                                            $dhara_son = $owner['dhara_son'];
                                                        }
                                                        if ($owner['owner_area'] == '1') {
                                                            $owner_area = '১.০০০';
                                                        } else {
                                                            $owner_area = explode('.', $owner['owner_area']);
                                                            if (isset($owner_area[1]) && strlen($owner_area[1]) == 1)
                                                                $owner_area = $owner['owner_area'] . '০০';
                                                            elseif (isset($owner_area[1]) && strlen($owner_area[1]) == 2)
                                                                $owner_area = $owner['owner_area'] . '০';
                                                            elseif (isset($owner_area[1]) && strlen($owner_area[1]) == 3)
                                                                $owner_area = $owner['owner_area'];
                                                            else
                                                                $owner_area = $owner['owner_area'];
                                                        }

                                                        if ($address_entry && isset($angshoBreak)) {
                                                            $owner_ongsho .= $lineBreak[$angshoBreak] . '<span class="paddTwo">' . $owner_area . '</span>' . '<br>' . $lineBreak[($ownerCountLine - 1)];
                                                        } else {
                                                            $owner_ongsho .= $owner_area . $lineBreak[($ownerCountLine - 1)] . '<br>';
                                                        }

                                                        $total_ongsho = $total_ongsho + $owner['owner_area'];
                                                    }

                                                    if ($pre_address_only !== false && empty($pre_address_only)) {
                                                        $pre_address_only = $lastOwnerAddress;
                                                    }
                                                    if ($pre_address_only !== false || !empty($pre_parent_name)) {
                                                        $owner_data .= '<br>' . $pre_parent_name;
                                                        $string = preg_replace('#(( ){0,}<br( {0,})(/{0,1})>){1,}$#i', '', $owner_data);
                                                        $owner_data = $string . '<br>' . preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $pre_address_only); // remove leading multiple br
                                                    }
                                                    $jl_number = '';
                                                    $dcr_number = '';
                                                    $resa_no = '';
                                                    $case_no = '';
                                                    $dag_no = '';
                                                    $krishi = '';
                                                    $non_krishi = '';
                                                    $total_dag_area_ekor = '';
                                                    $total_dag_area_shotangso = '';
                                                    $khotian_dag_portion = '';
                                                    $total_dag_portion_ekor = '';
                                                    $total_dag_portion_shotangso = '';
                                                    $remarks = '';
                                                    $total_khotian_dag_portion = 0;
                                                    $isSpecial = empty($khotian[0]['brs_khotian_entries']['is_special']) ? '' : $khotian[0]['brs_khotian_entries']['is_special'];
                                                    $computerCode = empty($khotian[0]['brs_khotian_entries']['computer_code']) ? '' : $khotian[0]['brs_khotian_entries']['computer_code'];
                                                    $dagsAreaByRows = null;

                                                    foreach ($khotian as $rowCnt => $row) {
                                                        $krishiLines = 0;
                                                        $okrishiLines = 0;
                                                        $dagParts = explode('/', $row['dag_number']);
                                                        $case_no = empty($row['namjari_case_no']) ? '' : $row['namjari_case_no'];
                                                        $resa_no = empty($row['resa_no']) ? '' : $row['resa_no'];
                                                        $dcr_number = empty($row['dcr_number']) ? '' : $row['dcr_number'];
                                                        $jl_number = empty($row['jl_number']) ? '' : $row['jl_number'];
                                                        if (!empty($dagParts[1])) {
                                                            $partOne = '<span class="dagUnderline">' . substr(trim($dagParts[1]), 0, 5) . '</span><br>';
                                                            $partTwo = substr(trim($dagParts[0]), 0, 5) . '<br>';

                                                            $dag_no .= $partOne . $partTwo;
                                                            $dagLine = 2; //wordwrap($row['dag_number'], 5, "<br>", true);
                                                        } else {
                                                            $dag_no .= substr(trim($row['dag_number']), 0, 5) . '<br>';
                                                            $dagLine = 1; //wordwrap($row['dag_number'], 5, "<br>", true);
                                                        }
                                                        if ($row['agricultural_use'] == 0 || $row['agricultural_use'] == '') {
                                                            $krishi .= '<br>';
                                                            $non_krishi .= mb_wordwrap($row['lt_name'], 13) . '<br>';
                                                            $okrishiLines = getLines($row['lt_name'], 13);
                                                        } else {
                                                            $krishi .= mb_wordwrap($row['lt_name'], 13) . '<br>';
                                                            $non_krishi .= '<br>';
                                                            $krishiLines = getLines($row['lt_name'], 13);
                                                        }
                                                        $dag_area = explode('.', $row['total_dag_area']);

                                                        if ($row['khotian_dag_portion'] != 1) {
                                                            $total_dag_area_ekor .= ($dag_area[0] > 0 ? $dag_area[0] : '') . '<br>'; // if 0 show empty
                                                            if (isset($dag_area[1])) {
                                                                if (strlen($dag_area[1]) == 1) {
                                                                    $total_dag_area_shotangso .= $dag_area[1] . '০০০' . '<br>';
                                                                } elseif (strlen($dag_area[1]) == 2) {
                                                                    $total_dag_area_shotangso .= $dag_area[1] . '০০' . '<br>';
                                                                } elseif (strlen($dag_area[1]) == 3) {
                                                                    $total_dag_area_shotangso .= $dag_area[1] . '০' . '<br>';
                                                                } else {
                                                                    $total_dag_area_shotangso .= $dag_area[1] . '<br>';
                                                                }
                                                            } else {
                                                                if (!empty($dag_area[0])) {
                                                                    $total_dag_area_shotangso .= '0000<br>';
                                                                }
                                                            }
                                                        } else {
                                                            $total_dag_area_ekor .= '<br>';
                                                            $total_dag_area_shotangso .= '<br>';
                                                        }

                                                        if ($row['khotian_dag_portion'] == '1') {
                                                            $khotian_dag_portion .= '<span class="oneOne">1.000</span>' . '<br>';
                                                        } else {
                                                            $khotian_dag_portion_arr = explode('.', $row['khotian_dag_portion']);
                                                            if (isset($khotian_dag_portion_arr[1]) && strlen($khotian_dag_portion_arr[1]) == 1)
                                                                $khotian_dag_portion .= $row['khotian_dag_portion'] . '00' . '<br>';
                                                            elseif (isset($khotian_dag_portion_arr[1]) && strlen($khotian_dag_portion_arr[1]) == 2)
                                                                $khotian_dag_portion .= $row['khotian_dag_portion'] . '0' . '<br>';
                                                            else
                                                                $khotian_dag_portion .= $row['khotian_dag_portion'] . '<br>';
                                                        }

                                                        $dag_portion = explode('.', $row['khotian_dag_area']);
                                                        $dagsAreaByRows .= $row['khotian_dag_area'] . '<br>';
                                                        $total_dag_portion_ekor .= ($dag_portion[0] > 0 ? $dag_portion[0] : '') . '<br>'; // if 0 show empty
                                                        if (isset($dag_portion[1])) {
                                                            if (strlen($dag_portion[1]) == 1) {
                                                                $total_dag_portion_shotangso .= $dag_portion[1] . '০০০' . '<br>';
                                                            } elseif (strlen($dag_portion[1]) == 2) {
                                                                $total_dag_portion_shotangso .= $dag_portion[1] . '০০' . '<br>';
                                                            } elseif (strlen($dag_portion[1]) == 3) {
                                                                $total_dag_portion_shotangso .= $dag_portion[1] . '০' . '<br>';
                                                            } else {
                                                                $total_dag_portion_shotangso .= $dag_portion[1] . '<br>';
                                                            }
                                                        } else {
                                                            $total_dag_portion_shotangso .= '0000<br>';
                                                        }
                                                        $remarkTextWithoutLatBr = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $row['remarks']);
                                                        $tmpTxt = preg_replace("#<br\s?/?>#", "<br>", $remarkTextWithoutLatBr);
                                                        $remarkTxt = mb_wordwrap($tmpTxt, 28, "<br>");
                                                        $remarks .= $remarkTxt . '<br>';
                                                        $remarkSize = getLines($remarkTxt, 28);
                                                        $size = $remarkSize > $okrishiLines ? $remarkSize : $okrishiLines;
                                                        $size = $size > $krishiLines ? $size : $krishiLines;
                                                        $size = $size > $dagLine ? $size : $dagLine;
                                                        $total_khotian_dag_portion += $row['khotian_dag_area'];

                                                        if ($size > 1) {

                                                            if ($remarkSize < $size) {
                                                                $remarks .= $lineBreak[$size - $remarkSize];
                                                            }
                                                            $dagLineAppendNumber = $size - $dagLine;
                                                            $dag_no .= $lineBreak[$dagLineAppendNumber];
                                                            $krishi .= $lineBreak[$size - ($krishiLines > 0 ? $krishiLines : 1)];
                                                            $non_krishi .= $lineBreak[$size - ($okrishiLines > 0 ? $okrishiLines : 1)];
                                                            $total_dag_area_shotangso .= $lineBreak[$size - 1];
                                                            $total_dag_area_ekor .= $lineBreak[$size - 1];
                                                            $total_dag_portion_ekor .= $lineBreak[$size - 1];
                                                            $khotian_dag_portion .= $lineBreak[$size - 1];
                                                            $total_dag_portion_shotangso .= $lineBreak[$size - 1];
                                                            $dagsAreaByRows .= $lineBreak[$size - 1];
                                                        }
                                                    }

                                                    $total_khotian_dag_portion = explode('.', $total_khotian_dag_portion);
                                                    $owner_data = str_replace('<br/>', '<br>', $owner_data);
                                                    $owner_data_by_land_owner = explode('<end/>', $owner_data);
                                                    $remove_string_last_separator = rtrim($owner_ongsho, '<br>');
                                                    $owner_ongsho_pages = explode('<br>', $remove_string_last_separator);
                                                    $ownerAngsho = [];
                                                    $pageAngsho = 0;
                                                    $ownerAngshoTrackerKey = 0;
                                                    $overAllPages = [];
                                                    $currentPage = 0;
                                                    foreach ($owner_data_by_land_owner as $LKey => $landowner) {
                                                        $landowner = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $landowner);
                                                        $landownerLineArr = explode('<br>', $landowner);
                                                        $currentPageSize = count($landownerLineArr);
                                                        if (empty($overAllPages[$currentPage])) {
                                                            if ($currentPageSize > $per_page_line_number) {
                                                                $tmpKey = 1;
                                                                foreach ($landownerLineArr as $key => $item) {
                                                                    $overAllPages[$currentPage][] = $item;
                                                                    $ownerAngsho[] = empty($owner_ongsho_pages[$ownerAngshoTrackerKey]) ? '' : $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                                    $ownerAngshoTrackerKey++;
                                                                    if (($tmpKey % ($per_page_line_number) == 0)) {
                                                                        $currentPage++;
                                                                    }
                                                                    $tmpKey++;
                                                                }
                                                            } else {
                                                                $overAllPages[$currentPage] = $landownerLineArr;
                                                                for ($ownerAngshoTrackerKey; $ownerAngshoTrackerKey < $currentPageSize; $ownerAngshoTrackerKey++) {
                                                                    $ownerAngsho[] = empty($owner_ongsho_pages[$ownerAngshoTrackerKey]) ? '' : $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                                }
                                                            }

                                                        } else {
                                                            $currentPageSize = count($overAllPages[$currentPage]);
                                                            $newOwnerBlockSize = count($landownerLineArr);
                                                            $totalElements = $currentPageSize + $newOwnerBlockSize;
                                                            if ($totalElements > $per_page_line_number) {
                                                                for ($currentPageSize; $currentPageSize < $per_page_line_number; $currentPageSize++) {
                                                                    $overAllPages[$currentPage][] = '<br>';
                                                                    $ownerAngsho[] = '<br>';
                                                                }
                                                                $currentPage++;
                                                                foreach ($landownerLineArr as $tmpKey => $ownerBlockLine) {
                                                                    $overAllPages[$currentPage][] = $ownerBlockLine;
                                                                    $ownerAngsho[] = $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                                    $ownerAngshoTrackerKey++;
                                                                }
                                                            } else {
                                                                foreach ($landownerLineArr as $tmpKey => $ownerBlockLine) {
                                                                    $overAllPages[$currentPage][] = $ownerBlockLine;
                                                                    $ownerAngsho[] = $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                                                    $ownerAngshoTrackerKey++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    $owner_data_pages = $overAllPages;
                                                    array_push($pages_number_array, count($owner_data_pages));
                                                    $owner_ongsho_pages = array_chunk($ownerAngsho, $per_page_line_number);
                                                    array_push($pages_number_array, count($owner_ongsho_pages));
                                                    $secondPartExtraLine = 1;
                                                    $dag_no_pages = pageSeparateOnNl($dag_no, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                    array_push($pages_number_array, count($dag_no_pages));
                                                    $krishi_pages = pageSeparateOnNl($krishi, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                    array_push($pages_number_array, count($krishi_pages));
                                                    $non_krishi_pages = pageSeparateOnNl($non_krishi, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                    array_push($pages_number_array, count($non_krishi_pages));
                                                    $total_dag_area_ekor_pages = pageSeparateOnNl($total_dag_area_ekor, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                    array_push($pages_number_array, count($total_dag_area_ekor_pages));
                                                    $total_dag_area_shotangso_pages = pageSeparateOnNl($total_dag_area_shotangso, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                    array_push($pages_number_array, count($total_dag_area_shotangso_pages));
                                                    $khotian_dag_portion_pages = pageSeparateOnNl($khotian_dag_portion, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                    array_push($pages_number_array, count($khotian_dag_portion_pages));
                                                    $total_dag_portion_ekor_pages = pageSeparateOnNl($total_dag_portion_ekor, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                    array_push($pages_number_array, count($total_dag_portion_ekor_pages));
                                                    $total_dag_portion_shotangso_pages = pageSeparateOnNl($total_dag_portion_shotangso, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                    array_push($pages_number_array, count($total_dag_portion_shotangso_pages));
                                                    $remarks_pages = pageSeparate($remarks, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                    array_push($pages_number_array, count($remarks_pages));
                                                    $dagsAreaByRowsPages = pageSeparate($dagsAreaByRows, '<br>', $per_page_line_number + $secondPartExtraLine);
                                                    array_push($pages_number_array, count($dagsAreaByRowsPages));
                                                    $countOfLoop = max($pages_number_array);
                                                    if(isset($owners) && isset($khotian))
                                                    {
                                                    for ($i = 0; $i < $countOfLoop; $i++) { ?>
                                                    <?php
                                                    if (isset($dagsAreaByRowsPages[$i])) {
                                                        foreach ($dagsAreaByRowsPages[$i] as $ekor) {
                                                            if (is_numeric($ekor)) {
                                                                $totalEkor += $ekor;
                                                            }
                                                        }
                                                    }
                                                    $totalEkorLocal = explode('.', $totalEkor);
                                                    if (isset($owner_ongsho_pages[$i])) {
                                                        foreach ($owner_ongsho_pages[$i] as $angshoFragment) {
                                                            $angshoFragment = bn2en($angshoFragment);
                                                            $angshoFragmentNumber = filter_var($angshoFragment, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                                                            if (is_numeric($angshoFragmentNumber)) {
                                                                $pageAngsho += $angshoFragmentNumber;
                                                            }
                                                        }
                                                    }
                                                    $computerCodeLatest = '';
                                                    $timeObj = \Illuminate\Support\Carbon::now();
                                                    $timeObj->modify('+14 minutes');
                                                    $datePartOne = $timeObj->format('md'); // month and day
                                                    $datePartTwo = $timeObj->format('Y');
                                                    $time = $timeObj->format('His');
                                                    $randomNumber = rand(10, 99);
                                                    $gel = substr($header_info['dglr_code'], -3);
                                                    if (empty($gel)) {
                                                        $gel = '000';
                                                    } elseif (strlen($gel) == 1) {
                                                        $gel = '00' . $gel;
                                                    } elseif (strlen($gel) == 2) {
                                                        $gel = '0' . $gel;
                                                    }
                                                    $computerCodeLatest = $randomNumber . $datePartOne . $userCode . $time . $gel . $formatedIpPartOne . '-' . $ownerRowId . $datePartTwo . $formatedIpPartTwo;
                                                    ?>
                                                    <div style="position: relative">
                                                        <?php if(!empty($application->status) && $application->status == 2){ ?>
                                                        <div
                                                            style='width: 80%; position: absolute; top: 300px; left: 10%; color: #00000030; font-size: 3em; display: block; font-weight: bolder; '>
                                                            <div style='position: relative'><span
                                                                    style='float: left'>সরকারি ব্যবহারের জন্য</span><span
                                                                    style='float: right'>সরকারি ব্যবহারের জন্য</span></div>
                                                        </div>
                                                        <?php } ?>
                                                        <table class="htable" border="0" style="margin-top: 2px;">
                                                            <tr>
                                                                <td colspan="4" align="left" style="border:1px">বাংলাদেশ ফর্ম নং ৫৪৬২
                                                                    (সংশোধিত)&nbsp;
                                                                </td>
                                                                <td colspan="6" align="center" style="border:1px;">
                                                                    <h2 style="padding-bottom: 0px; margin-top: 15px; margin-left: -85px; font-size: 29px;">
                                                                        খতিয়ান নং- <span
                                                                            class=""><?php echo eng_to_bangla_code($record->khotian_number); ?></span>
                                                                    </h2>
                                                                </td>
                                                                <td colspan="4"
                                                                    style="font-size: 15px; border:0px;text-align: right;padding-right: 6px;vertical-align: middle;"
                                                                    class="nikosh">

                                                                    <?= __('নামজারি মামলা  <span style="font-size: 15px;">নংঃ</span> ' . $case_no)?>
                                                                    <p style="font-size: 15px;padding-left: 20px"> <?= __('ডি সি আর   <span style="font-size: 15px;">নংঃ</span> ' . eng_to_bangla_code($dcr_number) ?? '')?>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="border:1px; font-size: 16px; padding-bottom: 15px;">
                                                                    {{-- TODO: changed here arman  --}}
                                                                    বিভাগঃ <?php echo $header_info['name_bn'] ?? $header_info['division_name'];  ?></td>
                                                                <td colspan="2" style="border:1px;  font-size: 16px; padding-bottom: 15px;">
                                                                    জেলাঃ <?php echo $header_info['district_name']; ?></td>
                                                                <td colspan="3"
                                                                    style="border:1px;  font-size: 16px; padding-bottom: 15px; max-width: 120px;">
                                                                    উপজেলা/থানাঃ <?php echo $header_info['upazila_name']; ?></td>
                                                                <td colspan="3"
                                                                    style="border:1px;  font-size: 16px; padding-bottom: 15px; min-width: 170px;">
                                                                    মৌজাঃ <?php echo $header_info['name_bd']; ?></td>
                                                                <td colspan="2" style="border:1px; padding-bottom: 15px;  font-size: 16px;">
                                                                    জে, এল,
                                                                    নংঃ <?php echo eng_to_bangla_code($jl_number); ?></td>
                                                                <td colspan="2" style="border:0px;  font-size: 15px; padding-bottom: 15px;">
                                                                    রেঃ সাঃ
                                                                    নংঃ <?= !empty($resa_no) ? eng_to_bangla_code($resa_no) : '&nbsp;' ?> </td>
                                                            </tr>
                                                        </table>

                                                        <table class="table" border="0" cellpadding="0" cellspacing="0" class="pp"
                                                               id="table_<?= $i ?>"
                                                               style="vertical-align:top; height: 17cm; margin-bottom: 0px;">
                                                            <thead>
                                                            <tr bgcolor="#EFF2F7" style="vertical-align:top;">
                                                                <td colspan="1"
                                                                    style="width: 232px; text-align: center;vertical-align:middle;border-left:1px solid;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                    মালিক, অকৃষি প্রজা বা ইজারাদারের<br>
                                                                    নাম ও ঠিকানা<br></td>
                                                                <td colspan="1"
                                                                    style="width: 49px; text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                    অংশ
                                                                    &nbsp;
                                                                </td>
                                                                <td colspan="1"
                                                                    style="width: 80px; text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                    রাজস্ব<br></td>
                                                                <td colspan="1"
                                                                    style="width: 46px;text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                    দাগ নং<br></td>
                                                                <td colspan="2" rowspan="1"
                                                                    style="text-align: center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                                                                    width="98px">
                                                                    জমির শ্রেণী
                                                                </td>
                                                                <td colspan="2" rowspan="1"
                                                                    style="text-align:center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                                                                    width="87px">
                                                                    দাগের মোট পরিমাণ
                                                                </td>
                                                                <td colspan="1"
                                                                    style="width: 150px;font-size:11px; text-align: center; vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                    দাগের মধ্যে
                                                                    অত্র <br>খতিয়ানের অংশ
                                                                </td>
                                                                <td colspan="2" rowspan="1"
                                                                    style="font-size: 11px; text-align:center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                                                                    width="87px">
                                                                    অংশানুযায়ী জমির<br>
                                                                    পরিমাণ
                                                                </td>
                                                                <td colspan="1"
                                                                    style="width: 172px;text-align: center; vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                                                                    দখল বিষয়ক বা অন্যান্য<br>
                                                                    বিশেষ মন্তব্য<br></td>
                                                            </tr>
                                                            <tr bgcolor="#b0c4de">
                                                                <td colspan="1" rowspan="2"
                                                                    style="width: 212px;text-align: center;vertical-align:middle;border-top:1px solid;border-right:1px solid;border-left:1px solid;  border-bottom: 1px solid">
                                                                    &nbsp;১
                                                                </td>
                                                                <td colspan="1" rowspan="2"
                                                                    style="width: 49px;text-align: center;  vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                                    ২
                                                                </td>
                                                                <td colspan="1" rowspan="2"
                                                                    style="width: 38px;text-align: center;  vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                                    ৩
                                                                </td>
                                                                <td colspan="1" rowspan="2"
                                                                    style="width: 77px;text-align: center;  vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                                    ৪
                                                                </td>
                                                                <td style="width: 41.57px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;"
                                                                >
                                                                    কৃষি<br></td>
                                                                <td style="width: 45.35px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                                    অকৃষি<br></td>
                                                                <td
                                                                    style="width: 41.57px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                                    একর<br></td>
                                                                <td
                                                                    style="width: 45.35px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                                    শতাংশ<br></td>
                                                                <td colspan="1" rowspan="2"
                                                                    style="width: 70px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                                    ৭
                                                                </td>
                                                                <td
                                                                    style="width: 41.57px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                                    একর<br></td>
                                                                <td
                                                                    style="width: 45.35px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
                                                                    শতাংশ<br></td>
                                                                <td colspan="1" rowspan="2"
                                                                    style="width: 172px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;  border-bottom: 1px solid">
                                                                    ৯
                                                                </td>
                                                            </tr>
                                                            <tr bgcolor="#b0c4de" style="border: none">
                                                                <td width="45px"
                                                                    style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">
                                                                    ৫ (ক)
                                                                </td>
                                                                <td width="45px"
                                                                    style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">
                                                                    ৫(খ)
                                                                </td>
                                                                <td width="41.57px"
                                                                    style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">
                                                                    ৬ (ক)
                                                                </td>
                                                                <td width="45.35px"
                                                                    style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">
                                                                    ৬ (খ)
                                                                </td>
                                                                <td width="41.57px"
                                                                    style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">
                                                                    ৮ (ক)
                                                                </td>
                                                                <td width="45.35px"
                                                                    style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">
                                                                    ৮ (খ)
                                                                </td>
                                                            </tr>
                                                            </thead>
                                                            <tbody style="">


                                                            <tr class="custom-border">
                                                                <td style="width: 212px; border-top: none; text-align: left; <?= $border_left ?> <?= $border_right ?> padding-left:7px;"
                                                                    valign="top">
                                                                    <?php  if( $i == 0 && $khotian_no != 1 ): ?>
                                                                    <p style="padding: 2px 0px 0px 0px;margin: 0px;">মালিক</p>
                                                                    <?php endif; ?>
                                                                    <?php  if( $i == 0 && $khotian_no == 1 ): ?>
                                                                    <p style="padding: 2px 0px 0px 0px;margin: 0px;"><br></p>
                                                                    <?php endif; ?>
                                                                    <?php
                                                                    if (isset($owner_data_pages[$i])) {
                                                                        echo implode('<br>', $owner_data_pages[$i]);
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="border-top: none; text-align: left; padding-left: 4px;vertical-align:top;<?= $border_right ?>">
                                                                    <?php  if( $i == 0): ?>
                                                                    <p style="padding: 2px 0px 0px 0px;margin: 0px;">&nbsp;</p>
                                                                    <?php endif; ?>
                                                                    <?php
                                                                    if (isset($owner_data_pages[$i])) {
                                                                        echo eng_to_bangla_code(implode('<br>', $owner_ongsho_pages[$i]));
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>"> <?php

                                                                    if ($i == 0 && isset($khotian[0]['revenue'])) {
                                                                        echo '<br>' . eng_to_bangla_code($khotian[0]['revenue']) . '/-';
                                                                    }
                                                                    ?> </td>
                                                                <td style="padding-left: 4px; border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                    <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                    <?php
                                                                    if (isset($dag_no_pages[$i])) {
                                                                        echo eng_to_bangla_code($dag_no_pages[$i]);
                                                                    }
                                                                    ?>
                                                                </td>

                                                                <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>white-space: normal;">
                                                                    <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                    <?php
                                                                    if (isset($krishi_pages[$i])) {
                                                                        echo $krishi_pages[$i];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="border-top: none; text-align: center;vertical-align:top; <?= $border_right ?> white-space: normal;">
                                                                    <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                    <?php
                                                                    if (isset($non_krishi_pages[$i])) {
                                                                        echo $non_krishi_pages[$i];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                    <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                    <?php
                                                                    if (isset($total_dag_area_ekor_pages[$i])) {
                                                                        echo eng_to_bangla_code($total_dag_area_ekor_pages[$i]);
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                    <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                    <?php
                                                                    if (isset($total_dag_area_shotangso_pages[$i])) {
                                                                        echo eng_to_bangla_code($total_dag_area_shotangso_pages[$i]);
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                    <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                    <?php
                                                                    if (isset($khotian_dag_portion_pages[$i])) {
                                                                        echo eng_to_bangla_code($khotian_dag_portion_pages[$i]);
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                    <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                    <?php
                                                                    if (isset($total_dag_portion_ekor_pages[$i])) {
                                                                        echo eng_to_bangla_code($total_dag_portion_ekor_pages[$i]);
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="border-top: none; text-align: center;vertical-align:top;<?= $border_right ?>">
                                                                    <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                    <?php
                                                                    if (isset($total_dag_portion_shotangso_pages[$i])) {
                                                                        echo eng_to_bangla_code($total_dag_portion_shotangso_pages[$i]);
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="border-top: none; text-align: center;vertical-align:top;word-break:break-all; <?= $border_right ?>">

                                                                    <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                                                                    <pre style="
                                                        text-align: center;
                                                        border: none;
                                                        padding: inherit;
                                                        font-size: inherit;
                                                        line-height: inherit;
                                                        margin: 0px;
                                                        color: inherit;
                                                        background-color: inherit;
                                                        border-radius: inherit;
                                                        font-size: 13px;
                                                        font-family:kalpurush;
                                                    "><?php
                                                                        if (isset($remarks_pages[$i])) {
                                                                            echo implode('<br>', $remarks_pages[$i]);
                                                                        }
                                                                        ?></pre>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr bgcolor="#CCCCCC" style="height: 1.2cm">
                                                                <td rowspan="1"
                                                                    style="font-size:12px; <?= $border_left ?> <?= $border_right ?> <?= $border_top ?> padding-left:5px;border-bottom:1px solid; font-style: italic">
                                                                    <?= !empty($khotian[0]['dhara_no']) ? eng_to_bangla_code($khotian[0]['dhara_no']) . ' ' : '..........' ?>
                                                                    ধারামতে নোট বা পরিবর্তন
                                                                    <b>মায় মোকদ্দমা
                                                                        নং</b><?= !empty($khotian[0]['mokoddoma_no']) ? ' ' . eng_to_bangla_code($khotian[0]['mokoddoma_no']) . ' ' : '.........' ?>
                                                                    এবং
                                                                    <b>সন</b><?= !empty($khotian[0]['dhara_year']) ? ' ' . eng_to_bangla_code($khotian[0]['dhara_year']) : '.........' ?>
                                                                </td>
                                                                <td style="text-align:center;<?= $border_right ?> <?= $border_top ?> border-bottom:1px solid;"><?php
                                                                    echo eng_to_bangla_code(number_format($pageAngsho, 3));
                                                                    ?></td>
                                                                <td style="font-size: 15px; text-align: right;vertical-align:middle;<?= $border_right ?> <?= $border_top ?> border-bottom:1px solid;padding-right:5px;"
                                                                    colspan="7">
                                                                    <span style="float: right;"> মোট জমিঃ</span>
                                                                </td>
                                                                <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid; text-align: center;"
                                                                    valign="top">
                                                                    <?php
                                                                    if (isset($totalEkorLocal[0])) {
                                                                        echo eng_to_bangla_code($totalEkorLocal[0]);
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid; text-align: left;"
                                                                    valign="top">
                                                                    <?php
                                                                    $totalEkorLocal[2] = '';
                                                                    if (isset($totalEkorLocal[1])) {
                                                                        if (isset($totalEkorLocal[1]) && strlen($totalEkorLocal[1]) == 1) {
                                                                            $totalEkorLocal[2] .= $totalEkorLocal[1] . '000'; //added (arman)
                                                                            $totalEkorLocal[1] .= '০০০';
                                                                        } elseif (isset($totalEkorLocal[1]) && strlen($totalEkorLocal[1]) == 2) {
                                                                            $totalEkorLocal[2] .= $totalEkorLocal[1] . '00'; //added (arman)

                                                                            $totalEkorLocal[1] .= '০০';
                                                                        } elseif (isset($totalEkorLocal[1]) && strlen($totalEkorLocal[1]) == 3) {
                                                                            $totalEkorLocal[2] .= $totalEkorLocal[1] . '0'; //added (arman)
                                                                            $totalEkorLocal[1] .= '০';
                                                                        }
                                                                        echo eng_to_bangla_code($totalEkorLocal[1]);
                                                                    } else {
                                                                        echo eng_to_bangla_code('0000');
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid;">
                                                                    <?php
                                                                    $totalValue = isset($totalEkorLocal[0]) ? $totalEkorLocal[0] : '0';
                                                                    $totalValue .= isset($totalEkorLocal[2]) ? '.' . $totalEkorLocal[2] : '0000';
                                                                    echo 'কথায়:' . \App\Helpers\Classes\NumberToBanglaWord::numToWord(isset($totalEkor) ? (float)$totalEkor : 0) . 'একর মাত্র ।';
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6"
                                                                    style="text-align: right; vertical-align: middle"><?= !empty($computerCodeLatest) ? 'কম্পিউটার কোডঃ ' . eng_to_bangla_code($computerCodeLatest) : '&nbsp' ?></td>
                                                            </tr>
                                                            <tr style="border: none;">
                                                                <td colspan="6" style="border: none;">&nbsp;</td>
                                                            </tr>
                                                            @if(isset($application) && !empty($application->applicant_name))
                                                                <tr style="border: none; display: none;">
                                                                    <td colspan="6" style="border: none;">আবেদনকারীর
                                                                        নাম: {{$application->applicant_name}} |
                                                                        আবেদন নং
                                                                        - {{eng_to_bangla_code($application->application_display_code)}}</td>
                                                                    <td colspan="6" style="border: none;">&nbsp;</td>
                                                                </tr>
                                                            @endif
                                                            </tfoot>
                                                        </table>

                                                        @if ($isAclandUser)
                                                            <table class="d" style='width: 1090px; margin: 0 auto;text-align:center'>
                                                                <tr style='line-height:100px;'>
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদন যোগ্য
                                                                    </td>
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদন যোগ্য
                                                                    </td>
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">মঞ্জর</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-family: nikoshBAN;">
                                                                        <?php echo eng_to_bangla_code($khotian[0]['signature_one_date']); ?>
                                                                        <br>
                                                                        <?php echo '(' . $khotian[0]['signature_one_name'] . ')'; ?> <br>
                                                                        {{ !empty($designations[$khotian[0]['signature_one_designation']]) ? $designations[$khotian[0]['signature_one_designation']]: $khotian[0]['signature_one_designation'] }}
                                                                        <br>
                                                                        <?php echo 'উপজেলা ভূমি অফিস'; ?> <br>
                                                                        {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}
                                                                    </td>
                                                                    <td style="font-family: nikoshBAN;">
                                                                        <?php echo eng_to_bangla_code($khotian[0]['signature_two_date']); ?>
                                                                        <br>
                                                                        <?php echo '(' . $khotian[0]['signature_two_name'] . ')'; ?> <br>
                                                                        <?php echo !empty($designations[$khotian[0]['signature_two_designation']]) ? $designations[$khotian[0]['signature_two_designation']] : $khotian[0]['signature_two_designation']; ?>
                                                                        <br>
                                                                        <?php echo 'উপজেলা ভূমি অফিস'; ?> <br>
                                                                        {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}
                                                                    </td>
                                                                    <td style="font-family: nikoshBAN;">
                                                                        <?php echo eng_to_bangla_code($khotian[0]['signature_three_date']); ?>
                                                                        <br>
                                                                        <?php echo '(' . $khotian[0]['signature_three_name'] . ')'; ?> <br>
                                                                        <?php echo !empty($designations[$khotian[0]['signature_three_designation']]) ? $designations[$khotian[0]['signature_three_designation']] : $khotian[0]['signature_three_designation'] ?>
                                                                        <br>
                                                                        <?php echo 'উপজেলা ভূমি অফিস'; ?> <br>
                                                                        {!! trim($header_info['upazila_name']) . ',' . trim($header_info['district_name']) !!}
                                                                    </td>
                                                                </tr>
                                                                {{--<tr>
                                                                    <td><img src="<?php echo '/storage/qr/'. $qr_code; ?>"
                                                                             style="margin-left:132% " width="140" height="140"/></td>
                                                                </tr>--}}
                                                            </table>
                                                        @elseif (!$isAclandUser)
                                                            <table class="d" style='width: 1090px; margin:0 auto'>
                                                                <tr style='line-height:100px;text-align:center'>
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">নকলকারী</td>
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">যাচাইকারী</td>
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">তুলনাকারী</td>
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদনকারী
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" rowspan="3" style="vertical-align: middle;"><img
                                                                            src="<?php echo '/storage/qr/'. $qr_code; ?>"
                                                                            style="margin-left:40% " width="140" height="140"/></td>

                                                                </tr>
                                                            </table>
                                                        @endif
                                                    </div>
                                                    @if ($i !== $countOfLoop)

                                                        <div style="page-break-after: always;"></div>
                                                    @endif

                                                    <?php
                                                    }
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <div class="alert alert-warning alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                                aria-hidden="true"></button>
                                                        <strong>Warning!</strong> Owner not Found.
                                                    </div>
                                                    <?php
                                                    }
                                                    }

                                                    if($print_type == 1):
                                                    ?>
                                                    <style>
                                                        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th {
                                                            border-top: none;
                                                        }
                                                    </style>
                                                    <?php
                                                    endif;
                                                    ?>
                                                    <style>
                                                        html, body, div {
                                                            font-family: kalpurush;
                                                        }

                                                        .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                                            padding: 2px;
                                                            vertical-align: middle;
                                                        }

                                                        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                                            padding: 2px;
                                                        }

                                                        @page {
                                                            size: A4 landscape;
                                                            margin-left: 3.5cm;
                                                            margin-top: 1cm;
                                                            margin-bottom: 0px;
                                                        }

                                                        .oneOne {
                                                            padding-left: 1.5px;
                                                        }

                                                        .dagUnderline {
                                                            border-bottom: 1px solid;
                                                        }

                                                        .table > tbody > tr > td {
                                                            padding-top: 0px !important;
                                                        }

                                                        .paddTwo {
                                                            padding: 0px 0px 0px 0px;
                                                        }

                                                        hr {
                                                            margin: 0px;
                                                            padding: 0px 0px 2px 0px;
                                                            border-top: 1px solid #323232;
                                                            width: 97%;
                                                            display: inline-block;
                                                        }

                                                        hr:first-child {
                                                            margin-top: 2px !important;
                                                            padding-bottom: 0px !important;
                                                        }

                                                        /* TODO: added (arman) */
                                                        .d {
                                                            table-layout: fixed;
                                                            width: 100%;
                                                        }


                                                        /* TODO: added for image slider start*/
                                                        @import "lesshat";

                                                        .ba-slider {
                                                            position: relative;
                                                            overflow: hidden;
                                                        }

                                                        .ba-slider iframe {
                                                            width: 100%;
                                                            display: block;
                                                            height: 100%;
                                                            pointer-events: none;
                                                        }

                                                        .resize {
                                                            position: absolute;
                                                            top: 69px;
                                                            left: 0;
                                                            height: 100%;
                                                            width: 50%;
                                                            overflow: auto;
                                                        }

                                                        ::-webkit-scrollbar {
                                                            width: 10px;
                                                        }

                                                        .handle {
                                                            position: absolute;
                                                            left: 50%;
                                                            top: 69px;
                                                            bottom: 0;
                                                            width: 4px;
                                                            margin-left: -2px;

                                                            background: rgba(0, 0, 0, .5);
                                                            cursor: ew-resize;
                                                        }

                                                        .handle:after {
                                                            position: absolute;
                                                            top: 27%;
                                                            width: 43px;
                                                            height: 44px;
                                                            margin: -32px 0 0 -20px;

                                                            content: '\21d4';
                                                            color: white;
                                                            font-weight: bold;
                                                            font-size: 36px;
                                                            text-align: center;
                                                            line-height: 44px;

                                                            background: #760eca;
                                                            border: 1px solid #ecedf1;
                                                            border-radius: 50%;
                                                            transition: all 0.3s ease;
                                                            box-shadow: 0 2px 6px rgba(0, 0, 0, .3),
                                                            inset 0 2px 0 rgba(255, 255, 255, .5),
                                                            inset 0 60px 50px -30px #760eca;
                                                        }

                                                        .draggable:after {
                                                            width: 48px;
                                                            height: 48px;
                                                            margin: -24px 0 0 -24px;
                                                            line-height: 48px;
                                                            font-size: 30px;
                                                        }

                                                        /* TODO: added for image slider end*/

                                                    </style>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($record->scan_copy)
                                        <div class="resize" style="background: white">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <img style="" src="{{ asset("storage/".$record->scan_copy)}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <span class="handle"></span>
                                    @endif
                                </div>
                            @endif
                        @endif


                        {{-- Muted Khotian Area --}}
                        <div class="row mt-5">
                            <div class="col-md-12">
                                @if($khotian[0]['stage'] == \Modules\Khotian\App\Models\MutedKhotian::STAGE_WRITER)

                                    {{--<form action="#">
                                        <textarea required class="form-control" name="writer_remark"
                                                  id="writer_remark" rows="5"
                                                  placeholder="{{__('আপনার মতামত প্রদান করুন')}}"></textarea>

                    <button type="button" id="send_to_compare"
                            data-action="{{ route('admin.khotians.compare.store', [$khotian[0]['id'], $khotian[0]['khotian_number']]) }}"
                            class="btn btn-success pull-right">
                        প্রেরণ করুন
                    </button>
                </form>--}}
                                @elseif($khotian[0]['stage'] == \Modules\Khotian\App\Models\MutedKhotian::STAGE_COMPARE)
                                    <form action="#">
                                        <textarea required class="form-control" name="compare_remark"
                                                  id="compare_remark" rows="5"
                                                  placeholder="{{__('আপনার মতামত প্রদান করুন')}}"></textarea>

                                        <button type="button" id="compare_to_approver"
                                                data-action="{{ route('admin.khotians.compare.store', [$khotian[0]['id'], $khotian[0]['khotian_number']]) }}"
                                                class="btn btn-success pull-right ml-5">প্রেরণ করুন
                                        </button>
                                        <button type="button" id="compare_to_writer"
                                                data-action="{{ route('admin.khotians.compare.return', [$khotian[0]['id'], $khotian[0]['khotian_number']]) }}"
                                                class="btn btn-warning pull-right">ফেরত পাঠান
                                        </button>
                                    </form>
                                @elseif($khotian[0]['stage'] == \Modules\Khotian\App\Models\MutedKhotian::STAGE_APPROVE)
                                    <form action="#">
                                        <textarea required class="form-control mb-1" name="approve_remark"
                                                  id="approve_remark" rows="5"
                                                  placeholder="{{__('আপনার মতামত প্রদান করুন')}}"></textarea>

                                        <button type="button" id="approve"
                                                data-action="{{ route('admin.khotians.approve.store', [$khotian[0]['id'], $khotian[0]['khotian_number']]) }}"
                                                class="btn btn-success pull-right ml-5">অনুমোদন করুন
                                        </button>
                                        <button type="button" id="approve_return"
                                                data-action="{{ route('admin.khotians.approve.return', [$khotian[0]['id'], $khotian[0]['khotian_number']]) }}"
                                                class="btn btn-warning pull-right">ফেরত পাঠান
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="clearfix"></div>


                    </div>
                </div>
            </div>
        </div>
    </div>









    {{-- Writer Moddal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="copy_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        {{ __('আপনি কি তুলনাকারির নিকট প্রেরণ করতে চান?') }}
                    </h4>
                </div>
                <div class="modal-body" id="copy_model_body"></div>
                <div class="modal-footer">
                    <form action="#" id="copy_form" method="POST">
                        {{ method_field("POST") }}
                        {{ csrf_field() }}
                        <input type="hidden" id="remark_writer" name="remark">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('হ্যাঁ') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Compare Modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="compare_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        {{ __('আপনি কি অনুমোদনকারীর নিকট প্রেরণ করতে চান?') }}
                    </h4>
                </div>
                <div class="modal-body" id="compare_model_body"></div>
                <div class="modal-footer">
                    <form action="#" id="compare_form" method="POST">
                        {{ method_field("POST") }}
                        {{ csrf_field() }}
                        <input type="hidden" id="remark_compare" name="remark">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('হ্যাঁ') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Compare Return Modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="compare_return_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" id="compare_return_form" method="POST">
                    {{ method_field("POST") }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="{{ __('voyager::generic.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">
                            {{ __('আপনি কি ফেরত পাঠাতে চান?') }}
                        </h4>
                    </div>

                    <div class="modal-body" id="compare_return_model_body">
                        <input type="hidden" id="remark_compare_return" name="remark">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('হ্যাঁ') }}">
                        <button type="button" class="btn btn-default pull-right"
                                data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Approver Modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="approve_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('আপনি কি অনুমোদন করতে চান?') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="approve_model_body"></div>
                <div class="modal-footer">
                    <form action="#" id="approve_form" method="POST">
                        {{ method_field("POST") }}
                        {{ csrf_field() }}
                        <input type="hidden" id="remark_approve" name="remark">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('হ্যাঁ') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('বন্ধ করুন') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Approve Return Modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="approve_return_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('আপনি কি নিশ্চিতভাবে ফেরন পাঠাতে চান?') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="approve_return_model_body">
                    <input type="hidden" id="remark_approve_return" name="remark">
                </div>
                <div class="modal-footer">
                    <form action="#" id="approve_return_form" method="POST">
                        {{ method_field("POST") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('হ্যাঁ, ফেরত পাঠান') }}">
                        <button type="button" class="btn btn-default pull-right"
                                data-dismiss="modal">{{ __('বন্ধ করুন') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @font-face {
            font-family: 'kalpurush';
            src: url('<?php echo asset('fonts/kalpurush-kalpurush.eot'); ?>') /* IE9 Compat Modes */
            src: url('<?php echo asset('fonts/kalpurush-kalpurush.eot?#iefix'); ?>') format('embedded-opentype'), /* IE6-IE8 */ url('<?php echo asset('fonts/kalpurush-kalpurush.woff'); ?>') format('woff'), /* Modern Browsers */ url('<?php echo asset('Kalpurush.ttf'); ?>') format('truetype'), /* Safari, Android, iOS */
        ;
        }
        .error {
            color: red;
        }
    </style>
    <style>
        .bg-5 {
            background-image: none !important;
        }
        .htable {
            width: 100%
        }

        table, table td {
            background: #fff;
        }
    </style>
@endpush


@push('js')
    <script type="text/javascript">
        function print_rpt() {
            URL = "/page/Print_a4_khotian.php?selLayer=PrintArea";
            day = new Date();
            id = day.getTime();
            eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
        }


        /** Writer Actions **/
        $(document, 'button').on('click', '#send_to_compare', function (e) {
            $('#copy_form')[0].action = $(this).data('action');
            let writerRemark = $('#writer_remark').val().replace(/(<([^>]+)>)/gi, "");
            $('#remark_writer').val(writerRemark.trim());
            $('#copy_modal').modal('show');
        });

        /** Compare Actions **/
        $(document, 'button').on('click', '#compare_to_approver', function (e) {
            $('#compare_form')[0].action = $(this).data('action');
            let compareRemark = $('#compare_remark').val().replace(/(<([^>]+)>)/gi, "");
            $('#remark_compare').val(compareRemark.trim());
            $('#compare_modal').modal('show');
        });
        $(document, 'button').on('click', '#compare_to_writer', function (e) {
            $('#compare_return_form')[0].action = $(this).data('action');
            let compareRemark = $('#compare_remark').val().replace(/(<([^>]+)>)/gi, "");

            if (compareRemark.trim() == '') {
                alert('আপনার মতামত প্রদান করুন !');
            } else {
                $('#remark_compare_return').val(compareRemark.trim());
                $('#compare_return_modal').modal('show');
            }
        });

        /** Approve Actions **/
        $(document, 'button').on('click', '#approve', function (e) {
            $('#approve_form')[0].action = $(this).data('action');
            let approveRemark = $('#approve_remark').val().replace(/(<([^>]+)>)/gi, "");
            $('#remark_approve').val(approveRemark.trim());
            $('#approve_modal').modal('show');
        });
        $(document, 'button').on('click', '#approve_return', function (e) {
            $('#approve_return_form')[0].action = $(this).data('action');
            let approveRemark = $('#approve_remark').val().replace(/(<([^>]+)>)/gi, "");

            if (approveRemark.trim() == '') {
                alert('আপনার মতামত প্রদান করুন !');
            } else {
                $('#remark_approve_return').val(approveRemark.trim());
                $('#approve_return_modal').modal('show');
            }
        });


        /*added for slider start */

        // Call & init
        $(document).ready(function () {
            $('.ba-slider').each(function () {
                var cur = $(this);
                // Adjust the slider
                var width = cur.width() + 'px';
                cur.find('.resize img').css('width', width);
                // Bind dragging events
                drags(cur.find('.handle'), cur.find('.resize'), cur);
            });
        });

        // Update sliders on resize.
        // Because we all do this: i.imgur.com/YkbaV.gif
        $(window).resize(function () {
            $('.ba-slider').each(function () {
                var cur = $(this);
                var width = cur.width() + 'px';
                cur.find('.resize img').css('width', width);
            });
        });

        function drags(dragElement, resizeElement, container) {

            // Initialize the dragging event on mousedown.
            dragElement.on('mousedown touchstart', function (e) {

                dragElement.addClass('draggable');
                resizeElement.addClass('resizable');

                // Check if it's a mouse or touch event and pass along the correct value
                var startX = (e.pageX) ? e.pageX : e.originalEvent.touches[0].pageX;

                // Get the initial position
                var dragWidth = dragElement.outerWidth(),
                    posX = dragElement.offset().left + dragWidth - startX,
                    containerOffset = container.offset().left,
                    containerWidth = container.outerWidth();

                // Set limits
                minLeft = containerOffset + 10;
                maxLeft = containerOffset + containerWidth - dragWidth - 10;

                // Calculate the dragging distance on mousemove.
                dragElement.parents().on("mousemove touchmove", function (e) {
                    // Check if it's a mouse or touch event and pass along the correct value
                    // main code var moveX = (e.pageX) ? e.pageX : e.originalEvent.touches[0].pageX;
                    var moveX = (e.pageX) ? e.pageX : 79;


                    leftValue = moveX + posX - dragWidth;
                    /*  $('#titleSpan').css('display', 'block');
                   // console.log('width outer',$("#titleSpan").width());
                    if($("#titleSpan").width() < 50){
                        $('#titleSpan').css('display', 'none');
                    } */
                    // Prevent going off limits
                    if (leftValue < minLeft) {
                        leftValue = minLeft;
                        // console.log('width',$("#titleSpan").width());
                    } else if (leftValue > maxLeft) {
                        leftValue = maxLeft;

                    }

                    // Translate the handle's left value to masked divs width.
                    widthValue = (leftValue + dragWidth / 2 - containerOffset) * 100 / containerWidth + '%';

                    // Set the new values for the slider and the handle.
                    // Bind mouseup events to stop dragging.
                    $('.draggable').css('left', widthValue).on('mouseup touchend touchcancel', function () {
                        $(this).removeClass('draggable');
                        resizeElement.removeClass('resizable');
                    });
                    $('.resizable').css('width', widthValue);
                }).on('mouseup touchend touchcancel', function () {
                    dragElement.removeClass('draggable');
                    resizeElement.removeClass('resizable');
                });
                e.preventDefault();
            }).on('mouseup touchend touchcancel', function (e) {
                dragElement.removeClass('draggable');
                resizeElement.removeClass('resizable');
            });
        }

    </script>
@endpush
