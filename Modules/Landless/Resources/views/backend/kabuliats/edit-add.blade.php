@php
    $edit = !empty($kabuliat->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();

    $langBn = Session::get('locale') != 'en';
@endphp


@extends('master::layouts.master')
@section('title')
    {{!$edit ? __('generic.add_new_kabuliat'): __('generic.update_kabuliat')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{!$edit ? __('generic.add_new_kabuliat'): __('generic.edit_kabuliat')}}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.kabuliats.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{$edit ? route('admin.kabuliats.update', $kabuliat->id) : route('admin.kabuliats.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    @if($edit)
                        @method('put')
                    @endif
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="case_no">{{ __('generic.settlement_case') }} </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control custom-form-control"
                                               name="case_no"
                                               id="case_no"
                                               value="{{$edit ? $kabuliat->case_no : ''}}"
                                               placeholder="{{ __('generic.number') }}"/>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control custom-form-control"
                                               name="case_year"
                                               id="case_year"
                                               value="{{$edit ? $kabuliat->case_year : ''}}"
                                               placeholder="{{ __('generic.year') }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="case_date"> {{ __('generic.date') }} </label>
                                <div class="input-group">
                                    <input type="text"
                                           class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                           name="case_date"
                                           id="case_date"
                                           placeholder="{{ __('generic.select_date') }}"
                                           value="{{$edit ? $kabuliat->case_date : ''}}"/>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"
                                             style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                            <i class="fas fa-calendar-day"
                                               style="color: #959595; transform: rotateY(180deg);"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_no"> {{ __('generic.confession_form_no') }}  </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="form_no"
                                               id="form_no"
                                               value="{{$edit ? $kabuliat->form_no : ''}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_date"> {{ __('generic.date') }} </label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                                   name="form_date"
                                                   id="form_date"
                                                   placeholder="{{ __('generic.select_date') }}"
                                                   value="{{$edit ? $kabuliat->form_date : ''}}"/>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"
                                                     style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                                    <i class="fas fa-calendar-day"
                                                       style="color: #959595; transform: rotateY(180deg);"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="committee_name"> {{ __('generic.district_Khas_and_settlement_committee') }}  </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="committee_name"
                                               id="committee_name"
                                               value="{{$edit ? $kabuliat->committee_name : ''}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting_date"> {{ __('generic.date') }} </label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                                   name="meeting_date"
                                                   id="meeting_date"
                                                   placeholder="{{ __('generic.select_date') }}"
                                                   value="{{$edit ? $kabuliat->meeting_date : ''}}"/>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"
                                                     style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                                    <i class="fas fa-calendar-day"
                                                       style="color: #959595; transform: rotateY(180deg);"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ulao_proposal_date"> {{ __('generic.ulao_proposal_date') }} </label>
                                <div class="input-group">
                                    <input type="text"
                                           class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                           name="ulao_proposal_date"
                                           id="ulao_proposal_date"
                                           placeholder="{{ __('generic.select_date') }}"
                                           value="{{$edit ? $kabuliat->ulao_proposal_date : ''}}"/>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"
                                             style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                            <i class="fas fa-calendar-day"
                                               style="color: #959595; transform: rotateY(180deg);"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_no"> {{ __('generic.collector_order_no') }}  </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="order_no"
                                               id="order_no"
                                               value="{{$edit ? $kabuliat->order_no : ''}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_date"> {{ __('generic.date') }} </label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                                   name="order_date"
                                                   id="order_date"
                                                   placeholder="{{ __('generic.select_date') }}"
                                                   value="{{$edit ? $kabuliat->order_date : ''}}"/>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"
                                                     style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                                    <i class="fas fa-calendar-day"
                                                       style="color: #959595; transform: rotateY(180deg);"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reg_no"> {{ __('generic.kabuliat_reg_no') }}  </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="reg_no"
                                               id="reg_no"
                                               value="{{$edit ? $kabuliat->reg_no : ''}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reg_date"> {{ __('generic.date') }} </label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                                   name="reg_date"
                                                   id="reg_date"
                                                   placeholder="{{ __('generic.select_date') }}"
                                                   value="{{$edit ? $kabuliat->reg_date : ''}}"/>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"
                                                     style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                                    <i class="fas fa-calendar-day"
                                                       style="color: #959595; transform: rotateY(180deg);"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ulao_return_date"> {{ __('generic.ulao_return_date') }} </label>
                                <div class="input-group">
                                    <input type="text"
                                           class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                           name="ulao_return_date"
                                           id="ulao_return_date"
                                           placeholder="{{ __('generic.select_date') }}"
                                           value="{{$edit ? $kabuliat->reg_date : ''}}"/>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"
                                             style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                            <i class="fas fa-calendar-day"
                                               style="color: #959595; transform: rotateY(180deg);"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="handover_date"> {{ __('generic.handover_date') }} </label>
                                <div class="input-group">
                                    <input type="text"
                                           class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                           name="handover_date"
                                           id="handover_date"
                                           placeholder="{{ __('generic.select_date') }}"
                                           value="{{$edit ? $kabuliat->handover_date : ''}}"/>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"
                                             style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                            <i class="fas fa-calendar-day"
                                               style="color: #959595; transform: rotateY(180deg);"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit"
                                    class="btn btn-warning form-submit" name="save_as_draft"
                                    value="5">{{ __('generic.save_as_draft') }}</button>
                            <button type="submit"
                                    class="btn btn-success form-submit">{{ /*$edit ?__('generic.update') : */__('generic.save') }}</button>
                        </div>
                    </div>
                    <div class="overlay" style="display: none">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
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
                        {{ __('generic.uploaded_file') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img
                        src="{{ !empty($kabuliat->attached_file)? asset("storage/{$kabuliat->attached_file}"):'' }}"
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
            width: 150px;
            left: 0;
            bottom: -45px;
        }

        em#file_type-error {
            position: absolute;
            width: 150px;
            left: -13px;
            bottom: -31px;
        }

        em#father_is_alive-error {
            position: absolute;
            width: 150px;
            left: -13px;
            bottom: -31px;
        }

        .custom-file-input:lang(en) ~ .custom-file-label::after {
            content: "Browse";
            height: 43px;
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

            const EDIT = !!'{{$edit}}';

            $.validator.addMethod(
                "nidBn",
                function (value, element) {
                    let regexp = /^([০-৯]{10}|[০-৯]{17})$/i;
                    let regexp1 = /^(\d{10}|\d{17})$/i;
                    let re = new RegExp(regexp);
                    let re1 = new RegExp(regexp1);
                    return this.optional(element) || re.test(value) || re1.test(value);
                },
                "সঠিক এন.আই.ডি প্রদান করুন [শুধুমাত্র ১০/১৭ সংখ্যার এন.আই.ডি প্রদান করুন] "
            );

            const editAddForm = $('.edit-add-form');
            editAddForm.validate({

                rules: {
                    case_no: {
                        required: true,
                    },
                    case_year: {
                        required: true,
                        minlength: 4,
                        maxlength: 4,
                    },
                    case_date: {
                        required: true,
                    },
                    form_no: {
                        required: true,
                    },
                    form_date: {
                        required: true,
                    },
                    committee_name: {
                        required: true,
                    },
                    meeting_date: {
                        required: true,
                    },
                    ulao_proposal_date: {
                        required: true,
                    },
                    order_no: {
                        required: true,
                    },
                    order_date: {
                        required: true,
                    },
                    reg_no: {
                        required: true,
                    },
                    reg_date: {
                        required: true,
                    },
                    ulao_return_date: {
                        required: true,
                    },
                    handover_date: {
                        required: true,
                    },


                },
                messages: {
                    case_no: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    case_year: {
                        required: '{{ __('generic.field_is_required') }}',
                        minlength: '{{ __('generic.minlength_4') }}',
                        maxlength: '{{ __('generic.maxlength_4') }}',
                    },
                    case_date: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    form_no: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    form_date: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    committee_name: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    meeting_date: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    ulao_proposal_date: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    order_no: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    order_date: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    reg_no: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    reg_date: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    ulao_return_date: {
                        required: '{{ __('generic.field_is_required') }}',
                    },
                    handover_date: {
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
                            $('.overlay').hide();
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

            $('.identity_type').on('change', function () {
                let identityType = $(this).val();
                if (identityType == 1 || identityType == 2) {
                    $('#fullname').prop('readonly', false);
                    $('#identity_number').prop('readonly', false);
                }

                if (identityType == 3) {
                    $('#identity_number').prop('readonly', true);
                }


                if (identityType == 2) {
                    $.validator.addClassRules('identity_number', {
                        required: true,
                        nidBn: true,
                    });

                    $('#user_check_submit').removeClass('d-none');
                    $('#user_check_submit').prop('disabled', false);
                    $('#is_validate_nid').prop('disabled', false);
                } else {
                    $.validator.addClassRules('identity_number', {
                        required: true,
                        nidBn: false,
                    });

                    $('#user_check_submit').addClass('d-none');
                    $('#user_check_submit').prop('disabled', true);
                    $('#is_validate_nid').prop('disabled', true);
                    $('#is_validate_nid').val(null);
                }
            });

            function loadUpazilas() {
                showLoader();
                let districtBbcCode = $('#loc_district_bbs').val();

                if (districtBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-upazilas') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'district_bbs_code': districtBbcCode,
                        },
                        success: function (response) {
                            /*$('#loc_upazila_bbs').html('');
                            $('#loc_upazila_bbs').html('<option value="">নির্বাচন করুন</option>');

                            $('#loc_union_bbs').html('');
                            $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');*/

                            $.each(response, function (key, value) {
                                $('#loc_upazila_bbs').append(
                                    '<option value="' + value.bbs_code + '">' + (langEn ? value.title_en : value.title) + '</option>'
                                );
                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });

                } else {
                    $('#loc_upazila_bbs').html('');
                    $('#loc_upazila_bbs').html('<option value="">নির্বাচন করুন</option>');

                    $('#loc_union_bbs').html('');
                    $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');
                    hideLoader();
                }
            }

            $('#loc_division_bbs').on('change', function () {
                showLoader();
                let divisionBbcCode = $('#loc_division_bbs').val();

                console.log('divisionBbcCode', divisionBbcCode)

                if (divisionBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-districts') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'division_bbs_code': divisionBbcCode,
                        },
                        success: function (response) {
                            $('#loc_district_bbs').html('');
                            $('#loc_district_bbs').html('<option value="">নির্বাচন করুন</option>');

                            $('#loc_upazila_bbs').html('');
                            $('#loc_upazila_bbs').html('<option value="">নির্বাচন করুন</option>');

                            $('#loc_union_bbs').html('');
                            $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');

                            $.each(response, function (key, value) {

                                if (value.bbs_code == "75") {
                                    //75 is Noakhali district
                                    $('#loc_district_bbs').append(
                                        '<option value="' + value.bbs_code + '" ' + /*(value.bbs_code == "75" ? "selected" : "") +*/ '>' + (langEn ? value.title_en : value.title) + '</option>'
                                    );
                                }

                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                } else {
                    $('#loc_district_bbs').html('');
                    $('#loc_district_bbs').html('<option value="">নির্বাচন করুন</option>');

                    $('#loc_upazila_bbs').html('');
                    $('#loc_upazila_bbs').html('<option value="">নির্বাচন করুন</option>');

                    $('#loc_union_bbs').html('');
                    $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');

                    hideLoader();
                }
            });

            $('#loc_district_bbs').on('change', function () {
                loadUpazilas();
            });

            $('#loc_upazila_bbs').on('change', function () {
                showLoader();
                let upazilaBbcCode = $(this).val();
                let DistrictBbsCode = $('#loc_district_bbs').val();
                let DivisionBbsCode = $('#loc_division_bbs').val();

                if (upazilaBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-unions') }}',
                        data: {
                            'division_bbs_code': DivisionBbsCode,
                            'district_bbs_code': DistrictBbsCode,
                            'upazila_bbs_code': upazilaBbcCode,
                        },
                        success: function (response) {
                            $('#loc_union_bbs').html('');
                            $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');
                            $.each(response, function (key, value) {
                                $('#loc_union_bbs').append(
                                    '<option value="' + value.bbs_code + '">' + (langEn ? value.title_en : value.title) + '</option>'
                                );
                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });

                } else {
                    $('#loc_union_bbs').html('');
                    $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');
                    hideLoader();
                }
            });

            $('#attached_file').on('change', function () {
                let fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            if ($('#loc_division_bbs').val() != '') {
                showLoader();
                let divisionBbcCode = $('#loc_division_bbs').val();

                if (divisionBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-districts') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'division_bbs_code': divisionBbcCode,
                        },
                        success: function (response) {
                            $.each(response, function (key, value) {

                                if (value.bbs_code == "75") {
                                    //75 is Noakhali district
                                    $('#loc_district_bbs').append(
                                        '<option value="' + value.bbs_code + '" ' + (value.bbs_code == "75" ? "selected" : "") + '>' + (langEn ? value.title_en : value.title) + '</option>'
                                    );
                                }

                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                }
                hideLoader();
            }

            setTimeout(function () {
                //when create
                if ($('#loc_district_bbs').val() != '') {
                    loadUpazilas();
                }
            }, 500);


            /**
             * NID Validation Start
             * **/
            $('#user_check_submit').on('click', function (e) {
                e.preventDefault();
                $(".edit-add-form").validate().element('#identity_number');
                $(".edit-add-form").validate().element('#date_of_birth');

                let nidNo = $('#identity_number').val();
                let nidDoB = $('#date_of_birth').val();
                if (!nidNo || !nidDoB) {
                    return false;
                }
                showLoader();
                $.ajax({
                    url: "{{ route('admin.get-owners-info-from-nid-api') }}",
                    data: {
                        nid: nidNo,
                        date_of_birth: nidDoB
                    },
                    type: "POST",
                    success: function (response) {
                        console.log(response);
                        if (response.name !== undefined) {
                            $('#fullname').val(langEn ? response.name : response.name_bn);
                            $('#fullname').prop('readonly', true);
                            $('#identity_number').prop('readonly', true);
                            $('.date_of_birth').prop('readonly', true);
                            $('#is_validate_nid').val('validated');

                            swal({
                                title: '{{ __('generic.all_right') }}',
                                text: '{{ __('generic.user_info_found') }}',
                                buttons: {
                                    text: "{{ __('generic.ok') }}",
                                },
                                icon: "success",
                            })
                        } else {
                            swal({
                                title: '{{ __('generic.all_wrong') }}',
                                text: '{{ __('generic.try_again') }}',
                                buttons: {
                                    text: "{{ __('generic.ok') }}",
                                },
                                icon: "error",
                            })
                        }
                        hideLoader();
                    },
                    complete: function () {
                        hideLoader();
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr)
                        alert('অনাকাঙ্খিত ত্রুটি!' + xhr.responseJSON.message);
                        hideLoader();
                    }
                });
            });

            $("#fullname, #identity_number, #date_of_birth").change(function () {
                if ($('#identity_type_2').is(':checked')) {
                    $('#is_validate_nid').val(null);
                    $('#user_check_submit').prop('disabled', false);
                    $('#user_check_submit').removeClass('d-none');
                }
            });

            $('.form-submit').on('click', function () {
                if ($('#identity_type_2').is(':checked') && $('#is_validate_nid').val() == '') {
                    swal({
                        title: '{{ __('generic.all_wrong') }}',
                        text: '{{ __('generic.first_verify_nid') }}',
                        buttons: {
                            text: "{{ __('generic.ok') }}",
                        },
                        icon: "error",
                    })
                }
            });

            $(document).on("keypress", "#case_year", function (event) {
                let txt = $(this).attr('id');
                if (event.key === 'Enter') {
                    return false;
                }
                toBnText(document.getElementById(txt), event, false);
                return false;
            });


        })();
    </script>
@endpush


