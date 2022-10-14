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
                        <h3 class="card-title font-weight-bold">{{__('generic.kabuliat_list')}}</h3>


                        <div class="card-tools">
                            <a href="{{ route('admin.kabuliats.create') }}"
                               class="btn btn-sm btn-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{ __('generic.add_new') }}
                            </a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="datatable-container">
                            <div class="row" id="filter-area">
                                <div class="col-md-2">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="case_no">
                                                {{ __('generic.case_no') }}
                                            </label>
                                        </div>
                                        <input type="text"
                                               class="form-control custom-form-control"
                                               name="case_no"
                                               id="case_no">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-3" style="height: 45px">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="case_date">
                                                {{ __('generic.case_date') }}
                                            </label>
                                        </div>
                                        <input type="text" style="height: 45px"
                                               class="flat-date form-control case_date"
                                               name="case_date"
                                               id="case_date"
                                               placeholder="{{ __('generic.select_date') }}"
                                               value=""/>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="reg_no">
                                                {{ __('generic.reg_no') }}
                                            </label>
                                        </div>
                                        <input type="text"
                                               class="form-control custom-form-control"
                                               name="reg_no"
                                               id="reg_no">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3" style="height: 45px">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="handover_date">
                                                {{ __('generic.occupancy_date') }}
                                            </label>
                                        </div>
                                        <input type="text" style="height: 45px"
                                               class="flat-date form-control handover_date"
                                               name="handover_date"
                                               id="handover_date"
                                               placeholder="{{ __('generic.select_date') }}"
                                               value=""/>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-3">
                                        <input type="submit" style="height: 45px"
                                               class="btn btn-info w-100"
                                               name="filter"
                                               id="filter"
                                               value="{{ __('generic.search') }}"/>
                                    </div>
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

    @include('utils.delete-confirm-modal')

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
        .handover_date, .case_date {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            box-shadow: inset 0 1px 2px rgb(0 0 0 / 8%);
        }

        input.flat-date.form-control.case_date.form-control.input {
            height: 45px;
        }
        input.flat-date.form-control.handover_date.form-control.input {
            height: 45px;
        }

        .select2-container--bootstrap4 {
            width: auto !important;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
    <script type="text/javascript" src="{{asset('/js/en2bn/en2bn.js')}}"></script>
    <script>
        $(function () {
            let lanBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};
            let lanBnPath = lanBn ? "/json/bn.json" : "";

            let params = serverSideDatatableFactory({
                url: '{{route('admin.kabuliats.datatable')}}',
                order: [[0, "asc"]],
                language: {
                    "url": lanBnPath,
                },
                columns: [
                    {
                        title: '{{ __('generic.sl_no') }}',
                        data: null,
                        defaultContent: "SL#",
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },
                    {
                        title: "{{ __('generic.settlement_case').' ('.__('generic.number').'), '.__('generic.year') }}",
                        data: "case_no_and_year",
                        name: "kabuliats.case_no"
                    },
                    {
                        title: "{{ __('generic.case_date') }}",
                        data: "case_date",
                        name: "kabuliats.case_date"
                    },
                    {
                        title: "{{ __('generic.ulao_proposal_date') }}",
                        data: "ulao_proposal_date",
                        name: "kabuliats.ulao_proposal_date",
                    },
                    {
                        title: "{{ __('generic.order_no_of_collector') }}",
                        data: "order_no",
                        name: "kabuliats.order_no",
                    },
                    {
                        title: "{{ __('generic.reg_no') }}",
                        data: "reg_no",
                        name: "kabuliats.reg_no",
                    },
                    {
                        title: "{{ __('generic.occupancy_date') }}",
                        data: "handover_date",
                        name: "kabuliats.handover_date",
                    },
                    {
                        title: "{{ __('generic.status') }}",
                        data: "status",
                        name: "kabuliats.status",
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
            bindDatatableSearchOnPresEnterOnly(datatable);

            /**
             * customize DataTable SL no
             * **/
            datatable.on('order.dt search.dt', function () {
                datatable.column(0, {
                    search: false,
                    order: false
                }).nodes().each(function (cell, i) {
                    let sl = i + 1;
                    cell.innerHTML = lanBn ? en2bn(sl.toString()) : sl;
                });
            }).draw();

            $('#filter').on('click', function () {
                let caseNo = $('#case_no').val();
                let caseDate = $('#case_date').val();
                let regNo = $('#reg_no').val();
                let handoverDate = $('#handover_date').val();

                datatable.column(1).search(caseNo).draw();
                datatable.column(2).search(caseDate).draw();
                datatable.column(5).search(regNo).draw();
                datatable.column(6).search(handoverDate).draw();
            });

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });

            flatpickr("#application_date", {
                mode: 'range',
            });

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
