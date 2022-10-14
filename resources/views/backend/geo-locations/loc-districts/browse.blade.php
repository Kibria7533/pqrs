@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title font-weight-bold">{{__('generic.list_district')}}</h3>


                        <div class="card-tools">
                            <a href="javascript:;"
                               class="btn btn-sm btn-outline-primary btn-rounded create-new-button">
                                <i class="fas fa-plus-circle"></i> {{__('generic.add_new')}}
                            </a>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
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

    <x-modal id="edit-add-modal" type="success" xl></x-modal>
    <x-modal id="view-modal" type="success" xl></x-modal>

    @include('utils.delete-confirm-modal')

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
        em#loc_division_id-error {
            position: absolute;
            bottom: -8px;
            left: 7px;
        }

        em#has_khatian-error, em#has_map-error {
            position: absolute;
            width: 150px;
            bottom: -23px;
            left: 0;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/en2bn/en2bn.js')}}"></script>
    <script>
        $(function () {

            const editAddModal = $("#edit-add-modal");
            const viewModal = $("#view-modal");

            let lanBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};
            let lanBnPath = lanBn ? "/json/bn.json" : "";

            let params = serverSideDatatableFactory({
                url: '{{route('admin.loc-districts.datatable')}}',
                //order: [[2, "asc"]],
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
                        data: "title_en",
                        name: "title_en"
                    },
                    {
                        title: "{{ __('generic.name_bn') }}",
                        data: "title",
                        name: "title"
                    },
                    {
                        title: "{{ __('generic.bbs_code') }}",
                        data: "bbs_code",
                        name: "bbs_code"
                    },
                    {
                        title: "{{ __('generic.division') }}",
                        data: "loc_divisions.title",
                        name: "loc_divisions.title"
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

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            })

            if ($(".create-new-button").length) {
                $(document).on('click', ".create-new-button", async function () {
                    let url = '{{route('admin.loc-districts.create')}}';
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
                        title_en: {
                            required: true,
                        },
                        title: {
                            required: true,
                            pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
                        },
                        bbs_code: {
                            required: true,
                            maxlength: 2
                        },
                        dglr_code: {
                            required: true,
                        },
                        loc_division_id: {
                            required: true
                        },
                        has_khatian: {
                            required: true
                        },
                        has_map: {
                            required: true
                        },

                    },
                    messages: {
                        title: {
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

        });


        /*$(document).on('change', '#loc_division_id', function (e) {
            if($(this).val() != null){
                $(this).valid();
            }
        });*/

    </script>
@endpush
