@extends('master::layouts.master')
@php
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') == 'bn';
@endphp
@section('title')
    {{__('খতিয়ান সমূহ (অনুমোদনের তালিকা)')}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    <i class="voyager-bookmark"></i> {{ __('খতিয়ান সমূহ (অনুমোদনের তালিকা)') }}
                </h3>
                <div class="card-tools">
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="datatable-container">
                    <div class="row">
                        <div class="col-md-4 d-noneM">
                            <div class="form-group">
                                <label for="division_bbs_code">{{ __('generic.division') }} </label>
                                <select class="form-control custom-form-control"
                                        name="division_bbs_code"
                                        id="division_bbs_code"
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                    <option value="{{ $locDivision->bbs_code }}"
                                            selected>{{ $locDivision->title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 d-noneM">
                            <div class="form-group">
                                <label for="district_bbs_code">{{ __('generic.district') }} </label>
                                <select class="form-control custom-form-control"
                                        name="district_bbs_code"
                                        id="district_bbs_code"
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                    <option value="{{ $locDistrict->bbs_code }}"
                                            selected>{{ $locDistrict->title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="upazila_bbs_code">{{ __('generic.upazila') }} </label>
                                <select class="form-control custom-form-control select2"
                                        name="upazila_bbs_code"
                                        id="upazila_bbs_code"
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="loc_union">{{ __('মৌজা') }} </label>
                                <select name="mouja_id"
                                        id="mouja_id"
                                        class="form-control custom-form-control select2"
                                        data-placeholder="{{ __('generic.select_placeholder') }}">
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="loc_upazila_bbs">{{ __('খতিয়ান নাম্বার') }} </label>
                                <input type="text"
                                       class="form-control custom-form-control"
                                       id="khotian_number"
                                       name="khotian_number">

                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp; </label>
                                <div class="input-group mb-3">
                                    <input type="submit" style="height: 45px"
                                           class="btn btn-success w-100"
                                           name="filter"
                                           id="filter"
                                           value="{{ __('generic.search') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>
                    <table id="dataTable" class="table table-bordered table-striped dataTable">
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-danger fade" tabindex="-1" id="approve_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        {{ __('আপনি কি নিশ্চিতভাবে অনুমোদন করতে চান?') }}
                    </h4>
                </div>
                <div class="modal-body" id="delete_model_body"></div>
                <div class="modal-footer">
                    <form action="#" id="approve_form" method="POST">
                        {{ method_field("POST") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('হ্যাঁ, অনুমোদন করুন') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="approve_return_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" id="compare_return_form" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{ __('আপনি কি নিশ্চিতভাবে ফেরন পাঠাতে চান?') }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="delete_model_body">
                        <textarea class="form-control" name="remark" placeholder="ফেরত পাঠানোর কারন"
                                  rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('হ্যাঁ, ফেরত পাঠান') }}">
                        <button type="button" class="btn btn-default pull-right"
                                data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="history_log_modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('খতিয়ানের হিস্টোরি লগ') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="history_log_model_body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('বন্ধ করুন') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for scan file view -->
    <div class="modal modal-danger fade" tabindex="-1" id="scan_copy_view_modal" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header custom-bg-gradient-info">
                    <h4 class="modal-title">
                        <i class="fa fa-eye"></i> {{ __(' খতিয়ানের স্ক্যান কপি') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="delete_model_body">
                    <form action="#" id="scan_copy_view_form">
                    </form>
                    <img class="scan-file-view"
                         alt="Scan File" width="100%" height="345">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('বন্ধ করুন') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for scan file upload -->
    <div class="modal modal-danger fade" tabindex="-1" id="scan_copy_upload_modal" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header custom-bg-gradient-info">
                    <h4 class="modal-title">
                        <i class="fa fa-upload"></i> {{ __(' খতিয়ানের স্ক্যান কপি প্রদান করুন') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="upload_model_body">
                    <form action="#" id="scan_copy_upload_form" method="POST" enctype="multipart/form-data">
                        {{ method_field("POST") }}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="scan_copy">খতিয়ানের স্ক্যান কপি</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file"
                                                   class="custom-file-input"
                                                   id="scan_copy"
                                                   name="scan_copy">
                                            <label class="custom-file-label" for="scan_copy">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-danger pull-right"
                                   value="{{ __('আপলোড করুন') }}">
                        </div>
                    </form>
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
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
        label#scan_copy-error {
            position: absolute;
            top: 34px;
        }

    </style>
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/moment/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/datatable/dataTables.dateTime.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/datatable/dataTables.select.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/en2bn/en2bn.js')}}"></script>

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

            let lanBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};
            let lanBnPath = lanBn ? "/json/bn.json" : "";

            let params = serverSideDatatableFactory({
                url: '{{ route("admin.khotians.approve.list") }}',
                order: [[0, "asc"]],
                language: {
                    "url": lanBnPath,
                },
                serialNumberColumn: 0,
                columns: [
                    {
                        title: '{{ __('generic.sl_no') }}',
                        data: 'sl_no',
                        defaultContent: "SL#",
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },
                    {
                        title: "{{ __('খতিয়ান নাম্বার') }}",
                        data: "khotian_number",
                        name: "{{ $khotianTalbe }}.khotian_number"
                    },
                    {
                        title: "{{ __('generic.mouja') }}",
                        data: "mouza_name",
                        name: "loc_all_moujas.name_bd"
                    },
                    {
                        title: "{{ __('generic.dglr_code') }}",
                        data: "dglr_code",
                        name: "{{ $khotianTalbe }}.dglr_code",
                    },
                    {
                        title: "{{ __('generic.jl_number') }}",
                        data: "jl_number",
                        name: "{{ $khotianTalbe }}.jl_number"
                    },
                    {
                        title: "{{ __('generic.resa_no') }}",
                        data: "resa_no",
                        name: "{{ $khotianTalbe }}.resa_no"
                    },
                    {
                        title: "{{ __('generic.namjari_case_no') }}",
                        data: "namjari_case_no",
                        name: "{{ $khotianTalbe }}.namjari_case_no"
                    },
                    {
                        title: "{{ __('generic.case_date') }}",
                        data: "case_date",
                        name: "{{ $khotianTalbe }}.case_date"
                    },
                    {
                        title: "{{ __('generic.scan_copy') }}",
                        data: "scan_copy",
                        name: "{{ $khotianTalbe }}.scan_copy",
                    },
                    {
                        title: "{{ __('generic.status') }}",
                        data: "status",
                        name: "{{ $khotianTalbe }}.status",
                    },
                    {
                        title: "{{ __('generic.action') }}",
                        data: "action",
                        orderable: false,
                        searchable: false,
                        visible: true
                    }
                ]
            });
            const datatable = $('#dataTable').DataTable(params);

            /**
             * customize DataTable SL no
             * **/
            datatable.on('order.dt search.dt', function () {

                datatable.column(0, {
                    search: true,
                    order: false
                }).nodes().each(function (cell, i) {
                    let sl = i + 1;
                    let slNo = lanBn ? en2bn(sl.toString()) : sl;
                    cell.innerHTML = slNo;
                });
            }).draw();

            $('#filter').on('click', function () {
                let khotianNumber = bn2en($('#khotian_number').val());
                let moujaJlNumber = $('#mouja_id').val();
                datatable.column(1).search(khotianNumber).draw();
                datatable.column(4).search(moujaJlNumber).draw();
            });

            $(document, 'td a').on('click', '.muted_khotian_approve', function (e) {
                $('#approve_form')[0].action = $(this).data('action');
                $('#approve_modal').modal('show');
            });

            $(document, 'td a').on('click', '.muted_khotian_return', function (e) {
                $('#approve_return_form')[0].action = $(this).data('action');
                $('#approve_return_modal').modal('show');
            });

            $(document, 'td a').on('click', '.muted_khotian_history_log', function (e) {
                let url = $(this).data('action');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (res) {
                        $('#history_log_model_body').html(res);
                        $('#history_log_modal').modal('show');
                    },
                    error: function (xhr, desc, err) {
                        console.log(err);
                    }
                });
            });

            function bn2en(input) {
                var numbers = {
                    '০': 0,
                    '১': 1,
                    '২': 2,
                    '৩': 3,
                    '৪': 4,
                    '৫': 5,
                    '৬': 6,
                    '৭': 7,
                    '৮': 8,
                    '৯': 9
                };
                var output = [];
                for (var i = 0; i < input.length; i++) {
                    if (numbers.hasOwnProperty(input[i])) {
                        output.push(numbers[input[i]]);
                    } else {
                        output.push(input[i]);
                    }
                }
                return output.join('').toString();
            }
            $(document, 'td').on('click', '.scan_copy_view', function (e) {
                $('#scan_copy_view_form')[0].action = $(this).data('action');

                $('.scan-file-view').attr('src', $(this).data('action'));
                $('#scan_copy_view_modal').modal('show');
            });

            $(document, 'td').on('click', '.scan_copy_upload', function (e) {
                $('#scan_copy_upload_form')[0].action = $(this).data('action');
                $('#scan_copy_upload_modal').modal('show');
            });

            $(function () {
                $('#scan_copy_upload_form').validate({
                    rules: {
                        scan_copy: {
                            extension: 'jpg|pdf',
                        },
                    },
                    messages: {
                        scan_copy: {
                            extension: 'শুধুমাত্র পিডিএফ/জেপিজি ফাইল প্রদান করুন।',
                        },
                    },
                    submitHandler: function (htmlForm) {
                        showLoader();
                        $('.overlay').show();
                        const form = $(htmlForm);
                        const formData = new FormData(htmlForm);
                        const url = form.attr("action");

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
                                hideLoader();
                            },
                        });
                        return false;
                    },
                });
            });

        });
    </script>
@endpush

