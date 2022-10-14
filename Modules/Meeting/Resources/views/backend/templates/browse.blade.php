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
                        <h3 class="card-title font-weight-bold">{{__('generic.template_list')}}</h3>


                        <div class="card-tools">
                            @can('create', \Modules\Meeting\Models\Template::class)
                                <a href="{{ route('admin.meeting_management.templates.create') }}"
                                   class="btn btn-sm btn-primary btn-rounded">
                                    <i class="fas fa-plus-circle"></i> {{ __('generic.add_new') }}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="datatable-container">
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

    </style>
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/en2bn/en2bn.js')}}"></script>

    <script>
        $(function () {
            let lanBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};
            let lanBnPath = lanBn ? "/json/bn.json" : "";

            let params = serverSideDatatableFactory({
                url: '{{route('admin.meeting_management.templates.datatable')}}',
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
                        title: "{{ __('generic.title_bn') }}",
                        data: "title",
                        name: "landless.title"
                    },
                    {
                        title: "{{ __('generic.title_en') }}",
                        data: "title_en",
                        name: "landless.title_en"
                    },
                    {
                        title: "{{ __('generic.template_type') }}",
                        data: "template_type",
                        name: "landless.template_type"
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

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });
        });
    </script>
@endpush
