@extends('master::layouts.master')
@section('title')
    {{__('generic.meeting_details')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{ __('generic.meeting_details') }} </h3>


                        <div class="card-tools">
                            <div class="btn-group">
                                @can('update', $meeting)
                                    <a href="{{route('admin.meeting_management.meetings.edit', [$meeting->id])}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-plus-circle"></i> {{ __('generic.edit_button_label') }}
                                    </a>
                                @endcan
                                @can('viewAny', $meeting)
                                    <a href="{{route('admin.meeting_management.meetings.index')}}"
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
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.title') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $meeting->title }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.meeting_number') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $meeting->meeting_no }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.date') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d, M Y') }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.committee_type') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($meeting->committee_type_id)? $meeting->committeeType->title :'' }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.template') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($meeting->template_id)? $meeting->template->title :'' }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.resolution_file') }}</p>
                                <div class="input-box custom-form-control">
                                    @if(!empty($meeting->resolution_file))
                                        @if(pathinfo( !empty($meeting->resolution_file)? $meeting->resolution_file : '', PATHINFO_EXTENSION) === 'pdf')
                                            <a
                                                target="_blank"
                                                href="{{ asset("storage/{$meeting->resolution_file}") }}"
                                                style="color: #3f51b5;font-weight: bold;"
                                                type="button"
                                                class="btn p-0">
                                                {{ __('generic.show_uploaded_resolution_file') }}
                                            </a>
                                        @else
                                            <button
                                                style="color: #3f51b5;font-weight: bold;"
                                                type="button"
                                                class="btn p-0"
                                                data-toggle="modal"
                                                data-target="#resolution_file_viewer">
                                                {{ __('generic.show_uploaded_resolution_file') }}
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 custom-view-box">
                                <p class="label-text">{{ __('generic.worksheet') }}</p>
                                <div class="input-box custom-form-control pl-4" style="height: max-content;">
                                    {!! !empty($meeting->worksheet)? $meeting->worksheet :'' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for  view -->
    <div class="modal fade" id="resolution_file_viewer" tabindex="-1" role="dialog"
         aria-labelledby="resolution_file_viewerTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resolution_file_viewerTitle">
                        {{ __('generic.uploaded_resolution_file') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img
                        src="{{ !empty($meeting->resolution_file)? asset("storage/{$meeting->resolution_file}"):'' }}"
                        alt="{{ __('generic.uploaded_file') }}" width="100%">
                </div>
            </div>
        </div>
    </div>
@endsection

