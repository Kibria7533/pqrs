@php
    $edit = !empty($permission->id);
@endphp
@extends('master::layouts.master')

@section('title')
    {{ $edit?__('generic.permission_edit'):__('generic.permission_create') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title font-weight-bold">
                            {{ $edit?__('generic.permission_edit'):__('generic.permission_create') }}
                        </h3>

                        <a href="{{route('admin.permissions.index')}}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-backward"></i> {{__('generic.back_to_list')}}
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('admin.permissions.update', $permission->id) : route('admin.permissions.store')}}"
                            method="POST" class="edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="key">{{__('generic.key')}} <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" name="key" id="key"
                                           pattern="[A-Za-z0-9\w]{4,191}"
                                           value="{{$edit ? $permission->key : old('key')}}"
                                           placeholder="{{__('generic.key')}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="table_name">{{__('generic.group_or_table')}} <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" name="table_name" id="table_name"
                                           value="{{$edit ? $permission->table_name : old('table_name')}}"
                                           placeholder="{{__('generic.group_or_table')}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="sub_group">{{__('generic.sub_group')}}</label>
                                    <input type="text" class="form-control" name="sub_group" id="sub_group"
                                           value="{{$edit ? $permission->sub_group : old('sub_group')}}"
                                           placeholder="{{__('generic.sub_group')}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="sub_group_order">{{__('generic.sub_group_order')}}</label>
                                    <input type="number" class="form-control" name="sub_group_order"
                                           id="sub_group_order"
                                           value="{{$edit ? $permission->sub_group_order : old('sub_group_order')}}"
                                           placeholder="{{__('generic.sub_group_order')}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="is_user_defined"
                                               id="is_user_defined" {{!$edit || $permission->is_user_defined ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_user_defined">
                                            {{ __('generic.is_user_defined') }}
                                        </label>
                                    </div>
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
@push('js')
    <x-generic-validation-error-toastr/>
    <script>
        const EDIT = !!'{{$edit}}';

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                key: {
                    required: true
                },
                table_name: {
                    required: true
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush


