@php
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') != 'en';

    $sl = 0;
    $upazilaOptions='';
    foreach ($upazilas as $key=>$upazila){
        $upazilaOptions .= '<option value="'.$upazila->bbs_code.'">'.$upazila->title.'</option>';
    }

    $landlessOptions = '';
@endphp

@extends('master::layouts.master')
@section('title')
    {{ __('generic.land_assignment') }}
@endsection
@section('content')
    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js"></script>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{ __('generic.land_assignment') }}
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
                @if(count($landlessApplications))
                    <form class="edit-add-form" method="post"
                          action="{{ route('admin.meeting_management.meetings.land-assignment.store',$meeting->id )}}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3 custom-view-box">
                                        <p class="label-text">{{ __('generic.division') }}</p>
                                        <div class="input-box custom-form-control" style="background: #e7e7e7">
                                            {{ !empty($division)?$division->title:'' }}
                                        </div>
                                    </div>

                                    <div class="col-md-3 custom-view-box">
                                        <p class="label-text">{{ __('generic.district') }}</p>
                                        <div class="input-box custom-form-control" style="background: #e7e7e7">
                                            {{ !empty($district)?$district->title:'' }}
                                        </div>
                                    </div>
                                    <div class="col-md-3 custom-view-box">
                                        <p class="label-text">{{ __('generic.date') }}</p>
                                        <div class="input-box custom-form-control" style="background: #e7e7e7">
                                            {{ Date('d M, Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered" id="landless-table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('generic.landless_name') }}</th>
                                        <th>{{ __('generic.upazila') }}</th>
                                        <th>{{ __('generic.mouja') }}</th>
                                        <th>{{ __('generic.settable_land') }}</th>
                                        <th>{{ __('generic.deliverable_land') }}</th>
                                        <th>{{ __('generic.distributed_land') }}</th>
                                        <th>{{ __('generic.case_no') }}</th>
                                        <th>{{ __('generic.remark') }}</th>
                                        <th>{{ __('generic.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($landlessApplications as $key=> $landlessApplication)
                                        @php
                                            $landlessOptions .= '<option value="'.$landlessApplication->landless_id.'">'.$landlessApplication->fullname.'</option>';
                                        @endphp
                                        <tr id="land_assignment_row_id_{{ ++$sl }}">
                                            <td width="200px">
                                                <select
                                                    class="input-box form-control custom-form-control landless-select select2"
                                                    name="land_assignment[{{ $sl }}][landless_application_id]"
                                                    id="landless_application_id_{{ $sl }}"
                                                    data-placeholder="{{ __('generic.select_placeholder') }}">
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                    <option value="{{ $landlessApplication->landless_id }}"
                                                            selected>{{ $landlessApplication->fullname }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select
                                                    class="input-box form-control custom-form-control upazila-select select2"
                                                    name="land_assignment[{{ $sl }}][upazila_bbs_code]"
                                                    id="upazila_bbs_code_{{ $sl }}"
                                                    data-placeholder="{{ __('generic.select_placeholder') }}">
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                    {!! $upazilaOptions !!}
                                                </select>
                                            </td>
                                            <td>
                                                <select
                                                    class="input-box form-control custom-form-control mouja-select select2"
                                                    name="land_assignment[{{ $sl }}][jl_number]"
                                                    id="jl_number_{{ $sl }}"
                                                    data-placeholder="{{ __('generic.select_placeholder') }}">
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select
                                                    class="input-box form-control custom-form-control dag-select select2"
                                                    name="land_assignment[{{ $sl }}][dag_number]"
                                                    id="dag_number_{{ $sl }}"
                                                    data-placeholder="{{ __('generic.select_placeholder') }}">
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="border-0"
                                                       id="remaining_khasland_area_{{ $sl }}"
                                                       readonly>
                                                <input type="hidden"
                                                       name="land_assignment[{{ $sl }}][eight_register_id]"
                                                       id="eight_register_id_{{ $sl }}">
                                                <input type="hidden"
                                                       name="land_assignment[{{ $sl }}][khotian_number]"
                                                       id="khotian_number_{{ $sl }}">
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control custom-form-control assigned_land_area"
                                                       name="land_assignment[{{ $sl }}][assigned_land_area]"
                                                       id="assigned_land_area_{{ $sl }}">
                                            </td>

                                            <td>
                                                <input type="text"
                                                       class="form-control custom-form-control case_number"
                                                       name="land_assignment[{{ $sl }}][case_number]"
                                                       id="case_number_{{ $sl }}">
                                            </td>

                                            <td>
                                            <textarea type="text"
                                                      class="form-control custom-form-control remark_area"
                                                      name="land_assignment[{{ $sl }}][remark]"
                                                      id="remark_{{ $sl }}"></textarea>
                                            </td>
                                            <td>
                                                {{--<span class="btn btn-danger px-3" onclick="deleteRow({{ $sl }})"><i
                                                        class="fas fa-trash-alt" style="font-size: 12px"></i></span>--}}
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 text-right my-3">
                            <span
                                class="btn btn-info" id="add-more"> <i class="fas fa-plus-circle"></i> {{ __('generic.add_more') }} </span>
                                <button type="submit"
                                        class="btn btn-success form-submit px-4"><i
                                        class="fas fa-save"></i> {{ __('generic.save') }}</button>
                            </div>
                        </div>
                        <div class="overlay" style="display: none">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>

                    </form>
                @else
                    <h3 class="text-center text-danger my-5">
                        <p>
                            <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="face-thinking"
                                 role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                 style="height: 4rem;">
                                <g class="fa-duotone-group">
                                    <path fill="currentColor"
                                          d="M224.6 510.1C228.6 504.4 231.9 498.1 234.4 491.3L255.4 433.6L291.1 420.6C315 411.9 329.4 388.6 327.9 364.5C326.6 340.1 311.4 318.4 288.7 308.8L166.2 257.3C158.1 253.8 148.7 257.6 145.3 265.8C141.8 273.9 145.6 283.3 153.8 286.7L236.2 321.4L144 354.1V352C144 321.1 118.9 296 88 296C57.07 296 32 321.1 32 352V380C11.61 343.3 0 301 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C245.4 512 234.9 511.4 224.6 510.1L224.6 510.1zM176.4 207.1C194 207.1 208.4 193.7 208.4 175.1C208.4 158.3 194 143.1 176.4 143.1C158.7 143.1 144.4 158.3 144.4 175.1C144.4 193.7 158.7 207.1 176.4 207.1zM336.4 159.1C318.7 159.1 304.4 174.3 304.4 191.1C304.4 209.7 318.7 223.1 336.4 223.1C354 223.1 368.4 209.7 368.4 191.1C368.4 174.3 354 159.1 336.4 159.1zM229.6 140.1C236.3 145.9 246.4 145.1 252.1 138.4C257.9 131.7 257.1 121.6 250.4 115.9L237.2 104.5C206.4 78.14 162.3 73.95 127.1 94.08L120.1 98.11C112.4 102.5 109.7 112.3 114.1 119.9C118.5 127.6 128.3 130.3 135.9 125.9L142.1 121.9C166.5 108.4 195.9 111.2 216.4 128.8L229.6 140.1z"
                                          style="color: #ffc107">
                                    </path>
                                    <path fill="currentColor"
                                          d="M135.9 125.9C128.3 130.3 118.5 127.6 114.1 119.9C109.7 112.3 112.4 102.5 120.1 98.11L127.1 94.08C162.3 73.95 206.4 78.14 237.2 104.5L250.4 115.9C257.1 121.6 257.9 131.7 252.1 138.4C246.4 145.1 236.3 145.9 229.6 140.1L216.4 128.8C195.9 111.2 166.5 108.4 142.1 121.9L135.9 125.9zM144.4 176C144.4 158.3 158.7 144 176.4 144C194 144 208.4 158.3 208.4 176C208.4 193.7 194 208 176.4 208C158.7 208 144.4 193.7 144.4 176zM112 400.6L263.8 345.4C276.3 340.9 290 347.3 294.6 359.8C299.1 372.3 292.7 386 280.2 390.6L230.4 408.7L204.3 480.4C197.4 499.4 179.4 512 159.2 512H112C85.49 512 64 490.5 64 464V352C64 338.7 74.75 328 88 328C101.3 328 112 338.7 112 352L112 400.6zM368.4 192C368.4 209.7 354 224 336.4 224C318.7 224 304.4 209.7 304.4 192C304.4 174.3 318.7 160 336.4 160C354 160 368.4 174.3 368.4 192z"
                                          style="color: #333">
                                    </path>
                                </g>
                            </svg>
                        </p>
                        {{ __('generic.no_landless_application') }}
                    </h3>
                @endif
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
        function deleteRow(n) {
            $("#land_assignment_row_id_" + n).remove();
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
                    title: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                },
                submitHandler: function (htmlForm) {

                    $('.overlay').show();

                    const form = $(htmlForm);
                    const formData = new FormData(htmlForm);
                    const url = form.attr("action");
                    console.log('form', form,)
                    console.log('formData', formData)
                    console.log('url', url)

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

            function loadMoujas(districtBbsCode, upazilaBbsCode, idNo) {
                console.log('mouja load:', districtBbsCode, upazilaBbsCode, idNo)
                if (upazilaBbsCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('admin.khotians.get-all-moujas') }}',
                        data: {
                            'upazila_bbs_code': upazilaBbsCode,
                            'district_bbs_code': districtBbsCode,
                        },
                        success: function (response) {
                            $('#jl_number_' + idNo).html('');
                            $('#jl_number_' + idNo).html('<option value="">নির্বাচন করুণ</option>');
                            $.each(response, function (key, value) {
                                $('#jl_number_' + idNo).append(
                                    '<option value="' + key + '" data-dglr-code="' + key + '" >' + value + '</option>'
                                );
                            });
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                } else {
                    console.log('idNo else:', idNo)
                    $('#jl_number_' + idNo).html('');
                    $('#jl_number_' + idNo).html('<option value="">নির্বাচন করুণ</option>');
                    $('#remaining_khasland_area_' + idNo).val(null);
                    $('#eight_register_id_' + idNo).val('');
                    $('#dag_number_' + idNo).html('');
                    $('#dag_number_' + idNo).html('<option value="">নির্বাচন করুণ</option>');
                }
            }

            $(document).on("change", ".upazila-select", function () {
                let idString = $(this)[0].id;
                let idNo = idString.split("_").pop();
                let upazilaBbsCode = $('#upazila_bbs_code_' + idNo).val();
                let districtBbsCode = 75;

                console.log('upazila select changed')

                loadMoujas(districtBbsCode, upazilaBbsCode, idNo);
            });

            $(document).on("change", ".mouja-select", function () {
                let idString = $(this)[0].id;
                let idNo = idString.split("_").pop();
                let jlNumber = $('#jl_number_' + idNo).val();
                let divisionBbsCode = 20;
                let districtBbsCode = 75;
                let upazilaBbsCode = $('#upazila_bbs_code_' + idNo).val();

                if (upazilaBbsCode && jlNumber) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('admin.khotians.get-register-eight-data') }}',
                        data: {
                            'division_bbs_code': divisionBbsCode,
                            'district_bbs_code': districtBbsCode,
                            'upazila_bbs_code': upazilaBbsCode,
                            'jl_number': jlNumber,
                        },
                        success: function (response) {
                            $('#dag_number_' + idNo).html('');
                            $('#dag_number_' + idNo).html('<option value="">নির্বাচন করুণ</option>');
                            console.log('dag response', response)

                            $.each(response, function (key, value) {
                                $('#dag_number_' + idNo).append(
                                    '<option value="' + value.dag_number + '" ' +
                                    'data-eight_register_id="' + value.id + '" ' +
                                    'data-remaining_khasland_area="' + value.remaining_khasland_area + '" ' +
                                    'data-provided_khasland_area="' + (value.provided_khasland_area ?? "") + '"' +
                                    'data-khotian_number="' + (value.khotian_number ?? "") + '"' +
                                    '>Dag No - ' + value.dag_number + '</option>'
                                );
                            });
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                } else {
                    $('#dag_number_' + idNo).html('');
                    $('#dag_number_' + idNo).html('<option value="">নির্বাচন করুণ</option>');
                    $('#remaining_khasland_area_' + idNo).val(null);
                    $('#eight_register_id_' + idNo).val('');
                }
            });

            $(document).on("change", ".dag-select", function () {
                let idString = $(this)[0].id;
                let idNo = idString.split("_").pop();
                let remainingKhaslandArea = $('#dag_number_' + idNo).find(':selected').data('remaining_khasland_area');
                let khotianNumber = $('#dag_number_' + idNo).find(':selected').data('khotian_number');
                let eightRegisterId = $('#dag_number_' + idNo).find(':selected').data('eight_register_id');
                $('#remaining_khasland_area_' + idNo).val(remainingKhaslandArea);
                $('#khotian_number_' + idNo).val(khotianNumber);
                $('#eight_register_id_' + idNo).val(eightRegisterId);
            });

            $(document).on("change", ".assigned_land_area", function () {
                let idString = $(this)[0].id;
                let idNo = idString.split("_").pop();
                let remainingLand = parseFloat($('#remaining_khasland_area_' + idNo).val());
                $('#assigned_land_area_' + idNo).rules("add", {
                    max: remainingLand,
                    messages: {
                        max: function () {
                            if ($('#remaining_khasland_area_' + idNo).val() == '') {
                                return "{{ __('generic.pls_dag_select') }}";
                            } else {
                                return "{{ __('generic.less_than_or_equal') }}";
                            }
                        },
                    }
                });
            });

            /**
             * Add more start
             * **/

            function dynamicTemplete(n) {
                let code = "";
                code += '<tr id="land_assignment_row_id_' + n + '">\n';
                code += '\t\t\t\t\t\t\t\t\t\t<td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<select\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tclass="input-box form-control custom-form-control landless-select select2"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tname="land_assignment[' + n + '][landless_application_id]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tid="landless_application_id_' + n + '"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tdata-placeholder="{{ __('generic.select_placeholder') }}">\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t<option value="">{{ __('generic.select_placeholder') }}</option>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t{!! $landlessOptions !!}\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t</select>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\n';
                code += '\t\t\t\t\t\t\t\t\t\t</td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t<td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<select\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tclass="input-box form-control custom-form-control upazila-select select2"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tname="land_assignment[' + n + '][upazila_bbs_code]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tid="upazila_bbs_code_' + n + '"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tdata-placeholder="{{ __('generic.select_placeholder') }}">\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t<option value="">{{ __('generic.select_placeholder') }}</option>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t{!! $upazilaOptions !!}\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t</select>\n';
                code += '\t\t\t\t\t\t\t\t\t\t</td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t<td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<select\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tclass="input-box form-control custom-form-control mouja-select select2"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tname="land_assignment[' + n + '][jl_number]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tid="jl_number_' + n + '"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tdata-placeholder="{{ __('generic.select_placeholder') }}">\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t<option value="">{{ __('generic.select_placeholder') }}</option>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t</select>\n';
                code += '\t\t\t\t\t\t\t\t\t\t</td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t<td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<select\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tclass="input-box form-control custom-form-control dag-select select2"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tname="land_assignment[' + n + '][dag_number]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tid="dag_number_' + n + '"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\tdata-placeholder="{{ __('generic.select_placeholder') }}">\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t<option value="">{{ __('generic.select_placeholder') }}</option>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t</select>\n';
                code += '\t\t\t\t\t\t\t\t\t\t</td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t<td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<input type="text"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   class="border-0"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   id="remaining_khasland_area_' + n + '"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   readonly>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<input type="hidden"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   name="land_assignment[' + n + '][eight_register_id]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   id="eight_register_id_' + n + '">\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<input type="hidden"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   name="land_assignment[' + n + '][khotian_number]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   id="khotian_number_' + n + '">\n';
                code += '\t\t\t\t\t\t\t\t\t\t</td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t<td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<input type="text"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   class="form-control custom-form-control assigned_land_area"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   name="land_assignment[' + n + '][assigned_land_area]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   id="assigned_land_area_' + n + '">\n';
                code += '\t\t\t\t\t\t\t\t\t\t</td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t<td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<input type="text"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   class="form-control custom-form-control case_number"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   name="land_assignment[' + n + '][case_number]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t   id="case_number_' + n + '">\n';
                code += '\t\t\t\t\t\t\t\t\t\t</td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t<td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<textarea type="text"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t  class="form-control custom-form-control remark_area"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t  name="land_assignment[' + n + '][remark]"\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\t  id="remark_' + n + '"></textarea>\n';
                code += '\t\t\t\t\t\t\t\t\t\t</td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t<td>\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t<span class="btn btn-danger px-3" onclick="deleteRow(' + n + ')"><i\n';
                code += '\t\t\t\t\t\t\t\t\t\t\t\t\tclass="fas fa-trash-alt" style="font-size: 12px"></i></span>\n';
                code += '\t\t\t\t\t\t\t\t\t\t</td>\n';
                code += '\t\t\t\t\t\t\t\t\t</tr>\n';
                return code;
            }

            let numberOrRow = 0;
            let countRow = $('#landless-table tbody tr').length;
            if (countRow > 0) {
                numberOrRow = countRow;
            }
            $('#add-more').click(function () {
                numberOrRow++;
                $('#landless-table tbody').append(dynamicTemplete(numberOrRow));
                $("#landless_application_id_" + numberOrRow).select2();
                $("#upazila_bbs_code_" + numberOrRow).select2();
                $("#jl_number_" + numberOrRow).select2();
                $("#dag_number_" + numberOrRow).select2();
                requireOptions(numberOrRow);
            });

            $.validator.addMethod("cRequired", $.validator.methods.required,
                "{{ __('generic.field_is_required') }}");

            /**
             * check unique case_number
             * **/
            $.validator.addMethod(
                "case_number",
                function (value, element) {
                    let parentForm = $(element).closest("form");
                    let timeRepeated = 0;
                    if (value != "") {
                        $(parentForm.find(":text")).each(function () {
                            if ($(this).val() === value) {
                                timeRepeated++;
                            }
                        });
                    }
                    return timeRepeated === 1 || timeRepeated === 0;
                }, "{{ __('generic.duplicate_case_no') }}");

            $(document).on("change", ".case_number", function () {
                let idString = $(this)[0].id;
                let idNo = idString.split("_").pop();

                let caseNumber = $('#case_number_' + idNo).val();

                $('#case_number_' + idNo).rules("add", {
                    remote: {
                        param: {
                            type: "get",
                            url: '{{ route('admin.meeting_management.check-unique-case-number') }}',
                            data: {
                                case_number: caseNumber
                            },
                        }
                    },
                });
            });

            function requireOptions(n) {
                for (let i = 1; i <= n; i++) {
                    $('#landless_application_id_' + i).rules("add", {
                        required: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                    $('#upazila_bbs_code_' + i).rules("add", {
                        required: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                    $('#jl_number_' + i).rules("add", {
                        required: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                    $('#dag_number_' + i).rules("add", {
                        required: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                    $('#assigned_land_area_' + i).rules("add", {
                        required: true,
                        min: 0.0001,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                            min: "{{ __('generic.gt_0') }}",
                        }
                    });

                    $('#case_number_' + i).rules("add", {
                        required: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                }
            }

            requireOptions(numberOrRow);

            /**
             * End Add more
             * **/


        })();
    </script>
@endpush


