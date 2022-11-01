@extends('master::layouts.master')
@section('title')
    {{__('generic.landless')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{ __('User') }} </h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                @can('update', $landless)
                                    <a href="{{route('admin.landless.edit', [$landless->id])}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-plus-circle"></i> {{ __('generic.edit_button_label') }}
                                    </a>
                                @endcan
                                @can('viewAny', $landless)
                                    <a href="{{route('admin.landless.index')}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                                    </a>
                                @endcan
                            </div>

                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>
                                    {{ __('User Info') }}
                                </label>
                                <div class="border rounded p-3">
                                    <div class="row">
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Name Of User') }}</p>
                                            <div class="input-box custom-form-control">
                                                {{ $landless->name }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Mobile No') }}</p>
                                            <div class="input-box custom-form-control">
                                                {{ $landless->mobile }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Email') }}</p>
                                            <div class="input-box custom-form-control">
                                                {{ $landless->email }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Gender') }}</p>
                                            <div class="input-box custom-form-control">
                                                {{ !empty($landless->gender)?  __('generic.'.\Modules\Landless\App\Models\Landless::GENDER[$landless->gender]) :'' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

    <!-- Modal for  view -->
    <div class="modal fade" id="scan_file_viewer" tabindex="-1" role="dialog"
         aria-labelledby="scan_file_viewerTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scan_file_viewerTitle">
                        {{ __('generic.uploaded_file') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modal_img" src=""
                         alt="{{ __('generic.uploaded_file') }}" width="100%">
                </div>
            </div>
        </div>
    </div>



    <!-- Modal for  meeting view -->
    <div class="modal fade" id="meeting_viewer" tabindex="-1" role="dialog"
         aria-labelledby="meeting_viewerTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meeting_viewerTitle">
                        {{ __('generic.meeting') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .input-group-append {
            margin: 0;
            height: 45px;
            display: flex !important;
            align-content: center;
            align-items: center;
        }
    </style>
@endpush

@push('js')
    <script>
        /**
         * Modal img showing
         * **/
        $('.file_modal_show').click(function (i, j) {
            $('#modal_img').attr('src', $(this)[0].dataset.action);
            $('#scan_file_viewer').modal('show');
        });

        $('#meeting_modal_show').click(function (i, j) {
            $('#meeting_viewer').modal('show');
        });
    </script>
@endpush

