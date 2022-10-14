@php
    $edit = !empty($landless->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') != 'en';
@endphp

@extends('master::layouts.master')
@section('title')
    {{!$edit ? __('generic.add_new_landless'): __('generic.update_landless')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card" style="background: #e1e1e1">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{!$edit ? __('generic.add_new_landless'): __('generic.update_landless')}}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.landless.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{$edit ? route('admin.landless.update', $landless->id) : route('admin.landless.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    @if($edit)
                        @method('put')
                    @endif
                    <div class="accordion mb-2" id="accordionExample">
                        <div id="step1" class="card rounded">
                            <div class="card-header" id="heading1" style="background: #f7f7f7">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left text-bold" type="button"
                                            data-toggle="collapse" data-target="#collapse1" aria-expanded="true"
                                            aria-controls="collapse1">
                                        {{ __('generic.applicant_info') }}
                                        <i class="fas fa-angle-up float-right"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse1" class="collapse show" aria-labelledby="heading1"
                                 data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fullname">
                                                    {{ __('generic.name_of_the_applicant') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="fullname"
                                                       id="fullname"
                                                       value="{{$edit ? $landless->fullname : ''}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mobile"> {{ __('generic.mobile_number') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="mobile"
                                                       id="mobile"
                                                       value="{{$edit ? $landless->mobile : ''}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email"> {{ __('email') }}
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="email"
                                                       id="email"
                                                       value="{{$edit ? $landless->email : ''}}"/>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ __('generic.identity_type') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="d-flex">
                                                    @foreach(\Modules\Landless\App\Models\Landless::IDENTITY_TYPE as $key=>$value)
                                                        <div
                                                            class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio"
                                                                   class="custom-control-input identity_type"
                                                                   id="identity_type_{{ $key }}"
                                                                   name="identity_type"
                                                                   value="{{ $key }}" {{ $key == 1 && $edit==false? 'checked': '' }}
                                                                {{ $edit && $landless->identity_type == $key ? 'checked': '' }}>
                                                            <label class="custom-control-label"
                                                                   for="identity_type_{{ $key }}">
                                                                {{ __('generic.'.$value) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="identity-type-area">
                                            <div class="form-group">
                                                <label for="identity_number">{{ __('generic.identity_number') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                       class="form-control custom-form-control identity_number"
                                                       name="identity_number"
                                                       id="identity_number"
                                                       {{ $edit && $landless->identity_type == \Modules\Landless\App\Models\Landless::IDENTITY_TYPE_NOT_AVAILABLE ? 'readonly': '' }}
                                                       value="{{ $edit ? $landless->identity_number : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="date_of_birth">
                                                    {{ __('generic.date_of_birth') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="text"
                                                           class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                                           name="date_of_birth"
                                                           id="date_of_birth"
                                                           placeholder="{{ __('generic.select_date') }}"
                                                           value="{{$edit ? $landless->date_of_birth : ''}}"/>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"
                                                             style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                                            <i class="fas fa-calendar-day"
                                                               style="color: #959595; transform: rotateY(180deg);"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>&nbsp;</label>
                                            <div class="form-group">
                                                <input type="button" id="user_check_submit"
                                                       value="{{ __('generic.verify') }}"
                                                       class="form-control custom-form-control bg-success d-none"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-none">
                                            <label>isValidateNID &nbsp;</label>
                                            <div class="form-group">
                                                <input type="text"
                                                       id="is_validate_nid"
                                                       name="is_validate_nid"
                                                       value="{{ $edit && $landless->identity_type == \Modules\Landless\App\Models\Landless::IDENTITY_TYPE_NID ? 'validated': null }}"
                                                       class="form-control custom-form-control" {{ $edit && $landless->identity_type == \Modules\Landless\App\Models\Landless::IDENTITY_TYPE_NID ? '': 'disabled' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="landless_type">
                                                    {{ __('generic.landless_type') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control custom-form-control"
                                                        name="landless_type"
                                                        id="landless_type">
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                    @foreach(\Modules\Landless\App\Models\Landless::LANDLESS_TYPE as $key=>$value)
                                                        <option
                                                            value="{{ $key }}" {{ $edit && $landless->landless_type == $key? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    {{ __('generic.gender') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="position-relative d-flex">
                                                    @foreach(\Modules\Landless\App\Models\Landless::GENDER as $key=>$value)
                                                        <div
                                                            class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" class="custom-control-input gender"
                                                                   id="gender_{{ $key }}"
                                                                   name="gender"
                                                                   value="{{ $key }}" {{ $edit && $landless->gender == $key? 'checked' : '' }} >
                                                            <label class="custom-control-label"
                                                                   for="gender_{{ $key }}">
                                                                {{ __('generic.'.$value) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="loc_division_bbs">
                                                    {{ __('generic.division') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control custom-form-control select2"
                                                        name="loc_division_bbs"
                                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                                        id="loc_division_bbs">
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                    @foreach($locDivisions as $locDivision)
                                                        @if($locDivision->bbs_code == '20')
                                                            <option
                                                                value="{{ $locDivision->bbs_code }}"
                                                                {{ $edit && $landless->loc_division_bbs == $locDivision->bbs_code ? 'selected':'' }}
                                                                {{ $locDivision->bbs_code == '20' ? 'selected':'' }} >{{ $langBn ? $locDivision->title: $locDivision->title_en }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="loc_district_bbs">
                                                    {{ __('generic.district') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control custom-form-control select2"
                                                        name="loc_district_bbs"
                                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                                        id="loc_district_bbs">
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                    @if($edit)
                                                        @foreach($districts as $key=>$value)
                                                            @if($value->bbs_code == '75')
                                                                <option
                                                                    value="{{ $value->bbs_code }}" {{ $landless->loc_district_bbs == $value->bbs_code ? "selected":"" }}> {{ $langBn ? $value->title : $value->title_en }} </option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="loc_upazila_bbs">
                                                    {{ __('generic.upazila') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control custom-form-control select2"
                                                        name="loc_upazila_bbs"
                                                        id="loc_upazila_bbs"
                                                        data-placeholder="{{ __('generic.select_placeholder') }}">
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                    @if($edit)
                                                        @foreach($upazilas as $key=>$value)
                                                            <option
                                                                value="{{ $value->bbs_code }}" {{ $value->bbs_code == $landless->loc_upazila_bbs?"selected":"" }}> {{ $langBn ? $value->title: $value->title_en }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="loc_union_bbs">
                                                    {{ __('generic.union') }}
                                                </label>
                                                <select class="form-control custom-form-control select2"
                                                        name="loc_union_bbs"
                                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                                        id="loc_union_bbs">
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                    @if($edit)
                                                        @foreach($unions as $key=>$value)
                                                            <option
                                                                value="{{ $value->bbs_code }}" {{ $landless->loc_union_bbs == $value->bbs_code ? "selected":"" }}> {{ $langBn ? $value->title:$value->title_en }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mouja_id">
                                                    {{ __('generic.mouja') }}
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select class="form-control custom-form-control select2"
                                                        name="mouja_id"
                                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                                        id="mouja_id">
                                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                                    @if($edit)
                                                        @foreach($moujas as $key=>$value)
                                                            <option
                                                                value="{{ $value->rs_jl_no }}" {{ $landless->jl_number == $value->rs_jl_no ? "selected":"" }}> {{ $langBn ? $value->name_bd:$value->name }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jl_number">
                                                    {{ __('generic.jl_number') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="jl_number"
                                                       id="jl_number"
                                                       value="{{$edit ? $landless->jl_number : ''}}" readonly/>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="village">
                                                    {{ __('generic.village') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="village"
                                                       id="village"
                                                       value="{{$edit ? $landless->village : ''}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step2" class="card rounded">
                            <div class="card-header" id="heading2" style="background: #f7f7f7">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed text-bold" type="button"
                                            data-toggle="collapse" data-target="#collapse2" aria-expanded="false"
                                            aria-controls="collapse2">
                                        {{ __('generic.family_info') }}
                                        <i class="fas fa-angle-down float-right"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse2" class="collapse" aria-labelledby="heading2"
                                 data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="father_name">
                                                            {{ __('generic.applicant_father_name') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control custom-form-control"
                                                               name="father_name"
                                                               id="father_name"
                                                               value="{{$edit ? $landless->father_name : ''}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="father_dob">
                                                            {{ __('generic.date_of_birth') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="text"
                                                                   class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                                                   name="father_dob"
                                                                   id="father_dob"
                                                                   placeholder="{{ __('generic.select_date') }}"
                                                                   value="{{$edit ? $landless->father_dob : ''}}"/>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"
                                                                     style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                                                    <i class="fas fa-calendar-day"
                                                                       style="color: #959595; transform: rotateY(180deg);"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="father_is_alive">
                                                            {{ __('generic.is_alive') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="row d-flex">
                                                            @foreach(\Modules\Landless\App\Models\Landless::IS_ALIVE as $key=>$value)
                                                                <div class="col-md-6 mb-1">
                                                                    <div class="form-control custom-form-control">
                                                                        <div
                                                                            class="custom-control custom-radio custom-control-inline h-100"
                                                                            style="padding: 5px 25px;margin-right: 0 !important;">
                                                                            <input type="radio"
                                                                                   class="custom-control-input"
                                                                                   id="father_is_alive_{{ $key }}"
                                                                                   name="father_is_alive"
                                                                                   value="{{ $key }}" {{ $edit && $landless->father_is_alive == $key? 'checked' : '' }}>
                                                                            <label class="custom-control-label"
                                                                                   for="father_is_alive_{{ $key }}">
                                                                                {{ __('generic.'.($key==1?'yes':'no')) }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="mother_name">
                                                            {{ __('generic.applicant_mother_name') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control custom-form-control"
                                                               name="mother_name"
                                                               id="mother_name"
                                                               value="{{$edit ? $landless->mother_name : ''}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="mother_dob">
                                                            {{ __('generic.date_of_birth') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="text"
                                                                   class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                                                   name="mother_dob"
                                                                   id="mother_dob"
                                                                   placeholder="{{ __('generic.select_date') }}"
                                                                   value="{{$edit ? $landless->mother_dob : ''}}"/>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"
                                                                     style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                                                    <i class="fas fa-calendar-day"
                                                                       style="color: #959595; transform: rotateY(180deg);"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="father_is_alive">
                                                            {{ __('generic.is_alive') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="row d-flex">
                                                            @foreach(\Modules\Landless\App\Models\Landless::IS_ALIVE as $key=>$value)
                                                                <div class="col-md-6 mb-1">
                                                                    <div class="form-control custom-form-control">
                                                                        <div
                                                                            class="custom-control custom-radio custom-control-inline h-100"
                                                                            style="padding: 5px 25px;margin-right: 0 !important;">
                                                                            <input type="radio"
                                                                                   class="custom-control-input"
                                                                                   id="mother_is_alive_{{ $key }}"
                                                                                   name="mother_is_alive"
                                                                                   value="{{ $key }}" {{ $edit && $landless->mother_is_alive == $key? 'checked' : '' }} >
                                                                            <label class="custom-control-label"
                                                                                   for="mother_is_alive_{{ $key }}">
                                                                                {{ __('generic.'.($key==1?'yes':'no')) }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="spouse_name">
                                                            {{ __('generic.applicant_spouse_name') }}
                                                        </label>
                                                        <input type="text" class="form-control custom-form-control"
                                                               name="spouse_name"
                                                               id="spouse_name"
                                                               value="{{$edit ? $landless->spouse_name : ''}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="spouse_dob">{{ __('generic.date_of_birth') }}</label>
                                                        <div class="input-group">
                                                            <input type="text"
                                                                   class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                                                   name="spouse_dob"
                                                                   id="spouse_dob"
                                                                   placeholder="{{ __('generic.select_date') }}"
                                                                   value="{{$edit ? $landless->spouse_dob : ''}}"/>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"
                                                                     style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                                                    <i class="fas fa-calendar-day"
                                                                       style="color: #959595; transform: rotateY(180deg);"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    {{--<div class="form-group">
                                                        <label for="po_sho_mo">{{ __('generic.p_s_m') }} </label>
                                                        <input type="text" class="form-control custom-form-control"
                                                               name="po_sho_mo"
                                                               id="po_sho_mo"
                                                               value="{{$edit ? $landless->po_sho_mo : ''}}"/>
                                                    </div>--}}
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="spouse_father">
                                                            {{ __('generic.applicant_spouse_father_name') }}
                                                        </label>
                                                        <input type="text" class="form-control custom-form-control"
                                                               name="spouse_father"
                                                               id="spouse_father"
                                                               value="{{$edit ? $landless->spouse_father : ''}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="spouse_mother">
                                                            {{ __('generic.applicant_spouse_mother_name') }}
                                                        </label>
                                                        <input type="text" class="form-control custom-form-control"
                                                               name="spouse_mother"
                                                               id="spouse_mother"
                                                               value="{{$edit ? $landless->spouse_mother : ''}}"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bosot_vita_details">
                                                            {{ __('generic.bosot_vita_details') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <textarea class="form-control custom-form-control"
                                                                  name="bosot_vita_details"
                                                                  id="bosot_vita_details"
                                                                  rows="2">{{$edit ? $landless->bosot_vita_details : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-groupt">
                                                        <label for="present_address">
                                                            {{ __('generic.present_address') }}
                                                        </label>
                                                        <textarea class="form-control custom-form-control"
                                                                  name="present_address"
                                                                  id="present_address"
                                                                  rows="2">{{$edit ? $landless->present_address : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="gurdian_khasland_details">
                                                            {{ __('generic.gurdian_khasland_details') }}
                                                        </label>
                                                        <textarea class="form-control custom-form-control"
                                                                  name="gurdian_khasland_details"
                                                                  id="gurdian_khasland_details"
                                                                  rows="2">{{$edit ? $landless->gurdian_khasland_details : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nodi_vanga_family_details">
                                                            {{ __('generic.nodi_vanga_family_details') }}
                                                        </label>
                                                        <textarea class="form-control custom-form-control"
                                                                  name="nodi_vanga_family_details"
                                                                  id="nodi_vanga_family_details"
                                                                  rows="2">{{$edit ? $landless->nodi_vanga_family_details : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="freedom_fighters_details">
                                                            {{ __('generic.freedom_fighters_details') }}
                                                        </label>
                                                        <textarea class="form-control custom-form-control"
                                                                  name="freedom_fighters_details"
                                                                  id="freedom_fighters_details"
                                                                  rows="2">{{$edit ? $landless->freedom_fighters_details : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="khasland_details">
                                                            {{ __('generic.khasland_details') }}
                                                        </label>
                                                        <textarea class="form-control custom-form-control"
                                                                  name="khasland_details"
                                                                  id="khasland_details"
                                                                  rows="2">{{$edit ? $landless->khasland_details : ''}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <hr>
                                                    <label>
                                                        {{ __('generic.family_members_info') }}
                                                    </label>
                                                    <div class="border rounded p-3">
                                                        <div id="family_member_area">
                                                            @if($edit)
                                                                @foreach($landless->family_members as $key=>$familyMember)
                                                                    <div class="row family_member_class"
                                                                         id="family_member_{{ ++$key }}">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                @if($key==1)
                                                                                    <label
                                                                                        for="family_member_name_{{$key}}">
                                                                                        {{ __('generic.name') }}
                                                                                    </label>
                                                                                @endif
                                                                                <input type="text"
                                                                                       class="form-control custom-form-control family_member_name"
                                                                                       name="family_members[{{$key}}][name]"
                                                                                       id="family_member_name_{{$key}}"
                                                                                       value="{{$familyMember['name']}}"
                                                                                       placeholder="{{ __('generic.name') }}"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                @if($key==1)
                                                                                    <label
                                                                                        for="family_member_mobile_{{$key}}">
                                                                                        {{ __('generic.mobile') }}
                                                                                    </label>
                                                                                @endif
                                                                                <input type="text"
                                                                                       class="form-control custom-form-control family_member_mobile"
                                                                                       name="family_members[{{$key}}][mobile]"
                                                                                       id="family_member_mobile_{{$key}}"
                                                                                       value="{{$familyMember['mobile']}}"
                                                                                       placeholder="{{ __('generic.mobile') }}"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <d1iv class="form-group">
                                                                                @if($key==1)
                                                                                    <label
                                                                                        for="family_member_profession_{{$key}}">
                                                                                        {{ __('generic.profession') }}
                                                                                    </label>
                                                                                @endif
                                                                                <input type="text"
                                                                                       class="form-control custom-form-control family_member_profession"
                                                                                       name="family_members[{{$key}}][profession]"
                                                                                       id="family_member_profession_{{$key}}"
                                                                                       value="{{$familyMember['profession']}}"
                                                                                       placeholder="{{ __('generic.profession') }}"/>
                                                                            </d1iv>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group text-center"
                                                                                 style="margin: 0; height: 45px; display: flex; align-content: center; justify-content: center; align-items: center;">
                                                                                <label>&nbsp;</label>
                                                                                @if($key>1)
                                                                                    <span class="btn btn-danger"
                                                                                          onclick="removeFamilyMember({{$key}})">
                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                </span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="row family_member_class"
                                                                     id="family_member_1">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="family_member_name_1">
                                                                                {{ __('generic.name') }}
                                                                                <span class="text-danger">*</span>
                                                                            </label>
                                                                            <input type="text"
                                                                                   class="form-control custom-form-control family_member_name"
                                                                                   name="family_members[1][name]"
                                                                                   id="family_member_name_1"
                                                                                   placeholder="{{ __('generic.name') }}"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="family_member_mobile_1">
                                                                                {{ __('generic.mobile') }}
                                                                                <span class="text-danger">*</span>
                                                                            </label>
                                                                            <input type="text"
                                                                                   class="form-control custom-form-control family_member_mobile"
                                                                                   name="family_members[1][mobile]"
                                                                                   id="family_member_mobile_1"
                                                                                   placeholder="{{ __('generic.mobile') }}"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <d1iv class="form-group">
                                                                            <label for="family_member_profession_1">
                                                                                {{ __('generic.profession') }}
                                                                                <span class="text-danger">*</span>
                                                                            </label>
                                                                            <input type="text"
                                                                                   class="form-control custom-form-control family_member_profession"
                                                                                   name="family_members[1][profession]"
                                                                                   id="family_member_profession_1"
                                                                                   placeholder="{{ __('generic.profession') }}"/>
                                                                        </d1iv>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>&nbsp;</label>
                                                                        <div class="form-group text-center"
                                                                             style="margin: 0; height: 45px; display: flex; align-content: center; justify-content: center; align-items: center;">
                                                                            <label>&nbsp;</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="d-block">
                                                            <div class="text-center">
                                                                <span class="btn btn-warning"
                                                                      onclick="addFamilyMember()">
                                                                        <i class="fas fa-plus-circle"></i> {{ __('generic.add_family_member') }}
                                                                    </span>
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
                        <div id="step3" class="card rounded">
                            <div class="card-header" id="heading3" style="background: #f7f7f7">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed text-bold" type="button"
                                            data-toggle="collapse" data-target="#collapse3" aria-expanded="false"
                                            aria-controls="collapse3">
                                        {{ __('generic.attachments') }}
                                        <i class="fas fa-angle-down float-right"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse3" class="collapse" aria-labelledby="heading3"
                                 data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>
                                                {{ __('generic.submitted_attachments') }}
                                            </label>
                                            <div class="border rounded p-3">
                                                <div id="attachment_area">
                                                    @if($edit)
                                                        @foreach($landlessApplicationAttachments as $key=>$landlessApplicationAttachment)

                                                            <div class="row attachment_class"
                                                                 id="attachment_{{++$key}}">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        @if($key==1)
                                                                            <label for="file_type_id_{{$key}}">
                                                                                {{ __('generic.file_type') }}
                                                                                <span class="text-danger">*</span>
                                                                            </label>
                                                                        @endif
                                                                        <select
                                                                            class="form-control custom-form-control attachment_file_type_id"
                                                                            name="attachments[{{$key}}][file_type_id]"
                                                                            onchange="attachmentDetails({{$key}})"
                                                                            id="file_type_id_{{$key}}"
                                                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                                                        >
                                                                            <option
                                                                                value="">{{ __('generic.select_placeholder') }}</option>
                                                                            @foreach($fileTypes as $fileType)
                                                                                <option
                                                                                    value="{{ $fileType->id }}"
                                                                                    {{ $landlessApplicationAttachment->file_type_id == $fileType->id? 'selected':''}}
                                                                                    data-allow-format="{{ json_encode($fileType->allow_format) }}">
                                                                                    {{ $fileType->title }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        @if($key==1)
                                                                            <label
                                                                                for="attached_file_{{$key}}">
                                                                                {{ __('generic.file') }}
                                                                                <span class="text-danger">*</span>
                                                                            </label>
                                                                        @endif
                                                                        <input
                                                                            type="hidden"
                                                                            value="{{ $landlessApplicationAttachment->id }}"
                                                                            name="attachments[{{$key}}][attachment_id]"
                                                                        >

                                                                        <div class="input-group" style="height: 45px">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"
                                                                                      style="background: #50177c33;">
                                                                                   <i class="fas fa-upload"></i>&nbsp; {{ __('generic.upload') }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="custom-file"
                                                                                 style="height: 45px">
                                                                                <input type="file"
                                                                                       class="custom-file-input custom-form-control attached_file"
                                                                                       name="attachments[{{$key}}][attached_file]"
                                                                                       id="attached_file_{{$key}}"
                                                                                       onChange="fileOnChange({{$key}})"
                                                                                       data-edit-field="true">
                                                                                <label class="custom-file-label"
                                                                                       id="custom-file-label-{{$key}}"
                                                                                       style="height: 45px">
                                                                                    {{ __('generic.no_file_chosen') }}
                                                                                </label>
                                                                            </div>

                                                                            @if(!empty($landlessApplicationAttachment->attachment_file))

                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text"
                                                                                          id="inputGroupFileAddon02">
                                                                                        @if((pathinfo(!empty($landlessApplicationAttachment->attachment_file)? $landlessApplicationAttachment->attachment_file : '', PATHINFO_EXTENSION) === 'pdf'))
                                                                                            <a
                                                                                                target="_blank"
                                                                                                href="{{ asset("storage/{$landlessApplicationAttachment->attachment_file}") }}"
                                                                                                style="color: #3f51b5;font-weight: bold;"
                                                                                                type="button">
                                                                                            <i class="fa fa-eye"></i>
                                                                                        </a>
                                                                                        @else
                                                                                            <span
                                                                                                class="file_modal_show"
                                                                                                data-action="{{ asset("storage/{$landlessApplicationAttachment->attachment_file}") }}"
                                                                                                style="color: #3f51b5;font-weight: bold;"
                                                                                                type="button"
                                                                                            >
                                                                                            <i class="fa fa-eye"></i>
                                                                                        </span>
                                                                                        @endif

                                                                                    </span>
                                                                                </div>

                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <d1iv class="form-group">
                                                                        @if($key==1)
                                                                            <label for="attached_title_{{$key}}">
                                                                                {{ __('generic.title') }}
                                                                            </label>
                                                                        @endif
                                                                        <input type="text"
                                                                               class="form-control custom-form-control"
                                                                               name="attachments[{{$key}}][title]"
                                                                               id="attached_title_{{$key}}"
                                                                               value="{{ $landlessApplicationAttachment->title }}"
                                                                               placeholder="{{ __('generic.title') }}"/>
                                                                    </d1iv>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group text-center"
                                                                         style="margin: 0; height: 45px; display: flex; align-content: center; justify-content: center; align-items: center;">
                                                                        <label>&nbsp;</label>
                                                                        @if($key>1)
                                                                            <span class="btn btn-danger"
                                                                                  onclick="removeAttachment({{$key}})">
                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="row attachment_class" id="attachment_1">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="file_type_id_1">
                                                                        {{ __('generic.file_type') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <select
                                                                        class="form-control custom-form-control attachment_file_type_id"
                                                                        name="attachments[1][file_type_id]"
                                                                        onchange="attachmentDetails(1)"
                                                                        id="file_type_id_1"
                                                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                                                    >
                                                                        <option
                                                                            value="">{{ __('generic.select_placeholder') }}</option>
                                                                        @foreach($fileTypes as $key=>$fileType)
                                                                            <option
                                                                                value="{{ $fileType->id }}"
                                                                                data-allow-format="{{ json_encode($fileType->allow_format) }}">
                                                                                {{ $fileType->title }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="attached_file_1">
                                                                        {{ __('generic.file') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="input-group" style="height: 45px">
                                                                        <div class="input-group-prepend">
                                                                        <span class="input-group-text"
                                                                              style="background: #50177c33;">
                                                                           <i class="fas fa-upload"></i>&nbsp; {{ __('generic.upload') }}
                                                                        </span>
                                                                        </div>
                                                                        <div class="custom-file" style="height: 45px">
                                                                            <input type="file"
                                                                                   class="custom-file-input custom-form-control attached_file"
                                                                                   name="attachments[1][attached_file]"
                                                                                   id="attached_file_1"
                                                                                   onChange="fileOnChange(1)"
                                                                                   placeholder="" disabled>
                                                                            <label class="custom-file-label"
                                                                                   id="custom-file-label-1"
                                                                                   style="height: 45px">
                                                                                {{ __('generic.no_file_chosen') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <d1iv class="form-group">
                                                                    <label for="attached_title_1">
                                                                        {{ __('generic.title') }}
                                                                    </label>
                                                                    <input type="text"
                                                                           class="form-control custom-form-control"
                                                                           name="attachments[1][title]"
                                                                           id="attached_title_1"
                                                                           placeholder="{{ __('generic.title') }}"/>
                                                                </d1iv>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label>&nbsp;</label>
                                                                <div class="form-group text-center">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-block">
                                                    <div class="text-center">
                                                        <span class="btn btn-warning"
                                                              onclick="addAttachment()">
                                                            <i class="fas fa-plus-circle"></i> {{ __('generic.add_file') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step4" class="card rounded">
                            <div class="card-header" id="heading4" style="background: #f7f7f7">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed text-bold" type="button"
                                            data-toggle="collapse" data-target="#collapse4" aria-expanded="true"
                                            aria-controls="collapse4">
                                        {{ __('generic.others_info') }}
                                        <i class="fas fa-angle-down float-right"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse4" class="collapse" aria-labelledby="heading4"
                                 data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>
                                                {{ __('generic.references') }}
                                            </label>
                                            <div class="border rounded p-3">
                                                <div id="reference_area">
                                                    @if($edit)
                                                        @foreach($landless->references as $key=>$reference)
                                                            <div class="row reference_class" id="reference_{{++$key}}">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        @if($key==1)
                                                                            <label for="reference_name_{{$key}}">
                                                                                {{ __('generic.name') }}
                                                                                <span class="text-danger">*</span>
                                                                            </label>
                                                                        @endif
                                                                        <input type="text"
                                                                               class="form-control custom-form-control reference_name"
                                                                               name="references[{{$key}}][name]"
                                                                               id="reference_name_{{$key}}"
                                                                               value="{{$reference['name']}}"
                                                                               placeholder="{{ __('generic.name') }}"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        @if($key==1)
                                                                            <label for="reference_mobile_{{$key}}">
                                                                                {{ __('generic.mobile') }}
                                                                                <span class="text-danger">*</span>
                                                                            </label>
                                                                        @endif
                                                                        <input type="text"
                                                                               class="form-control custom-form-control reference_mobile"
                                                                               name="references[{{$key}}][mobile]"
                                                                               id="reference_mobile_{{$key}}"
                                                                               value="{{$reference['mobile']}}"
                                                                               placeholder="{{ __('generic.mobile') }}"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <d1iv class="form-group">
                                                                        @if($key==1)
                                                                            <label for="reference_profession_{{$key}}">
                                                                                {{ __('generic.profession') }}
                                                                                <span class="text-danger">*</span>
                                                                            </label>
                                                                        @endif
                                                                        <input type="text"
                                                                               class="form-control custom-form-control reference_profession"
                                                                               name="references[{{$key}}][profession]"
                                                                               id="reference_profession_{{$key}}"
                                                                               value="{{$reference['profession']}}"
                                                                               placeholder="{{ __('generic.profession') }}"/>
                                                                    </d1iv>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group text-center"
                                                                         style="margin: 0; height: 45px; display: flex; align-content: center; justify-content: center; align-items: center;">
                                                                        @if($key>1)
                                                                            <span class="btn btn-danger"
                                                                                  onclick="removeReference({{$key}})">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="row reference_class" id="reference_1">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="reference_name_1">
                                                                        {{ __('generic.name') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="text"
                                                                           class="form-control custom-form-control reference_name"
                                                                           name="references[1][name]"
                                                                           id="reference_name_1"
                                                                           placeholder="{{ __('generic.name') }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="reference_mobile_1">
                                                                        {{ __('generic.mobile') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="text"
                                                                           class="form-control custom-form-control reference_mobile"
                                                                           name="references[1][mobile]"
                                                                           id="reference_mobile_1"
                                                                           placeholder="{{ __('generic.mobile') }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <d1iv class="form-group">
                                                                    <label for="reference_profession_1">
                                                                        {{ __('generic.profession') }}
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="text"
                                                                           class="form-control custom-form-control reference_profession"
                                                                           name="references[1][profession]"
                                                                           id="reference_profession_1"
                                                                           placeholder="{{ __('generic.profession') }}"/>
                                                                </d1iv>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>&nbsp;</label>
                                                                <div class="form-group text-center">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="d-block">
                                                    <div class="text-center">
                                                                <span class="btn btn-warning"
                                                                      onclick="addReference()">
                                                                        <i class="fas fa-plus-circle"></i> {{ __('generic.add_reference') }}
                                                                    </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 mt-3">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nothi_number">{{ __('generic.nothi_number') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="nothi_number"
                                                       id="nothi_number"
                                                       value="{{$edit ? $landless->nothi_number : ''}}"
                                                       placeholder="{{ __('generic.nothi_number') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="expected_lands">{{ __('generic.expected_lands') }} </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="expected_lands"
                                                       id="expected_lands"
                                                       value="{{$edit ? $landless->expected_lands : ''}}"
                                                       placeholder="{{ __('generic.expected_lands') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    for="application_received_date">{{ __('generic.application_received_date') }}</label>
                                                <div class="input-group">
                                                    <input type="text"
                                                           class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                                           name="application_received_date"
                                                           id="application_received_date"
                                                           value="{{$edit ? $landless->application_received_date : ''}}"
                                                           placeholder="{{ __('generic.select_date') }}"/>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"
                                                             style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                                            <i class="fas fa-calendar-day"
                                                               style="color: #959595; transform: rotateY(180deg);"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="receipt_number">{{ __('generic.receipt_number') }} </label>
                                                <input type="text" class="form-control custom-form-control"
                                                       name="receipt_number"
                                                       id="receipt_number"
                                                       value="{{$edit ? $landless->receipt_number : ''}}"
                                                       placeholder="{{ __('generic.receipt_number') }}"/>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit"
                                    class="btn btn-warning form-submit" name="status"
                                    value="5">{{ __('generic.save_as_draft') }}</button>
                            <button type="submit" name="status" value="3"
                                    class="btn btn-success form-submit">{{ /*$edit ?__('generic.update') : */__('generic.save') }}</button>
                        </div>
                    </div>
                </form>
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
                        {{ __('generic.file') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modal_img"
                         src="{{ !empty($landless->attached_file)? asset("storage/{$landless->attached_file}"):'' }}"
                         alt="{{ __('generic.uploaded_file') }}" width="100%">
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
    <style>
        em#gender-error {
            position: absolute;
            width: 160px;
            left: 0;
            bottom: -22px;
        }

        em#file_type-error {
            position: absolute;
            width: 160px;
            left: -13px;
            bottom: -31px;
        }

        em#father_is_alive-error, em#mother_is_alive-error {
            position: absolute;
            width: 160px;
            left: -13px;
            bottom: -31px;
        }

        .custom-file-input:lang(en) ~ .custom-file-label::after {
            content: "Browse";
            height: 43px;
        }

        em#file_type_id_1-error {
            position: absolute;
            left: 8px;
            bottom: -7px;
            width: 200px;
        }

    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        const EDIT = !!'{{$edit}}';
        let numFamilyMemberItems = {{ $edit? count($landless->family_members):1 }};
        function addFamilyMember() {
            numFamilyMemberItems = numFamilyMemberItems + 1;
            let rowNumber = numFamilyMemberItems;
            let addFamilyMemberTemplete = '<div class="row family_member_class" id="family_member_' + rowNumber + '">' +
                '                                                            <div class="col-md-4">' +
                '                                                                <div class="form-group">' +
                '                                                                    <input type="text" class="form-control custom-form-control family_member_name"' +
                '                                                                           name="family_members[' + rowNumber + '][name]"' +
                '                                                                           id="family_member_name_' + rowNumber + '"' +
                '                                                                           placeholder="{{ __("generic.name") }}"/>' +
                '                                                                </div>' +
                '                                                            </div>' +
                '                                                            <div class="col-md-3">' +
                '                                                                <div class="form-group">' +
                '                                                                    <input type="text" class="form-control custom-form-control family_member_mobile"' +
                '                                                                           name="family_members[' + rowNumber + '][mobile]"' +
                '                                                                           id="family_member_mobile_' + rowNumber + '"' +
                '                                                                           placeholder="{{ __("generic.mobile") }}"/>' +
                '                                                                </div>' +
                '                                                            </div>' +
                '                                                            <div class="col-md-3">' +
                '                                                                <d1iv class="form-group">' +
                '                                                                    <input type="text" class="form-control custom-form-control family_member_profession"' +
                '                                                                           name="family_members[' + rowNumber + '][profession]"' +
                '                                                                           id="family_member_profession_' + rowNumber + '"' +
                '                                                                           placeholder="{{ __("generic.profession") }}"/>' +
                '                                                                </d1iv>' +
                '                                                            </div>' +
                '                                                            <div class="col-md-2">' +
                '                                                                <div class="form-group text-center" style="margin: 0; height: 45px; display: flex; align-content: center; justify-content: center; align-items: center;" >' +
                '                                                                    <span ' +
                '                                                                           class="btn btn-danger"' +
                '                                                                           onclick="removeFamilyMember(' + rowNumber + ')">' +
                '                                                                        <i class="fas fa-trash-alt"></i>' +
                '                                                                    </span>' +
                '                                                                </div>' +
                '                                                            </div>' +
                '                                                        </div>' +
                '                                                    </div>';

            $('#family_member_area').append(addFamilyMemberTemplete);

        }
        function removeFamilyMember(number) {
            if (number != 1) {
                $('#family_member_' + number).remove();
            }
        }

        let numReferenceItems = {{ $edit?count($landless->references):1 }};
        function addReference() {
            numReferenceItems = numReferenceItems + 1;
            let rowNumber = numReferenceItems;
            let addReferenceTemplate = '<div class="row reference_class" id="reference_' + rowNumber + '">' +
                '                                                            <div class="col-md-4">' +
                '                                                                <div class="form-group">' +
                '                                                                    <input type="text" class="form-control custom-form-control reference_name"' +
                '                                                                           name="references[' + rowNumber + '][name]"' +
                '                                                                           id="reference_name_' + rowNumber + '"' +
                '                                                                           placeholder="{{ __("generic.name") }}"/>' +
                '                                                                </div>' +
                '                                                            </div>' +
                '                                                            <div class="col-md-3">' +
                '                                                                <div class="form-group">' +
                '                                                                    <input type="text" class="form-control custom-form-control reference_mobile"' +
                '                                                                           name="references[' + rowNumber + '][mobile]"' +
                '                                                                           id="reference_mobile_' + rowNumber + '"' +
                '                                                                           placeholder="{{ __("generic.mobile") }}"/>' +
                '                                                                </div>' +
                '                                                            </div>' +
                '                                                            <div class="col-md-3">' +
                '                                                                <d1iv class="form-group">' +
                '                                                                    <input type="text" class="form-control custom-form-control reference_profession"' +
                '                                                                           name="references[' + rowNumber + '][profession]"' +
                '                                                                           id="reference_profession_' + rowNumber + '"' +
                '                                                                           placeholder="{{ __("generic.profession") }}"/>' +
                '                                                                </d1iv>' +
                '                                                            </div>' +
                '                                                            <div class="col-md-2">' +
                '                                                                <div class="form-group text-center" style="margin: 0; height: 45px; display: flex; align-content: center; justify-content: center; align-items: center;">' +
                '                                                                    <label>&nbsp;</label>' +
                '' +
                '                                                                    <span ' +
                '                                                                           class="btn btn-danger"' +
                '                                                                           onclick="removeReference(' + rowNumber + ')">' +
                '                                                                        <i class="fas fa-trash-alt"></i>' +
                '                                                                    </span>' +
                '                                                                </div>' +
                '                                                            </div>' +
                '                                                        </div>' +
                '                                                    </div>';

            $('#reference_area').append(addReferenceTemplate);

        }
        function removeReference(number) {
            if (number != 1) {
                $('#reference_' + number).remove();
            }
        }

        $('#file_type_id_1').select2();
        let numAttachmentItems = {{ $edit?count($landlessApplicationAttachments):1 }};
        function addAttachment() {
            numAttachmentItems = numAttachmentItems + 1;
            let rowNumber = numAttachmentItems;
            let attachmentTemplate = '' +
                '<div class="row attachment_class" id="attachment_' + rowNumber + '">' +
                '                                                        <div class="col-md-3">' +
                '                                                            <div class="form-group">' +
                '                                                                <select class="form-control custom-form-control select2 attachment_file_type_id"' +
                '                                                                        name="attachments[' + rowNumber + '][file_type_id]"' +
                '                                                                        onchange="attachmentDetails(' + rowNumber + ')"' +
                '                                                                        id="file_type_id_' + rowNumber + '" data-placeholder="{{ __('generic.select_placeholder') }}">' +
                '                                                                    <option' +
                '                                                                        value="">{{ __("generic.select_placeholder") }}</option>' +
                '                                                                    @foreach($fileTypes as $key=>$fileType)' +
                '                                                                        <option' +
                '                                                                            value="{{ $fileType->id }}" data-allow-format="{{ json_encode($fileType->allow_format) }}">' +
                '                                                                            {{ $fileType->title }}' +
                '                                                                        </option>' +
                '                                                                    @endforeach' +
                '                                                                </select>' +
                '                                                            </div>' +
                '                                                        </div>' +
                '                                                        <div class="col-md-5">' +
                '                                                            <div class="form-group">' +
                '                                                                <div class="input-group" style="height: 45px">' +
                '                                                                    <div class="input-group-prepend">' +
                '                                                                        <span class="input-group-text"' +
                '                                                                              style="background: #50177c33;">' +
                '                                                                           <i class="fas fa-upload"></i>&nbsp; {{ __('generic.upload') }}' +
                '                                                                        </span>' +
                '                                                                    </div>' +
                '                                                                    <div class="custom-file" style="height: 45px">' +
                '                                                                        <input type="file"' +
                '                                                                               class="custom-file-input custom-form-control attached_file"' +
                '                                                                               name="attachments[' + rowNumber + '][attached_file]"' +
                '                                                                               id="attached_file_' + rowNumber + '"' +
                '                                                                               onChange="fileOnChange(' + rowNumber + ')" disabled>' +
                '                                                                        <label class="custom-file-label" id="custom-file-label-' + rowNumber + '"' +
                '                                                                               style="height: 45px">' +
                '                                                                            {{ __('generic.no_file_chosen') }}' +
                '                                                                        </label>' +
                '                                                                    </div>' +
                '                                                                </div>' +
                '                                                            </div>' +
                '                                                        </div>' +
                '                                                        <div class="col-md-3">' +
                '                                                            <d1iv class="form-group">' +
                '                                                                <input type="text"' +
                '                                                                       class="form-control custom-form-control"' +
                '                                                                       name="attachments[' + rowNumber + '][title]"' +
                '                                                                       id="attached_title_' + rowNumber + '"' +
                '                                                                       placeholder="{{ __('generic.title') }}"/>' +
                '                                                            </d1iv>' +
                '                                                        </div>' +
                '                                                        <div class="col-md-1">' +
                '                                                            <div class="form-group text-center" style="margin: 0; height: 45px; display: flex; align-content: center; justify-content: center; align-items: center;">' +
                '                                                                <label>&nbsp;</label>' +
                '                                                                <span href="#" class="btn btn-danger"' +
                '                                                                      onclick="removeAttachment(' + rowNumber + ')">' +
                '                                                                        <i class="fas fa-trash-alt"></i>' +
                '                                                                    </span>' +
                '                                                            </div>' +
                '                                                        </div>' +
                '                                                    </div>' +
                '';

            $('#attachment_area').append(attachmentTemplate);
            $('#file_type_id_' + rowNumber).select2();

        }
        function removeAttachment(number) {
            if (number != 1) {
                $('#attachment_' + number).remove();
            }
        }

        function fileOnChange(rowId) {
            /**
             *Custom file input name showing
             **/
            let fileName = $('#attached_file_' + rowId).val().split("\\").pop();
            $('#attached_file_' + rowId).siblings("#custom-file-label-" + rowId).addClass("selected").html(fileName);

            /**
             *File type frontend remote validation
             **/
            let fileExt = $('#attached_file_' + rowId).val().split('.').pop();
            let fileTypeId = $('option:selected', '#file_type_id_' + rowId).val();
            let url = '{{ route('file-types.check-allow-format','__') }}'.replace('__', fileTypeId);

            $('#attached_file_' + rowId).rules("add", {
                remote: {
                    param: {
                        type: "get",
                        url: url,
                        data: {
                            file_ext: fileExt
                        },
                    }
                },
            });
        }

        function attachmentDetails(rowId) {
            let fileTypeId = $('#file_type_id_' + rowId).val();
            $('#attached_file_' + rowId).prop("disabled",false);
        }

        (function () {
            function showLoader() {
                $('#loading-sniper').show();
                $('body').css('overflow', 'hidden');
            }

            function hideLoader() {
                $('#loading-sniper').hide();
                $('body').css('overflow', 'auto');
            }


            $.validator.addMethod(
                "nidBn",
                function (value, element) {
                    let regexp = /^([০-৯]{10}|[০-৯]{17})$/i;
                    let regexp1 = /^(\d{10}|\d{17})$/i;
                    let re = new RegExp(regexp);
                    let re1 = new RegExp(regexp1);
                    return this.optional(element) || re.test(value) || re1.test(value);
                },
                "সঠিক এন.আই.ডি প্রদান করুন [শুধুমাত্র ১০/১৭ সংখ্যার এন.আই.ডি প্রদান করুন] "
            );

            $.validator.addMethod(
                "mobileValidation",
                function (value, element) {
                    let regexp1 = /^(?:\+88|88)?(01[3-9]\d{8})$/i;
                    let regexp = /^(?:\+৮৮|৮৮)?(০১[৩-৯][০-৯]{8})$/i;
                    let re = new RegExp(regexp);
                    let re1 = new RegExp(regexp1);
                    return this.optional(element) || re.test(value) || re1.test(value);
                },
                "সঠিক মোবাইল নাম্বার লিখুন"
            );

            const editAddForm = $('.edit-add-form');
            editAddForm.validate({

                rules: {
                    fullname: {
                        required: true,
                        //pattern: /^[\s'\u0980-\u09ff]+$/,
                    },
                    mobile: {
                        mobileValidation: true,
                    },
                    email: {
                        required: false,
                    },
                    identity_type: {
                        required: true,
                    },
                    identity_number: {
                        required: function () {
                            if ($('#identity_type_3').is(':checked')) {
                                return false
                            } else {
                                return true;
                            }
                        },
                    },
                    date_of_birth: {
                        required: true,
                    },
                    is_validate_nid: {
                        required: true,
                    },
                    landless_type: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    },
                    file_type: {
                        required: true,
                    },
                    attached_file: {
                        required: false,
                    },
                    father_name: {
                        required: true,
                    },
                    father_dob: {
                        required: true,
                    },
                    father_is_alive: {
                        required: true,
                    },
                    mother_name: {
                        required: true,
                    },
                    mother_dob: {
                        required: true,
                    },
                    mother_is_alive: {
                        required: true,
                    },
                    bosot_vita_details: {
                        required: true,
                    },
                    loc_division_bbs: {
                        required: true,
                    },
                    loc_district_bbs: {
                        required: true,
                    },
                    loc_upazila_bbs: {
                        required: true,
                    },
                    loc_union_bbs: {
                        required: false,
                    },
                    mouja_id: {
                        required: true,
                    },
                    village: {
                        required: true,
                    },
                    nothi_number: {
                        required: true,
                        remote: {
                            param: {
                                type: "get",
                                url: '{{ route('admin.landless.check-nothi-number') }}',
                                data: {
                                    edit: '{{$edit?'true':'false'}}',
                                    id: '{{$edit?$landless->id:''}}',
                                },
                            }
                        },
                    },

                },
                messages: {
                    fullname: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    mobile: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    email: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    identity_type: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    identity_number: {
                        required: function () {
                            if ($('#identity_type_3').is(':checked')) {
                                return false
                            } else {
                                return "{{ __('generic.field_is_required') }}";
                            }
                        },
                    },
                    date_of_birth: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    is_validate_nid: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    landless_type: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    gender: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    file_type: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    attached_file: {
                        required: false,
                    },
                    father_name: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    father_dob: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    father_is_alive: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    mother_name: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    mother_dob: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    mother_is_alive: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    bosot_vita_details: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    loc_division_bbs: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    loc_district_bbs: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    loc_upazila_bbs: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    loc_union_bbs: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    mouja_id: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    village: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    nothi_number: {
                        required: "{{ __('generic.field_is_required') }}",
                    },

                },
                submitHandler: function (htmlForm) {
                    $('#loading-sniper').show();

                    // Get some values from elements on the page:
                    const form = $(htmlForm);
                    const formData = new FormData(htmlForm);
                    const url = form.attr("action");

                    // Send the data using post
                    $.ajax({
                        url: url,
                        data: formData,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            $('#loading-sniper').hide();
                            let alertType = response.alertType;
                            let alertMessage = response.message;
                            let alerter = toastr[alertType];
                            alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");


                            if (response.redirectTo) {
                                setTimeout(function () {
                                    window.location.href = response.redirectTo;
                                }, 100);
                            }

                        },
                    });

                    return false;
                }
            });

            let langEn = {{ Session::get('locale') == 'en' ? 1: 0 }};

            $('.identity_type').on('change', function () {
                let identityType = $(this).val();
                if (identityType == 1 || identityType == 2) {
                    $('#fullname').prop('readonly', false);
                    $('#identity_number').prop('readonly', false);
                }

                if (identityType == 3) {
                    $('#identity_number').prop('readonly', true);
                }


                if (identityType == 2) {
                    $.validator.addClassRules('identity_number', {
                        required: true,
                        nidBn: true,
                    });

                    $('#user_check_submit').removeClass('d-none');
                    $('#user_check_submit').prop('disabled', false);
                    $('#is_validate_nid').prop('disabled', false);
                } else {
                    $.validator.addClassRules('identity_number', {
                        required: true,
                        nidBn: false,
                    });

                    $('#user_check_submit').addClass('d-none');
                    $('#user_check_submit').prop('disabled', true);
                    $('#is_validate_nid').prop('disabled', true);
                    $('#is_validate_nid').val(null);
                }
            });

            function loadDistricts() {
                showLoader();
                let divisionBbcCode = $('#loc_division_bbs').val();

                if (divisionBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-districts') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'division_bbs_code': divisionBbcCode,
                        },
                        success: function (response) {
                            $('#loc_district_bbs').html('');
                            $('#loc_district_bbs').html('<option value="">নির্বাচন করুন</option>');

                            $('#loc_upazila_bbs').html('');
                            $('#loc_upazila_bbs').html('<option value="">নির্বাচন করুন</option>');

                            $('#loc_union_bbs').html('');
                            $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');

                            $('#mouja_id').html('');
                            $('#mouja_id').html('<option value="">নির্বাচন করুন</option>');

                            $.each(response, function (key, value) {

                                if (value.bbs_code == "75") {
                                    //75 is Noakhali district
                                    $('#loc_district_bbs').append(
                                        '<option value="' + value.bbs_code + '" ' + /*(value.bbs_code == "75" ? "selected" : "") +*/ '>' + (langEn ? value.title_en : value.title) + '</option>'
                                    );
                                }

                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                } else {
                    $('#loc_district_bbs').html('');
                    $('#loc_district_bbs').html('<option value="">নির্বাচন করুন</option>');

                    $('#loc_upazila_bbs').html('');
                    $('#loc_upazila_bbs').html('<option value="">নির্বাচন করুন</option>');

                    $('#loc_union_bbs').html('');
                    $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');

                    $('#mouja_id').html('');
                    $('#mouja_id').html('<option value="">নির্বাচন করুন</option>');

                    hideLoader();
                }
            }

            function loadUpazilas() {
                //showLoader();
                let districtBbcCode = $('#loc_district_bbs').val();

                if (districtBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-upazilas') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'district_bbs_code': districtBbcCode,
                        },
                        success: function (response) {
                            $('#loc_upazila_bbs').html('');
                            $('#loc_upazila_bbs').html('<option value="">নির্বাচন করুন</option>');

                            $('#loc_union_bbs').html('');
                            $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');

                            $('#mouja_id').html('');
                            $('#mouja_id').html('<option value="">নির্বাচন করুন</option>');

                            let isAcLandUser = '{!! $authUser->isAcLandUser() !!}';
                            let authUserUpazilaBbsCode = '{!! \Modules\Landless\App\Models\Landless::getAuthUpazilaBbsCode($authUser) !!}';
                            if (isAcLandUser) {
                                $.each(response, function (key, value) {
                                    if (value.bbs_code == authUserUpazilaBbsCode) {
                                        $('#loc_upazila_bbs').append(
                                            '<option value="' + value.bbs_code + '" ' + (value.bbs_code == authUserUpazilaBbsCode ? "selected" : "") + ' >' + (langEn ? value.title_en : value.title) + '</option>'
                                        );
                                    }
                                });
                            } else {
                                $.each(response, function (key, value) {
                                    $('#loc_upazila_bbs').append(
                                        '<option value="' + value.bbs_code + '">' + (langEn ? value.title_en : value.title) + '</option>'
                                    );
                                });
                            }
                            //hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });

                } else {
                    $('#loc_upazila_bbs').html('');
                    $('#loc_upazila_bbs').html('<option value="">নির্বাচন করুন</option>');

                    $('#loc_union_bbs').html('');
                    $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');

                    $('#mouja_id').html('');
                    $('#mouja_id').html('<option value="">নির্বাচন করুন</option>');
                    //hideLoader();
                }
            }

            function loadUnions() {
                showLoader();
                let upazilaBbcCode = $('#loc_upazila_bbs').val();
                let DistrictBbsCode = $('#loc_district_bbs').val();
                let DivisionBbsCode = $('#loc_division_bbs').val();

                if (upazilaBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-unions') }}',
                        data: {
                            'division_bbs_code': DivisionBbsCode,
                            'district_bbs_code': DistrictBbsCode,
                            'upazila_bbs_code': upazilaBbcCode,
                        },
                        success: function (response) {
                            $('#loc_union_bbs').html('');
                            $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');
                            $.each(response, function (key, value) {
                                $('#loc_union_bbs').append(
                                    '<option value="' + value.bbs_code + '">' + (langEn ? value.title_en : value.title) + '</option>'
                                );
                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                } else {
                    $('#loc_union_bbs').html('');
                    $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');
                    hideLoader();
                }
            }

            function loadMoujas() {
                showLoader();
                let upazilaBbcCode = $('#loc_upazila_bbs').val();
                let DistrictBbsCode = $('#loc_district_bbs').val();
                let DivisionBbsCode = $('#loc_division_bbs').val();

                if (upazilaBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-moujas') }}',
                        data: {
                            'division_bbs_code': DivisionBbsCode,
                            'district_bbs_code': DistrictBbsCode,
                            'upazila_bbs_code': upazilaBbcCode,
                        },
                        success: function (response) {
                            $('#mouja_id').html('');
                            $('#mouja_id').html('<option value="">নির্বাচন করুন</option>');
                            $.each(response, function (key, value) {
                                $('#mouja_id').append(
                                    '<option value="' + value.rs_jl_no + '" data-jl-number="' + value.rs_jl_no + '">' + (langEn ? value.name : value.name_bd) + '</option>'
                                );
                            });
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });

                } else {
                    $('#mouja_id').html('');
                    $('#mouja_id').html('<option value="">নির্বাচন করুন</option>');
                    hideLoader();
                }
            }

            $('#loc_division_bbs').on('change', function () {
                loadDistricts();
                $('#jl_number').val('');
            });

            $('#loc_district_bbs').on('change', function () {
                loadUpazilas();
                $('#jl_number').val('');
            });

            $('#loc_upazila_bbs').on('change', function () {
                loadUnions();
                loadMoujas();
                $('#jl_number').val('');

                if($(this).val()!=''){
                    $(this).valid();
                }
            });

            $('#mouja_id').on('change', function () {
                let jlNumber = $(this).val();
                $('#jl_number').val(jlNumber);
            });

            if ($('#loc_division_bbs').val() != '' && !EDIT) {
                showLoader();
                let divisionBbcCode = $('#loc_division_bbs').val();

                if (divisionBbcCode) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('get-districts') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'division_bbs_code': divisionBbcCode,
                        },
                        success: function (response) {
                            $.each(response, function (key, value) {
                                if (value.bbs_code == "75") {
                                    //75 is Noakhali district
                                    $('#loc_district_bbs').append(
                                        '<option value="' + value.bbs_code + '" ' + (value.bbs_code == "75" ? "selected" : "") + '>' + (langEn ? value.title_en : value.title) + '</option>'
                                    );
                                }
                            });
                            if ($('#loc_district_bbs').val() != '' && !EDIT) {
                                showLoader();
                                loadUpazilas();
                                hideLoader();
                            }
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                }
                hideLoader();
            }


            /**
             * NID Validation Start
             * **/
            $('#user_check_submit').on('click', function (e) {
                e.preventDefault();
                $(".edit-add-form").validate().element('#identity_number');
                $(".edit-add-form").validate().element('#date_of_birth');

                let nidNo = $('#identity_number').val();
                let nidDoB = $('#date_of_birth').val();
                if (!nidNo || !nidDoB) {
                    return false;
                }
                showLoader();
                $.ajax({
                    url: "{{ route('admin.get-owners-info-from-nid-api') }}",
                    data: {
                        nid: nidNo,
                        date_of_birth: nidDoB
                    },
                    type: "POST",
                    success: function (response) {

                        console.log('Nid Response', response)
                        if (response.name !== undefined) {
                            $('#fullname').val(langEn ? response.name : response.name_bn);
                            $('#fullname').prop('readonly', true);
                            $('#identity_number').prop('readonly', true);
                            $('.date_of_birth').prop('readonly', true);
                            $('#is_validate_nid').val('validated');

                            $('#father_name').val(response.father);
                            $('#mother_name').val(response.mother);

                            swal({
                                title: '{{ __('generic.all_right') }}',
                                text: '{{ __('generic.user_info_found') }}',
                                buttons: {
                                    text: "{{ __('generic.ok') }}",
                                },
                                icon: "success",
                            })
                        } else {
                            swal({
                                title: '{{ __('generic.all_wrong') }}',
                                text: '{{ __('generic.try_again') }}',
                                buttons: {
                                    text: "{{ __('generic.ok') }}",
                                },
                                icon: "error",
                            })
                        }
                        hideLoader();
                    },
                    complete: function () {
                        hideLoader();
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr)
                        alert('অনাকাঙ্খিত ত্রুটি!' + xhr.responseJSON.message);
                        hideLoader();
                    }
                });
            });

            $("#fullname, #identity_number, #date_of_birth").change(function () {
                if ($('#identity_type_2').is(':checked')) {
                    $('#is_validate_nid').val(null);
                    $('#user_check_submit').prop('disabled', false);
                    $('#user_check_submit').removeClass('d-none');
                }

                if($('#date_of_birth').val()!=''){
                    $('#date_of_birth').valid();
                }
            });

            $('#heading1 button,#heading2 button, #heading3 button, #heading4 button').on('click', function () {
                if ($(this).children("i").hasClass("fa-angle-up")) {
                    $(this).children("i").removeClass("fa-angle-up");
                    $(this).children("i").addClass("fa-angle-down");
                } else {
                    $(this).children("i").removeClass("fa-angle-down");
                    $(this).children("i").addClass("fa-angle-up");
                }
            });

            /**
             * Modal img showing
             * **/
            $('.file_modal_show').click(function (i, j) {
                $('#modal_img').attr('src', $(this)[0].dataset.action);
                $('#scan_file_viewer').modal('show');
            });
        })();

        $(document).ready(function (){
            $('.form-submit').on('click', function () {
                if ($('#identity_type_2').is(':checked') && $('#is_validate_nid').val() == '') {
                    swal({
                        title: '{{ __('generic.all_wrong') }}',
                        text: '{{ __('generic.first_verify_nid') }}',
                        buttons: {
                            text: "{{ __('generic.ok') }}",
                        },
                        icon: "error",
                    })
                }

                $('.family_member_name, .family_member_profession').each(function () {
                    $(this).rules("add", {
                        required: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                });

                $('.family_member_mobile').each(function () {
                    $(this).rules("add", {
                        required: true,
                        mobileValidation: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                });

                $('.attachment_file_type_id').each(function () {
                    $(this).rules("add", {
                        required: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                });

                $('.attached_file').each(function () {
                    let isNotRequired = $(this).data('edit-field');
                    $(this).rules("add", {
                        required: function () {
                            if (isNotRequired === true) {
                                return false;
                            } else {
                                return true;
                            }
                        },
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                });

                $('.reference_name, .reference_profession').each(function () {
                    $(this).rules("add", {
                        required: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                });

                $('.reference_mobile').each(function () {
                    $(this).rules("add", {
                        required: true,
                        mobileValidation: true,
                        messages: {
                            required: "{{ __('generic.field_is_required') }}",
                        }
                    });
                });

                for(let i=1; i<=4; i++){
                    let errorCount = 0;
                    $('#step'+i).find(".error").each(function (i, obj){
                        if($(this).html()!=''){
                            errorCount = errorCount+1;
                        }
                    });
                    if(errorCount){
                        $('#step'+i).find('.card-header h2 button').css("color", '#F00');
                        $('#step'+i).find('.card-header h2 button').focus();
                        $('#collapse'+1).addClass('show');
                    }else{
                        $('#step'+i).find('.card-header h2 button').css("color", '#007bff');
                        //$('#collapse'+1).removeClass('show');
                    }
                }
            });
        });

    </script>
@endpush


