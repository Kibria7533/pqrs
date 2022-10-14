@extends('voyager::master')

@section('page_title', __('নামজারি আবেদনসমূহের তালিকা') )

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-bookmark"></i> {{ __('নামজারি আবেদনসমূহের তালিকা') }}
            <button class="btn btn-success" onclick="tbl2exl()">Download</button>
        </h1>
    </div>
    <style>
        #dataTable .btn-sm {
            padding: 3px 8px;
            margin: 0 2px;
            font-size: .8rem;
        }
        .modal-header .close {
            position: absolute;
            top: 6px;
            right: 10px;
            color: #fff;
        }
        .voyager .modal.modal-danger .modal-header {
            background-color: #8167e8;
            color: #fff;
        }
        .modal-title {
            margin-bottom: 0;
            line-height: 1.5;
            font-size: 15px;
        }
        .voyager .btn.btn-danger {
            background: #2ecc5a;
        }
        .voyager .btn.btn-danger:hover {
            background: #18b845;
        }
    </style>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>আবেদনের তারিখ</label>
                                        <input class="form-control form-control-sm" type="text" id="apply_date" name="apply_date" value="" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label>আবেদন নং</label>
                                        <input class="form-control form-control-sm" type="text" id="application_display_code" name="application_display_code" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>আবেদনকারীর নাম/মোবাইল</label>
                                        <input class="form-control form-control-sm" type="text" id="applicant_name_mobile" name="applicant_name_mobile" value="" />
                                    </div>
                                   {{--TODO: commented out (arman)  <div class="col-lg-3">
                                        <label>উপজেলা</label>
                                        <input type="hidden" name="district_bbs" id="district_bbs" value="{{ $districtBBS }}">
                                        <select name="upazila_id" id="upazila_id"class="form-control form-control-sm">
                                            <option value="">--</option>
                                            @php
                                                if (!empty($upazilas) && count($upazilas) > 0) {
                                                    foreach ($upazilas as $bbs => $title) {
                                                        echo '<option value="'.$bbs.'"">'.$title.'</option>';
                                                    }
                                                }
                                            @endphp
                                        </select>
                                    </div> --}}

                                    <div class="col-lg-3">
                                        <label>মৌজা</label>
                                        <input type="hidden" name="district_bbs" id="district_bbs" value="{{ $districtBBS }}">
                                        <select name="mouja_id" id="mouja_id"class="form-control form-control-sm">
                                            <option value="">--</option>
                                            @php
                                                if (!empty($mouja) && count($mouja) > 0) {
                                                    foreach ($mouja as $bbs => $title) {
                                                        echo '<option value="'.$bbs.'">'.$title.'</option>';
                                                    }
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                    <div class="col-lg-1 col-md-1">
                                        <label>&nbsp;</label>
                                        <button id="search_btn" class="form-control form-control-sm btn-sm btn-primary">অনুসন্ধান</button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>{{__('আবেদন নং')}}</th>
                                            <th>{{__('আবেদনের তারিখ')}}</th>
                                            <th>{{__('আবেদনকারীর নাম/মোবাইল')}}</th>
                                            <th>{{__('মৌজা')}}</th>
                                            <th>{{__('জে.এল. নং')}}</th>
                                            <th>{{__('খতিয়ান নং')}}</th>
                                            <th>{{__('অবস্থা')}}</th>
                                            <th>{{__('voyager::generic.actions')}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}?
                    </h4>
                </div>
                <div class="modal-body" id="delete_model_body"></div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_this_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="history_log_modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        {{ __('খতিয়ানের হিস্টোরি লগ') }}
                    </h4>
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
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@stop

@section('javascript')
    <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        function en2bn(input) {
            var numbers = {
                0: '০',
                1: '১',
                2: '২',
                3: '৩',
                4: '৪',
                5: '৫',
                6: '৬',
                7: '৭',
                8: '৮',
                9: '৯'
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
        $(document).ready(function () {
            var dataTableParams = {!! json_encode(
                    array_merge([
                        "language" => __('voyager::datatable'),
                        "processing" => true,
                        "serverSide" => true,
                        "ordering" => true,
                        "searching" => true,
                        "stateSave"=> false,
                        "sDom" => 'lrtip', // TODO: removed search bar
                        "ajax" => [
                            "method" => "POST",
                            "url" => route("admin.muted_khotian.entry.list")
                        ],
                        "lengthMenu"=> [ [10, 25, 50, -1], [10, 25, 50, "All"] ],

                        "columns" => [
                            [ "data" => 'application_display_code',"name" => 'applications.application_display_code', 'searchable' => false],
                            [ "data" => 'application_date', "name" => 'applications.application_date', 'searchable' => false],
                            [ "data" => 'applicant_name_mobile', "name" => 'applications.applicant_name_mobile', 'searchable' => false],
                            [ "data" => 'mouja_name', "name" => 'applications.mouja_name', 'searchable' => false],
                            [ "data" => 'mouja_jl_code', "name" => 'applications.mouja_jl_code', 'searchable' => false],
                            [ "data" => 'khotian_no',"name" => 'khatian_entry_request.khotian_no', 'searchable' => false],
                            [ "data" => 'muted_status',"name" => 'khatian_entry_request.status', 'searchable' => false],
                            [ "data" => 'action', 'orderable' => false, 'searchable' => false]
                        ]
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!};

            let showSoftDeletes = 0;
            $('#show_soft_deletes').change(function () {
                showSoftDeletes = $(this).prop('checked') ? 1 : 0;
                table.draw();
            });

            let table = $('#dataTable').DataTable(dataTableParams);

            $(document).on('focus', '.dataTables_filter input', function() {
                $(this).unbind().bind('keyup', function(e) {
                    if(e.keyCode === 13) {
                        let search_value = en2bn(this.value.toString());
                        table.search( search_value ).draw();
                    }
                });
            });


            $('input[name="apply_date"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="apply_date"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('input[name="apply_date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $('#search_btn').click(function (){
                // alert('ok');
                let upazilaName = $('#upazila_id :selected').text();
                if (upazilaName == '--') {
                    upazilaName = '';
                }
                let moujaName= $('#mouja_id :selected').text();
               
                if (moujaName == '--') {
                    moujaName = '';
                }

                $('#dataTable').DataTable()
                    .column(0).search($('#application_display_code').val())
                    .column(1).search($('#apply_date').val())
                    .column(2).search($('#applicant_name_mobile').val())
                    .column(3).search(moujaName)
                //.column(10).search($('#delivery_medium :selected').val())
                    .columns
                    .adjust()
                    .draw();
            });
        });

        $(document, 'td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = $(this).data('action');
            $('#delete_modal').modal('show');
        });

        function tbl2exl() {
            $("#dataTable").table2excel({
                filename: "excel_sheet-name.xls"
            });
        }

        /** History Log **/
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

    </script>

@stop


@section('head')

@endsection