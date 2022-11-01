@php
    $edit = !empty($landless->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') != 'en';
@endphp

@extends('master::layouts.master')
@section('title')
    {{!$edit ? __('Add New User'): __('Update User')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card" style="background: #e1e1e1">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{!$edit ? __('Add New User'): __('Update')}}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.landless.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{$edit ? route('admin.landless.update-user', $landless->id) : route('admin.landless.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    @if($edit)
                        @method('put')
                    @endif
                    <div class="accordion mb-2" id="accordionExample">
                        <div id="step1" class="card rounded">
                            <div class="card-header" id="heading1" style="background: #f7f7f7">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left text-bold" type="button"
                                            data-toggle="collapse" data-target="#collapse1" aria-expanded="true"
                                            aria-controls="collapse1">
                                        {{ __('User Info') }}
                                        <i class="fas fa-angle-up float-right"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse1" class="collapse show" aria-labelledby="heading1"
                                 data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fullname">
                                                    {{ __('Name Of The User') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="name"
                                                       id="name"
                                                       value="{{$edit ? $landless->name : ''}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mobile"> {{ __('Mobile No') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="mobile"
                                                       id="mobile"
                                                       value="{{$edit ? $landless->mobile : ''}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email"> {{ __('Email') }}
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="email"
                                                       id="email"
                                                       value="{{$edit ? $landless->email : ''}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    {{ __('Gender') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="position-relative d-flex">
                                                    @foreach(\Modules\Landless\App\Models\Landless::GENDER as $key=>$value)
                                                        <div
                                                            class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" class="custom-control-input gender"
                                                                   id="gender_{{ $key }}"
                                                                   name="gender"
                                                                   value="{{ $key }}" {{ $edit && $landless->gender == $key? 'checked' : '' }} >
                                                            <label class="custom-control-label"
                                                                   for="gender_{{ $key }}">
                                                                {{ __('generic.'.$value) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
{{--                            <button type="submit"--}}
{{--                                    class="btn btn-warning form-submit" name="status"--}}
{{--                                    value="5">{{ __('generic.save_as_draft') }}</button>--}}
                            <button type="submit" name="status" value="3"
                                    class="btn btn-success form-submit">{{ /*$edit ?__('generic.update') : */__('UPDATE') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for  view -->
    <div class="modal fade" id="scan_file_viewer" tabindex="-1" role="dialog"
         aria-labelledby="scan_file_viewerTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scan_file_viewerTitle">
                        {{ __('generic.file') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modal_img"
                         src="{{ !empty($landless->attached_file)? asset("storage/{$landless->attached_file}"):'' }}"
                         alt="{{ __('generic.uploaded_file') }}" width="100%">
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
        em#gender-error {
            position: absolute;
            width: 160px;
            left: 0;
            bottom: -22px;
        }

        em#file_type-error {
            position: absolute;
            width: 160px;
            left: -13px;
            bottom: -31px;
        }

        em#father_is_alive-error, em#mother_is_alive-error {
            position: absolute;
            width: 160px;
            left: -13px;
            bottom: -31px;
        }

        .custom-file-input:lang(en) ~ .custom-file-label::after {
            content: "Browse";
            height: 43px;
        }

        em#file_type_id_1-error {
            position: absolute;
            left: 8px;
            bottom: -7px;
            width: 200px;
        }

    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        const EDIT = !!'{{$edit}}';

        function fileOnChange(rowId) {
            /**
             *Custom file input name showing
             **/
            let fileName = $('#attached_file_' + rowId).val().split("\\").pop();
            $('#attached_file_' + rowId).siblings("#custom-file-label-" + rowId).addClass("selected").html(fileName);

            /**
             *File type frontend remote validation
             **/
            let fileExt = $('#attached_file_' + rowId).val().split('.').pop();
            let fileTypeId = $('option:selected', '#file_type_id_' + rowId).val();
            let url = '{{ route('file-types.check-allow-format','__') }}'.replace('__', fileTypeId);

            $('#attached_file_' + rowId).rules("add", {
                remote: {
                    param: {
                        type: "get",
                        url: url,
                        data: {
                            file_ext: fileExt
                        },
                    }
                },
            });
        }



        (function () {
            function showLoader() {
                $('#loading-sniper').show();
                $('body').css('overflow', 'hidden');
            }

            function hideLoader() {
                $('#loading-sniper').hide();
                $('body').css('overflow', 'auto');
            }




            const editAddForm = $('.edit-add-form');
            editAddForm.validate({

                rules: {
                    name: {
                        required: true,
                        //pattern: /^[\s'\u0980-\u09ff]+$/,
                    },
                    mobile: {
                        mobileValidation: true,
                    },
                    email: {
                        required: false,
                    },
                    gender: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    mobile: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    email: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    gender: {
                        required: "{{ __('generic.field_is_required') }}",
                    },

                },
                submitHandler: function (htmlForm) {
                    $('#loading-sniper').show();
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
                            $('#loading-sniper').hide();
                            let alertType = response.alertType;
                            let alertMessage = response.message;
                            let alerter = toastr[alertType];
                            alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");


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

            let langEn = {{ Session::get('locale') == 'en' ? 1: 0 }};

            $("#fullname, #identity_number, #date_of_birth").change(function () {
                if ($('#identity_type_2').is(':checked')) {
                    $('#is_validate_nid').val(null);
                    $('#user_check_submit').prop('disabled', false);
                    $('#user_check_submit').removeClass('d-none');
                }

                if($('#date_of_birth').val()!=''){
                    $('#date_of_birth').valid();
                }
            });

            $('#heading1 button,#heading2 button, #heading3 button, #heading4 button').on('click', function () {
                if ($(this).children("i").hasClass("fa-angle-up")) {
                    $(this).children("i").removeClass("fa-angle-up");
                    $(this).children("i").addClass("fa-angle-down");
                } else {
                    $(this).children("i").removeClass("fa-angle-down");
                    $(this).children("i").addClass("fa-angle-up");
                }
            });



        })();

    </script>
@endpush


