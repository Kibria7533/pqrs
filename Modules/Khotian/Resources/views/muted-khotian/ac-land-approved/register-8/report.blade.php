@extends('master::layouts.master')

@php
    $edit = !empty($locUnion->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">
                            {{__('generic.view_report')}}
                        </h3>
                    </div>

                    <div class="card-body">
                        <form id="khotian-search-form">
                            <div class="row">
                                @if(empty($userOffice))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="division_bbs_code">{{ __('generic.division') }} <span
                                                    style="color: red"> * </span></label>
                                            <select class="form-control custom-form-control"
                                                    name="division_bbs_code"
                                                    id="division_bbs_code"
                                                    data-placeholder="{{ __('generic.select_placeholder') }}"
                                            >
                                                <option value="{{ $locDivision->bbs_code }}"
                                                        selected>{{ $locDivision->title }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="district_bbs_code">{{ __('generic.district') }} <span
                                                    style="color: red"> * </span></label>
                                            <select class="form-control custom-form-control"
                                                    name="district_bbs_code"
                                                    id="district_bbs_code"
                                                    data-placeholder="{{ __('generic.select_placeholder') }}"
                                            >
                                                <option value="{{ $locDistrict->bbs_code }}"
                                                        selected>{{ $locDistrict->title }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="upazila_bbs_code">{{ __('generic.upazila') }} <span
                                                    style="color: red"> * </span></label>
                                            <select class="form-control custom-form-control select2"
                                                    name="upazila_bbs_code"
                                                    id="upazila_bbs_code"
                                                    data-placeholder="{{ __('generic.select_placeholder') }}"
                                            >
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="division_bbs_code" id="division_bbs_code"
                                           value="{{ $locDivision->bbs_code }}">

                                    <input type="hidden" name="district_bbs_code" id="district_bbs_code"
                                           value="{{ $locDistrict->bbs_code }}">

                                    @if(!empty($userOffice->upazila_bbs_code) && !empty($locUpazila))
                                        <input type="hidden" name="upazila_bbs_code" id="upazila_bbs_code"
                                               value="{{ $userOffice->upazila_bbs_code }}"
                                               data-upazila-name="{{ $locUpazila->title }}">
                                    @else
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="upazila_bbs_code">{{ __('generic.upazila') }} <span
                                                        style="color: red"> * </span></label>
                                                <select class="form-control custom-form-control select2"
                                                        name="upazila_bbs_code"
                                                        id="upazila_bbs_code"
                                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                                >
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                    @foreach($locUpazilas as $key=>$locUpazila)
                                                        <option
                                                            value="{{ $locUpazila->bbs_code }}">{{ $locUpazila->title }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jl_number">
                                            {{ __('generic.mouja') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control custom-form-control select2"
                                                name="jl_number"
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                                id="jl_number">
                                            <option value="">{{ __('generic.select_placeholder') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="register_type">{{ __('অংশ') }} </label>
                                        <select class="form-control custom-form-control select2"
                                                name="register_type"
                                                id="register_type"
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                        >
                                            <option value="">{{ __('generic.select_placeholder') }}</option>
                                            @foreach(\Modules\Khotian\App\Models\MutedKhotian::REG_8_TYPE as $key => $type)
                                                @if(!empty($reg8Type) && $reg8Type == $key)
                                                    <option
                                                        value="{{ $key }}" selected>{{ $type }}</option>
                                                @endif
                                                @if(empty($reg8Type))
                                                    <option
                                                        value="{{ $key }}">{{ $type }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="khotian_number">{{ __('generic.khotian_number') }}</label>
                                        <input type="text"
                                               class="form-control custom-form-control"
                                               name="khotian_number"
                                               id="khotian_number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <label>&nbsp;</label>
                                        <input type="submit" style="height: 45px"
                                               class="btn btn-info w-100"
                                               name="view_report"
                                               id="view_report"
                                               value="{{ __('generic.view_report') }}"/>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-md-12 d-none" id="report-area">
                                <div class="row">
                                    <div class="col-md-12" id="report-table">
                                        <table class="w-100">
                                            <tr>
                                                <td colspan="12">
                                                    <div class="col-md-12 mb-2" id="report-table-header">
                                                        <div class="text-right my-2">
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Button group with nested dropdown">
                                                                <button type="button"
                                                                        class="btn btn-outline-primary"
                                                                        id="print-btn"
                                                                        onclick="window.print()">
                                                                    <i class="fas fa-print"></i>
                                                                    Print
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-5">
                                                            <div class="col-md-12">
                                                                <h3 CLASS="text-center">নবন্ধন বই ৮ - খাস জমি</h3>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>বাংলাদেশ ফরম নম্বর ১০৭২</p>
                                                                <p>(বিধি-২২)</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-4 m-0 p-0" id="register_type_area">
                                                                <p class="m-0" id="register_type_1">অংশ ১ - সাধারনের ব্যবহার্য্য/বন্দোবস্ত প্রদানযোগ্য নহে</p>
                                                                <p class="m-0" id="register_type_2">অংশ ২ - বন্দোবস্তের জমি</p>
                                                                <p class="m-0" id="register_type_3">অংশ ৩ - খরিদকৃত,পুন: অধিগ্রহনকৃত বা পরিত্যক্ত সম্পত্তি</p>
                                                                <p class="m-0" id="register_type_4">অংশ ৪ - শিকস্তি খাস জমির জন্য</p>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <p class="m-0">{{ __('generic.upazila') }}ঃ <span
                                                                                id="upazila-name"></span></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p class="m-0">{{ __('generic.mouja') }}ঃ <span
                                                                                id="mouja-name"></span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table table-bordered">
                                            <thead class="text-center v-align-middle">
                                            <tr>
                                                <td rowspan="2">{{ __('generic.sl_no') }}</td>
                                                <td rowspan="2"> {{ __('generic.dag_number') }}</td>
                                                <td colspan="4">{{ __('দাগের বিবরণ') }}</td>
                                                <td rowspan="2">{{ __('জমির শ্রেনী') }}</td>
                                                <td rowspan="2">{{ __('generic.khotian_number') }}</td>
                                                <td rowspan="2">{{ __('খতিয়ান ভূক্তির তারিখ') }}</td>
                                                <td rowspan="2">{{ __('পরিদর্শনের তারিখ') }}</td>
                                                <td rowspan="2">{{ __('নিবন্ধন বই-১২ অনুযায়ী বন্দোবস্ত কেস নম্বর এবং বন্দোবস্তের তারিখ') }}</td>
                                                <td rowspan="2">{{ __('মন্তব্য') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('মোট জমি') }}</td>
                                                <td>{{ __('মোট খাস জমি') }}</td>
                                                <td>{{ __('রেজিষ্টারে অংশভূক্ত জমি') }}</td>
                                                <td>{{ __('বন্দোবস্ত- প্রদত্ত জমি') }}</td>
                                            </tr>
                                            </thead>
                                            <tbody id="report-table-body">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loading-sniper"
         style="z-index: 99999; position: fixed; height: 100vh;width: 100%;top: 0px; left: 0; right: 0; bottom: 0px; background: rgba(0,0,0,.4); display: none; overflow: hidden;">
        <div class="holder" style="width: 200px;height: 200px;position: relative; margin: 10% auto;">
            <img src="/images/loading.gif" style="width: 75px;margin: 34%;">
        </div>
    </div>

@endsection
@push('css')
    <style>
        @media print {
            @page {
                margin: 0;
            }
            body * {
                visibility: hidden;
            }
            .btn-group {
                display: none;
            }

            #report-area, #report-area * {
                visibility: visible;
            }

            #report-area {
                left: 0px;
                top: 0px;
                position:absolute;
            }
        }

    </style>
@endpush

@push('js')
    <script>
        (function () {

            function showLoader() {
                $('#loading-sniper').show();
                $('body').css('overflow', 'hidden');
            }

            function hideLoader() {
                $('#loading-sniper').hide();
                $('body').css('overflow', 'auto');
            }


            let districtBbcCode = $('#district_bbs_code').val();

            function loadUpazilas(districtBbcCode) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('get-upazilas') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'district_bbs_code': districtBbcCode,
                    },
                    success: function (response) {
                        $('#upazila_bbs_code').html('');
                        $('#upazila_bbs_code').html('<option value="">{{ __('generic.select_placeholder') }}</option>');

                        $.each(response, function (key, value) {
                            $('#upazila_bbs_code').append(
                                '<option value="' + value.bbs_code + '">' + (value.title) + '</option>'
                            );
                        });
                    },
                    error: function () {
                        console.log("error");
                    }
                });
            }

            function loadMoujas() {
                let DivisionBbsCode = $('#division_bbs_code').val();
                let DistrictBbsCode = $('#district_bbs_code').val();
                let upazilaBbcCode = $('#upazila_bbs_code').val();

                if (upazilaBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-moujas') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'division_bbs_code': DivisionBbsCode,
                            'district_bbs_code': DistrictBbsCode,
                            'upazila_bbs_code': upazilaBbcCode,
                        },
                        success: function (response) {
                            $('#jl_number').html('');
                            $('#jl_number').html('<option value="">নির্বাচন করুন</option>');
                            $.each(response, function (key, value) {
                                $('#jl_number').append(
                                    '<option value="' + value.rs_jl_no + '" data-jl-number="' + value.rs_jl_no + '" data-mouja-name="' + value.name_bd + '">' + (value.name_bd) + '</option>'
                                );
                            });
                        },
                        error: function () {
                            console.log("error");
                        }
                    });

                } else {
                    $('#jl_number').html('');
                    $('#jl_number').html('<option value="">নির্বাচন করুন</option>');
                }
            }

            loadUpazilas(districtBbcCode);

            if ($('#upazila_bbs_code').val() != '') {
                loadMoujas();
            }

            $('#upazila_bbs_code').on('change', function () {
                loadMoujas();
                $('#jl_number').val('');

                if ($(this).val() != '') {
                    $(this).valid();
                }
            });

            const khotianSearchForm = $('#khotian-search-form');

            khotianSearchForm.validate({
                rules: {
                    upazila_bbs_code: {
                        required: true,
                    },
                    jl_number: {
                        required: true,
                    },
                },
                messages: {
                    upazila_bbs_code: {
                        required: '<?php echo e(__('generic.field_is_required')); ?>',
                    },
                    jl_number: {
                        required: '<?php echo e(__('generic.field_is_required')); ?>',
                    },
                },
            });
            $('#view_report').on('click', function (e) {
                e.preventDefault();
                khotianSearchForm.validate().element('#upazila_bbs_code');
                khotianSearchForm.validate().element('#jl_number');

                if(khotianSearchForm.validate().element('#jl_number')){
                    showLoader();
                    let divisionBbsCode = $('#division_bbs_code').val();
                    let districtBbsCode = $('#district_bbs_code').val();
                    let upazilaBbsCode = $('#upazila_bbs_code').val();
                    let jlNumber = $('#jl_number').val();
                    let moujaName = $('#jl_number').find(":selected").data('mouja-name');
                    let registerType = $('#register_type').val();
                    let khotianNumber = $('#khotian_number').val();

                    $.ajax({
                        type: 'post',
                        url: '{{ route('admin.khotians.register-eight.report-details') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'division_bbs_code': divisionBbsCode,
                            'district_bbs_code': districtBbsCode,
                            'upazila_bbs_code': upazilaBbsCode,
                            'jl_number': jlNumber,
                            'mouja_name': moujaName,
                            'register_type': registerType,
                            'khotian_number': khotianNumber,
                        },
                        success: function (response) {
                            if (response.header) {
                                $('#report-area').removeClass('d-none');
                                $('#division-name').html(response.header.division ? response.header.division : '');
                                $('#district-name').html(response.header.district ? response.header.district : '');
                                $('#upazila-name').html(response.header.upazila ? response.header.upazila : '');
                                $('#mouja-name').html(response.header.mouja ? response.header.mouja : '');

                                let registerType = response.header.register_type? response.header.register_type:null;

                                for(let i=1; i<=4; i++){
                                    if(i==registerType){
                                        $('#register_type_'+registerType).css("background-color", "yellow");
                                        $('#register_type_'+registerType).css("font-weight", "800");
                                    }else{
                                        $('#register_type_'+i).css("font-weight", "100");
                                        $('#register_type_'+i).css("background-color", "#fff");
                                    }
                                }
                            }

                            if (response.data.length > 0) {
                                $('#report-table-body').html('');
                                $.each(response.data, function (key, value) {
                                    let sl = ++key;
                                    $('#report-table-body').append(
                                        '<tr>'+
                                        '    <td>'+en2bn(sl.toString())+'</td>'+
                                        '    <td>'+(value.dag_number?en2bn(value.dag_number):"")+'</td>'+
                                        '    <td>'+(value.khotian_dag_area?en2bn(value.khotian_dag_area):"")+'</td>'+
                                        '    <td>'+(value.dag_khasland_area?en2bn(value.dag_khasland_area):"")+'</td>'+
                                        '    <td>'+(value.register_khasland_area?en2bn(value.register_khasland_area):"")+'</td>'+
                                        '    <td>'+(value.provided_khasland_area?en2bn(value.provided_khasland_area):"")+'</td>'+
                                        '    <td>'+value.land_type+'</td>'+
                                        '    <td>'+(value.khotian_number?en2bn(value.khotian_number):"")+'</td>'+
                                        '    <td>'+(value.register_entry_date?en2bn(value.register_entry_date):"")+'</td>'+
                                        '    <td>'+(value.visit_date? en2bn(value.visit_date):"")+'</td>'+
                                        '    <td>'+(value.register_12_case_number?en2bn(value.register_12_case_number):"")+'/'+(value.register_12_distribution_date?en2bn(value.register_12_distribution_date):"")+'</td>'+
                                        '    <td>'+value.remark+'</td>'+
                                        '</tr>'
                                    );
                                });
                            }else{
                                $('#report-table-body').html('');
                                $('#report-table-body').append(
                                    '<tr>'+
                                    '<td class="text-danger text-center" colspan="12">{{ __('generic.empty_table') }}</td>'+
                                    '<tr>');
                            }
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                }
            });

        })();
    </script>
@endpush
