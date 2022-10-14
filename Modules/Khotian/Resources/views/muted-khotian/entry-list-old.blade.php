@extends('voyager::master')

@section('page_title', __('নামজারি খতিয়ান সমূহ (নতুন এন্ট্রি কৃত)') )

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-bookmark"></i> {{ __('নামজারি খতিয়ান সমূহ (নতুন এন্ট্রি কৃত)') }}
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
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>{{__('খতিয়ান নাম্বার')}}</th>
                                            <th>{{__('মৌজা')}}</th>
                                            <th>{{__('ডি জি এল আর')}}</th>
                                            <th>{{__('জে এল')}}</th>
                                            <th>{{__('রে সা নং')}}</th>
                                            <th>{{__('নামজারি কেস নং')}}</th>
                                            <th>{{__('কেসের তারিখ')}}</th>
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

    <div class="modal modal-danger fade" tabindex="-1" id="copy_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        {{ __('আপনি কি নিশ্চিতভাবে নকল সম্পন্ন করতে চান?') }}
                    </h4>
                </div>
                <div class="modal-body" id="delete_model_body"></div>
                <div class="modal-footer">
                    <form action="#" id="copy_form" method="POST">
                        {{ method_field("POST") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('হ্যাঁ, নকল করুন') }}">
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
@stop

@section('javascript')
    <script>
        $(document).ready(function () {
            var dataTableParams = {!! json_encode(
                    array_merge([
                        "language" => __('voyager::datatable'),
                        "processing" => true,
                        "serverSide" => true,
                        "ordering" => true,
                        "searching" => true,
                        "stateSave"=> false,
                        "ajax" => [
                            "method" => "POST",
                            "url" => route("admin.muted_khotian.entry.list")
                        ],

                        "columns" => [
                            [ "data" => 'khotian_number',"name" => 'khotian_number',  'orderable' => false, 'searchable' => false],
                            [ "data" => 'mouza_name', "name" => 'mouza_name',  'orderable' => false, 'searchable' => false],
                            [ "data" => 'dglr_code', "name" => 'dglr_code',  'orderable' => false, 'searchable' => false],
                            [ "data" => 'jl_number', "name" => 'jl_number',  'orderable' => false, 'searchable' => false],
                            [ "data" => 'resa_no', "name" => 'resa_no',  'orderable' => false, 'searchable' => false,  'orderable' => false, 'searchable' => false],
                            [ "data" => 'namjari_case_no', "name" => 'namjari_case_no',  'orderable' => false, 'searchable' => false],
                            [ "data" => 'case_date', "name" => 'case_date',  'orderable' => false, 'searchable' => false],
                            [ "data" => 'status', "name" => 'status',  'orderable' => false, 'searchable' => false],
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
                        table.search( bn2en(this.value) ).draw();
                    }
                });
            });
        });

        $(document, 'td a').on('click', '.muted_khotian_copy', function (e) {
            $('#copy_form')[0].action = $(this).data('action');
            $('#copy_modal').modal('show');
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

    </script>
@stop


@section('head')

@endsection
