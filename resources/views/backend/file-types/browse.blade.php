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
                        <h3 class="card-title font-weight-bold">{{__('generic.file_type_list')}}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.file-types.create') }}"
                               class="btn btn-sm btn-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{ __('generic.add_new') }}
                            </a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="datatable-container">
                            {{--<div class="row" id="filter-area">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="org_code">{{ __('generic.org_code') }} </label>
                                        <input type="text"
                                               class="form-control custom-form-control select2"
                                            name="org_code"
                                            id="org_code" >
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="office_type">{{ __('generic.office_type') }} </label>
                                        <select class="custom-select select2"
                                                id="office_type"
                                                name="office_type"
                                                data-placeholder="{{ __('generic.select_placeholder') }}">
                                            <option value="">{{ __('generic.select_placeholder') }}</option>

                                            @foreach(\App\Models\Office::OFFICE_TYPE as $key=>$value)
                                                <option value="{{ $key }}">{{ __('generic.'.$value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="jurisdiction">{{ __('generic.jurisdiction') }} </label>
                                        <select class="custom-select select2"
                                                id="jurisdiction"
                                                name="jurisdiction"
                                                data-placeholder="{{ __('generic.select_placeholder') }}">
                                            <option value="">{{ __('generic.select_placeholder') }}</option>

                                            @foreach(\App\Models\Office::JURISDICTION as $key=>$value)
                                                <option value="{{ $key }}">{{ __('generic.'.$value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="dglr_code">{{ __('generic.dglr_code') }} </label>
                                        <input type="text"
                                               class="form-control custom-form-control select2"
                                               name="dglr_code"
                                               id="dglr_code" >
                                    </div>
                                </div>


                                <div class="col-md-2">
                                    <div class="input-group mb-3">
                                        <label for="gender">&nbsp; </label>
                                        <input type="submit" style="height: 45px"
                                               class="btn btn-info w-100"
                                               name="filter"
                                               id="filter"
                                               value="{{ __('generic.search') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
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
                url: '{{route('admin.file-types.datatable')}}',
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
                        title: "{{ __('generic.name_bn') }}",
                        data: "title",
                        name: "file_types.title"
                    },
                    {
                        title: "{{ __('generic.name_en') }}",
                        data: "title_en",
                        name: "offices.title_en"
                    },
                    {
                        title: "{{ __('generic.short_code') }}",
                        data: "short_code",
                        name: "offices.short_code"
                    },
                    {
                        title: "{{ __('generic.allow_format') }}",
                        data: "allow_format",
                        name: "offices.allow_format"
                    },
                    {
                        title: "{{ __('generic.order_number') }}",
                        data: "order_number",
                        name: "offices.order_number",
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
                let orgCode = $('#org_code').val();
                let officeType = $('#office_type').val();
                let jurisdiction = $('#jurisdiction').val();
                let dglrCode = $('#dglr_code').val();

                datatable.column(3).search(orgCode).draw();
                datatable.column(4).search(officeType).draw();
                datatable.column(5).search(jurisdiction).draw();
                datatable.column(6).search(dglrCode).draw();
            });

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });
        });
    </script>
@endpush
