@php
    $edit = !empty($role->id);
@endphp
@extends('master::layouts.master')

@section('title')
    {{ $edit? __('generic.role_edit'):__('generic.role_create') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-bg-gradient-info text-primary">
                        <h3 class="card-title font-weight-bold">
                            {{ $edit? __('generic.role_edit'):__('generic.role_create') }}
                        </h3>

                        <div class="card-tools">
                            <a href="{{route('admin.roles.index')}}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-backward"></i> {{__('generic.back_to_list')}}
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('admin.roles.update', $role->id) : route('admin.roles.store')}}"
                            method="POST" class="edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="code">{{ __('generic.code') }} <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" name="code" id="code"
                                           pattern="[A-Za-z0-9\w]{2,50}"
                                           value="{{$edit ? $role->code : old('code')}}"
                                           placeholder="{{ __('generic.code') }}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">{{ __('generic.title') }} <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" name="title" id="title"
                                           value="{{$edit ? $role->title : old('title')}}"
                                           placeholder="{{ __('generic.title') }}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">{{ __('generic.deletable') }}</label>
                                    <div class="input-group form-control">
                                        <div class="custom-control custom-radio custom-radio-is-deletable">
                                            <input type="radio" id="is_deletable_yes"
                                                   name="is_deletable"
                                                   value="1"
                                                   class="custom-control-input" {{$edit && $role->is_deletable == 1 ? 'checked':'' }}>
                                            <label class="custom-control-label" for="is_deletable_yes">{{ __('generic.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-radio-is-deletable">
                                            <input type="radio" id="is_deletable_no"
                                                   name="is_deletable"
                                                   value="0"
                                                   class="custom-control-input" {{$edit && $role->is_deletable == 0 ? 'checked':'' }}>
                                            <label class="custom-control-label" for="is_deletable_no">{{ __('generic.no') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="description">{{ __('generic.description') }}</label>
                                    <textarea type="text" class="form-control" name="description" id="description"
                                              placeholder="{{ __('generic.description') }}">{{$edit ? $role->description : old('description')}}</textarea>
                                </div>


                            </div>
                            <input type="submit" class="btn btn-primary float-right"
                                   value="{{ $edit? __('generic.update'):__('generic.save') }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('utils.delete-confirm-modal')

@endsection
@push('css')
    <style>
        .custom-radio-is-deletable{
            margin-right: 25px;
        }
    </style>
@endpush
@push('js')
    <x-generic-validation-error-toastr/>
    <script>
        const EDIT = !!'{{$edit}}';

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                title: {
                    required: true,
                },
                code: {
                    required: true
                },
                is_deletable: {
                    required: true
                }
            },
            messages:{
                title: {
                    pattern: "This field is required in English.",
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush


