<html>
<head>
</head>
<body>
<div class="container" style="background-image: url('<?php echo $bg; ?>'); background-size: 100% 100%; background-repeat: repeat-y; z-index: 999;">
    <div class="row">
        <div class="col-md-12">
            <div id="PrintArea" style="margin-left: 20px">
                <?php
               /*  function eng_to_bangla_code($input){
                    $ban_number = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','');
                    $eng_number = array(1,2,3,4,5,6,7,8,9,0,'');
                    return str_replace($eng_number,$ban_number,$input);
                } */
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

                if(isset($print_type) && !empty($print_type) && $print_type == 1){
                    // set no border
                    $border_right = ' border-right:none!important;';
                    $border_bottom = ' border-bottom:none!important;';
                    $border_top = ' border-bottom:none!important;';
                    $border_left = ' border-left: none!important;';
                }

                function getLines($text, $char = 20){
                    $newtext = mb_wordwrap($text, $char, "<br>");
                    $arr = explode( "<br>", $newtext );
                    return  count( $arr );
                }

                function mb_wordwrap($str, $width = 75, $break = "<br>", $cut = true) {
                    $lines = explode($break, $str);
                    foreach ($lines as &$line) {
//        $line = rtrim($line);
//        $line = preg_replace('/\s+/', '&nbsp;', $line);
                        if (mb_strlen($line) <= $width)
                            continue;
                        $words = explode(' ', $line);
                        $line = '';
                        $actual = '';
                        foreach ($words as $word) {
                            if (mb_strlen($actual.$word) <= $width)
                                $actual .= $word.' ';
                            else {
                                if ($actual != '')
                                    $line .= rtrim($actual).$break;
                                $actual = $word;
                                if ($cut) {
                                    while (mb_strlen($actual) > $width) {
                                        $line .= mb_substr($actual, 0, $width).$break;
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
                    foreach ($datas as $key => $data){
                        $output[$key] = implode('<br>', $data);
                    }

                    return $output;
                }
                function margePage(&$overAllPages, $landownerLineArr, $pageNumber){
                    foreach ($landownerLineArr as $ownerBlockLine){
                        $overAllPages[$pageNumber][] = $ownerBlockLine;
                    }
                }
                ?>

                <?php

                foreach($batch_khotians as $rootPage => $aKhotian){
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

                    $tmpAddress =  preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $tmpAddress);
                    $tmpName =  preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $tmpName);

                    $tmpName = mb_wordwrap($tmpName,34, '<br>', false);
                    $tmpAddress = mb_wordwrap($tmpAddress,34, '<br>', false);
                    $tmpAddressLine = getLines($tmpAddress,34, '<br>', false);
                    $tmp = $tmpAddress;
                    $singleOwner['address_line_num'] = $tmpAddressLine;
                    $singleOwner['owner_address'] = $tmpAddress;
                    $singleOwner['owner_name'] = $tmpName;

                    $tmpParentData = explode('<br>', $tmpAddress);
                    $singleOwner['parent_name'] = $tmpParentData[0];
                    unset($tmpParentData[0]);
                    $singleOwner['address_only'] = implode('<br>',  $tmpParentData);
                }
                
                $hasLine = [];
                $ownerPageArr = [];
                foreach ($owners as $key => $owner) {

                    //$ownerCountLine = getLines($owner['owner_name'], 30, '<br>', false);
                    $ownerCountLine = getLines($owner['owner_name'], 34, '<br>', false);
                    $address_entry = false;

                    $angshoBreak = 1;

                    if(empty($ownerRowId) && !empty($owner['id'])){
                        $ownerRowId = $owner['id'];
                    }

                    if ($pre_address_only !== false) {
                        if ($pre_parent_name != $owner['parent_name']) {
                            if($pre_address_only !=  $owner['address_only']){
                                // print full parent and address
                                $addressTMP = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $owner['address_only']);
                                $owner_data .= ' <br>' . $owner['parent_name'];
                                $owner_data .= ' <br>' .  $addressTMP;

                                $isPrintedHr = false;
                                if( !empty($pre_owner_data['owner_group_id']) && $pre_owner_data['owner_group_id'] != $owner['owner_group_id'] && !in_array($pre_owner_data['owner_group_id'], $hasLine)){
                                    $hasLine[] = $pre_owner_data['owner_group_id'];
                                    $isPrintedHr = true;
                                    $owner_data .= '<hr class="hr"/>';
                                    //$owner_data .= '<span style="margin: 0px; padding: 0px; border-top: 1px solid #323232; width: 97%;"></span>';
                                }

                                // now set current new owner data
                                $owner_data .=  '<br>'.$owner['owner_name'];

                                //  $pre_owner_address =   $owner['owner_address'];
                                $pre_owner_data = $owner;
                                $pre_address_only = $owner['address_only'];
                                $pre_parent_name  =  $owner['parent_name'];

                                $address_entry = true;

                                // angsho break
                                $angshoBreak = 1 +  getLines($addressTMP, 30, '<br>', false);

                            }else{
                                // parent different but address same
                                $owner_data .= '<br>' . $pre_parent_name;
                                $owner_data .=  '<br>' . $owner['owner_name'];

                                // set current owner name as pre, so for next owner er can check if they same
                                $pre_parent_name  = $owner['parent_name'];

                                $address_entry = true;

                                // angsho bresk
                                $angshoBreak = 1;
                            }
                        } else {
                            // parent same address same
                            // add only owner name as parent is same
                            $owner_data .=  '<br>' . $owner['owner_name'];

                        }
                    } else {
                        $pre_address_only = $owner['address_only'];
                        $pre_parent_name  = $owner['parent_name'];
                        $owner_data .= $owner['owner_name'];


                        // $pre_owner_address = $owner['owner_address'];
                        $pre_owner_address_holder = '';
                        $pre_owner_data = $owner;
                    }
                    // mokodoma dhara son
                    if(empty($mokadoma_no) && !empty($owner['mokadoma_no'])){
                        $mokadoma_no = $owner['mokadoma_no'];
                    }
                    if(empty($dhara_no) && !empty($owner['dhara_no'])){
                        $dhara_no = $owner['dhara_no'];
                    }
                    if(empty($dhara_son) && !empty($owner['dhara_son'])){
                        $dhara_son = $owner['dhara_son'];
                    }


                    //set the owner ongsho
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
                        $owner_ongsho .=  $lineBreak[$angshoBreak] . '<span class="paddTwo">' . $owner_area .'</span>'.' <br>'.$lineBreak[($ownerCountLine - 1)];
                    } else {
                        // while have same parent. so only name break allowed
                        $owner_ongsho .= $owner_area .  $lineBreak[($ownerCountLine-1)] . ' <br>';

                    }

                    $total_ongsho = $total_ongsho + $owner['owner_area'];
                }

                // print_r($owners); die;
                if (!empty($pre_address_only)) {
                    // $owner_data .= '<br>'.rtrim($pre_owner_address, '<br>');
                    $owner_data .= '<br>' . $pre_parent_name;
                    $owner_data .=  '<br>' . $pre_address_only;
                }


                // Arrange the data of Khotian
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
                $isSpecial = empty($khotian[0]['brs_khotian_entries']['is_special']) ? '': $khotian[0]['brs_khotian_entries']['is_special'];
                $computerCode = empty($khotian[0]['brs_khotian_entries']['computer_code']) ? '': $khotian[0]['brs_khotian_entries']['computer_code'];

                foreach ($khotian as $rowCnt => $row) {
                    $krishiLines = 0;
                    $okrishiLines = 0;
                    $dagParts = explode('/', $row['dag_number']);
                    if(!empty($dagParts[1])){
                        $partOne = '<span class="dagUnderline">' . substr(trim($dagParts[1]), 0, 5).  '</span> <br>';
                        $partTwo =  substr(trim($dagParts[0]), 0, 5).' <br>';

                        $dag_no .= $partOne.$partTwo;
                        $dagLine = 2; //wordwrap($row['dag_number'], 5, "<br>", true);
                    }else{
                        $dag_no .= substr(trim($row['dag_number']), 0, 5). ' <br>';
                        $dagLine = 1; //wordwrap($row['dag_number'], 5, "<br>", true);
                    }
//        $dag_no .= substr(trim($row['dag_number']), 0, 5). '<br>';
//        $dagLine = 1; //wordwrap($row['dag_number'], 5, "<br>", true);
//        $dagArr = explode( "<br>", $dagLine );
//        $dagLines =   count( $dagArr );
                    if ($row['agricultural_use'] == 0 || $row['agricultural_use'] == '') {
                        $krishi .= ' <br>';
                        $non_krishi .= mb_wordwrap($row['lt_name'], 13) . ' <br>';
                        $okrishiLines = getLines($row['lt_name'], 13);
                    } else {
                        $krishi .= mb_wordwrap($row['lt_name'], 13) . ' <br>';
                        $non_krishi .= '<br>';
                        $krishiLines = getLines($row['lt_name'], 13);
                    }
                    // dager mote poriman
                    $dag_area = explode('.', $row['total_dag_area']);

                    //check the dager modde otrro khotianer osho 1
                    if ($row['khotian_dag_portion'] != 1) {
                        $total_dag_area_ekor .= ($dag_area[0] > 0 ? $dag_area[0] : '') . ' <br>'; // if 0 show empty
                        if (isset($dag_area[1])) {
                            if (strlen($dag_area[1]) == 1) {
                                $total_dag_area_shotangso .= $dag_area[1] . '০০০' . ' <br>';
                            }elseif (strlen($dag_area[1]) == 2) {
                                $total_dag_area_shotangso .= $dag_area[1] .'০০'. ' <br>';
                            }elseif (strlen($dag_area[1]) == 3) {
                                $total_dag_area_shotangso .= $dag_area[1] .'০'. ' <br>';
                            } else {
                                $total_dag_area_shotangso .= $dag_area[1] . ' <br>';
                            }
                        }else{
                            if(!empty($dag_area[0])){
                                $total_dag_area_shotangso .= '0000 <br>';
                            }
                        }
                    } else {
                        $total_dag_area_ekor .= ' <br>';
                        $total_dag_area_shotangso .= ' <br>';
                    }
                    // dager modde otro khotian ongsho
                    if ($row['khotian_dag_portion'] == '1') {
                        $khotian_dag_portion .= '1.000 <br>';
                    } else {
                        $khotian_dag_portion_arr = explode('.', $row['khotian_dag_portion']);
                        if (isset($khotian_dag_portion_arr[1]) && strlen($khotian_dag_portion_arr[1]) == 1)
                            $khotian_dag_portion .= $row['khotian_dag_portion'] . '00' . ' <br>';
                        elseif (isset($khotian_dag_portion_arr[1]) && strlen($khotian_dag_portion_arr[1]) == 2)
                            $khotian_dag_portion .= $row['khotian_dag_portion'] . '0' . ' <br>';
                        else
                            $khotian_dag_portion .= $row['khotian_dag_portion'] . ' <br>';
                    }
                    //    $khotian_dag_portion .= $row['khotian_dag_portion'].'<br>';

                    // ongsho onujai jomir poriman
                    //$dag_portion = explode('.', $row['khotian_dag_portion']); // shn vai 02-11-15
                    $dag_portion = explode('.', $row['khotian_dag_area']);
                    $total_dag_portion_ekor .= ($dag_portion[0] > 0 ? $dag_portion[0] : '') . ' <br>'; // if 0 show empty
                    if (isset($dag_portion[1])) {
                        if (strlen($dag_portion[1]) == 1) {
                            $total_dag_portion_shotangso .= $dag_portion[1] .'০০০'. ' <br>';
                        } elseif (strlen($dag_portion[1]) == 2) {
                            $total_dag_portion_shotangso .= $dag_portion[1] .'০০'. ' <br>';
                        }  elseif (strlen($dag_portion[1]) == 3) {
                            $total_dag_portion_shotangso .= $dag_portion[1] .'০'. ' <br>';
                        } else {
                            $total_dag_portion_shotangso .= $dag_portion[1] . ' <br>';
                        }
                    }else{
                        $total_dag_portion_shotangso .=  '0000 <br>';
                    }
                    $remarkTextWithoutLatBr = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $row['remarks']);
                    $tmpTxt = preg_replace("#<br\s?/?>#", "<br>", $remarkTextWithoutLatBr);
                    $remarkTxt = mb_wordwrap($tmpTxt, 28, "<br>");
                    $remarks .=  $remarkTxt . '<br>';

                    $remarkSize = getLines($remarkTxt, 28);

                    $size = $remarkSize > $okrishiLines ? $remarkSize : $okrishiLines;
                    $size = $size > $krishiLines ? $size : $krishiLines;
                    $size = $size > $dagLine ? $size : $dagLine;

                    $total_khotian_dag_portion += $row['khotian_dag_area'];

                    // to main same line, add new line
                    if($size > 1){

                        if($remarkSize < $size ){
                            $remarks .=  $lineBreak[$size -$remarkSize];
                        }
                        $dagLineAppendNumber = $size - $dagLine;
                        $dag_no .= $lineBreak[$dagLineAppendNumber];

                        $krishi  .= $lineBreak[$size - ($krishiLines > 0 ? $krishiLines : 1 )];
                        $non_krishi  .= $lineBreak[$size - ($okrishiLines > 0 ? $okrishiLines : 1)];
                        // $dag_area  .= $lineBreak[$size-1];
                        $total_dag_area_shotangso  .= $lineBreak[$size-1];
                        $total_dag_area_ekor  .= $lineBreak[$size-1];
                        // $dag_portion  .= $lineBreak[$size-1];
                        $total_dag_portion_ekor  .= $lineBreak[$size-1];
                        $khotian_dag_portion  .= $lineBreak[$size-1];

                        $total_dag_portion_shotangso .= $lineBreak[$size-1];

                    }
                }

                $total_khotian_dag_portion = explode('.', $total_khotian_dag_portion);

                //by shahin
                //owner data lines
                $owner_data = str_replace('<br/>', '<br>', $owner_data);


                $owner_data_by_land_owner = explode('<end/>', $owner_data);
                //$owner_ongsho_pages =pageSeparate($owner_ongsho, '<br>', $per_page_line_number);

                $remove_string_last_separator = rtrim($owner_ongsho, '<br>');
                $owner_ongsho_pages = explode('<br>', $remove_string_last_separator);
