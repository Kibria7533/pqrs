@php
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    User List
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{__('generic.user_list')}}</h3>

                        <div class="card-tools">
                            @can('create', \App\Models\User::class)
                                <a href="{{route('admin.users.create')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-plus-circle"></i> {{__('generic.add_new')}}
                                </a>
                            @endcan
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name_en">{{ __('generic.name_en') }} </label>
                                            <input type="text"
                                                   class="form-control custom-form-control"
                                                   name="name_en"
                                                   id="name_en">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="user_type">{{ __('generic.user_type') }} </label>
                                            <select class="form-control select2"
                                                    name="user_type_id"
                                                    id="user_type_id"
                                                    data-placeholder="{{ __('generic.user_type') }}"
                                            >
                                                <option value="" selected
                                                        disabled>{{ __('generic.user_type') }}</option>
                                                @foreach($userTypes as $userType)
                                                    <option value="{{ $userType->title }}">
                                                        {{$userType->title}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="office_id">{{ __('generic.office') }} </label>
                                            <select class="form-control select2"
                                                    name="office_id"
                                                    id="office_id"
                                                    data-placeholder="{{ __('generic.office') }}"
                                            >
                                                <option value="" selected
                                                        disabled>{{ __('generic.office') }}</option>
                                                @foreach($offices as $office)
                                                    <option value="{{$office->name_bn}}">
                                                        {{$office->name_bn}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="filter"> &nbsp; </label>
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
                                </div>
                            </div>
                        </div>
                        <div class="datatable-container">
                            <table id="dataTable" class="table table-bordered table-striped dataTable">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal id="edit-add-modal" type="success" xl></x-modal>

    @include('utils.delete-confirm-modal')
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
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
                url: '{{ route('admin.users.datatable') }}',
                order: [[2, "asc"]],
                language: {
                    "url": lanBnPath,
                },
                columns: [
                    {
                        title: "{{ __('generic.sl_no') }}",
                        data: null,
                        defaultContent: "SL#",
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },
                    {
                        title: "{{ __('generic.name_en') }}",
                        data: "name",
                        name: "users.name"
                    },
                    {
                        title: "{{ __('generic.user_type') }}",
                        data: "user_type_title",
                        name: "user_types.title"
                    },
                    {
                        title: "{{ __('generic.office') }}",
                        data: "office_name_bn",
                        name: "offices.name_bn"
                    },
                    {
                        title: "{{ __('generic.action') }}",
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                        visible: true
                    },
                ]
            });
            const datatable = $('#dataTable').DataTable(params);

            $('#filter').on('click', function () {
                let userTypeId = $('#user_type_id').val();
                let office = $('#office_id').val();
                let nameEn = $('#name_en').val();

                datatable.column(1).search(nameEn).draw();
                datatable.column(2).search(userTypeId).draw();
                datatable.column(3).search(office).draw();
            });


            bindDatatableSearchOnPresEnterOnly(datatable);

            /**
             * customize DataTable SL no
             * **/
            datatable.on('order.dt', function () {
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
                console.log($('#delete_form')[0].action)
                $('#delete_modal').modal('show');
            });
        });
    </script>
@endpush
