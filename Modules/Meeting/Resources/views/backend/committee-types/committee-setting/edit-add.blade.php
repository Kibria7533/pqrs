@php
    $edit = !empty($committeeType->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') != 'en';
@endphp


@extends('master::layouts.master')
@section('title')
    {{ __('generic.add_new_committee_type') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{ __('generic.committee_setting') }}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.meeting_management.committee-types.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{ route('admin.meeting_management.committee-types.committee-setting.store', $committeeType) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('generic.committee_type') }} </label>
                                        <input type="text" class="form-control custom-form-control"
                                               id="title" value="{{ $committeeType->title }}" readonly/>
                                        <input type="hidden" class="form-control custom-form-control"
                                               id="committee_type_id"
                                               name="committee_type_id"
                                               value="{{ $committeeType->id }}" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number_of_member">
                                            {{ __('generic.number_of_member') }}
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="number" min="1" step="1" class="form-control custom-form-control"
                                               name="number_of_member"
                                               id="number_of_member"
                                               value="{{ !empty($committeeSetting)? $committeeSetting->number_of_member:'' }}"/>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="min_attendance">
                                            {{ __('generic.min_attendance') }}
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="number" min="1" step="1" class="form-control custom-form-control"
                                               name="min_attendance"
                                               id="min_attendance"
                                               value="{{ !empty($committeeSetting)? $committeeSetting->min_attendance:'' }}"/>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr class="m-0">
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row my-2">
                                                <div class="col-md-5 text-center">
                                                    <label class="p-0">{{ __('generic.org_member_designation') }}</label>
                                                </div>
                                                <div class="col-md-5 text-center">
                                                    <label class="p-0">{{ __('generic.committee_member_designation') }}</label>
                                                </div>
                                            </div>
                                            <hr class="mb-2 mt-0">
                                        </div>


                                        @if(!empty($committeeSetting))
                                            @foreach($committeeSetting['member_config'] as $index => $orgConfig)
                                                <div class="col-md-12" id="row_{{ $index }}">
                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="row mt-1">
                                                                <div class="col-md-6">
                                                                    <select
                                                                        class="form-control custom-form-control select2 org_designation_{{ $index }}"
                                                                        onchange="setOrgDesignationId({{ $index }})"
                                                                        name="member_config[{{ $index }}][org_designation]"
                                                                        id="org_designation_{{ $index }}"
                                                                        data-placeholder="{{ __('generic.select_placeholder') }}">
                                                                        <option
                                                                            value="">{{ __('generic.select_placeholder') }}</option>
                                                                        @foreach($designations as $key => $value)
                                                                            <option
                                                                                value="{{ $value->title }}"
                                                                                {{ $value->id == $orgConfig['org_designation_id']?'selected':'' }}
                                                                                data-designation_id="{{ $value->id }}">
                                                                                {{ $value->title }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden"
                                                                           name="member_config[{{ $index }}][org_designation_id]"
                                                                           id="org_designation_id_{{ $index }}"
                                                                           value="{{ $orgConfig['org_designation_id'] }}">
                                                                    <input type="hidden"
                                                                           name="member_config[{{ $index }}][committee_designation_id]"
                                                                           id="committee_designation_id_{{ $index }}"
                                                                           value="{{ $orgConfig['committee_designation_id'] }}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <select
                                                                        class="form-control custom-form-control select2 committee_designation_{{ $index }}"
                                                                        onchange="setCommitteeDesignationId({{ $index }})"
                                                                        name="member_config[{{ $index }}][committee_designation]"
                                                                        id="committee_designation_{{ $index }}"
                                                                        data-placeholder="{{ __('generic.select_placeholder') }}">
                                                                        <option
                                                                            value="">{{ __('generic.select_placeholder') }}</option>
                                                                        @foreach(\Modules\Meeting\Models\committeeType::MEETING_DESIGNATIONS as $key=>$value)
                                                                            <option
                                                                                value="{{ $value }}"
                                                                                {{ $key == $orgConfig['committee_designation_id']? 'selected':'' }}
                                                                                data-meeting_id="{{ $key }}">
                                                                                {{ $value }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($index >0)
                                                            <div class="col-md-1">
                                                            <span class="btn btn-danger px-3"
                                                                  onclick="deleteRow({{ $index }})">
                                                                <i class="fas fa-trash-alt" style="font-size: 12px"></i>
                                                            </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-md-12" id="row_0">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <select
                                                                    class="form-control custom-form-control select2 org_designation_0"
                                                                    onchange="setOrgDesignationId(0)"
                                                                    name="member_config[0][org_designation]"
                                                                    id="org_designation_0"
                                                                    data-placeholder="{{ __('generic.select_placeholder') }}">
                                                                    <option
                                                                        value="">{{ __('generic.select_placeholder') }}</option>
                                                                    @foreach($designations as $key => $value)
                                                                        <option
                                                                            value="{{ $value->title }}"
                                                                            data-designation_id="{{ $value->id }}">
                                                                            {{ $value->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden"
                                                                       name="member_config[0][org_designation_id]"
                                                                       id="org_designation_id_0">
                                                                <input type="hidden"
                                                                       name="member_config[0][committee_designation_id]"
                                                                       id="committee_designation_id_0">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select
                                                                    class="form-control custom-form-control select2 committee_designation_0"
                                                                    onchange="setCommitteeDesignationId(0)"
                                                                    name="member_config[0][committee_designation]"
                                                                    id="committee_designation_0"
                                                                    data-placeholder="{{ __('generic.select_placeholder') }}">
                                                                    <option
                                                                        value="">{{ __('generic.select_placeholder') }}</option>
                                                                    @foreach(\Modules\Meeting\Models\committeeType::MEETING_DESIGNATIONS as $key=>$value)
                                                                        <option
                                                                            value="{{ $value }}"
                                                                            data-meeting_id="{{ $key }}">
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 text-right">
                                                        {{--<span class="btn btn-danger px-3" onclick="deleteRow(0)">
                                                            <i class="fas fa-trash-alt" style="font-size: 12px"></i>
                                                        </span>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-md-12">
                                            <div class="row" id="dynamic-fields"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-11 text-right my-3">
                            <span
                                class="btn btn-info" id="add-more"> <i class="fas fa-plus-circle"></i> {{ __('generic.add_more') }} </span>
                            <button type="submit"
                                    class="btn btn-success form-submit px-4"> <i class="fas fa-save"></i> {{ __('generic.save') }}</button>
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

        em#father_is_alive-error {
            position: absolute;
            width: 160px;
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
        function setOrgDesignationId(n) {
            let value = $('#org_designation_' + n).find(':selected').data('designation_id');
            $('#org_designation_id_' + n).val(value);
        }

        function setCommitteeDesignationId(n) {
            let value = $('#committee_designation_' + n).find(':selected').data('meeting_id');
            $('#committee_designation_id_' + n).val(value);
        }

        function deleteRow(n) {
            $("#row_" + n).remove();
        }

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


            /**
             * Clone html div [start]
             * **/
            function dynamicTemplete(n) {
                let code = "";
                code += '<div class="col-md-12 mt-1" id="row_' + n + '">';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="row"><div class="col-md-11"><div class="row">';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="col-md-6">';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<select class="form-control custom-form-control org_designation_' + n + '" onchange="setOrgDesignationId(' + n + ')" \n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tname="member_config[' + n + '][org_designation]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tid="org_designation_' + n + '" data-placeholder="{{ __('generic.select_placeholder') }}">\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t' + '<option value="">{{ __('generic.select_placeholder') }}</option>' + designationOptions;
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</select>';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="hidden" name="member_config[' + n + '][org_designation_id]" id="org_designation_id_' + n + '">';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="hidden" name="member_config[' + n + '][committee_designation_id]" id="committee_designation_id_' + n + '">';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="col-md-6">';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<select class="form-control custom-form-control committee_designation_' + n + '" onchange="setCommitteeDesignationId(' + n + ')" \n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tname="member_config[' + n + '][committee_designation]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tid="committee_designation_' + n + '" data-placeholder="{{ __('generic.select_placeholder') }}">\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option value="">{{ __('generic.select_placeholder') }}</option>' + committeeDesignationsOptions;
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</select>';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div></div></div>';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="col-md-1">';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class="btn btn-danger px-3" onclick="deleteRow(' + n + ')"><i class="fas fa-trash-alt" style="font-size: 12px"></i></span>';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t</div>';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t</div>';
                return code;
            }

            let designations = {!! $designations !!};
            let designationOptions = '';
            $.each(designations, function (index, value) {
                designationOptions += '<option value="' + value.title + '" data-designation_id="' + value.id + '">' + value.title + '</option>'
            });

            let committeeDesignations = @json(\Modules\Meeting\Models\committeeType::MEETING_DESIGNATIONS);
            let committeeDesignationsOptions = '';
            $.each(committeeDesignations, function (index, value) {
                committeeDesignationsOptions += '<option value="' + value + '" data-meeting_id="' + index + '">' + value + '</option>'
            });

            let numberOrRow = 0;

            let countRow = @json($lastKeyOfMemberConfig);
            if (countRow > 0) {
                numberOrRow = countRow;
            }
            $('#add-more').click(function () {
                numberOrRow++;
                $('#dynamic-fields').append(dynamicTemplete(numberOrRow));
                $("#org_designation_" + numberOrRow).select2();
                $("#committee_designation_" + numberOrRow).select2();

                requireOptions(numberOrRow);
            });

            /**
             * Clone html div [end]
             * **/

            $.validator.addMethod("cRequired", $.validator.methods.required,
                "{{ __('generic.field_is_required') }}");

            function requireOptions(n) {
                for (let i = 0; i <= n; i++) {
                    $.validator.addClassRules("org_designation_" + i, {
                        cRequired: true,
                    });

                    $.validator.addClassRules("committee_designation_" + i, {
                        cRequired: true,
                    });
                }
            }

            requireOptions(numberOrRow);
        });
    </script>
@endpush


