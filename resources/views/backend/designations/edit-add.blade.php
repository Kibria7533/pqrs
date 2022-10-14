@php
    $edit = !empty($designation->id);
@endphp
@extends('master::layouts.master')

@section('title')
    {{ $edit? 'Edit Designation':'Create Designation' }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-bg-gradient-info text-primary">
                        <h3 class="card-title font-weight-bold">{{ $edit? __('generic.edit_designation') : __('generic.create_designation') }}</h3>

                        <div class="card-tools">
                            <a href="{{route('admin.designations.index')}}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-backward"></i> {{__('generic.back_to_list')}}
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('admin.designations.update', $designation->id) : route('admin.designations.store')}}"
                            method="POST" class="edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="code">{{__('generic.title_en')}} <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" name="title_en" id="title_en"
                                           value="{{$edit ? $designation->title_en : old('title_en')}}"
                                           placeholder="{{__('generic.title_en')}}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">{{__('generic.title_bn')}} <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" name="title" id="title"
                                           value="{{$edit ? $designation->title : old('title')}}"
                                           placeholder="{{__('generic.title_bn')}}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="description">{{__('generic.designation_level')}}<span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" name="level" id="level"
                                           placeholder="{{__('generic.designation_level')}}" value="{{$edit ? $designation->level : old('level')}}">
                                </div>

                            </div>
                            <input type="submit" class="btn btn-primary float-right"
                                   value="{{ $edit? __('generic.update') : __('generic.save') }}">
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
                title_en: {
                    required: true
                },
                level: {
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



