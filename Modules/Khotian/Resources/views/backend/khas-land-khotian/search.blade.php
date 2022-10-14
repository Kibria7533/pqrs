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
                            {{__('generic.add_new_khas_land_khotian')}}
                        </h3>

                        <div class="card-tools">
                            <a href="{{ route('admin.khotians.khasland-khotians.index') }}"
                               class="btn btn-sm btn-primary btn-rounded">
                                <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                            </a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="khotian-search-form">
                            <div class="row">
                                <div class="col-md-4">
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
                                <div class="col-md-4">
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
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jl_number">{{ __('generic.jl_number') }} <span
                                                style="color: red"> * </span></label>
                                        <input type="number" class="form-control custom-form-control"
                                               name="jl_number"
                                               id="jl_number" min="1">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="khotian_number">{{ __('generic.khotian_number') }} <span
                                                style="color: red"> * </span></label>
                                        <input type="text"
                                               class="form-control custom-form-control"
                                               name="khotian_number"
                                               id="khotian_number">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-3">
                                        <label>&nbsp;</label>
                                        <input type="button"
                                               style="height: 45px"
                                               class="btn btn-info w-100"
                                               name="search_khotian"
                                               id="search_khotian"
                                               value="{{ __('generic.search') }}"/>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center">
                                    <h3 id="local-message-area" class="py-3 d-noneM">

                                    </h3>
                                    <h3 id="message-area-khotian-not-found-api" class="py-3 d-none"></h3>
                                    <div id="khotian-display-area" class="d-none">
                                        <div class="card text-center">
                                            <div class="card-header">
                                                <h3 id="message-area">
                                                    <!-- custom msg here -->
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="khotian-info-table">
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                    <div class="float-right">
                                                        <a href="{{ route('admin.khotians.khasland-khotians.index') }}"
                                                           class="btn btn-info rounded dt-edit button-from-view">
                                                            <i class="far fa-window-close"></i> {{ __('generic.cancel') }}
                                                        </a>
                                                        <a href="#" data-toggle="modal" data-target="#saveConfirmation"
                                                           class="btn btn-success rounded dt-edit button-from-view">
                                                            <i class="fas fa-save"></i> {{ __('generic.save') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('utils.delete-confirm-modal')

    <!-- Button trigger modal -->
    <!-- Modal for save-->
    <div class="modal fade" id="saveConfirmation" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="saveConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="saveConfirmationLabel">
                        <i class="fas fa-hdd"></i>
                        {{ __('generic.khotian_save_confirmation') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('generic.khotian_save_confirmation_msg') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning"
                            data-dismiss="modal">{{ __('generic.cancel') }}</button>
                    <button type="button" class="btn btn-success"
                            id="save-khotian">{{ __('generic.confirm') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div id="loading-sniper"
         style="z-index: 99999; position: fixed; height: 100vh;width: 100%;top: 0px; left: 0; right: 0; bottom: 0px; background: rgba(0,0,0,.4); display: none; overflow: hidden;">
        <div class="holder" style="width: 200px;height: 200px;position: relative; margin: 10% auto;">
            <img src="{{ asset('/') }}/images/loading.gif" style="width: 75px;margin: 34%;">
        </div>
    </div>

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
        .application_date {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            box-shadow: inset 0 1px 2px rgb(0 0 0 / 8%);
        }

        .select2-container--bootstrap4 {
            width: auto !important;
        }

        .custom-label {
            min-width: 100px;
            text-align: center;
            display: block;
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
                        console.log('response', response)
                        $('#upazila_bbs_code').html('');
                        $('#upazila_bbs_code').html('<option value="">{{ __('generic.select_placeholder') }}</option>');

                        $.each(response, function (key, value) {
                            $('#upazila_bbs_code').append(
                                '<option value="' + value.bbs_code + '">' + (/*langEn ? value.title_en : */value.title) + '</option>'
                            );
                        });
                    },
                    error: function () {
                        console.log("error");
                    }
                });
            }

            loadUpazilas(districtBbcCode);

            const khotianSearchForm = $('#khotian-search-form');
            khotianSearchForm.validate({

                rules: {
                    division_bbs_code: {
                        required: true,
                    },
                    district_bbs_code: {
                        required: true,
                    },
                    upazila_bbs_code: {
                        required: true,
                    },
                    jl_number: {
                        required: true,
                        min: 1,
                    },
                    khotian_number: {
                        required: true,
                        pattern: /(^[0-9]*$)|(^[0-9]+[\/][0-9]+$)|(^[0-9]+[\-][0-9]+$)/,
                    },
                },
                messages: {
                    division_bbs_code: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    district_bbs_code: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    upazila_bbs_code: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    jl_number: {
                        required: '{{ __('generic.field_is_required') }}',
                        min: '{{ __('generic.min_1') }}',
                    },
                    khotian_number: {
                        required: '{{ __('generic.field_is_required') }}',
                        pattern: '{{ __('generic.input_valid_khotian_no') }}',
                    },
                },

                submitHandler: function (htmlForm) {
                    const form = $(htmlForm);
                    const formData = new FormData(htmlForm);
                    const url = form.attr("action");

                    // Send the data using post
                    $.ajax({
                        url: url,
                        data: formData,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log('submit ajax response', response);
                            //$('.overlay').hide();
                            let alertType = response.alertType;
                            let alertMessage = response.message;
                            let alerter = toastr[alertType];
                            alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");


                            if (response.redirectTo) {
                                setTimeout(function () {
                                    window.location.href = response.redirectTo;
                                }, 1000);
                            }

                        },
                    });

                    return false;
                }
            });

            function findKhotianFromApi(n = false) {
                let divisionBbsCode = $('#division_bbs_code').val();
                let districtBbsCode = $('#district_bbs_code').val();
                let upazilaBbsCode = $('#upazila_bbs_code').val();
                let jlNumber = $('#jl_number').val();
                let khotianNumber = $('#khotian_number').val();

                showLoader();

                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.khotians.khasland-khotian-search') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'division_bbs_code': divisionBbsCode,
                        'district_bbs_code': districtBbsCode,
                        'upazila_bbs_code': upazilaBbsCode,
                        'jl_number': jlNumber,
                        'khotian_number': khotianNumber,
                        'is_save': n ? 1 : 0,
                    },
                    success: function (response) {
                        if (response['local-status']) {
                            $('#local-message-area').removeClass('d-none');
                            $('#local-message-area').html(response['local-message']);
                            $('#khotian-display-area').addClass('d-none');
                            $('#message-area-khotian-not-found-api').addClass('d-none');

                        }

                        if (response['status']) {
                            $('#local-message-area').addClass('d-none');
                            $('#message-area-khotian-not-found-api').addClass('d-none');
                            $('#khotian-display-area').removeClass('d-none');
                            $('#message-area').html('{{ __('generic.khotian_details') }}');

                            let khotianNumber = response['data']['khotian_info']['khotian_number'];
                            let dglrCode = response['data']['khotian_info']['dglr_code'];
                            let jlNumber = response['data']['khotian_info']['jl_number'].toString();
                            let namjariCaseNo = response['data']['khotian_info']['namjari_case_no'];
                            let resaNo = response['data']['khotian_info']['resa_no'];
                            let caseDate = response['data']['khotian_info']['case_date'];

                            let dagNumbers = response['data']['dags'].map(function (e) {
                                return e["dag_number"];
                            }).toString().replace(/,/g, ', ');

                            let ownerNames = response['data']['owners'].map(function (e) {
                                return e["owner_name"];
                            }).toString().replace(/,/g, ', ');

                            $('#khotian-info-table tbody').html('');
                            $('#khotian-info-table tbody').append(
                                "<tr>" +
                                "<th>{{ __('generic.khotian_number') }}</td>" +
                                "<td>" + (khotianNumber ? en2bn(khotianNumber) : '') + "</td>" +
                                "<th>{{ __('generic.jl_number') }}</td>" +
                                "<td>" + (jlNumber ? en2bn(jlNumber) : '') + "</td>" +
                                "</tr>" +
                                "<tr>" +
                                "<th>{{ __('generic.resa_no') }}</td>" +
                                "<td>" + (resaNo ? resaNo : '') + "</td>" +
                                "<th>{{ __('generic.dglr_code') }}</td>" +
                                "<td>" + (dglrCode ? en2bn(dglrCode) : '') + "</td>" +
                                "</tr>" +
                                "<tr>" +
                                "<th>{{ __('generic.namjari_case_no') }}</td>" +
                                "<td>" + (namjariCaseNo ? namjariCaseNo : '') + "</td>" +
                                "<th>{{ __('generic.case_date') }}</td>" +
                                "<td>" + (caseDate ? en2bn(caseDate) : '') + "</td>" +
                                "</tr>" +
                                "<tr>" +
                                "<th colspan='2'>{{ __('generic.dags') }}</td>" +
                                "<th colspan='2'>{{ __('generic.owners') }}</td>" +
                                "</tr>" +
                                "<tr>" +
                                "<td colspan='2'>" + (dagNumbers ? en2bn(dagNumbers) : '') + "</td>" +
                                "<td colspan='2'>" + (ownerNames ? ownerNames : '') + "</td>" +
                                "</tr>"
                            );
                        }

                        if (response['status'] == false && response['data'].length == 0) {
                            $('#local-message-area').addClass('d-none');
                            $('#khotian-display-area').addClass('d-none');
                            $('#message-area-khotian-not-found-api').removeClass('d-none');
                            $('#message-area-khotian-not-found-api').html('{{ __('generic.khotian_not_found') }}');
                        }

                        if (response['success'] == false) {
                            $('#local-message-area').addClass('d-none');
                            $('#khotian-display-area').addClass('d-none');
                            $('#message-area-khotian-not-found-api').removeClass('d-none');
                            $('#message-area-khotian-not-found-api').html('');
                        }

                        if (response.alertType) {
                            let alertType = response.alertType;
                            let alertMessage = response.message;
                            let alerter = toastr[alertType];
                            alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");


                            if (response.redirectTo) {
                                setTimeout(function () {
                                    window.location.href = response.redirectTo;
                                }, 1000);
                            }
                        }

                    },
                    error: function () {
                        console.log("error");
                    }
                });

                setTimeout(function () {
                    hideLoader();
                }, 2000);
            }

            $('#search_khotian').on('click', function (e) {
                e.preventDefault();
                let a = khotianSearchForm.validate().element('#division_bbs_code');
                let b = khotianSearchForm.validate().element('#district_bbs_code');
                let c = khotianSearchForm.validate().element('#upazila_bbs_code');
                let d = khotianSearchForm.validate().element('#jl_number');
                let kn = khotianSearchForm.validate().element('#khotian_number');
                let condition = a && b && c && d && kn;

                if (condition) {
                    findKhotianFromApi();
                }
            });

            $('#save-khotian').on('click', function (e) {
                e.preventDefault();
                khotianSearchForm.validate().element('#division_bbs_code');
                khotianSearchForm.validate().element('#district_bbs_code');
                khotianSearchForm.validate().element('#upazila_bbs_code');
                khotianSearchForm.validate().element('#jl_number');
                khotianSearchForm.validate().element('#khotian_number');

                findKhotianFromApi(true);
            });

            $("#khotian_number, #jl_number, #upazila_bbs_code").change(function () {
                $('#khotian-display-area').addClass('d-none');
            });

        })();
    </script>

@endpush
