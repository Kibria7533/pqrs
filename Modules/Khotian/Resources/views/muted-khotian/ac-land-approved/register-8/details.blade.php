@php
    $edit = !empty($landless->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();

$langBn = Session::get('locale') != 'en';
@endphp


@extends('master::layouts.master')
@section('cadt')
    {{!$edit ? __('generic.add_new_landless'): __('generic.update_landless')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{ __('রেজিস্টার-৮ আপডেট') }}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.khotians.ac-land-approved-khotian.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{$edit ? route('admin.landless.update', $landless->id) : route('admin.khotians.update-on-register-8.store', $khotian->id)}}"
                      enctype="multipart/form-data">
                    @csrf
                    @if($edit)
                        @method('put')
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="upazila">{{ __('generic.upazila') }} </label>
                                <input type="text" {{--value="{{ $upazila->title }}"--}}
                                       class="form-control custom-form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="office_id">{{ __('generic.office') }} </label>
                                <select class="form-control custom-form-control select2"
                                        name="office_id"
                                        id="office_id">
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    {{--@foreach($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->name_bn }}</option>
                                    @endforeach--}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="register_type">{{ __('৮ নং রেজিস্টারের ধরণ') }} </label>
                                <select class="form-control custom-form-control select2"
                                        name="register_type"
                                        id="register_type">
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    @foreach(\Modules\Khotian\App\Models\MutedKhotian::REG_8_TYPE as $key => $type)
                                        {{--@if(!empty($reg8Type) && $reg8Type == $key)
                                            <option
                                                value="{{ $key }}" selected>{{ $type }}</option>
                                        @endif
                                        @if(empty($reg8Type))
                                            <option
                                                value="{{ $key }}">{{ $type }}</option>
                                        @endif--}}
                                        <option
                                            value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr/>
                            <div class="row">
                                <div class="col-md-2">
                                    <p>বাংলাদেশ ফরম নম্বর ১০৭২</p>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-2">
                                    <p class="float-right">(পরিশিষ্ট-২১)</p>
                                </div>
                            </div>

                            <h3>রেজিস্টার-৮</h3>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-bordered" id="register_8_table">
                                <thead>
                                <tr class="text-center">
                                    <th scope="col" width="80px">ক্রমিক<br>নম্বর</th>
                                    <th scope="col" width="100px">দাগ নম্বর</th>
                                    <th scope="col" width="180px">দাগের জমির পরিমান</th>
                                    <th scope="col" width="180px">বিবরণ</th>
                                    <th scope="col" width="130px">ভুক্তির তারিখ</th>
                                    <th scope="col" width="130px">পরিদর্শনের তারিখ</th>
                                    <th scope="col" width="180px">রেজিস্টার ১২ <br>মোতাবেক বন্দোবস্তি<br> কেইস নম্বর ও
                                        বন্দোবস্তির<br> তারিখ
                                    </th>
                                    <th scope="col">মন্তব্য</th>
                                </tr>
                                <tr class="text-center">
                                    @for($i=1; $i<=8; $i++)
                                        <th scope="row">{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($i) }}</th>
                                    @endfor
                                </tr>
                                </thead>
                                <tbody>
                                {{--@foreach($khotianDags as $key=>$khotianDag)
                                    <tr class="text-center" id="dag_row_{{ ++$key }}">
                                        <td>
                                            {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($key) }}
                                        </td>
                                        <td>
                                            {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotianDag->dag_number) }}
                                            <input type="hidden" class="form-control custom-form-control"
                                                   name="khotian_dag[{{ $key }}][khotian_dag_id]"
                                                   value="{{ $khotianDag->id }}">
                                            <input type="hidden" class="form-control custom-form-control"
                                                   name="khotian_dag[{{ $key }}][dag_number]"
                                                   value="{{ $khotianDag->dag_number }}">
                                        </td>
                                        <td>
                                            {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotianDag->total_dag_area) }}
                                            <input type="hidden" class="form-control custom-form-control"
                                                   name="khotian_dag[{{ $key }}][dag_land]"
                                                   value="{{ $khotianDag->total_dag_area }}">
                                        </td>

                                        <td>
                                            <textarea type="text"
                                                      class="form-control custom-form-control details"
                                                      name="khotian_dag[{{ $key }}][details]"
                                                      id="details_{{ $key }}"
                                                      style="height: 45px"
                                            ></textarea>
                                        </td>
                                        <td>
                                            <input
                                                class="form-control custom-form-control datepicker register_entry_date"
                                                name="khotian_dag[{{ $key }}][register_entry_date]"
                                                id="register_entry_date_{{ $key }}">
                                        </td>
                                        <td>
                                            <input
                                                class="form-control custom-form-control datepicker visit_date"
                                                name="khotian_dag[{{ $key }}][visit_date]"
                                                id="visit_date_{{ $key }}">
                                        </td>
                                        <td>
                                            <input
                                                class="form-control custom-form-control register_12_case_number"
                                                name="khotian_dag[{{ $key }}][register_12_case_number]"
                                                id="register_12_case_number_{{ $key }}"
                                                placeholder="কেইস নম্বর"
                                            >
                                            <input
                                                class="form-control custom-form-control datepicker mt-1 register_12_distribution_date"
                                                name="khotian_dag[{{ $key }}][register_12_distribution_date]"
                                                id="register_12_distribution_date_{{ $key }}"
                                                placeholder="বন্দোবস্তির তারিখ"
                                            >
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <textarea type="text"
                                                              class="form-control custom-form-control remark"
                                                              name="khotian_dag[{{ $key }}][remark]"
                                                              style="height: 45px"
                                                    ></textarea>
                                                </div>
                                                <div class="col-md-2 p-1">
                                                    <button class="btn btn-sm btn-danger"
                                                            onclick="deleteDagRow({{ $key }})"><i
                                                            class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach--}}

                                </tbody>
                            </table>
                            <input type="submit" value="submit">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <style>
        #register_8_table th, td {
            vertical-align: middle !important;
        }

    </style>
@endpush

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script>
        function deleteDagRow(n) {
            $('#dag_row_' + n).remove();
        }

        (function () {
            const EDIT = !!'{{$edit}}';

            const editAddForm = $('.edit-add-form');
            editAddForm.validate({

                rules: {
                    office_id: {
                        required: true,
                    },
                    register_type: {
                        required: true,
                    },

                },
                messages: {
                    office_id: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    register_type: {
                        required: "{{ __('generic.field_is_required') }}",
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

            function showLoader() {
                $('#loading-sniper').show();
                $('body').css('overflow', 'hidden');
            }

            function hideLoader() {
                $('#loading-sniper').hide();
                $('body').css('overflow', 'auto');
            }

            $('.datepicker').datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: '+0d'
            });

            $('.details, .register_entry_date,.visit_date,.register_12_case_number,.register_12_distribution_date,.remark').each(function () {
                $(this).rules("add",
                    {
                        required: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
            });

        })();

    </script>
@endpush


