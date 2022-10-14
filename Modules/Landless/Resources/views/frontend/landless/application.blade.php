@extends('master::layouts.landing-page-master')

@section('title')
    {{ __('cadt')}}
@endsection

@php
    $langBn = Session::get('locale') != 'en';
    $edit = false;
@endphp

@section('content')
    <div class="container">
        <div class="card my-2" style="background: #f6f6f6c4;">
            <div class="card-header">
                <h3 class="font-weight-bold text-center">
                    {{ __('User Registration')}}
                </h3>
            </div>
            <div class="card-body p-1">
                <form class="edit-add-form" method="post"
                      action="{{route('landless.application.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="accordion mb-2" id="accordionExample">
                        <div id="step1" class="card rounded">
                            <div class="card-header" id="heading1" style="background: #f7f7f7">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left text-bold" type="button"
                                            data-toggle="collapse" data-target="#collapse1" aria-expanded="true"
                                            aria-controls="collapse1">
                                        {{ __('User Information') }}
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
                                                    {{ __('Name') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="fullname"
                                                       id="fullname"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mobile"> {{ __('Mobile No') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="mobile"
                                                       id="mobile"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email"> {{ __('Email') }}
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="email"
                                                       id="email"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="passwors"> {{ __('Password') }}
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="password"
                                                       id="password"/>
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
                                                                   value="{{ $key }}">
                                                            <label class="custom-control-label"
                                                                   for="gender_{{ $key }}">
                                                                {{ __($value) }}
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
                        <div class="col-md-12 text-right mb-2">
                            <button type="submit" name="status" value="3"
                                    class="btn btn-success form-submit btn-lg px-5">{{ __('Apply') }}</button>
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


        (function () {
            function showLoader() {
                $('#loading-sniper').show();
                $('body').css('overflow', 'hidden');
            }

            function hideLoader() {
                $('#loading-sniper').hide();
                $('body').css('overflow', 'auto');
            }

            $.validator.addMethod(
                "mobileValidation",
                function (value, element) {
                    let regexp1 = /^(?:\+88|88)?(01[3-9]\d{8})$/i;
                    let regexp = /^(?:\+৮৮|৮৮)?(০১[৩-৯][০-৯]{8})$/i;
                    let re = new RegExp(regexp);
                    let re1 = new RegExp(regexp1);
                    return this.optional(element) || re.test(value) || re1.test(value);
                },
                "সঠিক মোবাইল নাম্বার লিখুন"
            );

            const editAddForm = $('.edit-add-form');
            editAddForm.validate({

                rules: {
                    fullname: {
                        required: true,
                        //pattern: /^[\s'\u0980-\u09ff]+$/,
                    },
                    mobile: {
                        required: true,
                        mobileValidation: true,
                    },
                    email: {
                        required: false,
                    },
                    password: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    }

                },
                messages: {
                    fullname: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    mobile: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    email: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    password: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    gender: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                },
                submitHandler: function (htmlForm) {
                    // $('#loading-sniper').show();

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

                            // $('#loading-sniper').hide();
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


            $('.file_modal_show').click(function (i, j) {
                $('#modal_img').attr('src', $(this)[0].dataset.action);
                $('#scan_file_viewer').modal('show');
            });

        })();


    </script>
@endpush


