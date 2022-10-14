@extends('master::layouts.master')

@section('title')
    View Designation
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('generic.designation')}}</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('admin.designations.edit', [$designation->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{__('generic.edit_designation')}}
                        </a>
                        <a href="{{route('admin.designations.index')}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{__('generic.back_to_list')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row card-body">
                <div class="col-md-6">
                    <div class="custom-view-box">
                        <p class="label-text">{{__('generic.title_en')}}</p>
                        <div class="input-box">
                            {{ $designation->title_en }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="custom-view-box">
                        <p class="label-text">{{__('generic.title_bn')}}</p>
                        <div class="input-box">
                            {{ $designation->title }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="custom-view-box">
                        <p class="label-text">{{__('generic.designation_level')}}</p>
                        <div class="input-box">
                            {{ $designation->level }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
