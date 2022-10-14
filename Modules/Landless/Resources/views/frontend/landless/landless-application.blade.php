@extends('master::layouts.landing-page-master')

@section('title')
    {{ __('cadt')}}
@endsection

@php

    $langBn = Session::get('locale') != 'en';
/*Session::put('langSessionSet', 'bn');
    $langBn = Session::get('langSessionSet') == 'bn';*/
@endphp


@section('content')
    <div class="container">
        <div class="card my-2" style="background: #f6f6f6c4;">
            <div class="card-header">
                <h3 class="font-weight-bold text-center">
                    {{ __('generic.landless_application')}}
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{ route('landless.landless-application.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fullname">
                                    {{ __('generic.name_of_the_applicant') }}
                                    <span class="text-danger"> * </span>
                                </label>
                                <input type="text" class="form-control custom-form-control"
                                       name="fullname"
                                       id="fullname"
                                       value=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile"> {{ __('generic.mobile_number') }} <span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control custom-form-control"
                                       name="mobile"
                                       id="mobile"
                                       value=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"> {{ __('email') }}
                                    <span class="text-danger"> * </span>
                                </label>
                                <input type="text" class="form-control custom-form-control"
                                       name="email"
                                       id="email"
                                       value=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('generic.identity_type') }}
                                    <span class="text-danger"> * </span>
                                </label>
                                <div class="d-flex">
                                    @foreach(\Modules\Landless\App\Models\Landless::IDENTITY_TYPE as $key=>$value)
                                        <div
                                            class="custom-control custom-radio custom-control-inline">
                                            <input type="radio"
                                                   class="custom-control-input identity_type"
                                                   id="identity_type_{{ $key }}"
                                                   name="identity_type"
                                                   value="{{ $key }}" {{ $key == 1 ? 'checked': '' }} >
                                            <label class="custom-control-label"
                                                   for="identity_type_{{ $key }}">
                                                {{ __('generic.'.$value) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" id="identity-type-area">
                            <div class="form-group">
                                <label for="identity_number">{{ __('generic.identity_number') }}
                                    <span class="text-danger"> * </span>
                                </label>
                                <input type="text"
                                       class="form-control custom-form-control identity_number"
                                       name="identity_number"
                                       id="identity_number"
                                       value=""/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date_of_birth">{{ __('generic.date_of_birth') }}
                                    <span class="text-danger"> * </span>
                                </label>
                                <div class="input-group">
                                    <input type="text"
                                           class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                           name="date_of_birth"
                                           id="date_of_birth"
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
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <div class="form-group">
                                <input type="button" id="user_check_submit" value="{{ __('generic.verify') }}"
                                       class="form-control custom-form-control bg-info d-none" disabled>
                            </div>
                        </div>
                        <div class="col-md-12 d-none">
                            <label>isValidateNID &nbsp;</label>
                            <div class="form-group">
                                <input type="text"
                                       id="is_validate_nid"
                                       name="is_validate_nid"
                                       value=""
                                       class="form-control custom-form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="landless_type">{{ __('generic.landless_type') }}
                                    <span class="text-danger"> * </span>
                                </label>
                                <select class="form-control custom-form-control"
                                        name="landless_type"
                                        id="landless_type">
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    @foreach(\Modules\Landless\App\Models\Landless::LANDLESS_TYPE as $key=>$value)
                                        <option
                                            value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> {{ __('generic.gender') }}
                                    <span class="text-danger"> * </span>
                                </label>
                                <div class="position-relative d-flex">
                                    @foreach(\Modules\Landless\App\Models\Landless::GENDER as $key=>$value)
                                        <div
                                            class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input gender"
                                                   id="gender_{{ $key }}"
                                                   name="gender"
                                                   value="{{ $key }}">
                                            <label class="custom-control-label"
                                                   for="gender_{{ $key }}">
                                                {{ __('generic.'.$value) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_type"> {{ __('generic.submitted_papers') }}
                                    <span class="text-danger"> * </span>
                                </label>
                                <div class="row d-flex">
                                    @foreach(\Modules\Landless\App\Models\Landless::FILE_TYPE as $key=>$value)
                                        <div class="col-md-4 mb-1">
                                            <div class="form-control custom-form-control">
                                                <div
                                                    class="custom-control custom-radio custom-control-inline h-100"
                                                    style="padding: 5px 25px;margin-right: 0 !important;">
                                                    <input type="radio" class="custom-control-input"
                                                           id="file_type_{{ $key }}"
                                                           name="file_type"
                                                           value="{{ $key }}">
                                                    <label class="custom-control-label" style="font-size: 12px"
                                                           for="file_type_{{ $key }}">
                                                        {{ __('generic.'.$value) }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="attached_file">{{ __('generic.file_upload') }} </label>

                                <div class="input-group" style="height: 45px">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01"
                                              style="background: #50177c33;">
                                           <i class="fas fa-upload"></i>&nbsp; {{ __('generic.upload') }}
                                        </span>
                                    </div>
                                    <div class="custom-file" style="height: 45px">
                                        <input type="file"
                                               class="custom-file-input custom-form-control"
                                               name="attached_file"
                                               id="attached_file">
                                        <label class="custom-file-label" for="attached_file"
                                               style="height: 45px">
                                            {{ __('generic.no_file_chosen') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="father_name"> {{ __('generic.applicant_father_name') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="father_name"
                                               id="father_name"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="father_dob">{{ __('generic.date_of_birth') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                                   name="father_dob"
                                                   id="father_dob"
                                                   placeholder="{{ __('generic.select_date') }}"
                                                   value=""/>
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
                                        <label for="father_is_alive">&nbsp; </label>
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
                                                                   value="{{ $key }}">
                                                            <label class="custom-control-label"
                                                                   for="father_is_alive_{{ $key }}">
                                                                {{ __('generic.'.$value) }}
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
                                            for="mother_name">{{ __('generic.applicant_mother_name') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="mother_name"
                                               id="mother_name"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="mother_dob">{{ __('generic.date_of_birth') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                                   name="mother_dob"
                                                   id="mother_dob"
                                                   placeholder="{{ __('generic.select_date') }}"
                                                   value=""/>
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
                                        <label for="father_is_alive">&nbsp; </label>
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
                                                                   value="{{ $key }}">
                                                            <label class="custom-control-label"
                                                                   for="mother_is_alive_{{ $key }}">
                                                                {{ __('generic.'.$value) }}
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
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="spouse_name"
                                               id="spouse_name"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="spouse_dob">{{ __('generic.date_of_birth') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text"
                                                   class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                                   name="spouse_dob"
                                                   id="spouse_dob"
                                                   placeholder="{{ __('generic.select_date') }}"
                                                   value=""/>
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
                                        <label for="po_sho_mo">{{ __('generic.p_s_m') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="po_sho_mo"
                                               id="po_sho_mo"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="spouse_father">
                                            {{ __('generic.applicant_spouse_father_name') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="spouse_father"
                                               id="spouse_father"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="spouse_mother">
                                            {{ __('generic.applicant_spouse_mother_name') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="spouse_mother"
                                               id="spouse_mother"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="col-md-4 d-none">
                                    <div class="form-group">
                                        <label for="loc_division_bbs">{{ __('generic.division') }}
                                            <span class="text-danger"> * </span>
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
                                                        {{ $locDivision->bbs_code == '20' ? 'selected':'' }} >{{ $langBn ? $locDivision->title: $locDivision->title_en }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 d-none">
                                    <div class="form-group">
                                        <label for="loc_district_bbs">{{ __('generic.district') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <select class="form-control custom-form-control select2"
                                                name="loc_district_bbs"
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                                id="loc_district_bbs">
                                            <option value="">{{ __('generic.select_placeholder') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="loc_upazila_bbs">{{ __('generic.upazila') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <select class="form-control custom-form-control select2"
                                                name="loc_upazila_bbs"
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                                id="loc_upazila_bbs">
                                            <option value="">{{ __('generic.select_placeholder') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="loc_union_bbs">{{ __('generic.union') }} </label>
                                        <select class="form-control custom-form-control select2"
                                                name="loc_union_bbs"
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                                id="loc_union_bbs">
                                            <option value="">{{ __('generic.select_placeholder') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="village">{{ __('generic.village') }}
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="village"
                                               id="village"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="family_member_name">
                                            {{ __('generic.family_member_name') }}
                                        </label>
                                        <input type="text" class="form-control custom-form-control"
                                               name="family_member_name"
                                               id="family_member_name"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bosot_vita_details">
                                            {{ __('generic.bosot_vita_details') }}
                                        </label>
                                        <textarea class="form-control custom-form-control"
                                                  name="bosot_vita_details"
                                                  id="bosot_vita_details"
                                                  rows="2"></textarea>
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
                                                  rows="2"></textarea>
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
                                                  rows="2"></textarea>
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
                                                  rows="2"></textarea>
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
                                                  rows="2"></textarea>
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
                                                  rows="2"></textarea>
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" name="status" value="3"
                                    class="btn btn-success btn-lg form-submit px-5">{{ __('generic.apply') }}</button>
                        </div>
                    </div>
                    <div class="overlay" style="display: none">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
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
                        {{ __('generic.uploaded_file') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img
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

        em#father_is_alive-error {
            position: absolute;
            width: 160px;
            left: -13px;
            bottom: -31px;
        }

        .custom-file-input:lang(en) ~ .custom-file-label::after {
            content: "Browse";
            height: 43px;
        }

        em#mother_is_alive-error {
            position: absolute;
            width: 160px;
            bottom: -29px;
            left: -13px;
        }

        /***Sweet alert btn color change*/
        button.swal-button.swal-button--text {
            background: #440079;
        }
        button.swal-button.swal-button--text:hover{
            background: #8f09fc;
        }

    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
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
                "mobileBd",
                function (value, element) {
                    let regexp1 = /^(?:\+88|88)?(01[3-9]\d{8})$/i;
                    let regexp = /^(?:\+৮৮|৮৮)?(০১[৩-৯][০-৯]{8})$/i;
                    let re = new RegExp(regexp);
                    let re1 = new RegExp(regexp1);
                    return this.optional(element) || re.test(value) || re1.test(value);
                },
                "সঠিক মোবাইল নাম্বার লিখুন"
            );

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

            const editAddForm = $('.edit-add-form');
            editAddForm.validate({

                rules: {
                    fullname: {
                        required: true,
                        //pattern: /^[\s'\u0980-\u09ff]+$/,
                    },
                    mobile: {
                        required: true,
                        mobileBd: true,
                    },
                    email: {
                        required: true,
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
                    spouse_name: {
                        required: true,
                    },
                    spouse_dob: {
                        required: true,
                    },
                    po_sho_mo: {
                        required: true,
                    },
                    spouse_father: {
                        required: true,
                    },
                    spouse_mother: {
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
                    village: {
                        required: true,
                    },
                    family_member_name: {
                        required: false,
                    },
                    bosot_vita_details: {
                        required: false,
                    },
                    present_address: {
                        required: false,
                    },
                    gurdian_khasland_details: {
                        required: false,
                    },
                    nodi_vanga_family_details: {
                        required: false,
                    },
                    freedom_fighters_details: {
                        required: false,
                    },
                    khasland_details: {
                        required: false,
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
                        required: "{{ __('generic.field_is_required') }}",
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
                    spouse_name: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    spouse_dob: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    po_sho_mo: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    spouse_father: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    spouse_mother: {
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
                    village: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    family_member_name: {
                        required: false,
                    },
                    bosot_vita_details: {
                        required: false,
                    },
                    present_address: {
                        required: false,
                    },
                    gurdian_khasland_details: {
                        required: false,
                    },
                    nodi_vanga_family_details: {
                        required: false,
                    },
                    freedom_fighters_details: {
                        required: false,
                    },
                    khasland_details: {
                        required: false,
                    },
                },
                submitHandler: function (htmlForm) {
                    $('.overlay').show();

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
                            $('.overlay').hide();
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
                            /*$('#loc_upazila_bbs').html('');
                            $('#loc_upazila_bbs').html('<option value="">নির্বাচন করুন</option>');

                            $('#loc_union_bbs').html('');
                            $('#loc_union_bbs').html('<option value="">নির্বাচন করুন</option>');*/

                            $.each(response, function (key, value) {
                                $('#loc_upazila_bbs').append(
                                    '<option value="' + value.bbs_code + '">' + (langEn ? value.title_en : value.title) + '</option>'
                                );
                            });
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
                    //hideLoader();
                }
            }

            $('#loc_division_bbs').on('change', function () {
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

                    hideLoader();
                }
            });

            $('#loc_district_bbs').on('change', function () {
                loadUpazilas();
            });

            $('#loc_upazila_bbs').on('change', function () {
                showLoader();
                let upazilaBbcCode = $(this).val();
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
            });

            $('#attached_file').on('change', function () {
                let fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            if ($('#loc_division_bbs').val() != '') {
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
                            hideLoader();
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                }
                hideLoader();
            }

            setTimeout(function () {
                if ($('#loc_district_bbs').val() != '') {
                    showLoader();
                    loadUpazilas();
                    hideLoader();
                }
            }, 1000);


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
                    url: "{{ route('public.get-owners-info-from-nid-api') }}",
                    data: {
                        nid: nidNo,
                        date_of_birth: nidDoB
                    },
                    type: "POST",
                    success: function (response) {
                        console.log(response);
                        if (response.name !== undefined) {
                            $('#fullname').val(langEn ? response.name : response.name_bn);
                            $('#fullname').prop('readonly', true);
                            $('#identity_number').prop('readonly', true);
                            $('.date_of_birth').prop('readonly', true);
                            $('#is_validate_nid').val('validated');

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
                                    text: "{{ __('generic.off') }}",
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
            });

            $('.form-submit').on('click', function () {
                if ($('#identity_type_2').is(':checked') && $('#is_validate_nid').val() == '') {
                    swal({
                        title: '{{ __('generic.all_wrong') }}',
                        text: '{{ __('generic.first_verify_nid') }}',
                        buttons: {
                            text: "{{ __('generic.off') }}",
                        },
                        icon: "error",
                    })
                }
            });


            function setValid(n) {
                let value = $(n).val();

                if (value != null || value != '') {
                    $(n).valid();
                }
            }

            $('.flat-date').on('change', function () {
                setValid($(this));
            });

            $('#loc_upazila_bbs').on('change', function () {
                setValid($(this));
            });

        })();

    </script>
@endpush


