@extends('master::layouts.master')

@php
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') == 'bn';
@endphp

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{__('generic.khotian_list')}}</h3>


                        <div class="card-tools">
                            <a href="{{ route('admin.khasland-khotian') }}"
                               class="btn btn-sm btn-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{ __('generic.add_new') }}
                            </a>
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
                                        <label for="jl_number">{{ __('generic.jl_number') }} </label>
                                        <input type="number" class="form-control custom-form-control"
                                               name="jl_number"
                                               id="jl_number" min="1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="khotian_number">{{ __('generic.khotian_number') }} </label>
                                        <input type="text"
                                               class="form-control custom-form-control"
                                               name="khotian_number"
                                               id="khotian_number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <label>&nbsp;</label>
                                        <input type="submit" style="height: 45px"
                                               class="btn btn-info w-100"
                                               name="filter_khotian"
                                               id="filter_khotian"
                                               value="{{ __('generic.search') }}"/>
                                    </div>
                                </div>
                            </div>

                            <div id="multi-select-area" class="position-absolute">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="select_all_rows">
                                    <label class="custom-control-label"
                                           for="select_all_rows">{{ __('generic.select_all') }}</label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <button id="approve-now" style="visibility: hidden" type="submit"
                                            class="mb-3 btn btn-sm btn-success float-right"
                                            data-toggle="modal" data-target="#approve-application-modal-all">
                                        <i class="fas fa-check-circle"></i> {{ __('generic.approve_all_khotian') }}
                                    </button>
                                </div>
                            </div>
                            <table id="dataTable" class="table table-bordered table-striped dataTable">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <!-- Modal for save-->
    <div class="modal fade" id="approveConfirmation" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="approveConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="approveConfirmationLabel">
                        <i class="fas fa-check-circle"></i>
                        {{ __('generic.khotian_approve_confirmation') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('generic.khotian_approve_confirmation_msg') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning"
                            data-dismiss="modal">{{ __('generic.cancel') }}</button>
                    <form action="#" id="approve_form" method="POST">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-success pull-right"
                               value="{{ __('generic.confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for approve khotian-->
    <div class="modal modal-danger fade" tabindex="-1" id="approve-application-modal-all" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="approveConfirmationLabel">
                        <i class="fas fa-check-circle"></i>
                        {{ __('generic.select_all_khotian_approve_confirmation') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('generic.select_all_khotian_approve_confirmation_msg') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-right"
                            data-dismiss="modal">{{ __('generic.cancel') }}</button>
                    <form action="{{route('admin.khotian-approve-all')}}" id="approve-now-form" class="float-left"
                          method="post">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-success pull-right delete-confirm"
                               value="{{ __('generic.confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
        .application_date {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            box-shadow: inset 0 1px 2px rgb(0 0 0 / 8%);
        }

        .select2-container--bootstrap4 {
            width: auto !important;
        }

        .custom-control-input:not(:disabled):active ~ .custom-control-label::before {
            content: " ";
            margin-top: -2px;
            margin-left: -6px;
            border: 1px solid black;
            border-radius: 3px;
        }
        .custom-control-label::before{
            background: #fff !important;
        }
        .custom-checkbox .custom-control-input:checked ~ .custom-control-label::after {
            content: "✓";
            font-size: 25px;
            margin-top: -14px;
            margin-left: 2px;
            text-align: center;
            text-shadow: 1px 1px #b0bed9, -1px -1px #b0bed9, 1px -1px #b0bed9, -1px 1px #b0bed9;
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
            let lanBn = {{ Session::get('locale') != 'en' ? 1: 0 }};
            let lanBnPath = lanBn ? "/json/bn.json" : "";

            let params = serverSideDatatableFactory({
                url: '{{route('admin.khasland-khotians.datatable')}}',
                order: [[0, "asc"]],
                language: {
                    "url": lanBnPath,
                },
                serialNumberColumn: 1,
                select: {
                    style: 'multi',
                    selector: 'td:first-child',
                },
                columnDefs: [
                    {
                        "targets": 0,
                        "orderable": false,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            console.log('rowData', rowData)
                            $(td).addClass('select-checkbox').prop('disabled', false);
                        }
                    }
                ],
                columns: [
                    {
                        title: "",
                        data: null,
                        defaultContent: '',
                        orderable: false,
                        searchable: false,
                        targets: 0
                    },
                    {
                        title: '{{ __('generic.sl_no') }}',
                        data: null,
                        defaultContent: "SL#",
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },
                    {
                        title: "{{ __('generic.khotian_number') }}",
                        data: "khotian_number",
                        name: "khasland_khotians.khotian_number"
                    },
                    {
                        title: "{{ __('generic.mouja') }}",
                        data: "jl_number_and_mouja",
                        name: "khasland_khotians.jl_number",
                        //searchable: false,
                    },
                    {
                        title: "{{ __('generic.resa_no') }}",
                        data: "resa_no",
                        name: "khasland_khotians.resa_no"
                    },
                    {
                        title: "{{ __('generic.namjari_case_no') }}",
                        data: "namjari_case_no",
                        name: "khasland_khotians.namjari_case_no",
                    },
                    {
                        title: "{{ __('generic.case_date') }}",
                        data: "case_date",
                        name: "khasland_khotians.case_date",
                    },
                    {
                        title: "{{ __('generic.upazila') }}",
                        data: "loc_upazila_title",
                        name: "khasland_khotians.upazila_bbs_code",
                    },
                    {
                        title: "{{ __('generic.mouja') }}",
                        data: "mouja_title_bn",
                        name: "loc_all_moujas.name_bd",
                        visible: false
                    },

                    /*
                    {
                        title: "{{ __('generic.dags') }}",
                        data: "dags",
                    },
                    {
                        title: "{{ __('generic.owners') }}",
                        data: "owners",
                    },*/
                    /*{
                        title: "{{ __('generic.status') }}",
                        data: "status",
                    },*/
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

            $("#select_all_rows").click(function () {
                let selectedRow = datatable.rows(".selected").nodes().length;
                if (selectedRow == 0) {
                    datatable.rows(':has(.select-checkbox)').select();
                } else {
                    datatable.rows(':has(.select-checkbox)').deselect();
                }
            });

            datatable.on('select deselect', function (e, dt, type, indexes) {
                if (type === 'row') {
                    let selectedRows = datatable.rows({selected: true}).count();
                    if (selectedRows) {
                        $('#approve-now').css({visibility: 'visible'});
                    } else {
                        $('#approve-now').css({visibility: 'hidden'});
                    }

                    let totalRows = datatable.rows().count();
                    $("#select_all_rows").prop('checked', totalRows === selectedRows)

                }
            });

            bindDatatableSearchOnPresEnterOnly(datatable);

            /**
             * customize DataTable SL no
             * **/
            datatable.on('order.dt search.dt', function () {
                datatable.column(1, {
                    search: false,
                    order: false
                }).nodes().each(function (cell, i) {
                    let sl = i + 1;
                    cell.innerHTML = lanBn ? en2bn(sl.toString()) : sl;
                });
            }).draw();

            $('#filter_khotian').on('click', function () {
                let upazilaBbsCode = $('#upazila_bbs_code').val();
                let jlNumber = $('#jl_number').val();
                let khotianNumber = $('#khotian_number').val();

                datatable.column(2).search(khotianNumber).draw();
                datatable.column(3).search(jlNumber).draw();
                datatable.column(7).search(upazilaBbsCode).draw();

            });

            $(document, 'td').on('click', '.approve', function (e) {
                $('#approve_form')[0].action = $(this).data('action');
                $('#approveConfirmation').modal('show');
            });

            let acceptNowForm = $("#approve-now-form");

            $("#approve-now").click(function () {
                acceptNowForm.find('.khasland_khotian_ids').remove();
                let selectedRows = Array.from(datatable.rows({selected: true}).data());
                (selectedRows || []).forEach(function (row) {
                    console.log('row', row)
                    acceptNowForm.append('<input name="khasland_khotian_ids[]" class="khasland_khotian_ids" value="' + row.id + '" type="hidden"/>');
                });
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
                                '<option value="' + value.bbs_code + '">' + (/*langEn ? value.title_en : */value.title) + '</option>'
                            );
                        });
                    },
                    error: function () {
                        console.log("error");
                    }
                });
            }
            loadUpazilas(districtBbcCode);


        });
    </script>
@endpush
