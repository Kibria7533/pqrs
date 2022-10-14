@extends('master::layouts.master')
@section('title')
    {{__('generic.template_details')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{ __('generic.template_details') }} </h3>

                        <div class="card-tools">
                            <div class="btn-group">
                                @can('update', $template)
                                    <a href="{{route('admin.meeting_management.templates.edit', [$template->id])}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-edit"></i> {{ __('generic.edit_button_label') }}
                                    </a>
                                @endcan
                                @can('viewAny', $template)
                                    <a href="{{route('admin.meeting_management.templates.index')}}"
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
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.title_bn') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $template->title }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.title_en') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $template->title_en }}
                                </div>
                            </div>

                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.template_type') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($template->template_type)? __('generic.'. \Modules\Meeting\Models\Template::TEMPLATE_TYPE[$template->template_type]):'' }}
                                </div>
                            </div>

                            <div class="col-md-12 custom-view-box">
                                <p class="label-text">{{ __('generic.description') }}</p>
                                <div class="input-box custom-form-control h-100">
                                    {!! $template->description !!}
                                </div>
                            </div>

                            <?php
/*                            echo str_replace("{{username}}", "Miladul Islam", $template->description);
                            */?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

