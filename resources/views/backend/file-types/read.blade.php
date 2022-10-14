@extends('master::layouts.master')
@section('title')
    {{__('generic.file_type')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{ __('generic.file_type') }} </h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                @can('update', $fileType)
                                    <a href="{{route('admin.file-types.edit', [$fileType->id])}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-plus-circle"></i> {{ __('generic.edit_button_label') }}
                                    </a>
                                @endcan
                                @can('viewAny', $fileType)
                                    <a href="{{route('admin.file-types.index')}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.name_bn') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $fileType->title }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.name_en') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $fileType->title_en }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.short_code') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $fileType->short_code }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.allow_format') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $fileType->allow_format }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.order_number') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $fileType->order_number }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

