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
                        <h3 class="card-title font-weight-bold">{{__('generic.committee_type_list')}}</h3>


                        <div class="card-tools">
                            <a href="{{ route('admin.meeting_management.committee-types.create') }}"
                               class="btn btn-sm btn-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{ __('generic.add_new') }}
                            </a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="datatable-container">
                            <div id="multi-select-area" class="position-absolute">
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
                url: '{{route('admin.meeting_management.committee-types.datatable')}}',
                order: [[0, "asc"]],
                language: {
                    "url": lanBnPath,
                },
                serialNumberColumn: 0,
                select: {
                    style: 'multi',
                    selector: 'td:first-child',
                },
                columnDefs: [

                ],
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
                        title: "{{ __('generic.committee_type_title') }}",
                        data: "title",
                        name: "committee_types.title"
                    },
                    {
                        title: "{{ __('generic.committee_type_title_en') }}",
                        data: "title_en",
                        name: "committee_types.title_en"
                    },
                    {
                        title: "{{ __('generic.office_type') }}",
                        data: "office_type",
                        name: "committee_types.office_type"
                    },
                    {
                        title: "{{ __('generic.status') }}",
                        data: "status",
                        name: "committee_types.status",
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

        });
    </script>
@endpush
