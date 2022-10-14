@extends('master::layouts.master')

@section('title')
    View Role
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('generic.role') }}</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('admin.roles.edit', [$role->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('generic.edit_button_label') }}
                        </a>
                        <a href="{{route('admin.roles.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{__('generic.back_to_list')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row card-body">
                <div class="col-md-6">
                    <div class="custom-view-box">
                        <p class="label-text">{{ __('generic.code') }}</p>
                        <div class="input-box">
                            {{ $role->code }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="custom-view-box">
                        <p class="label-text">{{ __('generic.title') }}</p>
                        <div class="input-box">
                            {{ $role->title }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="custom-view-box">
                        <p class="label-text">{{ __('generic.description') }}</p>
                        <div class="input-box">
                            {{ $role->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
