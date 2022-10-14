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
                        <h3 class="card-title font-weight-bold">{{__('বণ্টনকৃত জমি (ভূমিহীনের তালিকা)')}}</h3>

                        <div class="card-tools">
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
                                        <label for="jl_number">{{ __('generic.mouja') }} </label>
                                        <select class="form-control custom-form-control select2"
                                                name="jl_number"
                                                id="jl_number"
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                        >
                                            <option value="">{{ __('generic.select_placeholder') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status">{{ __('generic.status') }} </label>
                                        <select class="custom-select select2"
                                                id="status"
                                                name="status"
                                                data-placeholder="{{ __('generic.select_placeholder') }}">
                                            <option value="">{{ __('generic.select_placeholder') }}</option>

                                            @foreach(\Modules\Landless\App\Models\Landless::STATUS as $key=>$status)
                                                @if(!($key==\Modules\Landless\App\Models\Landless::STATUS_INACTIVE || $key==\Modules\Landless\App\Models\Landless::STATUS_DELETED))
                                                    <option value="{{ $key }}">{{ __('generic.'.$status) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                            <table id="dataTable" class="table table-bordered table-striped dataTable">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('utils.delete-confirm-modal')

    <!-- approve scratch map modal -->
    <div class="modal modal-success fade" tabindex="-1" id="approve-scratch-map-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle"></i>
                        {{ __('আপনি কি অনুমোদন দিবেন?') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-right"
                            data-dismiss="modal">{{ __('generic.no') }}</button>
                    <form action="" id="approve-scratch-map-modal-form" class="float-left"
                          method="post">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-success pull-right"
                               value="{{ __('generic.yes') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- reject modal -->
    <div class="modal modal-warning fade" tabindex="-1" id="reject-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-ban"></i>
                        {{ __('আপনি কি এটি বাতিল করতে চান?') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-right"
                            data-dismiss="modal">{{ __('generic.no') }}</button>
                    <form action="" id="reject-modal-form" class="float-left"
                          method="post">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-success pull-right"
                               value="{{ __('generic.yes') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
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

        .custom-control-label::before {
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
        .dataTables_scrollBody{
            min-height: 200px!important;
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
                url: '{{route('admin.land-assignments.datatable')}}',
                order: [[1, "desc"]],
                language: {
                    "url": lanBnPath,
                },
                serialNumberColumn: 0,
                columns: [
                    {
                        title: '{{ __('generic.sl_no') }}',
                        data: null,
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },
                    {
                        title: "id",
                        data: "id",
                        searchable: false,
                        visible: false
                    },
                    {
                        title: "{{ __('generic.name_of_the_applicant') }}",
                        data: "fullname",
                        name: "landless_applications.fullname"
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
                        visible: false
                    },
                    {
                        title: "{{ __('generic.upazila') }}",
                        data: "upazila_title_bn",
                        name: "landless_applications.loc_upazila_bbs",
                    },
                    {
                        title: "{{ __('generic.mouja') }}",
                        data: "mouja_name_bn",
                        name: "landless_applications.jl_number",
                    },
                    {
                        title: "{{ __('generic.jl_number') }}",
                        data: "jl_number",
                        name: "landless_applications.jl_number",
                    },
                    {
                        title: "{{ __('generic.dag_number') }}",
                        data: "dag_number",
                        name: "land_assignments.dag_number",
                    },
                    {
                        title: "{{ __('generic.assigned_land_area') }}",
                        data: "assigned_land_area",
                        name: "land_assignments.assigned_land_area",
                    },
                    {
                        title: "{{ __('generic.status') }}",
                        data: "status_title",
                        name: "land_assignments.status",
                    },
                    {
                        title: "{{ __('পর্যায়') }}",
                        data: "stage_title",
                        name: "land_assignments.stage",
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
                let jlNumber = $('#jl_number').val();
                let gender = $('#gender').val();
                let status = $('#status').val();

                datatable.column(7).search(gender).draw();
                datatable.column(8).search(locUpazila).draw();
                datatable.column(9).search(jlNumber).draw();
                datatable.column(11).search(status).draw();
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

            $(document, 'td').on('click', '.approve-scratch-map', function (e) {
                $('#approve-scratch-map-modal-form')[0].action = $(this).data('action');
                $('#approve-scratch-map-modal').modal('show');
            });

            $(document, 'td').on('click', '.reject-scratch-map', function (e) {
                $('#reject-modal-form')[0].action = $(this).data('action');
                $('#reject-modal').modal('show');
            });

            let langBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};

            $('#loc_upazila_bbs').on('change', function () {
                let upazilaBbcCode = $(this).val();
                let DistrictBbsCode = 75;
                let DivisionBbsCode = 20;
                if (upazilaBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-moujas') }}',
                        data: {
                            'division_bbs_code': DivisionBbsCode,
                            'district_bbs_code': DistrictBbsCode,
                            'upazila_bbs_code': upazilaBbcCode,
                        },
                        success: function (response) {
                            console.log(response)
                            $('#jl_number').html('');
                            $('#jl_number').html('<option value="">নির্বাচন করুন</option>');
                            $.each(response, function (key, value) {
                                $('#jl_number').append(
                                    '<option value="' + value.rs_jl_no + '">' + (langBn ? value.name_bd : value.name) + '</option>'
                                );
                            });
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                } else {
                    $('#jl_number').html('');
                    $('#jl_number').html('<option value="">নির্বাচন করুন</option>');
                }
            });
        });
    </script>
@endpush
