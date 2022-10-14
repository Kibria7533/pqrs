@php
    $edit = !empty($landless->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') != 'en';
@endphp

@extends('master::layouts.master')
@section('title')
    {{ __('রেজিস্টার-৮ আপডেট') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{ __('রেজিস্টার-৮ আপডেট') }}
                </h3>

                <div class="card-tools">
                    @can('viewAny', app(\Modules\Khotian\App\Models\EightRegister::class))
                        <a href="{{ route('admin.khotians.acland-approved.index') }}"
                           class="btn btn-sm btn-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                        </a>
                    @endcan
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form
                    class="edit-add-form"
                    @if($reg8Status==null || $reg8Status==\Modules\Khotian\App\Models\EightRegister::MODIFY or $reg8Status==\Modules\Khotian\App\Models\EightRegister::SAVE_AS_DRAFT)
                        @if($authUser->can('saveAsDraft', \Modules\Khotian\App\Models\EightRegister::class) || $authUser->can('save', \Modules\Khotian\App\Models\EightRegister::class))
                            action="{{ route('admin.khotians.register-eight.store', $khotian->id)}}?type={{$reg8Type}}"
                    @endif
                    @endif

                    enctype="multipart/form-data">
                    @csrf
                    @if($edit)
                        @method('put')
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="upazila">{{ __('generic.upazila') }} </label>
                                <input type="text" value="{{ $upazila->title }}"
                                       class="form-control custom-form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="office_id">{{ __('generic.office') }} </label>
                                <select class="form-control custom-form-control select2"
                                        name="office_id"
                                        id="office_id"
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    @foreach($offices as $office)
                                        <option
                                            value="{{ $office->id }}" {{ count($reg8Dags)?'selected':'' }}>{{ $office->name_bn }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="register_type">{{ __('৮ নং রেজিস্টারের ধরণ') }} </label>
                                <select class="form-control custom-form-control select2"
                                        name="register_type"
                                        id="register_type"
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    @foreach(\Modules\Khotian\App\Models\MutedKhotian::REG_8_TYPE as $key => $type)
                                        @if(!empty($reg8Type) && $reg8Type == $key)
                                            <option
                                                value="{{ $key }}" selected>{{ $type }}</option>
                                        @endif
                                        @if(empty($reg8Type))
                                            <option
                                                value="{{ $key }}">{{ $type }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr/>
                            <h3>রেজিস্টার-৮</h3>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-bordered" id="register_8_table">
                                <thead>
                                <tr class="text-center">
                                    <th scope="col" width="60px">ক্রমিক<br>নম্বর</th>
                                    <th scope="col" width="60px">দাগ নম্বর</th>
                                    <th scope="col" width="60px">দাগে মোট জমি</th>
                                    <th scope="col" width="150px">প্রাপ্ত মোট খাস জমি</th>
                                    <th scope="col" width="150px">রেজিস্টার অংশভুক্ত খাস জমি</th>
                                    <th scope="col" width="150px">বিবরণ</th>
                                    <th scope="col" width="130px">ভুক্তির তারিখ</th>
                                    <th scope="col" width="130px">পরিদর্শনের তারিখ</th>
                                    <th scope="col" width="180px">রেজিস্টার ১২ <br>মোতাবেক বন্দোবস্তি<br> কেইস নম্বর ও
                                        বন্দোবস্তির<br> তারিখ
                                    </th>
                                    <th scope="col">মন্তব্য</th>
                                </tr>
                                <tr class="text-center">
                                    @for($i=1; $i<=10; $i++)
                                        <th scope="row">{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($i) }}</th>
                                    @endfor
                                </tr>
                                </thead>
                                <tbody>

                                @if($authUser->isAcLandOfficeAssistantUser())
                                    @if(count($reg8Dags)<1)
                                        @foreach($khotianDags as $key=>$khotianDag)
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
                                                    {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotianDag->khotian_dag_portion) }}
                                                    <input type="hidden" class="form-control custom-form-control"
                                                           name="khotian_dag[{{ $key }}][khotian_dag_area]"
                                                           value="{{ $khotianDag->khotian_dag_portion }}">
                                                </td>
                                                <td>
                                                    <input
                                                        class="form-control custom-form-control dag_khasland_area"
                                                        name="khotian_dag[{{ $key }}][dag_khasland_area]"
                                                        id="dag_khasland_area_{{ $key }}"
                                                        value="{{ !empty($reg8DagLandAlreadyEntry[$khotianDag->id])?$reg8DagLandAlreadyEntry[$khotianDag->id]: '' }}"
                                                        data-khotian-dag-id="{{ $khotianDag->id }}"
                                                        data-url="{{ route('admin.khotians.register-eight.check-dag-khasland-area',['id'=>$khotian->id, 'dag_id'=>$khotianDag->id]) }}?key={{$key}}"
                                                        data-array-key="{{ $key }}"
                                                        {{ !empty($reg8DagLandAlreadyEntry[$khotianDag->id])?'readonly':'' }}
                                                        placeholder="প্রাপ্ত মোট খাস জমি"
                                                    >
                                                <td>
                                                    <input
                                                        class="form-control custom-form-control register_khasland_area"
                                                        name="khotian_dag[{{ $key }}][register_khasland_area]"
                                                        id="register_khasland_area_{{ $key }}"
                                                        data-url="{{ route('admin.khotians.register-eight.check-register-khasland-area',$khotianDag->id) }}?key={{$key}}"
                                                        placeholder="রেজিস্টার অংশভুক্ত খাস জমি"
                                                    >

                                                <td>
                                            <textarea type="text"
                                                      class="form-control custom-form-control details"
                                                      name="khotian_dag[{{ $key }}][details]"
                                                      id="details_{{ $key }}"
                                                      placeholder="বিবরণ"
                                                      style="height: 45px"
                                            ></textarea>
                                                </td>
                                                <td>
                                                    <input
                                                        class="form-control custom-form-control datepicker register_entry_date"
                                                        name="khotian_dag[{{ $key }}][register_entry_date]"
                                                        id="register_entry_date_{{ $key }}"
                                                        placeholder="ভুক্তির তারিখ"
                                                    >
                                                </td>
                                                <td>
                                                    <input
                                                        class="form-control custom-form-control datepicker visit_date"
                                                        name="khotian_dag[{{ $key }}][visit_date]"
                                                        id="visit_date_{{ $key }}"
                                                        placeholder="পরিদর্শনের তারিখ"
                                                    >
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
                                                              placeholder="মন্তব্য"
                                                              style="height: 45px"
                                                    ></textarea>
                                                        </div>
                                                        <div class="col-md-2 p-1">
                                                            <a href="#" class="text-danger"
                                                               onclick="deleteDagRow({{ $key }})">
                                                                <i class="fas fa-minus-circle fa-1x"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach($reg8Dags as $key=>$khotianDag)
                                            <tr class="text-center" id="dag_row_{{ ++$key }}">
                                                <td>
                                                    {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($key) }}
                                                </td>
                                                <td>
                                                    {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotianDag->dag_number) }}
                                                    <input type="hidden" class="form-control custom-form-control"
                                                           name="khotian_dag[{{ $key }}][khotian_dag_id]"
                                                           value="{{ $khotianDag->khotian_dag_id }}">
                                                    <input type="hidden" class="form-control custom-form-control"
                                                           name="khotian_dag[{{ $key }}][dag_number]"
                                                           value="{{ $khotianDag->dag_number }}">
                                                </td>
                                                <td>
                                                    {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotianDag->khotian_dag_area) }}
                                                    <input type="hidden" class="form-control custom-form-control"
                                                           name="khotian_dag[{{ $key }}][khotian_dag_area]"
                                                           value="{{ $khotianDag->khotian_dag_area }}"
                                                    >
                                                </td>
                                                <td>
                                                    <input type="text"
                                                           class="form-control custom-form-control dag_khasland_area"
                                                           name="khotian_dag[{{ $key }}][dag_khasland_area]"
                                                           id="dag_khasland_area_{{ $key }}"
                                                           data-url="{{ route('admin.khotians.register-eight.check-dag-khasland-area',['id'=>$khotian->id, 'dag_id'=>$khotianDag->khotian_dag_id]) }}?key={{$key}}"
                                                           value="{{ !empty($reg8DagLandAlreadyEntry)? $reg8DagLandAlreadyEntry[$khotianDag->khotian_dag_id]:$khotianDag->dag_khasland_area }}"
                                                        {{ !empty($reg8DagLandAlreadyEntry)?'readonly':'' }}
                                                    >
                                                </td>
                                                <td>

                                                    <input type="text"
                                                           class="form-control custom-form-control register_khasland_area"
                                                           name="khotian_dag[{{ $key }}][register_khasland_area]"
                                                           id="register_khasland_area_{{ $key }}"
                                                           data-url="{{ route('admin.khotians.register-eight.check-register-khasland-area',$khotianDag->khotian_dag_id) }}?key={{$key}}"
                                                           value="{{ $khotianDag->register_khasland_area }}"
                                                    >
                                                </td>

                                                <td>
                                                    <textarea type="text"
                                                              class="form-control custom-form-control details"
                                                              name="khotian_dag[{{ $key }}][details]"
                                                              id="details_{{ $key }}"
                                                              style="height: 45px"
                                                    >{{ $khotianDag->details }}</textarea>
                                                </td>
                                                <td>
                                                    <input
                                                        class="form-control custom-form-control datepicker register_entry_date"
                                                        name="khotian_dag[{{ $key }}][register_entry_date]"
                                                        id="register_entry_date_{{ $key }}"
                                                        value="{{ $khotianDag->register_entry_date }}"
                                                    >
                                                </td>
                                                <td>
                                                    <input
                                                        class="form-control custom-form-control datepicker visit_date"
                                                        name="khotian_dag[{{ $key }}][visit_date]"
                                                        id="visit_date_{{ $key }}"
                                                        value="{{ $khotianDag->visit_date }}"
                                                    >
                                                </td>
                                                <td>
                                                    <input
                                                        class="form-control custom-form-control register_12_case_number"
                                                        name="khotian_dag[{{ $key }}][register_12_case_number]"
                                                        id="register_12_case_number_{{ $key }}"
                                                        placeholder="কেইস নম্বর"
                                                        value="{{ $khotianDag->register_12_case_number }}"
                                                    >
                                                    <input
                                                        class="form-control custom-form-control datepicker mt-1 register_12_distribution_date"
                                                        name="khotian_dag[{{ $key }}][register_12_distribution_date]"
                                                        id="register_12_distribution_date_{{ $key }}"
                                                        placeholder="বন্দোবস্তির তারিখ"
                                                        value="{{ $khotianDag->register_12_distribution_date }}"
                                                    >
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                    <textarea type="text"
                                                              class="form-control custom-form-control remark"
                                                              name="khotian_dag[{{ $key }}][remark]"
                                                              style="height: 45px"
                                                    >{{ $khotianDag->remark }}</textarea>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif

                                @if($authUser->isAcLandUser())
                                    @foreach($reg8Dags as $key=>$khotianDag)
                                        <tr class="text-center" id="dag_row_{{ ++$key }}">
                                            <td>
                                                {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($key) }}
                                            </td>
                                            <td>
                                                {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotianDag->dag_number) }}
                                            </td>
                                            <td>
                                                {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotianDag->khotian_dag_area) }}
                                            </td>
                                            <td>
                                                {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotianDag->dag_khasland_area) }}
                                            </td>
                                            <td>
                                                {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($khotianDag->register_khasland_area) }}
                                            </td>

                                            <td>
                                                {{ $khotianDag->details }}
                                            </td>
                                            <td>
                                                {{ $khotianDag->register_entry_date }}
                                            </td>
                                            <td>
                                                {{ $khotianDag->visit_date }}
                                            </td>
                                            <td>
                                                {{ $khotianDag->register_12_case_number.', '.$khotianDag->register_12_distribution_date }}
                                            </td>
                                            <td>
                                                {{ $khotianDag->remark }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if(count($reg8Dags)<1)
                                        <tr>
                                            <td colspan="10">
                                                <h4 class="text-danger text-center">
                                                    {{ __('generic.empty_table') }}
                                                </h4>
                                            </td>
                                        </tr>
                                    @endif
                                @endif

                                </tbody>
                            </table>
                            <div class="float-right">
                                @if($reg8Status==null || $reg8Status==\Modules\Khotian\App\Models\EightRegister::MODIFY or $reg8Status==\Modules\Khotian\App\Models\EightRegister::SAVE_AS_DRAFT)
                                    @can('saveAsDraft', \Modules\Khotian\App\Models\EightRegister::class)
                                        <input type="submit" class="btn btn-warning" name="save_as"
                                               value="{{ __('generic.save_as_draft') }}">
                                    @endcan

                                    @can('save', \Modules\Khotian\App\Models\EightRegister::class)
                                        <input type="submit" class="btn btn-success" value="{{ __('generic.save') }}">
                                    @endcan
                                @endif


                                @if($reg8Status==\Modules\Khotian\App\Models\EightRegister::ON_PROGRESS)
                                    @can('approve', \Modules\Khotian\App\Models\EightRegister::class)
                                        <a href="#"
                                           data-action="{{ route('admin.khotians.register-eight.approve', $khotian->id) }}"
                                           class="btn btn-success approve">{{ __('generic.approve') }}</a>
                                    @endcan

                                    @can('reject', \Modules\Khotian\App\Models\EightRegister::class)
                                        <a href="#"
                                           data-action="{{ route('admin.khotians.register-eight.reject', $khotian->id) }}"
                                           class="btn btn-danger reject">{{ __('generic.reject') }}</a>
                                    @endcan
                                @endif


                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Accept register-8 updated khotian -->
    <div class="modal modal-danger fade" tabindex="-1" id="approve-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle"></i>
                        {{ __('আপনি কি অনুমোদন দিবেন?') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-right"
                            data-dismiss="modal">{{ __('generic.cancel') }}</button>
                    <form action="" id="approve-modal-form" class="float-left"
                          method="post">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-success pull-right"
                               value="{{ __('generic.confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Accept register-8 updated khotian -->
    <div class="modal modal-danger fade" tabindex="-1" id="reject-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle"></i>
                        {{ __('আপনি কি অনুমোদন দিবেন?') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-right"
                            data-dismiss="modal">{{ __('generic.cancel') }}</button>
                    <form action="" id="reject-modal-form" class="float-left"
                          method="post">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-success pull-right"
                               value="{{ __('generic.confirm') }}">
                    </form>
                </div>
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

            $('.details, .register_entry_date,.register_12_case_number,.register_12_distribution_date').each(function (index, element) {
                $(this).rules("add", {
                    required: true,
                    messages: {
                        required: "{{ __('generic.field_is_required') }}",
                    }
                });
            });

            $('.dag_khasland_area').each(function () {
                let url = $(this).data('url');
                $(this).rules("add",
                    {
                        required: true,
                        remote: url,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
            });

            $('.register_khasland_area').on('change', function () {
                console.log($(this));

                $('.register_khasland_area').each(function (index) {
                    let url = $(this).data('url');
                    let dagKhaslandArea = $('#dag_khasland_area_' + (index + 1)).val();

                    console.log('url', url)
                    $(this).rules("add",
                        {
                            required: true,
                            remote: {
                                param: {
                                    type: "get",
                                    url: url,
                                    data: {
                                        dag_khasland_area: dagKhaslandArea,
                                        type: {{ $_GET['type'] }},
                                    },
                                }
                            },
                            min: 0.000001,
                            messages: {
                                required: "{{ __('generic.field_is_required') }}",
                                lessThanEqual: "{{ __("অবশ্যই প্রাপ্ত মোট খাস জমি এর চেয়ে ছোট/সমান হতে হবে") }}",
                                min: "{{ __("অবশ্যই প্রাপ্ত মোট খাস জমি ০ এর চেয়ে বড় হতে হবে") }}",
                            }
                        });
                });
            })


            $(document, 'td').on('click', '.approve', function (e) {
                let registerType = $('#register_type').val();
                $('#approve-modal-form')[0].action = $(this).data('action') + '?type=' + registerType;
                $('#approve-modal').modal('show');
            });

            $(document, 'td').on('click', '.reject', function (e) {
                let registerType = $('#register_type').val();
                $('#reject-modal-form')[0].action = $(this).data('action') + '?type=' + registerType;
                $('#reject-modal').modal('show');
            });

        })();

    </script>
@endpush


