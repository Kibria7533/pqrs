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
                        <h3 class="card-title font-weight-bold">{{ __('generic.landless_list')}} ( {{ __('generic.dc_approved') }} )</h3>


                        <div class="card-tools">
                            {{--<a href="{{ route('admin.landless.create') }}"
                               class="btn btn-sm btn-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{ __('generic.add_new') }}
                            </a>--}}
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="datatable-container">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loc_upazila_bbs">{{ __('generic.upazila') }} </label>
                                        <select class="form-control custom-form-control select2"
                                                name="loc_upazila_bbs"
                                                id="loc_upazila_bbs"
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                        >
                                            <option value="">{{ __('generic.select_placeholder') }}</option>
                                            @foreach($locUpazilas as $key => $value)
                                                <option
                                                    value="{{ $value->bbs_code }}"> {{ $langBn ? $value->title: $value->title_en }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loc_union">{{ __('generic.union') }} </label>
                                        <select class="form-control custom-form-control select2"
                                                name="loc_union_bbs"
                                                id="loc_union_bbs"
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                        >
                                            <option value="">{{ __('generic.select_placeholder') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="gender">{{ __('generic.gender') }} </label>
                                        <select class="custom-select select2"
                                                id="gender"
                                                name="gender"
                                                data-placeholder="{{ __('generic.select_placeholder') }}">
                                            <option value="">{{ __('generic.select_placeholder') }}</option>
                                            <option value="1">{{ __('generic.male') }}</option>
                                            <option value="2">{{ __('generic.female') }}</option>
                                            <option value="3">{{ __('generic.others') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="gender">{{ __('generic.application_date') }} </label>
                                        <input type="text" style="height: 45px"
                                               class="flat-date form-control application_date"
                                               name="application_date"
                                               id="application_date"
                                               placeholder="{{ __('generic.select_date') }}"
                                               value=""/>
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
                            {{--<div id="multi-select-area" class="position-absolute">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="select_all_rows">
                                    <label class="custom-control-label"
                                           for="select_all_rows">{{ __('generic.select_all') }}</label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <button id="approve-now" style="visibility: hidden" type="submit"
                                            class="mb-3 btn btn-sm btn-success float-right"
                                            data-toggle="modal" data-target="#approve-application-modal-all">
                                        <i class="fas fa-check-circle"></i> {{ __('generic.approve_all_landless') }}
                                    </button>

                                    <button id="reject-multiple" style="visibility: hidden" type="submit"
                                            class="mb-3 ml-1 btn btn-sm btn-danger float-right"
                                            data-toggle="modal" data-target="#reject-multiple-modal">
                                        <i class="fas fa-times-circle"></i> {{ __('generic.reject_all_landless') }}
                                    </button>
                                </div>
                            </div>--}}
                            <table id="dataTable" class="table table-bordered table-striped dataTable">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for single approve landless-->
    <div class="modal modal-danger fade" tabindex="-1" id="approve-single-landless-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="approveSingleLandless">
                        <i class="fas fa-check-circle"></i>
                        {{ __('generic.landless_approve_confirmation') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('generic.landless_approve_confirmation_msg') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-right"
                            data-dismiss="modal">{{ __('generic.cancel') }}</button>
                    <form action="" id="approve-single-landless-form" class="float-left"
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

    <!-- Modal for single reject landless-->
    <div class="modal modal-danger fade" tabindex="-1" id="reject-single-landless-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="rejectSingleLandless">
                        <i class="fas fa-check-circle"></i>
                        {{ __('generic.landless_reject_confirmation') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('generic.landless_reject_confirmation_msg') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-right"
                            data-dismiss="modal">{{ __('generic.cancel') }}</button>
                    <form action="" id="reject-single-landless-form" class="float-left"
                          method="post">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right"
                               value="{{ __('generic.confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for multiple approve landless-->
    <div class="modal modal-danger fade" tabindex="-1" id="approve-application-modal-all" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="approveConfirmationLabel">
                        <i class="fas fa-check-circle"></i>
                        {{ __('generic.select_all_landless_approve_confirmation') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('generic.select_all_landless_approve_confirmation_msg') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-right"
                            data-dismiss="modal">{{ __('generic.cancel') }}</button>
                    <form action="" id="approve-now-form" class="float-left"
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

    <!-- Modal for multiple reject landless-->
    <div class="modal modal-danger fade" tabindex="-1" id="reject-multiple-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="rejectConfirmationLabel">
                        <i class="fas fa-check-circle"></i>
                        {{ __('generic.select_all_landless_reject_confirmation') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('generic.select_all_landless_reject_confirmation_msg') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-right"
                            data-dismiss="modal">{{ __('generic.cancel') }}</button>
                    <form action="" id="reject-multi-form" class="float-left"
                          method="post">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('generic.confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('utils.delete-confirm-modal')

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
        .application_date {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            box-shadow: inset 0 1px 2px rgb(0 0 0 / 8%);
            height: 45px;
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
            let lanBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};
            let lanBnPath = lanBn ? "/json/bn.json" : "";

            let params = serverSideDatatableFactory({
                url: '{{route('admin.landless.acland-approved-list.datatable')}}',
                order: [[0, "asc"]],
                language: {
                    "url": lanBnPath,
                },
                serialNumberColumn: 1,
                /*select: {
                    style: 'multi',
                    selector: 'td:first-child',
                },*/
                columnDefs: [
                    {
                        "targets": 0,
                        "orderable": false,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            //$(td).addClass('select-checkbox').prop('disabled', false);
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
                        title: "{{ __('generic.name_of_the_applicant') }}",
                        data: "fullname",
                        name: "landless_applications.fullname",
                        //name: "landless.fullname",
                    },
                    {
                        title: "{{ __('generic.mobile_number') }}",
                        data: "mobile",
                        name: "landless_applications.mobile"
                    },
                    {
                        title: "{{ __('email') }}",
                        data: "email",
                        name: "landless_applications.email"
                    },
                    {
                        title: "{{ __('generic.identity_number') }}",
                        data: "identity_number",
                        name: "landless_applications.identity_number",
                    },
                    {
                        title: "{{ __('generic.gender') }}",
                        data: "gender",
                        name: "landless_applications.gender",
                    },
                    {
                        title: "{{ __('generic.upazila') }}",
                        data: "loc_upazila_title",
                        name: "landless_applications.loc_upazila_bbs",
                    },
                    {
                        title: "{{ __('generic.union') }}",
                        data: "loc_union_title",
                        name: "landless_applications.loc_union_bbs",
                    },
                    {
                        title: "{{ __('generic.application_date') }}",
                        data: "application_date",
                        name: "landless_applications.created_at",
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

            $('#filter').on('click', function () {
                let locUpazila = $('#loc_upazila_bbs').val();
                let locUnion = $('#loc_union_bbs').val();
                let gender = $('#gender').val();
                let applicationDate = $('#application_date').val();

                datatable.column(6).search(gender).draw();
                datatable.column(7).search(locUpazila).draw();
                datatable.column(8).search(locUnion).draw();
                datatable.column(9).search(applicationDate).draw();
            });

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
                        $('#reject-multiple').css({visibility: 'visible'});
                    } else {
                        $('#approve-now').css({visibility: 'hidden'});
                        $('#reject-multiple').css({visibility: 'hidden'});
                    }

                    let totalRows = datatable.rows().count();
                    $("#select_all_rows").prop('checked', totalRows === selectedRows)

                }
            });

            let acceptNowForm = $("#approve-now-form");
            let rejectMultiForm = $("#reject-multi-form");

            $("#approve-now").click(function () {
                acceptNowForm.find('.landless_ids').remove();
                let selectedRows = Array.from(datatable.rows({selected: true}).data());
                (selectedRows || []).forEach(function (row) {
                    acceptNowForm.append('<input name="landless_ids[]" class="landless_ids" value="' + row.id + '" type="hidden"/>');
                });
            });
            $("#reject-multiple").click(function () {
                rejectMultiForm.find('.landless_ids').remove();
                let selectedRows = Array.from(datatable.rows({selected: true}).data());
                (selectedRows || []).forEach(function (row) {
                    rejectMultiForm.append('<input name="landless_ids[]" class="landless_ids" value="' + row.id + '" type="hidden"/>');
                });
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

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });

            $(document, 'td').on('click', '.approve', function (e) {
                $('#approve-single-landless-form')[0].action = $(this).data('action');
                $('#approve-single-landless-modal').modal('show');
            });

            $(document, 'td').on('click', '.reject', function (e) {
                $('#reject-single-landless-form')[0].action = $(this).data('action');
                $('#reject-single-landless-modal').modal('show');
            });

            /*flatpickr("#application_date", {
                mode: 'range',
            });*/

            let langBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};

            $('#loc_upazila_bbs').on('change', function () {
                //showLoader();
                let upazilaBbcCode = $(this).val();
                let DistrictBbsCode = 75;
                let DivisionBbsCode = 20;

                if (upazilaBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-unions') }}',
                        data: {
                            'division_bbs_code': DivisionBbsCode,
                            'district_bbs_code': DistrictBbsCode,
                            'upazila_bbs_code': upazilaBbcCode,
                        },
                        success: function (response) {
                            console.log(response)
                            $('#loc_union_bbs').html('');
                            $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');
                            $.each(response, function (key, value) {
                                $('#loc_union_bbs').append(
                                    '<option value="' + value.bbs_code + '">' + (langBn ? value.title : value.title_en) + '</option>'
                                );
                            });
                            //hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });

                } else {
                    $('#loc_union_bbs').html('');
                    $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');
                    //hideLoader();
                }
            });

        });
    </script>
@endpush
