@extends('master::layouts.master')

@section('title', __('খতিয়ান সমূহ (ব্যাচ এন্ট্রি)') )
@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    <i class="voyager-bookmark"></i> {{ __('খতিয়ান সমূহ (ব্যাচ এন্ট্রি)') }}
                </h3>
                <div class="card-tools">
                    @can('addMutedBatchEntry', app(\Modules\Khotian\App\Models\MutedKhotian::class))
                        <a href="{{ route('admin.khotians.batch-entry.create') }}" class="btn btn-info">
                            <span class="glyphicon glyphicon-list"></span>&nbsp;
                            {{ __('generic.add_new') }}
                        </a>
                    @endcan
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="datatable-container">
                    <div class="row">
                        <div class="col-md-4 d-none">
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
                        <div class="col-md-4 d-none">
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

    <div class="modal modal-danger fade" tabindex="-1" id="compare_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        {{ __('আপনি কি নিশ্চিতভাবে তুলনা সম্পন্ন করতে চান?') }}
                    </h4>
                </div>
                <div class="modal-body" id="delete_model_body"></div>
                <div class="modal-footer">
                    <form action="#" id="compare_form" method="POST">
                        {{ method_field("POST") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('হ্যাঁ, তুলনা করুন') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="compare_return_modal" role="dialog">
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
                                data-dismiss="modal">{{ __('বন্ধ করুন') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" id="history_log_modal" tabindex="-1" aria-labelledby="historyLogModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ __('খতিয়ানের হিস্টোরি লগ') }}
                    </h5>
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
        /*datatable design customize*/
        div#dataTable_filter {
            float: right;
        }

        ul.pagination {
            float: right;
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
        $(document).ready(function () {
            function showLoader() {
                $('#loading-sniper').show();
                $('body').css('overflow', 'hidden');
            }

            function hideLoader() {
                $('#loading-sniper').hide();
                $('body').css('overflow', 'auto');
            }

            let lanBn = {{ Session::get('locale') != 'en' ? 1: 0 }};
            let lanBnPath = lanBn ? "/json/bn.json" : "";

            let params = serverSideDatatableFactory({
                url: '{{route("admin.khotians.batch-entry.list")}}',
                order: [[0, "asc"]],
                language: {
                    "url": lanBnPath,
                },
                columns: [
                    {
                        title: "{{__('generic.sl_no')}}",
                        data: null,
                        defaultContent: '',
                        orderable: false,
                        searchable: false,
                        targets: 0
                    },
                    {
                        title: "{{ __('generic.khotian_number') }}",
                        data: "khotian_number",
                        name: "division20_khotians.khotian_number",
                    },
                    {
                        title: "{{ __('generic.upazila') }}",
                        data: "upazila_name",
                        name: "division20_khotians.upazila_bbs_code",
                    },
                    {
                        title: "{{ __('generic.mouja') }}",
                        data: "mouza_name",
                        name: "division20_khotians.jl_number",
                    },
                    {
                        title: "{{ __('generic.dglr_code') }}",
                        data: "dglr_code",
                        name: "division20_khotians.dglr_code",
                    },
                    {
                        title: "{{ __('generic.jl_number') }}",
                        data: "jl_number",
                        name: "division20_khotians.jl_number",
                    },
                    {
                        title: "{{ __('generic.resa_no') }}",
                        data: "resa_no",
                        name: "division20_khotians.resa_no",
                    },
                    {
                        title: "{{ __('generic.namjari_case_no') }}",
                        data: "namjari_case_no",
                        name: "division20_khotians.namjari_case_no",
                    },
                    {
                        title: "{{ __('generic.case_date') }}",
                        data: "case_date",
                        name: "division20_khotians.case_date",
                    },
                    {
                        title: "{{ __('generic.status') }}",
                        data: "status",
                        name: "division20_khotians.status",
                    },
                    {
                        title: "{{ __('generic.action') }}",
                        data: "action",
                        orderable: false,
                        searchable: false,
                    }]
            });
            const table = $('#dataTable').DataTable(params);

            let showSoftDeletes = 0;
            $('#show_soft_deletes').change(function () {
                showSoftDeletes = $(this).prop('checked') ? 1 : 0;
                table.draw();
            });

            $('#filter').click(function () {
                table
                    .column(1).search(bn2en($('#khotian_number').val()))
                    .column(2).search(bn2en($('#upazila_bbs_code').val()))
                    .column(3).search($('#mouja_id').val())
                    .draw();
            });

            let districtBbcCode = $('#district_bbs_code').val();

            function loadUpazilas(districtBbcCode) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('get-upazilas') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'district_bbs_code': districtBbcCode,
                    },
                    success: function (response) {
                        console.log('response', response)
                        $('#upazila_bbs_code').html('');
                        $('#upazila_bbs_code').html('<option value="">{{ __('generic.select_placeholder') }}</option>');

                        $.each(response, function (key, value) {
                            $('#upazila_bbs_code').append(
                                '<option value="' + value.bbs_code + '">' + (value.title) + '</option>'
                            );
                        });
                    },
                    error: function () {
                        console.log("error");
                    }
                });
            }

            function loadMoujas() {
                //showLoader();
                let upazilaBbsCode = $('#upazila_bbs_code').val();
                let districtBbsCode = $('#district_bbs_code').val();
                if (upazilaBbsCode) {
                    $('#mouja_id').prop('disabled', false);

                    $.ajax({
                        type: 'post',
                        url: '{{ route('admin.khotians.get-all-moujas') }}',
                        data: {
                            'upazila_bbs_code': upazilaBbsCode,
                            'district_bbs_code': districtBbsCode,
                        },
                        success: function (response) {
                            $('#mouja_id').html('');
                            $('#mouja_id').html('<option value="">নির্বাচন করুণ</option>');
                            $.each(response, function (key, value) {
                                $('#mouja_id').append(
                                    '<option value="' + key + '" data-dglr-code="' + key + '" >' + value + '</option>'
                                );
                            });
                            //hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });

                } else {
                    $('#mouja_id').html('');
                    $('#mouja_id').html('<option value="">নির্বাচন করুণ</option>');
                    //hideLoader();
                }
            }

            loadUpazilas(districtBbcCode);

            $('#upazila_bbs_code').on('change', function () {
                loadMoujas();
            });

            $(document, 'td a').on('click', '.muted_khotian_compare', function (e) {
                $('#compare_form')[0].action = $(this).data('action');
                $('#compare_modal').modal('show');
            });

            $(document, 'td a').on('click', '.muted_khotian_return', function (e) {
                $('#compare_return_form')[0].action = $(this).data('action');
                $('#compare_return_modal').modal('show');
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

        });

    </script>
@endpush