#dd($owner_ongsho_pages);


                $ownerAngsho = [];
                $ownerAngshoTrackerKey = 0;
                $overAllPages = [];
                $currentPage = 0;
                foreach ($owner_data_by_land_owner as $LKey => $landowner){

                    $landowner = preg_replace('#(\s*<br\s*/?>)*\s*$#i', '', $landowner);
                    $landownerLineArr = explode('<br>', $landowner);
                    $currentPageSize = count($landownerLineArr);
                    // dd($currentPageSize,$owner_ongsho_pages);
                    if(empty($overAllPages[$currentPage])){
                        if($currentPageSize > $per_page_line_number){
                            foreach ($landownerLineArr as $key=>$item){
                                $overAllPages[$currentPage][] = $item;
                                // ongsho
                                $ownerAngsho[] = empty($owner_ongsho_pages[$ownerAngshoTrackerKey])?'':$owner_ongsho_pages[$ownerAngshoTrackerKey];
                                // $ownerAngsho[] = $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                $ownerAngshoTrackerKey++;
                                if($key = 0 && ($currentPageSize - 1) % $key == 0){
                                    $currentPage ++;
                                }
                            }
                        }else{
                            $overAllPages[$currentPage] = $landownerLineArr;
                            // ongsho
                            for($ownerAngshoTrackerKey; $ownerAngshoTrackerKey < $currentPageSize; $ownerAngshoTrackerKey++){
                                $ownerAngsho[] = empty($owner_ongsho_pages[$ownerAngshoTrackerKey]) ? '' : $owner_ongsho_pages[$ownerAngshoTrackerKey];
                            }
                        }

                    }else{
                        $currentPageSize = count($overAllPages[$currentPage]);
                        $newOwnerBlockSize = count($landownerLineArr);
                        $totalElements = $currentPageSize + $newOwnerBlockSize;
                        if( $totalElements > $per_page_line_number){
                            for ($currentPageSize; $currentPageSize < $per_page_line_number; $currentPageSize++){
                                $overAllPages[$currentPage][] = '<br>';
                                $ownerAngsho[] = '<br>';
                            }
                            $currentPage++;
                            // margePage($overAllPages, $landownerLineArr, $currentPage);
                            foreach ($landownerLineArr as $tmpKey => $ownerBlockLine){
                                $overAllPages[$currentPage][] = $ownerBlockLine;
                                $ownerAngsho[] =  $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                $ownerAngshoTrackerKey++;
                            }

                        }else{
                            //  margePage($overAllPages, $landownerLineArr, $currentPage);
                            foreach ($landownerLineArr as $tmpKey => $ownerBlockLine){
                                $overAllPages[$currentPage][] = $ownerBlockLine;
                                $ownerAngsho[] =  $owner_ongsho_pages[$ownerAngshoTrackerKey];
                                $ownerAngshoTrackerKey++;
                            }

                            //print_r($owner_ongsho_pages[$ownerAngshoTrackerKey]);
                        }
                    }

                }
                //   $owner_data_lines_array = explode('<br>', $owner_data); //preg_split( '/ (<br>|<hr style=\"margin: 0px; padding: 2px 0px; border-top: 1px solid #323232; width: 97%;\"/>) /', $owner_data ); //explode('<br>', $owner_data);
                $owner_data_pages = $overAllPages; // array_chunk($owner_data_lines_array, $per_page_line_number);
                array_push($pages_number_array, count($owner_data_pages));

                //owner ongsho line separate




                // $owner_ongsho_pages =pageSeparate($owner_ongsho, '<br>', $per_page_line_number);
                $owner_ongsho_pages = array_chunk($ownerAngsho, $per_page_line_number);
                array_push($pages_number_array, count($owner_ongsho_pages));

                //owner dag number line separate
                $secondPartExtraLine = 1;
                $dag_no_pages = pageSeparateOnNl($dag_no, '<br>', $per_page_line_number + $secondPartExtraLine);
                array_push($pages_number_array, count($dag_no_pages));

                // krishi line separate
                $krishi_pages = pageSeparateOnNl($krishi, '<br>', $per_page_line_number + $secondPartExtraLine);
                array_push($pages_number_array, count($krishi_pages));

                // non_krishi line separate
                $non_krishi_pages = pageSeparateOnNl($non_krishi, '<br>', $per_page_line_number + $secondPartExtraLine);
                array_push($pages_number_array, count($non_krishi_pages));

                // total_dag_area_ekor line separate
                $total_dag_area_ekor_pages = pageSeparateOnNl($total_dag_area_ekor, '<br>', $per_page_line_number + $secondPartExtraLine);
                array_push($pages_number_array, count($total_dag_area_ekor_pages));

                // total_dag_area_shotangso line separate
                $total_dag_area_shotangso_pages = pageSeparateOnNl($total_dag_area_shotangso, '<br>', $per_page_line_number + $secondPartExtraLine);
                array_push($pages_number_array, count($total_dag_area_shotangso_pages));

                // khotian_dag_portion line separate
                $khotian_dag_portion_pages = pageSeparateOnNl($khotian_dag_portion, '<br>', $per_page_line_number + $secondPartExtraLine);
                array_push($pages_number_array, count($khotian_dag_portion_pages));

                // total_dag_portion_ekor line separate
                $total_dag_portion_ekor_pages = pageSeparateOnNl($total_dag_portion_ekor, '<br>', $per_page_line_number + $secondPartExtraLine);
                array_push($pages_number_array, count($total_dag_portion_ekor_pages));

                // total_dag_portion_shotangso line separate
                $total_dag_portion_shotangso_pages = pageSeparateOnNl($total_dag_portion_shotangso, '<br>', $per_page_line_number + $secondPartExtraLine);
                array_push($pages_number_array, count($total_dag_portion_shotangso_pages));

                // remarks per page

                $remarks_pages = pageSeparate($remarks, '<br>', $per_page_line_number + $secondPartExtraLine);
                array_push($pages_number_array, count($remarks_pages));

                $countOfLoop = max($pages_number_array);


                if(isset($owners) && isset($khotian))
                {
                // start content block

                for ($i = 0; $i < $countOfLoop; $i++) { ?>
                <?php
                if($i > 0 && $i== $countOfLoop-1){
                ?>

                <div style="page-break-after: auto;"></div>
                <?php
                } //end if
                // generat computer code
                $computerCodeLatest = '';
                $timeObj = \Illuminate\Support\Carbon::now();
                $timeObj->modify('+14 minutes');
                $datePartOne = $timeObj->format('md'); // month and day
                $datePartTwo = $timeObj->format('Y');
                $time = $timeObj->format('His');
                $randomNumber = rand(10,99);
                $gel = substr($header_info['dglr_code'], -3);
                if(empty($gel)){
                    $gel = '000';
                }elseif (strlen($gel) == 1){
                    $gel = '00'.$gel;
                }elseif (strlen($gel) == 2){
                    $gel = '0'.$gel;
                }

                // $computerCodeLatest = 'random 2: '. $randomNumber.' date: '.$date.' User code: 000'.'time: '.$time.'gel: '.$gel.' ip: '.$formatedIP.'row: 0000';

                // assign  ৭১২০১৯১১১১০০১১৯১১১৮০১৯১১৪১৩০০৫৫১৬৪৩১০৭৮
                //  $computerCodeLatest = $randomNumber.$date.$userCode.$time.$gel.$formatedIP.$ownerRowId;
                $computerCodeLatest = $randomNumber. $datePartOne . $userCode . $time . $gel . $formatedIpPartOne . '-'. $ownerRowId . $datePartTwo . $formatedIpPartTwo;
                ?>
                <div style="position: relative">
                    <table class="htable" border="0"  style="margin-top: 2px">
                        <tr>
                            <td colspan="4" align="left" style="border:1px">&nbsp;</td>
                            <td colspan="6" align="center" style="border:1px;">
                                <h2 style="padding-bottom: 0px; margin-top: 15px; margin-left: -85px; font-size: 29px;">খতিয়ান নং- <span
                                        class="nikosh">
                                        <?php echo eng_to_bangla_code($khaslandKhotian->khotian_number); ?>
                                    </span>
                                </h2>
                            </td>
                            <td colspan="4" style="font-size: 15px; border:0px;text-align: right;padding-right: 6px;vertical-align: middle;" class="nikosh">
                                <?= __('পৃষ্ঠা <span style="font-family: muktinarrow">নংঃ</span> '. ( $countOfLoop > 1 ?  eng_to_bangla_code( $countOfLoop) .' এর '. eng_to_bangla_code($i+1) : eng_to_bangla_code($i+1) ) )?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border:1px; font-size: 16px; padding-bottom: 15px;">
                                বিভাগঃ <?php echo $header_info['district_name']; ?></td>
                            <td colspan="2" style="border:1px;  font-size: 16px; padding-bottom: 15px;">জেলাঃ <?php echo $header_info['district_name']; ?></td>
                            <td colspan="3" style="border:1px;  font-size: 16px; padding-bottom: 15px; max-width: 120px;">উপজেলা/থানাঃ <?php echo $header_info['upazila_name']; ?></td>
                            <td colspan="3" style="border:1px;  font-size: 16px; padding-bottom: 15px; min-width: 170px;">মৌজাঃ <?php echo $header_info['name_bd']; ?></td>
                            <td colspan="2" style="border:1px; padding-bottom: 15px;  font-size: 16px;">জে, এল,
                                <span style="font-family: muktinarrow">নংঃ</span>  <?php echo eng_to_bangla_code(substr($header_info['dglr_code'], -3)); ?></td>
                            <td colspan="2" style="border:0px;  font-size: 15px; padding-bottom: 15px;">রেঃ সাঃ <span style="font-family: muktinarrow">নংঃ</span>  <?= !empty($header_info['resa_number']) ? $header_info['resa_number'] : '&nbsp;' ?></td>
                        </tr>
                    </table>

                <table class="table" border="0" cellpadding="0" cellspacing="0" class="pp" id="table_<?= $i ?>"
                           style="vertical-align:top; height: 645px; margin-bottom: 0px; autosize="2.4"">
                    <thead>
                    <tr style="vertical-align:top;">
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
                            style="width: 38px; text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                            রাজস্ব<br></td>
                        <td colspan="1"
                            style="width: 46px;text-align: center;  vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
                            দাগ নং<br></td>
                        <td colspan="2" rowspan="1"
                            style="text-align: center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                            width="184px">
                            জমির শ্রেণী
                        </td>
                        <td colspan="2" rowspan="1"
                            style="text-align:center;vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;"
                            width="87px">
                            দাগের মোট পরিমাণ
                        </td>
                        <td colspan="1"
                            style="width: 70px;font-size:11px; text-align: center; vertical-align:middle;border-right:1px solid;border-top:1px solid; padding-top:5px;">
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
                    <tr>
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
                        <td style="width: 102px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;"
                        >
                            কৃষি<br></td>
                        <td style="width: 96.48px;text-align: center; vertical-align:middle;border-top:1px solid;border-right:1px solid;">
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
                    <tr style="border: none">
                        <td width="102px" style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">৫ (ক)</td>
                        <td width="96.48px" style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">৫(খ)</td>
                        <td width="41.57px" style="padding: 0px; border-top: none; text-align: center;border-right:1px solid; border-bottom: 1px solid">৬ (ক)</td>
                        <td width="45.35px" style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">৬ (খ)</td>
                        <td width="41.57px" style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">৮ (ক)</td>
                        <td width="45.35px" style="padding: 0px; border-top: none; text-align: center;border-right:1px solid;  border-bottom: 1px solid">৮ (খ)</td>
                    </tr>
                    </thead>
                    <tbody style="font-family: nikoshBAN;">


                    <tr class="custom-border">
                        <td style="height: 400px; width: 212px; border-top: none; text-align: left; <?= $border_left ?> <?= $border_right ?> padding-left:7px;"
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
                        <td style="border-top: none; text-align: left;vertical-align:top;<?= $border_right ?>"> <p style="padding: 2px 0px 0px 0px;margin: 0px;">&nbsp;</p> </td>
                        <td style="padding-left: 4px; border-top: none; text-align: left;vertical-align:top;<?= $border_right ?>">
                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                            <?php
                            if (isset($dag_no_pages[$i])) {
                                echo eng_to_bangla_code( $dag_no_pages[$i]);
                            }
                            ?>
                        </td>
                        <td style="padding-left: 4px; border-top: none; text-align: left;vertical-align:top;<?= $border_right ?>white-space: normal;">
                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                            <?php
                            if (isset($krishi_pages[$i])) {
                                echo $krishi_pages[$i];
                            }
                            ?>
                        </td>
                        <td style="padding-left: 4px; border-top: none; text-align: left;vertical-align:top; <?= $border_right ?> white-space: normal;">
                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                            <?php
                            if (isset($non_krishi_pages[$i])) {
                                echo  $non_krishi_pages[$i];
                            }
                            ?>
                        </td>
                        <td style="padding-left: 2px; border-top: none; text-align: right;vertical-align:top;<?= $border_right ?>">
                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                            <?php
                            if (isset($total_dag_area_ekor_pages[$i])) {
                                echo eng_to_bangla_code( $total_dag_area_ekor_pages[$i]);
                            }
                            ?>
                        </td>
                        <td style="padding-left: 2px; border-top: none; text-align: left;vertical-align:top;<?= $border_right ?>">
                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                            <?php
                            if (isset($total_dag_area_shotangso_pages[$i])) {
                                echo eng_to_bangla_code( $total_dag_area_shotangso_pages[$i]);
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
                        <td style="padding-left: 2px; border-top: none; text-align: right;vertical-align:top;<?= $border_right ?>">
                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                            <?php
                            if (isset($total_dag_portion_ekor_pages[$i])) {
                                echo eng_to_bangla_code($total_dag_portion_ekor_pages[$i]);
                            }
                            ?>
                        </td>
                        <td style="padding-left: 3px; border-top: none; text-align: left;vertical-align:top;<?= $border_right ?>">
                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                            <?php
                            if (isset($total_dag_portion_shotangso_pages[$i])) {
                                echo eng_to_bangla_code($total_dag_portion_shotangso_pages[$i]);
                            }
                            ?>
                        </td>
                        <td style="padding-left: 7px; border-top: none; text-align: left;vertical-align:top; <?= $border_right ?>">
                            <p style="padding-bottom: 2px;margin: 0px;">&nbsp;</p>
                            <pre style="
                            display: block;
                            border: none;
                            padding: inherit;
                            font-size: inherit;
                            line-height: inherit;
                            margin: 0px;
                            color: inherit;
                            background-color: inherit;
                            border-radius: inherit;
                            font-family: kalpurush;
                        "><?php
                                if (isset($remarks_pages[$i])) {
                                    echo implode('<br>', $remarks_pages[$i]);
                                    // echo "দালান/১২<br>এই মন্তব্যটি ২২ নং দাগের<br>অন্তর্ভুক্ত।<br><br><br><br><br>দালান/১<br>এই মন্তব্যটি ৪৪৭৮ নং দাগের<br>অন্তর্ভুক্ত।<br><br>দালান/১২<br>এই মন্তব্যটি ৮৯৭৪ নং দাগের<br>অন্তর্ভুক্ত।<br><br>দালান/১২<br>এই মন্তব্যটি ৬৬৯৮৭৯ নং দাগের<br>অন্তর্ভুক্ত।<br>জোর দং<br>করিম        ০.৫০০<br>রহিম        ০.৫০০<br>পিং আলী   ---------------<br>সাং নিজ     ১.০০০                    ";
                                }
                                ?></pre>
                        </td>
                    </tr>


                    </tbody>
                    <tfoot style="font-family: nikoshBAN;">
                    <tr style="height: 1.2cm">
                        <td rowspan="1"
                            style="font-size:12px; <?= $border_left ?> <?= $border_right ?> <?= $border_top ?> padding-left:5px;border-bottom:1px solid; font-style: italic">
                            <?= !empty($dhara_no) ? eng_to_bangla_code($dhara_no) . ' ': '..........' ?>ধারামতে নোট বা পরিবর্তন
                            <b>মায় মোকদ্দমা নং</b><?= !empty($mokadoma_no) ? ' ' . eng_to_bangla_code($mokadoma_no) . ' ': '.........' ?> এবং <b>সন</b><?= !empty($dhara_son) ? ' ' . eng_to_bangla_code($dhara_son) : '.........' ?>
                        </td>
                        <td style="text-align:center;<?= $border_right ?> <?= $border_top ?> border-bottom:1px solid;"><?php echo eng_to_bangla_code(number_format($total_ongsho, 3)); ?></td>
                        <td style="position: relative; font-size: 15px; text-align: right;vertical-align:middle;<?= $border_right ?> <?= $border_top ?> border-bottom:1px solid;padding-right:5px;"
                            colspan="7">

                            <span style="float: right; margin-top: -2px;"> মোট জমিঃ</span>
                        </td>
                        <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid; padding-right: 3px; text-align: right;" valign="top">
                            <?php echo (empty($total_khotian_dag_portion[0] ) ? "" : eng_to_bangla_code($total_khotian_dag_portion[0])); ?>
                        </td>
                        <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid; padding-left: 3px;  text-align: left;" valign="top">
                            <?php
                            if (isset($total_khotian_dag_portion[1]) && strlen($total_khotian_dag_portion[1]) == 1) {
                                $total_khotian_dag_portion[1] .= '০০০';
                            }elseif (isset($total_khotian_dag_portion[1]) && strlen($total_khotian_dag_portion[1]) == 2) {
                                $total_khotian_dag_portion[1] .= '০০';
                            } elseif (isset($total_khotian_dag_portion[1]) && strlen($total_khotian_dag_portion[1]) == 3) {
                                $total_khotian_dag_portion[1] .= '০';
                            }
                            echo eng_to_bangla_code((isset($total_khotian_dag_portion[1]) ? $total_khotian_dag_portion[1] : '0000'));
                            ?>
                        </td>
                        <td style="<?= $border_right ?><?= $border_top ?> border-bottom:1px solid;">&nbsp;
                        </td>
                    </tr>

                    <tr>
                        <td colspan="11" style="vertical-align: middle">মুদ্রণঃ সেটেলমেন্ট প্রেস, ঢাকা। &nbsp; তারিখঃ <?= eng_to_bangla_code(date('d-m-Y')); ?></td>
                        <td colspan="4" rowspan="3" style="vertical-align: middle">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="11" style="vertical-align: top">বাংলাদেশ ফর্ম নং ৫৪৬২ (সংশোধিত)</td>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td colspan="11" style="vertical-align: top"><?= !empty($computerCodeLatest) ? 'কম্পিউটার কোডঃ ' . eng_to_bangla_code($computerCodeLatest) : '&nbsp;' ?></td>
                        <td colspan="4"></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

                <?php
                }
                // end content block
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
                    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th{
                        border-top: none;  font-family: kalpurush;
                    }
                </style>
                <?php
                endif;
                ?>
                <style>
                    html, body, div,pr,span, tr, td, p {
                        font-family: kalpurush;
                    }
                    .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                        padding: 2px;
                        vertical-align: middle;
                    }

                    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                        padding: 2px;
                    }
                    .oneOne{
                        padding-left: 1.5px;
                    }
                    .dagUnderline{
                        border-bottom: 1px solid;
                    }
                    .table>tbody>tr>td{
                        padding-top: 0px!important;
                    }
                    .paddTwo{
                        padding: 0px 0px 0px 0px;
                    }
                    hr{
                        margin: 0px; padding: 0px 0px 2px 0px; border-top: 1px solid #323232; width: 97%; display: inline-block;
                    }
                    hr:first-child {
                        margin-top: 2px !important;
                        padding-bottom: 0px !important;
                    }
                </style>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<style>
    .bg-5{background-image: none!important;}
    .htable{width: 100%}
</style>
</body>
</html>
