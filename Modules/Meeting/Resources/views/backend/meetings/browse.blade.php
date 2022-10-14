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
                        <h3 class="card-title font-weight-bold">
                            {{ __('generic.meeting_list') }}
                        </h3>

                        <div class="card-tools">
                            <a href="{{ route('admin.meeting_management.meetings.create') }}"
                               class="btn btn-sm btn-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{ __('generic.add_new') }}
                            </a>
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

    <!-- Modal for resolution_file upload-->
    <div class="modal modal-danger fade" tabindex="-1" id="resolution-file-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="approveSingleLandless">
                        <i class="fas fa-upload"></i>
                        {{ __('generic.upload_resolution_file') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="resolution-file-form"
                          method="post">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-12 pb-5">
                                <div class="form-group">
                                    <label for="resolution_file">
                                        {{ __('generic.resolution_file') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group" style="height: 45px">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id=""
                                              style="background: #50177c33;">
                                           <i class="fas fa-upload"></i>&nbsp; {{ __('generic.upload') }}
                                        </span>
                                        </div>
                                        <div class="custom-file" style="height: 45px">
                                            <input type="file"
                                                   class="custom-file-input custom-form-control"
                                                   name="resolution_file"
                                                   id="resolution_file">
                                            <label class="custom-file-label" for="resolution_file"
                                                   style="height: 45px; text-overflow: ellipsis;overflow:hidden;white-space:nowrap;width: 100%;">
                                                {{ __('generic.no_file_chosen') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12 text-right">
                                <span type="button" class="btn btn-warning pull-right"
                                      data-dismiss="modal">{{ __('generic.cancel') }}</span>
                                <input type="submit" class="btn btn-success pull-right"
                                       value="{{ __('generic.confirm') }}">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for landless-meeting-list view and update-->
    <div class="modal modal-danger fade" tabindex="-1" id="landless-meeting-list-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <i class="fas fa-list"></i>
                        <span id="modal-title-text"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="landless-list-area">
                    {{--load content from ajax response--}}
                </div>
            </div>
        </div>
    </div>

    <div id="loading-sniper"
         style="z-index: 99999; position: fixed; height: 100vh;width: 100%;top: 0px; left: 0; right: 0; bottom: 0px; background: rgba(0,0,0,.4); display: none; overflow: hidden;">
        <div class="holder" style="width: 200px;height: 200px;position: relative; margin: 10% auto;">
            <img src="/images/loading.gif" style="width: 75px;margin: 34%;">
        </div>
    </div>

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
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

        .custom-file-input:lang(en) ~ .custom-file-label::after {
            content: "Browse";
            height: 43px;
        }

        /*Datatable custom btn design*/
        .dataTables_scrollBody{
            overflow: unset!important;
        }
        .dropdown-menu a{
            display: list-item;
            margin: 3px 0;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/moment/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/datatable/dataTables.dateTime.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/datatable/dataTables.select.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/en2bn/en2bn.js')}}"></script>


{{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>--}}

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


            let lanBn = {{ Session::get('locale') == 'bn' ? 1: 0 }};
            let lanBnPath = lanBn ? "/json/bn.json" : "";

            let params = serverSideDatatableFactory({
                url: '{{route('admin.meeting_management.meetings.datatable')}}',
                order: [[0, "asc"]],
                language: {
                    "url": lanBnPath,
                },
                serialNumberColumn: 0,
                select: {
                    style: 'multi',
                    selector: 'td:first-child',
                },
                columnDefs: [],
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
                        title: "{{ __('generic.title') }}",
                        data: "title",
                        name: "meetings.title"
                    },
                    {
                        title: "{{ __('generic.meeting_number') }}",
                        data: "meeting_no",
                        name: "meetings.meeting_no"
                    },
                    {
                        title: "{{ __('generic.date') }}",
                        data: "meeting_date",
                        name: "meetings.meeting_date",
                    },
                    {
                        title: "{{ __('generic.committee_type') }}",
                        data: "committee_type",
                        name: "meeting_types.title"
                    },
                    {
                        title: "{{ __('generic.status') }}",
                        data: "status",
                        name: "meetings.status",
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

            $(document, 'td').on('click', '.upload-resolution', function (e) {
                $('#resolution-file-form')[0].action = $(this).data('action');
                $('#resolution-file-modal').modal('show');
            });

            $(document, 'td').on('click', '.landless-meeting-list', function (e) {
                let id = $(this).data('meeting-id');
                let meetingTitle = $(this).data('meeting-title');
                showLoader();
                $.ajax({
                    url: '{{ route('admin.meeting_management.meetings.landless-meeting-list-datatable','__') }}'.replace('__', id),
                    type: 'POST',
                    success: function (response) {
                        $('#modal-title-text').html('{{ __('generic.landless_meeting_list') }}' + ' (' + meetingTitle + ')');
                        $('#landless-list-area').html('');
                        $('#landless-list-area').append(response.data);
                    },
                    error: function(xhr, status, error) {
                        console.log(' xhr error response: ', xhr.responseJSON.message)
                        $('#landless-list-area').html('');
                        $('#landless-list-area').append(
                            '<p class="text-center text-danger">'+xhr.responseJSON.message+'</p>'
                        );
                    }
                });

                setTimeout(function () {
                    hideLoader();
                    $('#landless-meeting-list-modal').modal('show')
                }, 500)
            });


            $('#resolution_file').on('change', function () {
                let fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            const resolutionFileForm = $('#resolution-file-form');
            resolutionFileForm.validate({

                rules: {
                    resolution_file: {
                        required: true,
                        extension: "jpg|pdf"
                    },
                },
                messages: {
                    resolution_file: {
                        required: "{{ __('generic.field_is_required') }}",
                        extension: "{{ __('generic.valid_extension') }} [ jpg/pdf ]",
                    },
                },
                submitHandler: function (htmlForm) {
                    $('.overlay').show();

                    const form = $(htmlForm);
                    const formData = new FormData(htmlForm);
                    const url = form.attr("action");
                    console.log('formData', form, formData, url)

                    $.ajax({
                        url: url,
                        data: formData,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log('response', response)
                            $('.overlay').hide();
                            let alertType = response.alertType;
                            let alertMessage = response.message;
                            let alerter = toastr[alertType];
                            alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");

                            if (response.redirectTo) {
                                setTimeout(function () {
                                    window.location.href = response.redirectTo;
                                }, 1000);
                            }

                        },
                    });

                    return false;
                }
            });
        });
    </script>
@endpush
