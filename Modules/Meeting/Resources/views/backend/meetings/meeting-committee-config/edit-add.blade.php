@php
    $edit = !empty($meeting->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') != 'en';
@endphp


@extends('master::layouts.master')
@section('title')
    {{ __('generic.meeting_committee_config') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{ __('generic.meeting_committee_config') }}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.meeting_management.meetings.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{ route('admin.meeting_management.meetings.meeting-committee-config-store', $meeting) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @can('create', \Modules\Meeting\Models\Notification::class)
                                <div class="float-right">
                                    <a href="{{ route('admin.meeting_management.notifications.create', $meeting) }}"
                                       class="btn btn-sm btn-info d-block font-weight-bold">
                                        <i class="fas fa-bell"></i> {{ __('generic.send_notification') }}
                                    </a>
                                    <span class="text-danger">({{ count($notifications)? "ইতিপূর্বে  ".\App\Helpers\Classes\NumberToBanglaWord::engToBn(count($notifications))."টি নোটিফিকেশন পাঠানো হয়েছে":"ইতিপূর্বে কোন নোটিফিকেশন পাঠানো হয়নি" }})</span>
                                </div>
                            @endcan
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">{{ __('generic.meeting_name') }}
                                            : {{ $meeting->title }}</label>
                                        <input type="hidden" class="form-control custom-form-control"
                                               id="meeting_id"
                                               name="meeting_id"
                                               value="{{ $meeting->id }}" readonly/>

                                        <input type="hidden" class="form-control custom-form-control"
                                               id="committee_setting_id"
                                               name="committee_setting_id"
                                               value="{{ !empty($committeeSetting)? $committeeSetting->id: '' }}"
                                               readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <hr class="m-0">
                                </div>

                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead class="text-center">
                                        <tr>
                                            <th scope="col">{{ __('generic.office_designation') }}</th>
                                            <th scope="col">{{ __('generic.meeting_designation') }}</th>
                                            <th scope="col">{{ __('generic.name') }}</th>
                                            <th scope="col">{{ __('generic.mobile') }}</th>
                                            <th scope="col">{{ __('email') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(!empty($meetingCommittees))
                                            @foreach($meetingCommittees->member_config as $key=>$memberConfig)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $memberConfig['org_designation'] }}
                                                        <input type="hidden"
                                                               class="form-control custom-form-control"
                                                               name="member_config[{{ $key }}][org_designation_id]"
                                                               value="{{ $memberConfig['org_designation_id'] }}"/>
                                                        <input type="hidden"
                                                               class="form-control custom-form-control"
                                                               name="member_config[{{ $key }}][org_designation]"
                                                               value="{{ $memberConfig['org_designation'] }}"/>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $memberConfig['committee_designation'] }}
                                                        <input type="hidden"
                                                               class="form-control custom-form-control"
                                                               name="member_config[{{ $key }}][committee_designation_id]"
                                                               value="{{ $memberConfig['committee_designation_id'] }}"/>
                                                        <input type="hidden"
                                                               class="form-control custom-form-control"
                                                               name="member_config[{{ $key }}][committee_designation]"
                                                               value="{{ $memberConfig['committee_designation'] }}"/>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                               class="form-control custom-form-control name_{{ $key }}"
                                                               name="member_config[{{ $key }}][name]"
                                                               id="name_{{ $key }}"
                                                               value="{{ $memberConfig['name'] }}"
                                                               placeholder="{{ __('generic.name') }}"/>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                               class="form-control custom-form-control mobile_{{ $key }}"
                                                               name="member_config[{{ $key }}][mobile]"
                                                               id="mobile_{{ $key }}"
                                                               value="{{ $memberConfig['mobile'] }}"
                                                               placeholder="{{ __('generic.mobile') }}"/>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                               class="form-control custom-form-control email_{{ $key }}"
                                                               name="member_config[{{ $key }}][email]"
                                                               id="email_{{ $key }}"
                                                               value="{{ $memberConfig['email'] }}"
                                                               placeholder="{{ __('email') }}"/>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        @if(!empty($committeeSetting) && empty($meetingCommittees))
                                            @foreach($committeeSetting->member_config as $key=>$memberConfig)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $memberConfig['org_designation'] }}
                                                        <input type="hidden"
                                                               class="form-control custom-form-control"
                                                               name="member_config[{{ $key }}][org_designation_id]"
                                                               value="{{ $memberConfig['org_designation_id'] }}"/>
                                                        <input type="hidden"
                                                               class="form-control custom-form-control"
                                                               name="member_config[{{ $key }}][org_designation]"
                                                               value="{{ $memberConfig['org_designation'] }}"/>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $memberConfig['committee_designation'] }}
                                                        <input type="hidden"
                                                               class="form-control custom-form-control"
                                                               name="member_config[{{ $key }}][committee_designation_id]"
                                                               value="{{ $memberConfig['committee_designation_id'] }}"/>
                                                        <input type="hidden"
                                                               class="form-control custom-form-control"
                                                               name="member_config[{{ $key }}][committee_designation]"
                                                               value="{{ $memberConfig['committee_designation'] }}"/>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                               class="form-control custom-form-control name_{{ $key }}"
                                                               name="member_config[{{ $key }}][name]"
                                                               id="name_{{ $key }}"
                                                               value="" placeholder="{{ __('generic.name') }}"/>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                               class="form-control custom-form-control mobile_{{ $key }}"
                                                               name="member_config[{{ $key }}][mobile]"
                                                               id="mobile_{{ $key }}"
                                                               value="" placeholder="{{ __('generic.mobile') }}"/>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                               class="form-control custom-form-control email_{{ $key }}"
                                                               name="member_config[{{ $key }}][email]"
                                                               id="email_{{ $key }}"
                                                               value="" placeholder="{{ __('email') }}"/>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        @if(empty($meetingCommittees) && empty($committeeSetting))
                                            <tr class="text-center text-danger">
                                                <td colspan="5">
                                                    {{ __('generic.empty_table') }}
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-right my-3">
                            @if(!empty($meetingCommittees) || !empty($committeeSetting))
                                <button type="submit"
                                        class="btn btn-success form-submit px-4"><i
                                        class="fas fa-save"></i> {{ __('generic.save') }}</button>
                            @else
                                <h3 class="text-center text-danger">
                                    সভা কমিটি তৈরি করার জন্য প্রথমে কমিটির ধরণে গিয়ে কমিটি সেটিং করুন।
                                </h3>
                            @endif

                        </div>
                    </div>

                    <div class="overlay" style="display: none">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
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


    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(function () {
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
                    number_of_member: {
                        required: true,
                    },
                    min_attendance: {
                        required: true,
                    },
                },
                messages: {
                    number_of_member: {
                        required: "{{ __('generic.field_is_required') }}",
                        number: "{{ __('generic.number_only') }}",
                        min: "{{ __('generic.min_1') }}",
                        step: "{{ __('generic.step_1') }}",
                    },
                    min_attendance: {
                        required: "{{ __('generic.field_is_required') }}",
                        number: "{{ __('generic.number_only') }}",
                        min: "{{ __('generic.min_1') }}",
                        step: "{{ __('generic.step_1') }}",
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
                                }, 1000);
                            }

                        },
                    });

                    return false;
                },
                highlight: function (element, errorClass, validClass) {
                    var elem = $(element);
                    if (elem.hasClass("select2-hidden-accessible")) {
                        $("#select2-" + elem.attr("id") + "-container").parent().addClass(errorClass);
                    } else {
                        elem.addClass(errorClass);
                    }
                },
                unhighlight: function (element, errorClass, validClass) {
                    var elem = $(element);
                    if (elem.hasClass("select2-hidden-accessible")) {
                        $("#select2-" + elem.attr("id") + "-container").parent().removeClass(errorClass);
                    } else {
                        elem.removeClass(errorClass);
                    }
                },
                errorPlacement: function (error, element) {
                    var elem = $(element);
                    if (elem.hasClass("select2-hidden-accessible")) {
                        element = $("#select2-" + elem.attr("id") + "-container").parent();
                        error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $.validator.addMethod(
                "mobileValidation",
                function (value, element) {
                    let regexp1 = /^(?:\+88|88)?(01[3-9]\d{8})$/i;
                    let regexp = /^(?:\+৮৮|৮৮)?(০১[৩-৯][০-৯]{8})$/i;
                    let re = new RegExp(regexp);
                    let re1 = new RegExp(regexp1);
                    return this.optional(element) || re.test(value) || re1.test(value);
                },
                "{{ __('generic.valid_mobile') }}"
            );


            $.validator.addMethod("cRequired", $.validator.methods.required,
                "{{ __('generic.field_is_required') }}");

            let numberOrRow = '{!! !empty($committeeSetting)? count($committeeSetting->member_config):0 !!}';

            function requireOptions(n) {
                for (let i = 0; i <= n; i++) {
                    $.validator.addClassRules("name_" + i, {
                        cRequired: true,
                    });
                    $.validator.addClassRules("mobile_" + i, {
                        cRequired: true,
                        mobileValidation: true,
                    });

                    $.validator.addClassRules("email_" + i, {
                        cRequired: false,
                    });
                }
            }

            requireOptions(numberOrRow);


        });
    </script>
@endpush


