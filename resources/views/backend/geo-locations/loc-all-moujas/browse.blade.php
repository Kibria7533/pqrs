@extends('master::layouts.master')

@php
    $langBn = Session::get('locale') == 'bn';
@endphp

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{ __('generic.list_mouja') }}</h3>

                        <div class="card-tools">
                            <a href="javascript:;"
                               class="btn btn-sm btn-primary btn-rounded create-new-button">
                                <i class="fas fa-plus-circle"></i> {{__('generic.add_new')}}
                            </a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="division_bbs_code">{{ __('generic.division') }} </label>
                                    <select class="form-control custom-form-control select2"
                                            name="division_bbs_code"
                                            id="division_bbs_code"
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                        <option value="">{{ __('generic.select_placeholder') }}</option>
                                        @foreach($locDivisions as $key => $value)
                                            <option
                                                value="{{ $value->bbs_code }}"> {{ $langBn ? $value->title: $value->title_en }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="district_bbs_code">{{ __('generic.district') }} </label>
                                    <select class="form-control custom-form-control select2"
                                            name="district_bbs_code"
                                            id="district_bbs_code"
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                        <option value="">{{ __('generic.select_placeholder') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="upazila_bbs_code">{{ __('generic.upazila') }} </label>
                                    <select class="form-control custom-form-control select2"
                                            name="upazila_bbs_code"
                                            id="upazila_bbs_code"
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                        <option value="">{{ __('generic.select_placeholder') }}</option>
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
    <x-modal id="view-modal" type="success" xl></x-modal>

    @include('utils.delete-confirm-modal')

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
        em#loc_division_id-error , em#loc_upazila_id-error, em#loc_district_id-error {
            position: absolute;
            bottom: 16px;
            left: 7px;
        }

        em#loc_upazila_id-error , em#loc_district_id-error{
            position: absolute;
            bottom: -8px;
            left: 7px;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script>
        $(function () {

            function showLoader() {
                $('#loading-sniper').show();
                $('body').css('overflow', 'hidden');
            }

            function hideLoader() {
                $('#loading-sniper').hide();
                $('body').css('overflow', 'auto');
            }

            const editAddModal = $("#edit-add-modal");
            const viewModal = $("#view-modal");

            let lanBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};
            let lanBnPath = lanBn ? "/json/bn.json" : "";

            let params = serverSideDatatableFactory({
                url: '{{route('admin.loc-all-moujas.datatable')}}',
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
                        name: "name"
                    },
                    {
                        title: "{{ __('generic.name_bn') }}",
                        data: "name_bd",
                        name: "name_bd"
                    },
                    {
                        title: "{{ __('generic.dglr_code') }}",
                        data: "dglr_code",
                        name: "dglr_code"
                    },
                    {
                        title: "{{ __('generic.division') }}",
                        data: "division_name",
                        name: "loc_all_moujas.division_bbs_code",
                        visible: false
                    },
                    {
                        title: "{{ __('generic.district') }}",
                        data: "district_name",
                        name: "loc_all_moujas.district_bbs_code",
                        visible: false
                    },
                    {
                        title: "{{ __('generic.upazila') }}",
                        data: "upazila_bbs_code",
                        name: "loc_all_moujas.upazila_bbs_code",
                        visible: false
                    },
                    {
                        title: "{{ __('generic.division') }}",
                        data: "division_name",
                        name: "division_name",
                    },
                    {
                        title: "{{ __('generic.district') }}",
                        data: "district_name",
                        name: "district_name",
                    },
                    {
                        title: "{{ __('generic.upazila') }}",
                        data: "upazila_name",
                        name: "upazila_name"
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
                let divisionBbsCode = $('#division_bbs_code').val();
                let districtBbsCode = $('#district_bbs_code').val();
                let upazilaBbsCode = $('#upazila_bbs_code').val();

                datatable.column(4).search(divisionBbsCode).draw();
                datatable.column(5).search(districtBbsCode).draw();
                datatable.column(6).search(upazilaBbsCode).draw();

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
            })

            if ($(".create-new-button").length) {
                $(document).on('click', ".create-new-button", async function () {
                    let url = '{{route('admin.loc-all-moujas.create')}}';
                    let response = await $.get(url);
                    editAddModal.find('.modal-content').html(response);
                    initializeSelect2(".select2-ajax-wizard");
                    editAddModal.modal('show');
                    registerValidator(false);
                });
            }

            $(document).on('click', ".dt-edit", async function () {
                let response = await $.get($(this).data('url'));
                editAddModal.find('.modal-content').html(response);
                initializeSelect2(".select2-ajax-wizard");
                editAddModal.modal('show');
                registerValidator(true);
                if ($(this).hasClass('button-from-view')) {
                    viewModal.modal('hide');
                }
            });

            $(document).on('click', ".dt-view", async function () {
                let url = $(this).data('url');
                let response = await $.get(url);
                viewModal.find('.modal-content').html(response);
                viewModal.modal('show');
            });

            editAddModal.on('hidden.bs.modal', function () {
                editAddModal.find('.modal-content').empty();
            });

            viewModal.on('hidden.bs.modal', function () {
                viewModal.find('.modal-content').empty();
            });

            function registerValidator(edit) {
                $(".edit-add-form").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        name_bd: {
                            required: true,
                        },
                        bbs_code: {
                            required: true,
                            maxlength: 4
                        },
                        loc_division_id: {
                            required: true
                        },
                        loc_district_id: {
                            required: true
                        },
                        loc_upazila_id: {
                            required: true
                        },
                        dglr_code: {
                            required: true
                        },

                    },
                    messages: {
                        name_bd: {
                            pattern: "Please fill this field in Bangla."
                        },
                    },
                    submitHandler: function (htmlForm) {
                        $('.overlay').show();
                        let formData = new FormData(htmlForm);
                        let jForm = $(htmlForm);
                        $.ajax({
                            url: jForm.prop('action'),
                            method: jForm.prop('method'),
                            data: formData,
                            enctype: 'multipart/form-data',
                            cache: false,
                            contentType: false,
                            processData: false,
                        })
                            .done(function (responseData) {
                                toastr.success(responseData.message);
                                editAddModal.modal('hide');
                            })
                            .fail(window.ajaxFailedResponseHandler)
                            .always(function () {
                                datatable.draw();
                                $('.overlay').hide();
                            });
                        return false;
                    }
                });
            }

            function loadDistrict(){
                showLoader();
                let divisionBbcCode = $('#division_bbs_code').val();

                if (divisionBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-districts') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'division_bbs_code': divisionBbcCode,
                        },
                        success: function (response) {
                            $('#district_bbs_code').html('');
                            $('#district_bbs_code').html('<option value="">নির্বাচন করুন</option>');

                            $('#upazila_bbs_code').html('');
                            $('#upazila_bbs_code').html('<option value="">নির্বাচন করুন</option>');

                            $('#union_bbs_code').html('');
                            $('#union_bbs_code').html('<option value="">নির্বাচন করুন</option>');
                            $.each(response, function (key, value) {
                                $('#district_bbs_code').append(
                                    '<option value="' + value.bbs_code + '" ' + '>' + (value.title) + '</option>'
                                );
                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                } else {
                    $('#district_bbs_code').html('');
                    $('#district_bbs_code').html('<option value="">নির্বাচন করুন</option>');

                    $('#upazila_bbs_code').html('');
                    $('#upazila_bbs_code').html('<option value="">নির্বাচন করুন</option>');

                    $('#union_bbs_code').html('');
                    $('#union_bbs_code').html('<option value="">নির্বাচন করুন</option>');

                    hideLoader();
                }
            }

            function loadUpazila(){
                showLoader();
                let districtBbcCode = $('#district_bbs_code').val();

                if (districtBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-upazilas') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'district_bbs_code': districtBbcCode,
                        },
                        success: function (response) {
                            $('#upazila_bbs_code').html('');
                            $('#upazila_bbs_code').html('<option value="">নির্বাচন করুন</option>');

                            $('#union_bbs_code').html('');
                            $('#union_bbs_code').html('<option value="">নির্বাচন করুন</option>');

                            $.each(response, function (key, value) {
                                $('#upazila_bbs_code').append(
                                    '<option value="' + value.bbs_code + '">' + (value.title) + '</option>'
                                );
                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });

                } else {
                    $('#upazila_bbs_code').html('');
                    $('#upazila_bbs_code').html('<option value="">নির্বাচন করুন</option>');

                    $('#union_bbs_code').html('');
                    $('#union_bbs_code').html('<option value="">নির্বাচন করুন</option>');
                    hideLoader();
                }
            }



            $('#division_bbs_code').on('change', function () {
                loadDistrict();
            });

            $('#district_bbs_code').on('change', function () {
                loadUpazila();
            });

            /*$('#loc_division_id').on('change', function () {
                loadDistrict();
            });

            $('#loc_district_id').on('change', function () {
                loadUpazila();
            });*/
        });
    </script>
@endpush
