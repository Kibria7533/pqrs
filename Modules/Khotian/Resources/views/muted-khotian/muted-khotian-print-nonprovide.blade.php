@extends('master::layouts.master')
@php
    $title =  __('আবেদনের বিস্তারিত');
    $designations = Modules\Khotian\App\Models\MutedKhotian::SIGNATURE_DESIGNATION;
    $non_provide = Modules\Khotian\App\Models\MutedKhotian::NON_PROVIDABLE_REASONS;
    $header_info = $batch_khotians[0]['header_info'];
    $jl_number = $batch_khotians[0]['jl_number'];
    $khotian = $batch_khotians[0]['khotian'];
    $isAclandUser = $batch_khotians[0]['isAclandUser'];
    $khotian_no=$batch_khotians[0]['khotian_no'];
    use Illuminate\Support\Facades\File;
@endphp
@section('title', $title)

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6" style="margin-bottom: 0px!important">
                <h1 class="page-title">
                    <i class="voyager-bookmark"></i> {{ __('আবেদনের বিস্তারিত') }}
                </h1>
            </div>
            <div class="col-md-6">

                <button class="btn btn-info pull-right" type="button" onclick="print_rpt()" href="#"
                        style="margin: 39px 18px 0px;">
                    প্রিন্ট <i class="fa fa-print"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <style>
        .modal-header .close {
            position: absolute;
            top: 6px;
            right: 10px;
            color: #fff;
        }

        .voyager .modal.modal-danger .modal-header {
            background-color: #8167e8;
            color: #fff;
        }

        .modal-title {
            margin-bottom: 0;
            line-height: 1.5;
            font-size: 15px;
        }

        .voyager .btn.btn-danger {
            background: #2ecc5a;
        }

        .voyager .btn.btn-danger:hover {
            background: #18b845;
        }
    </style>
