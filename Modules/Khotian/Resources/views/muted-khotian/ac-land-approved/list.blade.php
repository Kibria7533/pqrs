@extends('master::layouts.master')
@php
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') == 'bn';
@endphp

@section('title', __('খতিয়ান সমূহ (ব্যাচ এন্ট্রি)') )
@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    <i class="voyager-bookmark"></i> {{ __('খতিয়ান সমূহ (AC land Approved)') }}
                </h3>
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body">
                <div class="datatable-container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="loc_upazila_bbs">{{ __('খতিয়ান নাম্বার') }} </label>
                                <input type="text"
                                       class="form-control custom-form-control"
                                       id="khotian_number"
                                       name="khotian_number">

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="loc_union">{{ __('মৌজা') }} </label>
                                <input type="hidden" name="district_bbs" id="district_bbs" value="{{ $districtBBS }}">
                                <select name="mouja_id" id="mouja_id"class="form-control custom-form-control select2">
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    @php
                                        if (!empty($mouja) && count($mouja) > 0) {
                                            foreach ($mouja as $bbs => $title) {
                                                echo '<option value="'.$bbs.'">'.$title.'</option>';
                                            }
                                        }
                                    @endphp
                                </select>
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

                    <table id="dataTable" class="table table-bordered table-striped dataTable"></table>

                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="compare_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        {{ __('আপনি কি নিশ্চিতভাবে তুলনা সম্পন্ন করতে চান?') }}
                    </h4>
                </div>
                <div class="modal-body" id="delete_model_body"></div>
                <div class="modal-footer">
                    <form action="#" id="compare_form" method="POST">
                        {{ method_field("POST") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('হ্যাঁ, তুলনা করুন') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
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
            let langBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};
            let lanBnPath = langBn ? "/json/bn.json" : "";

            let params = serverSideDatatableFactory({
                url: '{{route('admin.khotians.acland-approved.datatable')}}',
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
                        title: "{{ __('generic.khotian_number') }}",
                        data: "khotian_number",
                        name: "{{$khotianTalbe}}.khotian_number"
                    },
                    {
                        title: "{{ __('generic.mouja') }}",
                        data: "mouza_name",
                        name: "loc_all_moujas.name_bd"
                    },
                    {
                        title: "{{ __('generic.dglr_code') }}",
                        data: "dglr_code",
                        name: "{{$khotianTalbe}}.dglr_code"
                    },
                    {
                        title: "{{ __('generic.jl_number') }}",
                        data: "jl_number",
                        name: "{{$khotianTalbe}}.jl_number",
                    },
                    {
                        title: "{{ __('generic.resa_no') }}",
                        data: "resa_no",
                        name: "{{$khotianTalbe}}.resa_no",
                    },
                    {
                        title: "{{ __('generic.namjari_case_no') }}",
                        data: "namjari_case_no",
                        name: "{{$khotianTalbe}}.namjari_case_no",
                    },
                    {
                        title: "{{ __('generic.case_date') }}",
                        data: "case_date",
                        name: "{{$khotianTalbe}}.case_date",
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
                    cell.innerHTML = langBn ? en2bn(sl.toString()) : sl;
                });
            }).draw();

            $('#filter').on('click', function () {
                let khotianNumber = bn2en($('#khotian_number').val());
                let moujaJlNumber = $('#mouja_id').val();

                datatable.column(1).search(khotianNumber).draw();
                datatable.column(4).search(moujaJlNumber).draw();
            });

            bindDatatableSearchOnPresEnterOnly(datatable);
        });

    </script>
@endpush

