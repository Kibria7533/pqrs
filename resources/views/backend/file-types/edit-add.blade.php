@php
    $edit = !empty($fileType->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')
@section('title')
    {{!$edit ? __('generic.create_file_type'): __('generic.edit_file_type')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{!$edit ? __('generic.create_file_type'): __('generic.edit_file_type')}}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.file-types.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="POST"
                      action="{{$edit ? route('admin.file-types.update', $fileType->id) : route('admin.file-types.store')}}"
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
                                            for="title">{{ __('generic.name_bn') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               name="title"
                                               id="title"
                                               value="{{ $edit ? $fileType->title:'' }}"
                                               class="form-control custom-form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="title_en">{{ __('generic.name_en') }}
                                        </label>
                                        <input type="text"
                                               name="title_en"
                                               id="title_en"
                                               value="{{ $edit ? $fileType->title_en:'' }}"
                                               class="form-control custom-form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="title_en">{{ __('generic.short_code') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               name="short_code"
                                               id="short_code"
                                               value="{{ $edit ? $fileType->short_code:'' }}"
                                               class="form-control custom-form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="">{{ __('generic.allow_format') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            @foreach(\Modules\Landless\App\Models\FileType::FILE_EXTENSIONS as $key=>$value)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           id="allow_format_{{$key}}"
                                                           name="allow_format[]"
                                                           value="{{ $value }}"
                                                    @if($edit && in_array($value, $fileTypes))
                                                        {{ 'checked' }}
                                                        @endif
                                                    >
                                                    <label class="form-check-label"
                                                           for="allow_format_{{$key}}">{{ $value }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="order_number">{{ __('generic.order_number') }}
                                        </label>
                                        <input type="text"
                                               name="order_number"
                                               id="order_number"
                                               value="{{ $edit? $fileType->order_number:'' }}"
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
                    title: {
                        required: true,
                    },
                    title_en: {
                        required: false,
                    },
                    short_code: {
                        required: true,
                    },
                    'allow_format[]': {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    title_en: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    short_code: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    'allow_format[]': {
                        required: '{{ __('generic.field_is_required') }}',
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


