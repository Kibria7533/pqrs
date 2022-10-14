@extends('master::layouts.master')
@section('title')
    Designations
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title font-weight-bold">{{__('generic.designation')}}</h3>
                        <div class="card-tools">
                            @can('create', \App\Models\Designation::class)
                                <a href="{{route('admin.designations.create')}}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus-circle"></i> {{__('generic.add_new')}}
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
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/en2bn/en2bn.js')}}"></script>
    <script>
        $(function () {
            let lanBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};
            let lanBnPath = lanBn ? "/json/bn.json" : "";
            let params = serverSideDatatableFactory({
                url: '{{route('admin.designations.datatable')}}',
                order: [[2, "desc"]],
                language: {
                    "url": lanBnPath,
                },
                columns: [
                    {
                        title: "{{__('generic.sl_no')}}",
                        data: null,
                        defaultContent: "SL#",
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },
                    {
                        title: "{{__('generic.title_bn')}}",
                        data: "title"
                    },
                    {
                        title: "{{__('generic.title_en')}}",
                        data: "title_en"
                    },

                    {
                        title: "{{__('generic.designation_level')}}",
                        data: "level"
                    },
                    {
                        title: "{{__('generic.action')}}",
                        data: "action",
                        orderable: false,
                        searchable: false,
                        visible: true
                    }
                ]
            });
            const datatable = $('#dataTable').DataTable(params);

            bindDatatableSearchOnPresEnterOnly(datatable);

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });

            datatable.on('order.dt search.dt', function () {
                datatable.column(0, {
                    search: false,
                    order: false
                }).nodes().each(function (cell, i) {
                    let sl = i + 1;
                    cell.innerHTML = lanBn ? en2bn(sl.toString()) : sl;
                });
            }).draw();
        });
    </script>
@endpush