@stop

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
                                    {{--<button class="btn btn-circle blue" type="button" style="padding: 5px 50px;color: #000;border: 1px solid;"
                                            onclick="print_rpt()">প্রিন্ট
                                    </button>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="PrintArea" style="margin-left: 36px">
                                            <div style="position: relative">
                                                {{-- <php if(!empty($application->status) && $application->status == 2){ ?>
                                                <div style='width: 80%; position: absolute; top: 300px; left: 10%; color: #00000030; font-size: 3em; display: block; font-weight: bolder; '>
                                                    <div style='position: relative'><span style='float: left'>সরকারি ব্যবহারের জন্য</span><span
                                                                style='float: right'>সরকারি ব্যবহারের জন্য</span></div>
                                                </div>
                                                <php } ?> --}}
                                                <table class="htable" border="0" style='width: 1090px; margin: 0 auto'>
                                                    <tr>
                                                        <td colspan="4" align="left" style="border:1px">&nbsp;
                                                        </td>
                                                        <td colspan="6" align="center" style="border:1px;">
                                                            <h2 style="padding-bottom: 0px; margin-top: 15px; margin-left: -291px; font-size: 29px;">
                                                                খতিয়ান নং- <span
                                                                    class=""><?php echo \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotian_no); ?></span>
                                                            </h2>
                                                        </td>
                                                        {{-- TODO:added case no --}}
                                                        <td colspan="4"
                                                            style="font-size: 15px; border:0px;text-align: right;padding-right: 6px;vertical-align: middle;"
                                                            class="nikosh">
                                                        </td>
                                                        {{-- <td colspan="4" style="font-size: 15px; border:0px;text-align: right;padding-right: 6px;vertical-align: middle;" class="">
                                                        <= __('পৃষ্ঠা নংঃ '. ( $countOfLoop > 1 ?  eng_to_bangla_code( $countOfLoop) .' এর '. eng_to_bangla_code($i+1) : eng_to_bangla_code($i+1) ) )?>
                                                        </td> --}}
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
                                                            style="border:1px;  font-size: 16px; padding-bottom: 15px; min-width: 20px;">
                                                            মৌজাঃ <?php echo $header_info['name_bd']; ?></td>
                                                        <td colspan="2" style="border:1px; padding-bottom: 15px;  font-size: 16px;">জে, এল,
                                                            নংঃ <?php echo eng_to_bangla_code($jl_number); ?></td>
                                                        {{-- <php echo eng_to_bangla_code(substr($header_info['dglr_code'], -3)); ?></td> --}}
                                                        <td colspan="2" style="border:0px;  font-size: 15px; padding-bottom: 15px;">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php $count = 0; ?>
                                                <table class="d"
                                                       style='width: 1090px; margin: 0 auto'>
                                                    <tbody>
                                                    <tr>
                                                        <td>এই খতিয়ানটি প্রদানযোগ্য নয় | অপ্রদান এর কারন :</td>
                                                    </tr>
                                                    @foreach ($batch_khotians[0]['non_provide'] as $key => $value)
                                                        <tr>
                                                            <td>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($count + 1) }}
                                                                . {{ $non_provide[$value] }}</td>
                                                        </tr>
                                                        <?php $count++; ?>
                                                    @endforeach

                                                    {{-- @dd($batch_khotians[0]['non_provide']) --}}

                                                    </tbody>
                                                </table>

                                                @if ($isAclandUser)
                                                    <table class="d" style='width: 1090px; margin: 0 auto;text-align: center'>
                                                        <tr style='line-height:100px;'>
                                                            {{-- <td style="padding-bottom: 10px;font-family: nikoshBAN;">প্রস্তাবিত
                                                                খতিয়ান
                                                            </td> --}}
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
                                                            <td><img src="<?php echo '/storage/qr/'. $qr_code; ?>" style="margin-left:130% "
                                                                     width="140" height="140"/></td>
                                                        </tr>--}}
                                                    </table>

                                                @elseif (!$isAclandUser)
                                                    <table class="d" style='width: 1090px; margin: 0 auto'>
                                                        <tr style='line-height:100px;'>
                                                            {{-- <td style="padding-bottom: 10px;font-family: nikoshBAN;">প্রস্তাবিত
                                                                খতিয়ান
                                                            </td> --}}
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">নকলকারী</td>
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">যাচাইকারী</td>
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">তুলনাকারী</td>
                                                            <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদনকারী</td>
                                                        </tr>
                                                    </table>
                                                @endif

                                            </div>

                                            <?php

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
                                                <div style="position: relative">
                                                    <table class="htable col-sm-12 col-md-12 col-lg-12" border="0" style=''>
                                                        <tr>
                                                            <td colspan="4" align="left" style="border:1px">&nbsp;
                                                            </td>
                                                            <td colspan="6" align="center" style="border:1px;">
                                                                <h2 style="padding-bottom: 0px; margin-top: 15px; margin-left: -91px; font-size: 29px;">
                                                                    খতিয়ান নং- <span
                                                                        class=""><?php echo \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotian_no); ?></span>
                                                                </h2>
                                                            </td>
                                                            <td colspan="4"
                                                                style="font-size: 15px; border:0px;text-align: right;padding-right: 6px;vertical-align: middle;"
                                                                class="nikosh">
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
                                                                style="border:1px;  font-size: 16px; padding-bottom: 15px; min-width: 20px;">
                                                                মৌজাঃ <?php echo $header_info['name_bd']; ?></td>
                                                            <td colspan="2" style="border:1px; padding-bottom: 15px;  font-size: 16px;">জে,
                                                                এল,
                                                                নংঃ <?php echo eng_to_bangla_code($jl_number); ?></td>
                                                            <td colspan="2" style="border:0px;  font-size: 15px; padding-bottom: 15px;">
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php $count = 0; ?>
                                                    <table class="d col-sm-12 col-md-12 col-lg-12"
                                                           style=''>
                                                        <tbody>
                                                        <tr>
                                                            <td>এই খতিয়ানটি প্রদানযোগ্য নয় | অপ্রদান এর কারন :</td>
                                                        </tr>
                                                        @foreach ($batch_khotians[0]['non_provide'] as $key => $value)
                                                            <tr>
                                                                <td>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($count + 1) }}
                                                                    . {{ $non_provide[$value] }}</td>
                                                            </tr>
                                                            <?php $count++; ?>
                                                        @endforeach
                                                        </tbody>
                                                    </table>

                                                    @if ($isAclandUser)
                                                        <table class="d " style=' margin: 0 auto;text-align: center'>
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
                                                                         style="margin-left:130% " width="140" height="140"/></td>
                                                            </tr>--}}
                                                        </table>

                                                    @elseif (!$isAclandUser)
                                                        <table class="d" style='width: 1090px; margin: 0 auto'>
                                                            <tr style='line-height:100px;'>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">নকলকারী</td>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">যাচাইকারী</td>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">তুলনাকারী</td>
                                                                <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদনকারী</td>
                                                            </tr>
                                                        </table>
                                                    @endif

                                                </div>

                                                <?php

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
                                        <div class="col-md-12 col-sm-12 col-lg-5" style="border-style: ridge;max-height: 50rem">
                                            <iframe id="pdfIframe" src="{{ asset("storage/".$record->scan_copy)}}" frameborder="0"
                                                    style="background: #FFFFFF;" width="108%" height="100%"
                                                    allowtransparency="true"></iframe>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="ba-slider">
                                    @if ($record->scan_copy)
                                        <div class="row">
                                            <div class="col-md-6" style="margin-bottom: 0px !important">
                                                <h4 style="
                    text-align: center;
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
                                                    <div style="position: relative">
                                                        <table class="htable" border="0" style='width: 1090px; margin: 0 auto'>
                                                            <tr>
                                                                <td colspan="4" align="left" style="border:1px">&nbsp;
                                                                </td>
                                                                <td colspan="6" align="center" style="border:1px;">
                                                                    <h2 style="padding-bottom: 0px; margin-top: 15px; margin-left: -291px; font-size: 29px;">
                                                                        খতিয়ান নং- <span
                                                                            class=""><?php echo \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotian_no); ?></span>
                                                                    </h2>
                                                                </td>
                                                                {{-- TODO:added case no --}}
                                                                <td colspan="4"
                                                                    style="font-size: 15px; border:0px;text-align: right;padding-right: 6px;vertical-align: middle;"
                                                                    class="nikosh">
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
                                                                    style="border:1px;  font-size: 16px; padding-bottom: 15px; min-width: 20px;">
                                                                    মৌজাঃ <?php echo $header_info['name_bd']; ?></td>
                                                                <td colspan="2" style="border:1px; padding-bottom: 15px;  font-size: 16px;">
                                                                    জে, এল,
                                                                    নংঃ <?php echo eng_to_bangla_code($jl_number); ?></td>
                                                                {{-- <php echo eng_to_bangla_code(substr($header_info['dglr_code'], -3)); ?></td> --}}
                                                                <td colspan="2" style="border:0px;  font-size: 15px; padding-bottom: 15px;">
                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <?php $count = 0; ?>
                                                        <table class="d"
                                                               style='width: 1090px; margin: 0 auto'>
                                                            <tbody>
                                                            <tr>
                                                                <td>এই খতিয়ানটি প্রদানযোগ্য নয় | অপ্রদান এর কারন :</td>
                                                            </tr>
                                                            @foreach ($batch_khotians[0]['non_provide'] as $key => $value)
                                                                <tr>
                                                                    <td>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($count + 1) }}
                                                                        . {{ $non_provide[$value] }}</td>
                                                                </tr>
                                                                <?php $count++; ?>
                                                            @endforeach

                                                            {{-- @dd($batch_khotians[0]['non_provide']) --}}

                                                            </tbody>
                                                        </table>

                                                        @if ($isAclandUser)
                                                            <table class="d" style='width: 1090px; margin: 0 auto;text-align: center'>
                                                                <tr style='line-height:100px;'>
                                                                    {{-- <td style="padding-bottom: 10px;font-family: nikoshBAN;">প্রস্তাবিত
                                                                        খতিয়ান
                                                                    </td> --}}
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
                                                                             style="margin-left:130% " width="140" height="140"/></td>
                                                                </tr>--}}
                                                            </table>

                                                        @elseif (!$isAclandUser)
                                                            <table class="d" style='width: 1090px; margin: 0 auto'>
                                                                <tr style='line-height:100px;'>
                                                                    {{-- <td style="padding-bottom: 10px;font-family: nikoshBAN;">প্রস্তাবিত
                                                                        খতিয়ান
                                                                    </td> --}}
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">নকলকারী</td>
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">যাচাইকারী</td>
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">তুলনাকারী</td>
                                                                    <td style="padding-bottom: 10px;font-family: nikoshBAN;">অনুমোদনকারী
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        @endif

                                                    </div>

                                                    <?php

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
                                                            /* overflow: hidden; */
                                                            overflow: auto;
                                                            /* margin-top:4px;  */
                                                        }

                                                        ::-webkit-scrollbar {
                                                            width: 10px;
                                                        }

                                                        .handle { /* Thin line seperator */
                                                            position: absolute;
                                                            left: 50%;
                                                            top: 69px;
                                                            bottom: 0;
                                                            width: 4px;
                                                            margin-left: -2px;

                                                            background: rgba(0, 0, 0, .5);
                                                            cursor: ew-resize;
                                                            /* margin-top:3.5vh;  */
                                                        }

                                                        .handle:after { /* Big orange knob  */
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

                                                            background: #760eca; /* @orange */
                                                            border: 1px solid #ecedf1; /* darken(@orange, 5%) */
                                                            border-radius: 50%;
                                                            transition: all 0.3s ease;
                                                            box-shadow: 0 2px 6px rgba(0, 0, 0, .3),
                                                            inset 0 2px 0 rgba(255, 255, 255, .5),
                                                            inset 0 60px 50px -30px #760eca; /* lighten(@orange, 20%)*/
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
                                    @if ($record->scan_copy)
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

                        @if($isAclandUser)
                            {{-- Muted Khotian Area --}}
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    @if($khotian[0]['stage'] == \Modules\Khotian\App\Models\MutedKhotian::STAGE_WRITER)
                                        {{--<form action="#">
                                                                <textarea required class="form-control" name="writer_remark"
                                                                          id="writer_remark" rows="5"
                                                                          placeholder="{{__('আপনার মতামত প্রদান করুন')}}"></textarea>
                                            <button type="button" id="send_to_compare"
                                                    data-action="{{ route('admin.khotians.entry.send_to_compare', [$khotian[0]['id'], $khotian[0]['khotian_number']]) }}"
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
                                        <form action="#" id="approve_return_form" method="POST">
                                            {{ method_field("POST") }}
                                            {{ csrf_field() }}
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    {{ __('আপনি কি ফেরত পাঠাতে চান?') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body" id="approve_return_model_body">
                                                <input type="hidden" id="remark_approve_return" name="remark">
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                                       value="{{ __('হ্যাঁ') }}">
                                                <button type="button" class="btn btn-default pull-right"
                                                        data-dismiss="modal">{{ __('বন্ধ করুন') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
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

        /*added for slider end */
    </script>
@endpush
