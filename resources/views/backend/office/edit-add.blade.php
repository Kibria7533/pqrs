@php
    $edit = !empty($office->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')
@section('title')
    {{!$edit ? __('generic.office_create'): __('generic.office_edit')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{!$edit ? __('generic.office_create'): __('generic.office_edit')}}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.offices.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="POST"
                      action="{{$edit ? route('admin.offices.update', $office->id) : route('admin.offices.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    @if($edit)
                        @method('put')
                    @endif
                    <div class="row p-2">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="name_bn">{{ __('generic.name_bn') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               name="name_bn"
                                               id="name_bn"
                                               value="{{ $edit ? $office->name_bn:'' }}"
                                               class="form-control custom-form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="name_en">{{ __('generic.name_en') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               name="name_en"
                                               id="name_en"
                                               value="{{ $edit ? $office->name_en:'' }}"
                                               class="form-control custom-form-control">
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="office_type">{{ __('generic.office_type') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="office_type"
                                                id="office_type"
                                                class="form-control custom-form-control select2">
                                            <option value="" disabled selected>
                                                নির্বাচন করুন
                                            </option>
                                            @foreach(\App\Models\Office::OFFICE_TYPE as $key => $value)
                                                <option
                                                    value="{{ $key }}" {{ $edit && $office->office_type == $key ? 'selected':'' }}>{{ $value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="jurisdiction">{{ __('generic.jurisdiction') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="jurisdiction"
                                                id="jurisdiction"
                                                class="form-control custom-form-control select2"
                                                data-placeholder="{{ __('generic.select_placeholder') }}">
                                            <option value="" disabled selected>
                                                {{ __('generic.select_placeholder') }}
                                            </option>
                                            @foreach(\App\Models\Office::JURISDICTION  as $key => $value)
                                                <option
                                                    value="{{ $key }}" {{ $edit && $office->jurisdiction == $key ? 'selected':'' }}>{{ __('generic.'.$value)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4" id="division-area">
                                    <div class="form-group">
                                        <label for="division_bbs_code">{{ __('generic.division') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="division_bbs_code"
                                                id="division_bbs_code"
                                                class="form-control  custom-form-control select2"
                                                {{ $edit && $office->division_bbs_code?'':'disabled' }}
                                                data-placeholder="{{ __('generic.select_placeholder') }}">
                                            <option value="">নির্বাচন করুন</option>
                                            @foreach($locDivisions as $key=>$value)
                                                <option
                                                    value="{{ $value->bbs_code }}" {{ $edit && $office->division_bbs_code == $value->bbs_code ? 'selected':'' }}>{{ $value->title_en }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="district-area">
                                    <div class="form-group">
                                        <label for="district_bbs_code">{{ __('generic.district') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="district_bbs_code"
                                                id="district_bbs_code"
                                                class="form-control custom-form-control select2"
                                                {{ $edit && $office->district_bbs_code?'':'disabled' }}
                                                data-placeholder="{{ __('generic.select_placeholder') }}">
                                            <option value="" disabled
                                                    selected> {{ __('generic.select_placeholder') }}</option>
                                            @if($edit && $office->district_bbs_code)
                                                @foreach($locDistricts as $value)
                                                    <option
                                                        value="{{ $value->bbs_code }}" {{ $office->district_bbs_code == $value->bbs_code ? 'selected':'' }}>{{ $value->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4" id="upazila-area">
                                    <div class="form-group">
                                        <label for="upazila_bbs_code">{{ __('generic.upazila') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="upazila_bbs_code"
                                                id="upazila_bbs_code"
                                                class="form-control custom-form-control select2"
                                                {{ $edit && $office->upazila_bbs_code?'':'disabled' }}
                                                data-placeholder="{{ __('generic.select_placeholder') }}">
                                            <option value="" disabled
                                                    selected> {{ __('generic.select_placeholder') }}</option>

                                            @if($edit && $office->upazila_bbs_code)
                                                @foreach($locUpazilas as $value)
                                                    <option
                                                        value="{{ $value->bbs_code }}" {{ $office->upazila_bbs_code == $value->bbs_code ? 'selected':'' }}>{{ $value->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4" id="upazila-area">
                                    <div class="form-group">
                                        <label for="union_bbs_code">{{ __('generic.union') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="union_bbs_code"
                                                id="union_bbs_code"
                                                class="form-control custom-form-control select2"
                                                {{ $edit && $office->union_bbs_code?'':'disabled' }}
                                                data-placeholder="{{ __('generic.select_placeholder') }}">
                                            <option value="" disabled
                                                    selected> {{ __('generic.select_placeholder') }}</option>

                                            @if($edit && $office->union_bbs_code)
                                                @foreach($locUnions as $value)
                                                    <option
                                                        value="{{ $value->bbs_code }}" {{ $office->union_bbs_code == $value->bbs_code ? 'selected':'' }}>{{ $value->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dglr_code">{{ __('generic.dglr_code') }}
                                        </label>
                                        <input type="text"
                                               name="dglr_code"
                                               id="dglr_code"
                                               value="{{ $edit? $office->dglr_code:'' }}"
                                               class="form-control custom-form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="org_code">{{ __('generic.org_code') }}
                                        </label>
                                        <input type="text"
                                               name="org_code"
                                               id="org_code"
                                               value="{{ $edit? $office->org_code:'' }}"
                                               class="form-control custom-form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col-md-12">
                            <input type="submit"
                                   class="btn btn-success px-3 float-right mx-2"
                                   value="{{ $edit? __('generic.update') : __('generic.save') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="loading-sniper"
         style="z-index: 99999; position: fixed; height: 100vh;width: 100%;top: 0px; left: 0; right: 0; bottom: 0px; background: rgba(0,0,0,.4); display: none; overflow: hidden;">
        <div class="holder" style="width: 200px;height: 200px;position: relative; margin: 10% auto;">
            <img src="/images/loading.gif" style="width: 75px;margin: 34%;">
        </div>
    </div>
@stop


@push('css')
    <style>
        .form-group label.required::after {
            color: red;
            content: "*";
            left: 5px;
            position: relative;
        }

        [class*="col-"] {
            margin-bottom: 0px !important;
        }
    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

            /**
             * datepicker Configuration
             * **/
            $(function () {
                $('.datepicker').datepicker({
                    dateFormat: "yy-mm-dd",
                    maxDate: '+0d'
                });

            });

            const editAddForm = $('.edit-add-form');
            editAddForm.validate({
                errorElement: "em",
                onkeyup: false,
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    element.parents(".form-group").addClass("has-feedback");

                    if (element.parents(".form-group").length) {
                        error.insertAfter(element.parents(".form-group").first().children().last());
                    } else if (element.hasClass('select2') || element.hasClass('select2-ajax-custom') || element.hasClass('select2-ajax')) {
                        error.insertAfter(element.parents(".form-group").first().find('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                    $(element).closest('.help-block').remove();
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                },
                rules: {
                    name_bn: {
                        required: true,
                    },
                    name_en: {
                        required: true,
                    },
                    office_type: {
                        required: true,
                    },
                    jurisdiction: {
                        required: true,
                    },
                    division_bbs_code: {
                        required: true,
                    },
                    district_bbs_code: {
                        required: true,
                    },
                    upazila_bbs_code: {
                        required: true,
                    },
                    union_bbs_code: {
                        required: true,
                    },
                    dglr_code: {
                        required: false,
                        pattern: /^\+?(0|[1-9]\d*)$/
                    },
                    org_code: {
                        required: false,
                    },
                },
                messages: {
                    name_bn: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    name_en: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    office_type: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    jurisdiction: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    division_bbs_code: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    district_bbs_code: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    upazila_bbs_code: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    union_bbs_code: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    dglr_code: {
                        required: false,
                        pattern: /^\+?(0|[1-9]\d*)$/
                    },
                    org_code: {
                        required: false,
                    },
                },
                submitHandler: function (htmlForm) {
                    $('.overlay').show();

                    // Get some values from elements on the page:
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
                            console.log('response', response)
                            $('.overlay').hide();
                            let alertType = response.alertType;
                            let alertMessage = response.message;
                            let alerter = toastr[alertType];
                            alerter ? alerter(alertMessage) : toastr.error("toastr alert-type" + alertType + " is unknown");

                            if (response.redirectTo) {
                                setTimeout(function () {
                                    window.location.href = response.redirectTo;
                                }, 100);
                            }

                        },
                    });

                    return false;
                }
            });

            function resetGeoLocationField() {
                $('#division_bbs_code').val($('#division_bbs_code option:first-child').val()).trigger('change');
                hideLoader();
                $('#district_bbs_code').html('');
                $('#district_bbs_code').html('<option value="">নির্বাচন করুণ</option>');
                $('#upazila_bbs_code').html('');
                $('#upazila_bbs_code').html('<option value="">নির্বাচন করুণ</option>');
            }

            $('#jurisdiction').on('change', function () {
                let jurisdiction = $(this).val();
                resetGeoLocationField();

                if (jurisdiction === 'division') {
                    $('#division_bbs_code').prop('disabled', false);
                    $('#district_bbs_code').prop('disabled', true);
                    $('#upazila_bbs_code').prop('disabled', true);
                    $('#union_bbs_code').prop('disabled', true);
                }

                if (jurisdiction === 'district') {
                    $('#division_bbs_code').prop('disabled', false);
                    $('#district_bbs_code').prop('disabled', false);
                    $('#upazila_bbs_code').prop('disabled', true);
                    $('#union_bbs_code').prop('disabled', true);
                }

                if (jurisdiction === 'upazila') {
                    $('#division_bbs_code').prop('disabled', false);
                    $('#district_bbs_code').prop('disabled', false);
                    $('#upazila_bbs_code').prop('disabled', false);
                    $('#union_bbs_code').prop('disabled', true);
                }

                if (jurisdiction === 'union') {
                    $('#division_bbs_code').prop('disabled', false);
                    $('#district_bbs_code').prop('disabled', false);
                    $('#upazila_bbs_code').prop('disabled', false);
                    $('#union_bbs_code').prop('disabled', false);
                }
            });

            $('#division_bbs_code').on('change', function () {
                showLoader();
                $('#district_bbs_code').html('');
                $('#district_bbs_code').html('<option value="">{{ __('generic.select_placeholder') }}</option>');
                $('#upazila_bbs_code').html('');
                $('#upazila_bbs_code').html('<option value="">{{ __('generic.select_placeholder') }}</option>');
                $('#union_bbs_code').html('');
                $('#union_bbs_code').html('<option value="">{{ __('generic.select_placeholder') }}</option>');

                let divisionBbcCode = $(this).val();
                if (divisionBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-districts') }}',
                        data: {
                            'division_bbs_code': divisionBbcCode,
                        },
                        success: function (response) {
                            $.each(response, function (key, value) {
                                $('#district_bbs_code').append(
                                    '<option value="' + value.bbs_code + '">' + value.title + '</option>'
                                );
                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                }
                hideLoader();
            });

            $('#district_bbs_code').on('change', function () {
                showLoader();
                $('#upazila_bbs_code').html('');
                $('#upazila_bbs_code').html('<option value="">নির্বাচন করুণ</option>');

                let districtBbcCode = $(this).val();
                if (districtBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-upazilas') }}',
                        data: {
                            'district_bbs_code': districtBbcCode,
                        },
                        success: function (response) {
                            $.each(response, function (key, value) {
                                $('#upazila_bbs_code').append(
                                    '<option value="' + value.bbs_code + '">' + value.title + '</option>'
                                );
                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });

                }
            });

            $('#upazila_bbs_code').on('change', function () {
                showLoader();
                $('#union_bbs_code').html('');
                $('#union_bbs_code').html('<option value="">নির্বাচন করুণ</option>');

                let divisionBbcCode = $('#division_bbs_code').val();
                let districtBbcCode = $('#district_bbs_code').val();
                let upazilaBbcCode = $(this).val();
                if (districtBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-unions') }}',
                        data: {
                            'division_bbs_code': divisionBbcCode,
                            'district_bbs_code': districtBbcCode,
                            'upazila_bbs_code': upazilaBbcCode,
                        },
                        success: function (response) {
                            $.each(response, function (key, value) {
                                $('#union_bbs_code').append(
                                    '<option value="' + value.bbs_code + '">' + value.title + '</option>'
                                );
                            });
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


