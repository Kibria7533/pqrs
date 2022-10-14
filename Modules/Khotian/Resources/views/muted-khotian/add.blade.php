@extends('voyager::master')
@section('page_title', 'খতিয়ান এন্ট্রি | ই-পর্চা - ই-পর্চা ম্যানেজমেন্ট সিস্টেম' )

@php
    $edit = !empty($batch->id);
@endphp

@section('content')

    <div class="alert alert-success alert-block" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" style="color:red;"><span class="color-red">×</span>
        </button>
        <strong></strong>
    </div>


    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="d-none" id="hidden-fields-area">
                            <input type="text" class="form-control" id="owner-verified" value="">
                            <input type="text" class="form-control" id="owner-edit-array" value="">
                            <input type="text" class="form-control" id="dag-edit-array" value="">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="heading-2" style="background: #8dc542">
                                            <p class="mb-0 text-white">
                                                <i class="fa fa-gift" aria-hidden="true"></i> খতিয়ান এন্ট্রি
                                                <a class="collapsed" role="button" data-toggle="collapse"
                                                   href="#collapse-2"
                                                   aria-expanded="false" aria-controls="collapse-2">
                                                </a>
                                            </p>
                                        </div>
                                        <div id="collapse-2" class="collapse show" data-parent="#accordion"
                                             aria-labelledby="heading-2">
                                            <div class="card-body">
                                                <form id="muted_khotian_add_edit"
                                                      action="{{ route('admin.khotians.entry.store') }}"
                                                      method="POST"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="application_id"
                                                           value="{{ \Illuminate\Support\Facades\Crypt::encrypt($mutedKhotianInfoData['application_id']) }}">
                                                    <div class="row">

                                                        @if(!empty($mutedKhotianInfoData))
                                                            <div class="col-md-3 m-0">
                                                                <div class="form-group">
                                                                    <label for="division_bbs_code">
                                                                        বিভাগ
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="hidden" class="form-control"
                                                                           name="division_bbs_code"
                                                                           value="{{ $mutedKhotianInfoData['division_bbs_code'] }}"
                                                                           id="division_bbs_code" readonly>
                                                                    <input type="text" class="form-control"
                                                                           value="{{ $mutedKhotianInfoData['division_title']}}"
                                                                           readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 m-0">
                                                                <div class="form-group">
                                                                    <label for="district_bbs_code">
                                                                        জেলা
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="hidden" class="form-control"
                                                                           name="district_bbs_code"
                                                                           value="{{ $mutedKhotianInfoData['district_bbs_code'] }}"
                                                                           id="district_bbs_code" readonly>
                                                                    <input type="text" class="form-control"
                                                                           value="{{ $mutedKhotianInfoData['district_title']}}"
                                                                           readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 m-0">
                                                                <div class="form-group">
                                                                    <label for="upazila_bbs_code">
                                                                        উপজেলা
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="hidden" class="form-control"
                                                                           name="upazila_bbs_code"
                                                                           value="{{ $mutedKhotianInfoData['upazila_bbs_code'] }}"
                                                                           id="upazila_bbs_code" readonly>
                                                                    <input type="text" class="form-control"
                                                                           value="{{ $mutedKhotianInfoData['upazila_title']}}"
                                                                           readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 m-0">
                                                                <div class="form-group">
                                                                    <label for="loc_all_mouja_id">
                                                                        মৌজা
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="hidden" class="form-control"
                                                                           name="loc_all_mouja_id"
                                                                           value="{{ $mutedKhotianInfoData['jl_number'] }}"
                                                                           id="loc_all_mouja_id" readonly>
                                                                    <input type="text" class="form-control"
                                                                           value="{{ $mutedKhotianInfoData['mouja_title']}}"
                                                                           readonly>
                                                                </div>
                                                            </div>

                                                        @else
                                                            <div class="col-md-3 m-0">
                                                                <div class="form-group">
                                                                    <label for="division_bbs_code">
                                                                        বিভাগ
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <select class="form-control select2"
                                                                            name="division_bbs_code"
                                                                            id="division_bbs_code">
                                                                        <option value="">নির্বাচন করুণ</option>
                                                                        @foreach($locDivisions as $locDivision)
                                                                            <option
                                                                                value="{{ $locDivision->bbs_code }}">{{ $locDivision->title }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 m-0">
                                                                <div class="form-group">
                                                                    <label for="district_bbs_code">
                                                                        জেলা
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <select class="form-control select2"
                                                                            name="district_bbs_code"
                                                                            id="district_bbs_code" disabled>
                                                                        <option value="">নির্বাচন করুণ</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 m-0">
                                                                <div class="form-group">
                                                                    <label for="upazila_bbs_code">
                                                                        উপজেলা
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <select class="form-control select2"
                                                                            name="upazila_bbs_code"
                                                                            id="upazila_bbs_code" disabled>
                                                                        <option value="">নির্বাচন করুণ</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 m-0">
                                                                <div class="form-group">
                                                                    <label for="loc_all_mouja_id">
                                                                        মৌজা
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <select class="form-control select2"
                                                                            name="loc_all_mouja_id"
                                                                            id="loc_all_mouja_id" disabled>
                                                                        <option value="">নির্বাচন করুণ</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif


                                                        <div class="col-md-3 m-0">
                                                            <div class="form-group">
                                                                <label for="jl_number">
                                                                    জে.এল নং
                                                                </label>
                                                                <input class="form-control"
                                                                       name="jl_number"
                                                                       value="{{ $mutedKhotianInfoData['jl_number']??'' }}"
                                                                       id="jl_number" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 m-0">
                                                            <div class="form-group">
                                                                <label for="khotian_number">
                                                                    খতিয়ান নং <span class="text-danger">*</span>
                                                                </label>
                                                                <input class="form-control"
                                                                       {{ $mutedKhotianInfoData['khotian_number']?'readonly':''}}
                                                                       name="khotian_number"
                                                                       value="{{ $mutedKhotianInfoData['khotian_number']??'' }}"
                                                                       id="khotian_number">
                                                            </div>
                                                        </div>


                                                        <div class="col-md-3 m-0">
                                                            <div class="form-group">
                                                                <label for="resa_no">
                                                                    রে.সা.নং
                                                                </label>
                                                                <input class="form-control"
                                                                       name="resa_no"
                                                                       id="resa_no">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 m-0">
                                                            <div class="form-group">
                                                                <label for="namjari_case_no">
                                                                    নামজারি মামলা নম্বর
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input class="form-control"
                                                                       name="namjari_case_no"
                                                                       id="namjari_case_no">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 m-0">
                                                            <div class="form-group">
                                                                <label for="case_date">
                                                                    মামলার তারিখ
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input class="form-control datepicker"
                                                                       name="case_date" autocomplete="off"
                                                                       id="case_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 m-0">
                                                            <div class="form-group">
                                                                <label for="has_dhara_yes">
                                                                    ধারা আছে ?
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <div
                                                                    style="padding: 3px 3px; height: 33.5px;">
                                                                    <div
                                                                        class="form-check form-check-inline">
                                                                        <input
                                                                            class="form-check-input has_dhara"
                                                                            type="radio"
                                                                            name="has_dhara"
                                                                            id="has_dhara_yes"
                                                                            value="1">
                                                                        <label
                                                                            class="form-check-label"
                                                                            for="has_dhara_yes">
                                                                            হ্যাঁ
                                                                        </label>
                                                                    </div>
                                                                    <div
                                                                        class="form-check form-check-inline">
                                                                        <input
                                                                            class="form-check-input has_dhara"
                                                                            type="radio"
                                                                            name="has_dhara"
                                                                            id="has_dhara_no"
                                                                            value="0">
                                                                        <label
                                                                            class="form-check-label"
                                                                            for="has_dhara_no">
                                                                            না
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 m-0 d-none" id="dhara_no_area">
                                                            <div class="form-group">
                                                                <label for="dhara_no">
                                                                    ধারা নং
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input class="form-control"
                                                                       name="dhara_no" disabled
                                                                       id="dhara_no">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 m-0 d-none" id="dhara_year_area">
                                                            <div class="form-group">
                                                                <label for="dhara_year">
                                                                    ধারার বছর
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input class="form-control"
                                                                       name="dhara_year" disabled
                                                                       id="dhara_year">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 m-0">
                                                            <div class="form-group">
                                                                <label for="mokoddoma_no">
                                                                    মোকদ্দমা নং
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input class="form-control"
                                                                       name="mokoddoma_no"
                                                                       id="mokoddoma_no">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 m-0">
                                                            <div class="form-group">
                                                                <label for="revenue">
                                                                    রাজস্ব
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input class="form-control"
                                                                       name="revenue"
                                                                       id="revenue">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 m-0">
                                                            <div class="form-group">
                                                                <label for="dcr_number">
                                                                    ডিসিআর নম্বর
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input class="form-control"
                                                                       name="dcr_number"
                                                                       value=""
                                                                       id="dcr_number">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 m-0">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="d-block rounded">
                                                                            <h5>
                                                                                খতিয়ান সম্পর্কিত তথ্যাদি প্রদান করুন :
                                                                            </h5>
                                                                        </label>
                                                                        <div class="row border p-2 rounded">
                                                                            <div class="col-md-6 row m-0 owner-area">
                                                                                <div
                                                                                    id="dag-items"
                                                                                    class="form-group">
                                                                                    <div
                                                                                        class="row border rounded ownerDetails">
                                                                                        <div class="col-md-3 m-0">
                                                                                            <div
                                                                                                class="form-group round py-2">
                                                                                                <input
                                                                                                    type="hidden"
                                                                                                    class="form-control"
                                                                                                    id="owner_sl_no"
                                                                                                    name="owner_sl_no"
                                                                                                    disabled>
                                                                                                <label for="owner_no">
                                                                                                    মালিক নং</label>
                                                                                                <input
                                                                                                    class="form-control"
                                                                                                    id="owner_no"
                                                                                                    name="owner_no"
                                                                                                    value="{{ en2bn(1) }}"
                                                                                                    readonly>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-9 m-0">
                                                                                            <div
                                                                                                class="form-group round py-2">
                                                                                                <label>
                                                                                                    পরিচয়ের ধরণ
                                                                                                </label>
                                                                                                <div
                                                                                                    style="padding: 3px 3px; height: 33.5px;">

                                                                                                    @foreach(\Module\Khatian\Models\MutedKhotian::OWNER_IDENTITY_TYPE as $key=>$value)
                                                                                                        <div
                                                                                                            class="form-check form-check-inline">
                                                                                                            <input
                                                                                                                class="form-check-input identity_type"
                                                                                                                type="radio"
                                                                                                                name="identity_type"
                                                                                                                id="identity_type_{{ !empty($key)? \Module\Khatian\Models\MutedKhotian::IDENTITY_TYPE[$key]:'' }}"
                                                                                                                value="{{ $key }}"
                                                                                                                {{ !empty($key)? (\Module\Khatian\Models\MutedKhotian::IDENTITY_TYPE[$key]==='nid'?'checked':''):'' }}>
                                                                                                            <label
                                                                                                                class="form-check-label"
                                                                                                                for="identity_type_{{ !empty($key)? \Module\Khatian\Models\MutedKhotian::IDENTITY_TYPE[$key]:'' }}">
                                                                                                                {{ $value }}
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    @endforeach

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 m-0"
                                                                                             id="owner-nid-area">
                                                                                            <div class="row">
                                                                                                <div
                                                                                                    class="form-group col-md-6 m-0">
                                                                                                    <label
                                                                                                        for="identity_number">
                                                                                                        পরিচয়
                                                                                                        নম্বরঃ<span
                                                                                                            class="text-danger">*</span>
                                                                                                    </label>
                                                                                                    <input type="text"
                                                                                                           name="identity_number"
                                                                                                           id="identity_number"
                                                                                                           class="form-control identity_number"
                                                                                                           required>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="form-group col-md-4 m-0">
                                                                                                    <label for="dob">জন্ম
                                                                                                        তারিখঃ</label>
                                                                                                    <input type="date"
                                                                                                           name="dob"
                                                                                                           id="dob"
                                                                                                           class="form-control"
                                                                                                           required>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="form-group col-md-2 m-0">
                                                                                                    <label>&nbsp;</label>
                                                                                                    <input
                                                                                                        id="user_check_submit"
                                                                                                        class="form-control"
                                                                                                        type="button"
                                                                                                        value="যাচাই"
                                                                                                        style="float: right; padding: 10px; background-color: #72BE44; color: #fff; border: none; cursor: pointer;"/>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-6 m-0">
                                                                                            <div
                                                                                                class="form-group round py-2">
                                                                                                <label for="owner_name">
                                                                                                    মালিক, অকৃষি বা
                                                                                                    ইজারাদারের
                                                                                                    নাম <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input
                                                                                                    class="form-control"
                                                                                                    id="owner_name"
                                                                                                    name="owner_name">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 m-0">
                                                                                            <div
                                                                                                class="form-group round py-2">
                                                                                                <label
                                                                                                    for="guardian">
                                                                                                    অভিভাবকের ধরণ
                                                                                                    <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <div
                                                                                                    style="padding: 3px 3px; height: 33.5px;">
                                                                                                    <div
                                                                                                        class="form-check form-check-inline">
                                                                                                        <input
                                                                                                            class="form-check-input guardian_type"
                                                                                                            type="radio"
                                                                                                            name="guardian_type"
                                                                                                            id="guardian_type_father"
                                                                                                            value="1">
                                                                                                        <label
                                                                                                            class="form-check-label"
                                                                                                            for="guardian_type_father">
                                                                                                            পিতা
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="form-check form-check-inline">
                                                                                                        <input
                                                                                                            class="form-check-input guardian_type"
                                                                                                            type="radio"
                                                                                                            name="guardian_type"
                                                                                                            id="guardian_type_husband"
                                                                                                            value="0">
                                                                                                        <label
                                                                                                            class="form-check-label"
                                                                                                            for="guardian_type_husband">
                                                                                                            স্বামী
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-6 m-0">
                                                                                            <div
                                                                                                class="form-group round py-2">
                                                                                                <label
                                                                                                    for="guardian">
                                                                                                    অভিভাবকের নাম
                                                                                                    <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input
                                                                                                    class="form-control"
                                                                                                    id="guardian"
                                                                                                    name="guardian">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 m-0">
                                                                                            <div
                                                                                                class="form-group round py-2">
                                                                                                <label
                                                                                                    for="mother_name">
                                                                                                    মাতার নাম
                                                                                                </label>
                                                                                                <input
                                                                                                    class="form-control"
                                                                                                    id="mother_name"
                                                                                                    name="mother_name">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 m-0">
                                                                                            <div
                                                                                                class="form-group round py-2">
                                                                                                <label
                                                                                                    for="owner_area">
                                                                                                    অংশ <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input
                                                                                                    class="form-control"
                                                                                                    id="owner_area"
                                                                                                    name="owner_area"
                                                                                                    onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : (event.charCode == 46 ? !event.target.value.match(/\./) : (event.charCode >= 48 && event.charCode <= 57))"
                                                                                                    step="any"/>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 m-0">
                                                                                            <div
                                                                                                class="form-group round py-2">
                                                                                                <label
                                                                                                    for="owner_group">
                                                                                                    গ্রুপ
                                                                                                </label>
                                                                                                <input
                                                                                                    class="form-control"
                                                                                                    id="owner_group"
                                                                                                    name="owner_group"
                                                                                                    value="1">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 m-0">
                                                                                            <div
                                                                                                class="form-group round py-2">
                                                                                                <label
                                                                                                    for="owner_mobile">
                                                                                                    মোবাইল নম্বর
                                                                                                </label>
                                                                                                <input
                                                                                                    class="form-control"
                                                                                                    id="owner_mobile"
                                                                                                    autocomplete="nope"
                                                                                                    name="owner_mobile">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 m-0">
                                                                                            <div
                                                                                                class="form-group round py-2">
                                                                                                <label
                                                                                                    for="owner_address">
                                                                                                    ঠিকানা (সাং ) <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <textarea
                                                                                                    class="form-control"
                                                                                                    rows="1"
                                                                                                    id="owner_address"
                                                                                                    name="owner_address"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="col-md-12 m-0">
                                                                                    <div class=""
                                                                                         role="group"
                                                                                         aria-label="Basic example">

                                                                                        <a id="owner-add-more"
                                                                                           class="btn btn-success">
                                                                                            <i class="fa fa-plus-circle"></i>
                                                                                            মালিক যোগ করুন</a>

                                                                                        <a id="owner-entry-enable"
                                                                                           class="btn btn-warning d-none">
                                                                                            <i class="fa fa-repeat"></i>
                                                                                            মালিক যোগ সচল করুন </a>

                                                                                        <a id="owner-update"
                                                                                           class="btn btn-success d-none">
                                                                                            <i class="fa fa-check-square"></i>
                                                                                            মালিক আপডেট করুন </a>

                                                                                        <a class="btn btn-info"
                                                                                           id="owner-entry-finish">
                                                                                            <i class="fa fa-check-circle"
                                                                                               aria-hidden="true"></i>
                                                                                            মালিক এন্ট্রি সমাপ্ত করুন
                                                                                        </a>


                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 m-0"
                                                                                 id="owner-table-area">
                                                                                <table
                                                                                    class="table table-striped"
                                                                                    id="owner-table">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th scope="col">মালিক নং</th>
                                                                                        <th scope="col">মালিক, অকৃষি বা
                                                                                            ইজারাদারের নাম
                                                                                        </th>
                                                                                        <th scope="col">পিতা / স্বামী
                                                                                        </th>
                                                                                        <th scope="col">মাতার নাম</th>
                                                                                        <th scope="col">অংশ</th>
                                                                                        <th scope="col">জন্ম তারিখ</th>
                                                                                        <th scope="col">পদক্ষেপ</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="d-block rounded">
                                                                            <h5>
                                                                                দাগ সম্পর্কিত তথ্যাদি প্রদান করুন :
                                                                            </h5>
                                                                        </label>
                                                                        <div class="row border p-2 rounded">
                                                                            <div class="col-md-6 row m-0">

                                                                                <div class="col-md-12 m-0">
                                                                                    <div
                                                                                        id="dag-items"
                                                                                        class="form-group">
                                                                                        <div
                                                                                            class="row border rounded dagDetails">
                                                                                            <div class="col-md-6 m-0">
                                                                                                <div
                                                                                                    class="form-group round py-2">
                                                                                                    <label
                                                                                                        for="dag_number">
                                                                                                        দাগ নং
                                                                                                        <span
                                                                                                            class="text-danger">*</span>
                                                                                                    </label>
                                                                                                    <input
                                                                                                        type="hidden"
                                                                                                        class="form-control"
                                                                                                        id="dag_sl_no"
                                                                                                        name="dag_sl_no"
                                                                                                        disabled>
                                                                                                    <input
                                                                                                        class="form-control"
                                                                                                        name="dag_number"
                                                                                                        id="dag_number">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6 m-0">
                                                                                                <div
                                                                                                    class="form-group round py-2">
                                                                                                    <label
                                                                                                        for="land_owner_type_id">
                                                                                                        মালিকের ধরণ
                                                                                                        <span
                                                                                                            class="text-danger">*</span>
                                                                                                    </label>
                                                                                                    <select
                                                                                                        class="form-control"
                                                                                                        id="land_owner_type_id"
                                                                                                        name="land_owner_type_id">
                                                                                                        <option
                                                                                                            value="">
                                                                                                            নির্বাচন
                                                                                                            করুন
                                                                                                        </option>
                                                                                                        @foreach(\Module\Khatian\Models\MutedKhotian::OWNER_TYPE as $key=>$value)
                                                                                                            <option
                                                                                                                value="{{ $key }}">
                                                                                                                {{ $value }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-12 m-0">
                                                                                                <div class="row">
                                                                                                    <div
                                                                                                        class="col-md-6">
                                                                                                        <div
                                                                                                            class="form-group round">
                                                                                                            <label
                                                                                                                for="ag_land_type_changer"
                                                                                                                style="width: 50px">কৃষি </label>
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                onkeypress="return event.charCode >= 48"
                                                                                                                min="1"
                                                                                                                max="1124"
                                                                                                                name="ag_land_type_changer"
                                                                                                                id="ag_land_type_changer"
                                                                                                                autocomplete="off"
                                                                                                                class="form-control">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-md-6">
                                                                                                        <div
                                                                                                            class="form-group round">
                                                                                                            <label
                                                                                                                style="width: 50px">শ্রেণী </label>
                                                                                                            <select
                                                                                                                name="ag_land_type"
                                                                                                                id="ag_land_type"
                                                                                                                class="form-control"
                                                                                                                tabindex="-1"
                                                                                                                title="">
                                                                                                                <option
                                                                                                                    value="">
                                                                                                                    নির্বাচন
                                                                                                                    করুন
                                                                                                                </option>

                                                                                                                @foreach(\Module\Khatian\Models\MutedKhotian::LAND_TYPE as $key=>$value)
                                                                                                                    <option
                                                                                                                        value="{{ $key }}">
                                                                                                                        {{ $value }}
                                                                                                                    </option>
                                                                                                                @endforeach
                                                                                                            </select>
                                                                                                        </div>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-12 m-0">
                                                                                                <div class="row">
                                                                                                    <div
                                                                                                        class="col-md-6 m-0">
                                                                                                        <div
                                                                                                            class="form-group round">
                                                                                                            <label
                                                                                                                for="non_ag_land_type_changer"
                                                                                                                style="width: 50px">অকৃষি </label>
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                onkeypress="return event.charCode >= 48"
                                                                                                                min="1"
                                                                                                                max="1124"
                                                                                                                name="non_ag_land_type_changer"
                                                                                                                id="non_ag_land_type_changer"
                                                                                                                autocomplete="off"
                                                                                                                class="form-control"
                                                                                                                aria-invalid="false">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-md-6 m-0">
                                                                                                        <div
                                                                                                            class="form-group round">
                                                                                                            <label
                                                                                                                style="width: 50px">শ্রেণী </label>
                                                                                                            <select
                                                                                                                name="non_ag_land_type"
                                                                                                                id="non_ag_land_type"
                                                                                                                class="form-control"
                                                                                                                tabindex="-1"
                                                                                                                title="">
                                                                                                                <option
                                                                                                                    value="">
                                                                                                                    নির্বাচন
                                                                                                                    করুন
                                                                                                                </option>
                                                                                                                @foreach(\Module\Khatian\Models\MutedKhotian::LAND_TYPE as $key=>$value)
                                                                                                                    <option
                                                                                                                        value="{{ $key }}">
                                                                                                                        {{ $value }}
                                                                                                                    </option>
                                                                                                                @endforeach
                                                                                                            </select>
                                                                                                        </div>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6 m-0">
                                                                                                <div
                                                                                                    class="form-group round py-2">
                                                                                                    <label
                                                                                                        for="total_dag_area">
                                                                                                        দাগে মোট জমির
                                                                                                        পরিমান
                                                                                                        <span
                                                                                                            class="text-danger">*</span>
                                                                                                    </label>
                                                                                                    <input
                                                                                                        class="form-control"
                                                                                                        id="total_dag_area"
                                                                                                        name="total_dag_area">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6 m-0">
                                                                                                <div
                                                                                                    class="form-group round py-2">
                                                                                                    <label
                                                                                                        for="khotian_dag_area">
                                                                                                        অংশ <span
                                                                                                            class="text-danger">*</span>
                                                                                                    </label>
                                                                                                    <input
                                                                                                        class="form-control"
                                                                                                        type="text"
                                                                                                        id="khotian_dag_area"
                                                                                                        name="khotian_dag_area"
                                                                                                        onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : (event.charCode == 46 ? !event.target.value.match(/\./) : (event.charCode >= 48 && event.charCode <= 57))"
                                                                                                        step="any"/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6 m-0">
                                                                                                <div
                                                                                                    class="form-group round py-2">
                                                                                                    <label
                                                                                                        for="khotian_dag_portion">
                                                                                                        অংশ অনুযায়ী জমির
                                                                                                        পরিমান
                                                                                                    </label>
                                                                                                    <input
                                                                                                        class="form-control"
                                                                                                        id="khotian_dag_portion"
                                                                                                        name="khotian_dag_portion"
                                                                                                        value="0"
                                                                                                        readonly>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6 m-0">
                                                                                                <div
                                                                                                    class="form-group round py-2">
                                                                                                    <label
                                                                                                        for="motamot">
                                                                                                        মন্তব্য
                                                                                                    </label>
                                                                                                    <textarea
                                                                                                        id="motamot"
                                                                                                        name="motamot"
                                                                                                        rows="1"
                                                                                                        class="form-control"></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <a id="dag-add-more"
                                                                                       class="btn btn-success">
                                                                                        <i class="fa fa-plus-circle"></i>
                                                                                        আরো দাগ যোগ করুন</a>

                                                                                    <a id="dag-entry-enable"
                                                                                       class="btn btn-warning d-none">
                                                                                        <i class="fa fa-repeat"></i>
                                                                                        দাগ যোগ সচল করুন </a>

                                                                                    <a id="dag-update"
                                                                                       class="btn btn-success d-none">
                                                                                        <i class="fa fa-check-square"></i>
                                                                                        দাগ আপডেট করুন </a>

                                                                                    <a class="btn btn-info"
                                                                                       id="dag-entry-finish">
                                                                                        <i class="fa fa-check-circle"
                                                                                           aria-hidden="true"></i>
                                                                                        দাগ এন্ট্রি সমাপ্ত করুন
                                                                                    </a>
                                                                                </div>


                                                                            </div>
                                                                            <div class="col-md-6 m-0"
                                                                                 id="dag-table-area">
                                                                                <table
                                                                                    class="table table-striped"
                                                                                    id="dag-table">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th scope="col">দাগ নং</th>
                                                                                        <th scope="col">
                                                                                            জমির শ্রেনী
                                                                                        </th>
                                                                                        <th scope="col">দাগে মোট জমির
                                                                                            পরিমান
                                                                                        </th>
                                                                                        <th scope="col">অংশ
                                                                                        </th>
                                                                                        <th scope="col">অংশ অনুযায়ী জমির
                                                                                            পরিমান
                                                                                        </th>
                                                                                        <th scope="col">মন্তব্য</th>
                                                                                        <th scope="col">পদক্ষেপ</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="row border p-2 rounded">
                                                                            <div class="col-md-12 m-0 ">
                                                                                <label>
                                                                                    খতিয়ানের স্বাক্ষর
                                                                                    সমূহ :
                                                                                </label>
                                                                                <div class="row">
                                                                                    <div class="col-md-4 m-0 ">
                                                                                        <div
                                                                                            class="form-group p-4 rounded"
                                                                                            style="background: ghostwhite;">
                                                                                            <label for="signed1">
                                                                                                স্বাক্ষরিত - ১ <span
                                                                                                    class="text-danger">*</span>
                                                                                            </label>
                                                                                            <div class="form-group">
                                                                                                <input
                                                                                                    class="form-control mb-1"
                                                                                                    id="signature_one_name"
                                                                                                    name="signature_one_name"
                                                                                                    placeholder="নাম">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <input
                                                                                                    class="form-control mb-1 datepicker"
                                                                                                    type="text"
                                                                                                    id="signature_one_date"
                                                                                                    name="signature_one_date"
                                                                                                    autocomplete="off"
                                                                                                    placeholder="স্বাক্ষরের তারিখ (দিন-মাস-বছর)">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <select
                                                                                                    class="form-control mb-1"
                                                                                                    name="signature_one_designation"
                                                                                                    id="signature_one_designation">
                                                                                                    <option value="">
                                                                                                        পদবী
                                                                                                        নির্বাচন
                                                                                                        করুন
                                                                                                    </option>
                                                                                                    @foreach(\Module\Khatian\Models\MutedKhotian::SIGNATURE_DESIGNATION as $key=>$value)
                                                                                                        <option
                                                                                                            value="{{ $key }}">
                                                                                                            {{ $value }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 m-0 ">
                                                                                        <div
                                                                                            class="form-group p-4 rounded"
                                                                                            style="background: ghostwhite;">
                                                                                            <label for="signed-2">
                                                                                                স্বাক্ষরিত - ২ <span
                                                                                                    class="text-danger">*</span>
                                                                                            </label>
                                                                                            <div class="form-group">
                                                                                                <input
                                                                                                    class="form-control mb-1"
                                                                                                    id="signature_two_name"
                                                                                                    name="signature_two_name"
                                                                                                    placeholder="নাম">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <input
                                                                                                    class="form-control mb-1 datepicker"
                                                                                                    type="text"
                                                                                                    id="signature_two_date"
                                                                                                    name="signature_two_date"
                                                                                                    autocomplete="off"
                                                                                                    placeholder="স্বাক্ষরের তারিখ (দিন-মাস-বছর)">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <select
                                                                                                    class="form-control mb-1"
                                                                                                    name="signature_two_designation"
                                                                                                    id="signature_two_designation">
                                                                                                    <option value="">
                                                                                                        পদবী
                                                                                                        নির্বাচন
                                                                                                        করুন
                                                                                                    </option>
                                                                                                    @foreach(\Module\Khatian\Models\MutedKhotian::SIGNATURE_DESIGNATION as $key=>$value)
                                                                                                        <option
                                                                                                            value="{{ $key }}">
                                                                                                            {{ $value }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 m-0 ">
                                                                                        <div
                                                                                            class="form-group p-4 rounded"
                                                                                            style="background: ghostwhite;">
                                                                                            <label
                                                                                                for="exampleInputEmail1">
                                                                                                স্বাক্ষরিত - ৩ <span
                                                                                                    class="text-danger">*</span>
                                                                                            </label>
                                                                                            <div class="form-group">
                                                                                                <input
                                                                                                    class="form-control mb-1"
                                                                                                    id="signature_three_name"
                                                                                                    name="signature_three_name"
                                                                                                    placeholder="নাম">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <input
                                                                                                    class="form-control mb-1 datepicker"
                                                                                                    type="text"
                                                                                                    id="signature_three_date"
                                                                                                    name="signature_three_date"
                                                                                                    autocomplete="off"
                                                                                                    placeholder="স্বাক্ষরের তারিখ (দিন-মাস-বছর)">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <select
                                                                                                    class="form-control mb-1"
                                                                                                    name="signature_three_designation"
                                                                                                    id="signature_three_designation">
                                                                                                    {{-- <option value="">
                                                                                                        পদবী
                                                                                                        নির্বাচন
                                                                                                        করুন
                                                                                                    </option> --}}
                                                                                                    {{-- main code @foreach(\Module\Khatian\Models\MutedKhotian::SIGNATURE_DESIGNATION as $key=>$value)
                                                                                                        <option
                                                                                                            value="{{ $key }}">
                                                                                                            {{ $value }}
                                                                                                        </option>
                                                                                                    @endforeach --}}
                                                                                                    <option value="4" selected>
                                                                                                        সহকারী কমিশনার (ভূমি)
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-12">

                                                                                <div class="form-body">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="col-md-3 control-label">
                                                                                            <input type="checkbox"
                                                                                                   name="not_providable"
                                                                                                   id="not_providable"
                                                                                                   value="1"/> এই
                                                                                            খতিয়ানটি প্রদানযোগ্য নয়
                                                                                        </label>
                                                                                        <div class="col-md-10"
                                                                                             id="not_providable-reason"
                                                                                             style="display:none">
                                                                                            <select name="reasons[]"
                                                                                                    id="reasons"
                                                                                                    class="form-control"
                                                                                                    multiple size="10">
                                                                                                @foreach(\Module\Khatian\Models\MutedKhotian::NON_PROVIDABLE_REASONS as $key=>$value)
                                                                                                    <option
                                                                                                        value="{{ $key }}">
                                                                                                        {{ $value }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>

                                                                                            <span class="help-block">অপ্রদান এর কারন</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>


                                                                            <div class="col-md-6 m-0 ">
                                                                                <label for="exampleInputEmail1">
                                                                                    পূর্ববর্তী খতিয়ান সম্পর্কিত তথ্য :
                                                                                </label>
                                                                                <div class="form-group rounded"
                                                                                     style="background: ghostwhite;">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 m-0">
                                                                                            <div
                                                                                                class="form-group p-4 rounded"
                                                                                                style="background: ghostwhite;">
                                                                                                <label
                                                                                                    for="ref_khotian_number">
                                                                                                    রেফারেল খতিয়ান নং
                                                                                                    <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <input
                                                                                                    class="form-control mb-1"
                                                                                                    id="ref_khotian_number"
                                                                                                    name="ref_khotian_number"
                                                                                                    placeholder="রেফারেল খতিয়ান নং">
                                                                                            </div>

                                                                                        </div>
                                                                                        <div
                                                                                            class="col-md-6 m-0">
                                                                                            <div
                                                                                                class="form-group p-4 rounded"
                                                                                                style="background: ghostwhite;">
                                                                                                <label
                                                                                                    for="ref_khotian_type">
                                                                                                    খতিয়ানের ধরণ
                                                                                                    <span
                                                                                                        class="text-danger">*</span>
                                                                                                </label>
                                                                                                <select
                                                                                                    class="form-control mb-1 select2"
                                                                                                    id="ref_khotian_type"
                                                                                                    name="ref_khotian_type">
                                                                                                    <option value="">
                                                                                                        নির্বাচন করুন
                                                                                                    </option>
                                                                                                    @foreach(\App\Models\KhotianIndexs::SURVEY_TYPE as $key=>$value)
                                                                                                        <option
                                                                                                            value="{{ $key }}">
                                                                                                            {{ $value }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6 m-0 ">
                                                                                <label for="exampleInputEmail1">
                                                                                    খতিয়ানের স্ক্যান কপি সংযুক্ত করুন :
                                                                                </label>
                                                                                <div class="form-group p-4 rounded"
                                                                                     style="background: ghostwhite;">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="">
                                                                                                    খতিয়ানের স্ক্যান
                                                                                                    কপি <span class="text-danger">*</span>
                                                                                                </label>
                                                                                                <div
                                                                                                    class="input-group"
                                                                                                    id="scan_copy_div">
                                                                                                    <div
                                                                                                        class="custom-file">
                                                                                                        <input
                                                                                                            type="file"
                                                                                                            class="custom-file-input"
                                                                                                            id="scan_copy"
                                                                                                            name="scan_copy"
                                                                                                            onchange="changeFileName(event)">
                                                                                                        <label
                                                                                                            class="custom-file-label"
                                                                                                            for="scan_copy">Choose
                                                                                                            file</label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <p>১। খতিয়ান সংযুক্তির
                                                                                                ক্ষেত্রে স্ক্যান কপি
                                                                                                ফাইলটি
                                                                                                অবশ্যই jpg অথবা pdf
                                                                                                ফরমেটে হতে হবে।</p>
                                                                                            <p>২। pdf ফাইলের সাইজ
                                                                                                সর্বোচ্চ ২ মেগাবাইট হতে
                                                                                                হবে।</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 m-0">
                                                                    <div class="float-right"
                                                                         role="group"
                                                                         aria-label="Basic example">
                                                                        <button type="submit" name="draft" value="draft"
                                                                                class="btn btn-warning mx-2">
                                                                            <i class="fa fa-cloud"
                                                                               aria-hidden="true"></i>
                                                                            খসড়া করুন
                                                                        </button>
                                                                        <button type="submit"
                                                                                class="btn btn-info">
                                                                            পরবর্তী ধাপে প্রেরণ করুন
                                                                            <i class="fa fa-arrow-circle-right"
                                                                               aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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

    </div>


    <div id="loading-sniper"
         style="z-index: 99999; position: fixed; height: 100vh;width: 100%;top: 0px; left: 0; right: 0; bottom: 0px; background: rgba(0,0,0,.4); display: none; overflow: hidden;">
        <div class="holder" style="width: 200px;height: 200px;position: relative; margin: 10% auto;">
            <img src="/img/loading.gif" style="width: 75px;margin: 34%;">
        </div>
    </div>


@stop

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <style>
        .mb-0 > a {
            display: block;
            position: relative;
        }

        .mb-0 > a:after {
            content: "\f078"; /* fa-chevron-down */
            font-family: 'FontAwesome';
            position: absolute;
            right: 0;
            top: -20px;
            color: #fff;
        }

        .mb-0 > a[aria-expanded="true"]:after {
            content: "\f077"; /* fa-chevron-up */
        }

        .land-owner {
            margin: 0;
            border-radius: 7px;
            padding: 11px;
        }

        .land-owner-checkbox {
            margin: 0;
            border-radius: 7px;
            padding: 11px;
            border: 1px solid #f1f1f1;
        }

        label#land_owner_type_id-error {
            position: absolute;
            left: 16px;
            bottom: -32px;
            width: 106px;
        }

        /**
        *Input field backgraound shadow remove
        **/
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #ffffff inset !important;
        }
    </style>
    <style>
        #dataTable .btn-sm {
            padding: 3px 8px;
            margin: 0 2px;
            font-size: .8rem;
        }

        #select_all_application {
            transform: scale(1.5);
            margin-left: 5px;
        }

        #select_all_application:hover {
            cursor: pointer;
        }

        input[type="checkbox"] {
            cursor: pointer;
        }
    </style>
@endpush

@push('javascript')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.13.1/additional-methods.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        function showLoader() {
            $('#loading-sniper').show();
            $('body').css('overflow', 'hidden');
        }

        function changeFileName(event) {
            event.preventDefault();
            $(".custom-file-label").text('');
            $(".custom-file-label").text(event.target.files[0].name);
        }

        // TODO: to avoid double click in file button (arman)
        $("#scan_copy_div").click(function (event) {
            event = event || window.event;
            if (event.target.id != 'scan_copy') {
                scan_copy.click();
            }
        });

        $('#not_providable-reason').hide();
        $('#not_providable').click(function () {
            if ($(this).is(':checked')) {
                $('#not_providable-reason').show();
            }else{
                $('#not_providable-reason').hide();
            }

        });

        function hideLoader() {
            $('#loading-sniper').hide();
            $('body').css('overflow', 'auto');
        }

        jQuery.validator.addMethod("greaterThan",
            function (value, element, params) {

                if (!/Invalid|NaN/.test(new Date(value))) {
                    return new Date(value) >= new Date($(params).val());
                }

                return isNaN(value) && isNaN($(params).val())
                    || (Number(value) >= Number($(params).val()));
            });

        jQuery.validator.addMethod("decimalPoint",
            function (value, element, params) {
               // console.log('get', value, ' element ', element, ' params ', params);
                if (value.indexOf('.') != -1) {
                    console.log(value.split(".")[1].length);
                    if (value.split(".")[1].length > 4) {
                        return false;
                    }
                }
                return true;
            });

            jQuery.validator.addMethod("decimalPointOwner",
            function (value, element, params) {
               // console.log('get', value, ' element ', element, ' params ', params);
                if (value.indexOf('.') != -1) {
                    console.log(value.split(".")[1].length);
                    if (value.split(".")[1].length > 3) {
                        return false;
                    }
                }
                return true;
            });

            function dagOngshoCheck(value) {
                if (value.indexOf('.') != -1) {
                    console.log(value.split(".")[1].length);
                    if (value.split(".")[1].length > 4) {
                        return false;
                    }
                }
                return true;
            }

            function ownerOngshoCheck(value) {
                if (value.indexOf('.') != -1) {
                    console.log(value.split(".")[1].length);
                    if (value.split(".")[1].length > 3) {
                        return false;
                    }
                }
                return true;
            }


        /**
         * datepicker Configuration
         * **/
        $(function () {
            $('.datepicker').datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: '+0d'
            });
        });

        /**
         * Validate form
         * **/
        $.validator.addMethod(
            "mobileValidation",
            function (value, element) {
                let regexp1 = /^(?:\+88|88)?(01[3-9]\d{8})$/i;
                let regexp = /^(?:\+৮৮|৮৮)?(০১[৩-৯][০-৯]{8})$/i;
                let re = new RegExp(regexp);
                let re1 = new RegExp(regexp1);
                return this.optional(element) || re.test(value) || re1.test(value);
            },
            "আপনার সঠিক মোবাইল নাম্বার লিখুন"
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
            "সঠিক এন.আই.ডি ব্যবহার করুন [শুধুমাত্র ১০/১৭ সংখ্যার এন.আই.ডি প্রদান করুন] "
        );
        $.validator.addMethod(
            "birthRegNo",
            function (value, element) {
                let en = /^[0-9]*$/i;
                let bn = /^[০-৯]*$/i;
                let reEn = new RegExp(en);
                let reBn = new RegExp(bn);
                return this.optional(element) || reEn.test(value) || reBn.test(value);
            },
            "এখানে সঠিক জন্ম নিবন্ধন নম্বর লিখুন।"
        );

        if ($('#identity_type_nid').is(':checked')) {
            $.validator.addClassRules('identity_number', {
                required: true,
                nidBn: true,
            });
        }

        $("#muted_khotian_add_edit").validate({
            ignore: function () {
                if ($('#not_providable').prop('checked') == true) {
                    return ":not(#signature_one_name)";
                } else {
                    return "";
                }
            },
            errorElement: "em",
            onkeyup: false,
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                element.parents(".form-group").addClass("has-feedback");

                if (element.parents(".form-group").length) {
                    error.insertAfter(element.parents(".form-group").first().children().last());
                } else if (element.hasClass('select2') || element.hasClass('select2-ajax-custom') || element.hasClass('select2-ajax')) {
                    error.insertAfter(element.parents(".form-group").first().find('.select2-container'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                $(element).closest('.help-block').remove();
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
            },
            rules: {
                ref_khotian_type: {
                    required: true,
                },
                ref_khotian_number: {
                    required: true,
                },
                division_bbs_code: {
                    required: true,
                },
                district_bbs_code: {
                    required: true,
                },

                upazila_bbs_code: {
                    required: true,
                }, loc_all_mouja_id: {
                    required: true,
                },
                khotian_number: {
                    required: true,
                },
                jl_number: {
                    required: false,
                },
                resa_no: {
                    required: false,
                },
                namjari_case_no: {
                    required: true,
                },

                case_date: {
                    required: true,
                },
                has_dhara: {
                    required: true,
                },
                dhara_no: {
                    required: true,
                },
                dhara_year: {
                    required: true,
                    minlength: 4,
                    maxlength: 4,
                    //min: 1800,
                    //max: {{ \Carbon\Carbon::now()->format('Y') }},
                },
                mokoddoma_no: {
                    required: true,
                },
                revenue: {
                    required: true,
                    numberEnOrBn: true,
                },
                dcr_number: {
                    required: true,
                },
                land_owner_type_id: {
                    required: true,
                },
                ag_land_type_changer: {
                    min: 1,
                    max: 1124,
                },
                non_ag_land_type_changer: {
                    min: 1,
                    max: 1124,
                },
                identity_number: {
                    required: true,
                },
                dob: {
                    required: function () {
                        if ($('#identity_type_nid').is(':checked') == true) {
                            return true;
                        } else {
                            return false;
                        }
                    },
                },

                owner_name: {
                    required: true,
                },
                guardian: {
                    required: true,
                },
                guardian_type: {
                    required: true,
                },
                mother_name: {
                    required: false,
                },
                owner_area: {
                    required: true,
                    number: true,
                    decimalPointOwner:'#owner_area',
                    min: 0.000001,
                    max: function (e) {
                        if (Number(ownerAreaCount) == 0) {
                            return 1;
                        }
                        if (Number(ownerAreaCount) > 0) {
                            return 1.000001 - Number(ownerAreaCount);
                        }
                    },
                },
                owner_group: {
                    required: false,
                    //number: true,
                    //min: 1,
                    //step: 1,
                },
                owner_mobile: {
                    mobileValidation: true,
                },
                owner_address: {
                    required: true,
                },

                dag_number: {
                    required: true,
                    pattern: "^[0-9/]*$"
                },
                total_dag_area: {
                    required: true,
                    number: true,
                    min: 0.00000001,
                    // decimalPoint:"^\d*(\.\d{0,2})?$"
                    decimalPoint: "#total_dag_area"
                },
                khotian_dag_portion: {
                    /*required: true,
                    number: true,
                    pattern: "^\s*(?=.*[1-9])\d*(?:\.\d*)?\s*$",*/
                },
                khotian_dag_area: {
                    required: true,
                    number: true,
                    min: 0.000000001,
                    max: 1,
                },

                signature_one_name: {
                    required: true,
                },
                signature_one_date: {
                    required: true,

                },
                signature_one_designation: {
                    required: true,
                },

                signature_two_name: {
                    required: true,
                }, signature_two_date: {
                    required: true,
                    greaterThan: "#signature_one_date"
                }, signature_two_designation: {
                    required: true,
                },
                signature_three_name: {
                    required: true,
                },
                signature_three_date: {
                    required: true,
                    greaterThan: "#signature_one_date",
                    greaterThan: "#signature_two_date"
                },
                signature_three_designation: {
                    required: true,
                },
                scan_copy: {
                    required: true,
                    extension: 'jpg|pdf',
                },
            },
            messages: {
                ref_khotian_type: {
                    required: 'এখানে খতিয়ানের ধরণ প্রদান করুন।',
                },
                ref_khotian_number: {
                    required: 'এখানে রেফারেল খতিয়ান নং প্রদান করুন।',
                },
                division_bbs_code: {
                    required: "যেকোনো একটি বিভাগ নির্বাচন করুন।",
                },
                district_bbs_code: {
                    required: "যেকোনো একটি জেলা নির্বাচন করুন।",
                },

                upazila_bbs_code: {
                    required: "যেকোনো একটি উপজেলা নির্বাচন করুন।",
                },
                loc_all_mouja_id: {
                    required: "যেকোনো একটি মৌজা নির্বাচন করুন।",
                },
                khotian_number: {
                    required: "এখানে খতিয়ান নম্বর প্রদান করুন।",
                },
                jl_number: {},
                resa_no: {
                    required: "এখানে রে.সা.নং প্রদান করুন।",
                },
                namjari_case_no: {
                    required: "এখানে নামজারি মামলা নম্বর প্রদান করুন।",
                },
                case_date: {
                    required: "এখানে মামলার তারিখ প্রদান করুন।",
                },
                has_dhara: {
                    required: "যেকোনো একটি নির্বাচন করুন।",
                },
                dhara_no: {
                    required: "এখানে ধারা নং প্রদান করুন।",
                },
                dhara_year: {
                    required: "এখানে ধারার বছর প্রদান করুন।",
                    minlength: "কমপক্ষে 4 সংখ্যায় ধারার বছর প্রদান করুন।",
                    maxlength: "সর্বোচ্চ 4 সংখ্যায় ধারার বছর প্রদান করুন।",
                    //min: "ধারার বছর সর্বনিন্ম 1800 সাল প্রদান করুন।",
                    //max:"ধারার বছর সর্বোচ্চ {{ \Carbon\Carbon::now()->format('Y') }} সাল প্রদান করুন।",
                },
                mokoddoma_no: {
                    required: "এখানে মোকদ্দমা নং প্রদান করুন।",
                },
                revenue: {
                    required: "এখানে রাজস্ব উল্লেখ করুন।",
                    numberEnOrBn: "এখানে সঠিক রাজস্বের পরিমাণ উল্লেখ করুন।",
                },
                dcr_number: {
                    required: "এখানে ডিসিআর নম্বর উল্লেখ করুন।",
                },


                land_owner_type_id: {
                    required: "যেকোনো একটি নির্বাচন করুন।",
                },
                ag_land_type_changer: {
                    min: "কৃষি শ্রেণীর নম্বর 1 থেকে অধিক হতে হবে।",
                    max: 'কৃষি শ্রেণীর নম্বর সর্বোচ্চ 1124 প্রদান করুন।',
                },
                non_ag_land_type_changer: {
                    min: "কৃষি শ্রেণীর নম্বর 1 থেকে অধিক হতে হবে।",
                    max: 'কৃষি শ্রেণীর নম্বর সর্বোচ্চ 1124 প্রদান করুন।',
                },
                identity_number: {
                    required: "এখানে পরিচয় নম্বর প্রদান করুন।",
                },
                dob: {
                    required: "এখানে জন্ম তারিখ প্রদান করুন।",
                },

                owner_name: {
                    required: "এখানে মালিক, অকৃষি বা ইজারাদারের নাম প্রদান করুন।",
                },
                guardian_type: {
                    required: "যেকোনো একটি নির্বাচন করুন।",
                },
                guardian: {
                    required: "পিত/স্বামীর নাম উল্লেখ করুন।",
                },
                owner_area: {
                    required: "এখানে অংশের পরিমাণ লিখুন।",
                    number: "সঠিক অংশের পরিমাণ প্রদান করুন।",
                    min: "অংশের পরিমাণ ০ (শূন্য) থেকে অধিক হতে হবে।",
                    max: "সকল মালিকের মোট অংশের পরিমান সর্বোচ্চ এক(১)।",
                    decimalPointOwner:'দশমিকের পর ৩ সংখ্যার অধিক সংখ্যা নেয়া যাবে না।'
                },
                owner_group: {
                    number: "শুধু সংখ্যায় প্রদান করুন।",
                    min: "কমপক্ষে এক(১) সংখ্যা প্রদান করুন।",
                    step: "দয়া করে সঠিক সংখ্যা প্রদান করুন।",
                },
                owner_mobile: {
                    mobileValidation: 'এখানে সঠিক মোবাইল নাম্বার লিখুন।',
                },

                owner_address: {
                    required: "এখানে ঠিকানা প্রদান করুন।",
                },

                dag_number: {
                    required: "এখানে দাগ নং প্রদান করুন।",
                    pattern: 'শুধুমাত্র সংখ্যা বা সংখ্যা সহ "/" স্পেশাল ক্যারেক্টর ব্যবহার করুন। [ উদাহরণ: 120 বা 120/1 ]',
                },
                total_dag_area: {
                    required: "এখানে দাগে মোট জমির পরিমান উল্লেখ করুন।",
                    number: "এখানে সঠিক দাগে মোট জমির পরিমান উল্লেখ করুন।",
                    min: "দাগে মোট জমির পরিমান ০ (শূন্য) থেকে অধিক হতে হবে।",
                    decimalPoint: 'দশমিকের পর ৪ সংখ্যার অধিক সংখ্যা নেয়া যাবে না।'
                },

                khotian_dag_portion: {
                    required: "এখানে দাগে মোট জমির পরিমান উল্লেখ করুন।",
                    number: "এখানে অংশ অনুযায়ী সঠিক জমির পরিমান উল্লেখ করুন।",
                    pattern: "অংশ অনুযায়ী জমির পরিমান ০ (শূন্য) থেকে অধিক হতে হবে।"
                },

                khotian_dag_area: {
                    required: "এখানে অংশ উল্লেখ করুন।",
                    number: "সঠিক অংশ উল্লেখ করুন।",
                    min: "অংশের পরিমাণ ০ (শূন্য) থেকে অধিক হতে হবে।",
                    max: 'অংশের পরিমান সর্বোচ্চ এক(১) প্রদান করুন।',
                },

                signature_one_name: {
                    required: "এখানে স্বাক্ষরকারীর নাম লিখুন।",
                },
                signature_one_date: {
                    required: "এখানে স্বাক্ষরের তারিখ লিখুন।",
                },
                signature_one_designation: {
                    required: "এখানে স্বাক্ষরকারীর পদবী লিখুন।",
                },

                signature_two_name: {
                    required: "এখানে স্বাক্ষরকারীর নাম লিখুন।",
                }, signature_two_date: {
                    required: "এখানে স্বাক্ষরের তারিখ লিখুন।",
                    greaterThan: "স্বাক্ষরের তারিখ ভুল হয়েছে।",
                }, signature_two_designation: {
                    required: "এখানে স্বাক্ষরকারীর পদবী লিখুন।",
                },

                signature_three_name: {
                    required: "এখানে স্বাক্ষরকারীর নাম লিখুন।",
                }, signature_three_date: {
                    required: "এখানে স্বাক্ষরের তারিখ লিখুন।",
                    greaterThan: "স্বাক্ষরের তারিখ ভুল হয়েছে।",
                },
                signature_three_designation: {
                    required: "এখানে স্বাক্ষরকারীর পদবী লিখুন।",
                },
                scan_copy: {
                    required: "খতিয়ানের স্ক্যান কপি প্রদান করুন।",
                    extension: 'শুধুমাত্র পিডিএফ/জেপিজি ফাইল প্রদান করুন।',
                },
            },
            submitHandler: function (htmlForm) {
                /*let signatureOneName = $('#signature_one_name').val();
                let signatureTwoName = $('#signature_two_name').val();
                let signatureThreeName = $('#signature_three_name').val();

                if(signatureOneName ==''){
                    alert('pls provide signature_three_name');
                }
                if(signatureTwoName ==''){
                    alert('pls provide signature_two_name');
                }
                if(signatureThreeName ==''){
                    alert('pls provide signature_three_name');
                }*/

                showLoader();
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
                        hideLoader();
                    },
                });

                return false;
            }
        });

        let countOwner = 0;
        let hasOwner = 0;
        let hasDag = 0;
        let ownerAreaCount = 0;
        let alreadyAddedOwnerIdentityNo = [];
        let countDag = 0;
        let dagNoCount = [];
        let apiNID = null;
        let apiName = null;
        let apiDOB = null;

        let resetNidVerification = () => {
            $('#user_check_submit').prop('disabled', false);
            $('#owner-verified').val('');
        }

        $('#identity_number').on('change', function () {
            resetNidVerification();
        });

        $('#dob').on('change', function () {
            resetNidVerification();
        });

        $('#owner_name').on('change', function () {
            resetNidVerification();
        });

        function checkArrayValue(value, arr) {
            let status = false;

            for (let i = 0; i < arr.length; i++) {
                let name = arr[i];
                if (name == value) {
                    status = true;
                    break;
                }
            }
            return status;
        }

        /**
         * add/remove Owner
         * **/
        function ownerEdit(n) {
            let currentTrOwnerNo = $('#tbl_identity_type' + n).closest("tr").children('td:first').text();
            currentTrOwnerNo = currentTrOwnerNo.split(" ").join("");
            console.log('currentTrOwnerNo', currentTrOwnerNo);
            ownerFieldEnable();
            let identityType = $('#tbl_identity_type' + n).val();
            $('#owner-edit-array').val(n);

            $('#identity_number').val($('#tbl_identity_number' + n).val());
            $('#dob').val($('#tbl_dob' + n).val());

            if (identityType === '1') {
                $('#identity_type_birth_reg').prop('checked', true);
                $('#identity_type_nid').prop('checked', false);
                $('#identity_type_passport').prop('checked', false);
                $('#identity_type_no').prop('checked', false);

                $('#user_check_submit').addClass('d-none');
                $('#user_check_submit').prop('disabled', true);
            }
            if (identityType === '2') {
                $('#identity_type_birth_reg').prop('checked', false);
                $('#identity_type_nid').prop('checked', true);
                $('#identity_type_passport').prop('checked', false);
                $('#identity_type_no').prop('checked', false);

                $('#user_check_submit').removeClass('d-none');
                $('#user_check_submit').prop('disabled', false);

                $('#owner-verified').val('verified');
            }
            if (identityType === '3') {
                $('#identity_type_birth_reg').prop('checked', false);
                $('#identity_type_nid').prop('checked', false);
                $('#identity_type_passport').prop('checked', true);
                $('#identity_type_no').prop('checked', false);

                $('#user_check_submit').addClass('d-none');
                $('#user_check_submit').prop('disabled', true);
            }
            if (identityType === '4') {
                $('#identity_type_birth_reg').prop('checked', false);
                $('#identity_type_nid').prop('checked', false);
                $('#identity_type_passport').prop('checked', false);
                $('#identity_type_no').prop('checked', true);

                $('#user_check_submit').addClass('d-none');
                $('#user_check_submit').prop('disabled', true);
                $('#identity_number').prop('disabled', true);
                $('#identity_number').val('');
            }

            $('#owner_no').val(currentTrOwnerNo);
            $('#owner_name').val($('#tbl_owner_name' + n).val());

            let ownerGuardianTypeCheck = $('#tbl_guardian_type' + n).val();
            if (ownerGuardianTypeCheck === '1') {
                $('#guardian_type_father').prop('checked', true);
                $('#guardian_type_husband').prop('checked', false);
            }
            if (ownerGuardianTypeCheck === '0') {
                $('#guardian_type_father').prop('checked', false);
                $('#guardian_type_husband').prop('checked', true);
            }

            $('#guardian').val($('#tbl_guardian' + n).val());
            $('#mother_name').val($('#tbl_mother_name' + n).val());
            $('#owner_area').val($('#tbl_owner_area' + n).val());
            $('#owner_group').val($('#tbl_owner_group' + n).val());
            $('#owner_mobile').val($('#tbl_owner_mobile' + n).val());
            $('#owner_address').val($('#tbl_owner_address' + n).val());

            $('#owner-add-more').addClass('d-none');
            $('#owner-entry-finish').addClass('d-none');
            $('#owner-update').removeClass('d-none');
            $('#owner-update').addClass('owner-update-' + n);

            ownerAreaCount = ownerAreaCount - Number($('#tbl_owner_area' + n).val());
            console.log('new ownerAreaCount:', ownerAreaCount)
        }

        $('#owner-update').on('click', function (e) {
            let n = $('#owner-edit-array').val();

            if ($('#owner-verified').val() != 'verified' && $('#identity_type_nid').is(':checked')) {
                swal("জাতীয় পরিচয়পত্র যাচাই ভুল হয়েছে!", "সঠিক তথ্য দিয়ে আবার চেষ্টা করুন", "error");
            } else {
                let ownerNoEdit = bn2en($('#owner_no').val());
                let ownerNameEdit = $('#owner_name').val();
                let ownerGuardianTypeEdit = $("input[type='radio'].guardian_type:checked").val();
                let ownerGuardianEdit = $('#guardian').val();
                let ownerMotherNameEdit = $('#mother_name').val();
                let ownerAreaEdit = $('#owner_area').val();
                let ownerGroupEdit = bn2en($('#owner_group').val());
                let ownerMobileEdit = $('#owner_mobile').val();
                let ownerIdentityTypeEdit = $("input[type='radio'].identity_type:checked").val();
                let ownerIdentityNoEdit = $('#identity_number').val();

                let ownerOngsho=ownerOngshoCheck($('#owner_area').val());

                if (ownerIdentityTypeEdit === '4') {
                    ownerIdentityNoEdit = true;
                }

                let ownerDobEdit = '';
                if ($('#identity_type_nid').is(':checked') == false && $('#dob').val() == '') {
                    ownerDobEdit = true;
                } else {
                    ownerDobEdit = $('#dob').val();
                }

                let ownerAddressEdit = $('#owner_address').val();

                const index = alreadyAddedOwnerIdentityNo.indexOf($('#tbl_identity_number' + n).val());
                if (index > -1) {
                    alreadyAddedOwnerIdentityNo.splice(index, 1);
                }

                let ownerIdentityNumberAlreadyExistsEdit = false;
                console.log('identity number', alreadyAddedOwnerIdentityNo);
                if (alreadyAddedOwnerIdentityNo.indexOf(ownerIdentityNoEdit) !== -1) {
                    ownerIdentityNumberAlreadyExistsEdit = true;
                }

                if (ownerNameEdit && (ownerGuardianTypeEdit === '1' || ownerGuardianTypeEdit === '0') && ownerGuardianEdit && (Number(ownerAreaCount) + Number(ownerAreaEdit) <= 1 && Number(ownerAreaCount) + Number(ownerAreaEdit) > 0) && ownerAddressEdit && ownerDobEdit && ownerIdentityNoEdit && ownerIdentityNumberAlreadyExistsEdit == false && ownerOngsho !== false) {
                    let ownerDobCustom = '';
                    if (isNaN(ownerDobEdit) && !isNaN(Date.parse(ownerDobEdit))) {
                        ownerDobCustom = ownerDobEdit;
                    }

                    $('#tbl_owner_no' + n).val(ownerNoEdit);
                    $('#tbl_owner_name' + n).val(ownerNameEdit);
                    $('#tbl_guardian_type' + n).val(ownerGuardianTypeEdit);
                    $('#tbl_guardian' + n).val(ownerGuardianEdit);
                    $('#tbl_mother_name' + n).val(ownerMotherNameEdit);
                    $('#tbl_owner_area' + n).val(ownerAreaEdit);

                    $('#tbl_owner_group' + n).val(ownerGroupEdit);
                    $('#tbl_owner_mobile' + n).val(ownerMobileEdit);
                    $('#tbl_identity_type' + n).val(ownerIdentityTypeEdit);
                    $('#tbl_identity_number' + n).val(ownerIdentityNoEdit);
                    $('#tbl_dob' + n).val(ownerDobCustom);
                    $('#tbl_owner_address' + n).val(ownerAddressEdit);

                    $('#tbl_view_owner_no' + n).html(en2bn(ownerNoEdit));
                    $('#tbl_view_owner_name' + n).html(ownerNameEdit);
                    $('#tbl_view_guardian' + n).html(ownerGuardianEdit);
                    $('#tbl_view_mother_name' + n).html(ownerMotherNameEdit);
                    $('#tbl_view_owner_area' + n).html(ownerAreaEdit);
                    $('#tbl_view_owner_group' + n).html(ownerGroupEdit);
                    $('#tbl_view_owner_mobile' + n).html(ownerMobileEdit);
                    $('#tbl_view_identity_type' + n).html(ownerIdentityTypeEdit);
                    $('#tbl_view_identity_number' + n).html(ownerIdentityNoEdit);

                    $('#tbl_view_dob' + n).html(ownerDobCustom);
                    $('#tbl_view_owner_address' + n).html(ownerAddressEdit);

                    ownerAreaCount = Number(ownerAreaCount) + Number(ownerAreaEdit);

                    $('#owner-add-more').removeClass('d-none');
                    $('#owner-entry-finish').removeClass('d-none');
                    $('#owner-update').addClass('d-none');
                    $('#owner-edit-array').val('');

                    if (ownerIdentityTypeEdit != 4) {
                        alreadyAddedOwnerIdentityNo.push(ownerIdentityNoEdit);
                    }

                    console.log('alreadyAddedOwnerIdentityNo arr: ', alreadyAddedOwnerIdentityNo);
                    swal("মালিকের তথ্যাদি আপডেট করা হয়েছে!", "", "success");

                    resetOwnerFields();
                } else {
                    e.preventDefault();
                    $("#muted_khotian_add_edit").validate().element('#owner_name');
                    $("#muted_khotian_add_edit").validate().element('.guardian_type');
                    $("#muted_khotian_add_edit").validate().element('#guardian');
                    $("#muted_khotian_add_edit").validate().element('#owner_area');
                    $("#muted_khotian_add_edit").validate().element('#owner_address');

                    if ($('#identity_number').prop('disabled', false) == true) {
                        $("#muted_khotian_add_edit").validate().element('#identity_number');
                    }

                    $("#muted_khotian_add_edit").validate().element('#dob');

                    if (ownerIdentityNumberAlreadyExistsEdit) {
                        swal("এই মালিকের তথ্য ইতিমধ্যেই যোগ করা হয়েছে!", "অনুগ্রহ করে NID অথবা জন্ম নিবন্ধন অথবা পাসপোর্ট নম্বর পরিবর্তন ", "error");
                    }
                }
            }

        });

        function identityOwnerCheckedNid() {
            $('#identity_type_nid').prop('checked', true);
            $('#identity_type_birth_reg').prop('checked', false);
        }

        function identityOwnerCheckedBirthCertificate() {
            $('#identity_type_nid').prop('checked', false);
            $('#identity_type_birth_reg').prop('checked', true);


            $('#owner-nid-area').addClass('d-none');
            $('#owner-date-of-birth-area').removeClass('d-none');

            $('#owner_name').prop('readonly', false);
        }

        function resetOwnerFields() {
            identityOwnerCheckedNid();
            let ownerNoSl = hasOwner + 1;
            $('#owner_no').val(en2bn(ownerNoSl.toString()));

            $('#identity_number').val('');
            $('#identity_number').prop('readonly', false);
            $('#identity_number').prop('disabled', false);
            $('#dob').val('');
            $('#dob').prop('readonly', false);
            $('#user_check_submit').removeClass('d-none');
            $('#user_check_submit').prop('disabled', false);

            $('#owner_name').val('');
            $('#guardian_type_father').prop('checked', false);
            $('#guardian_type_husband').prop('checked', false);
            $('#guardian').val('');
            $('#mother_name').val('');
            $('#owner_area').val('');
            $('#owner_group').val('1');
            $('#owner_mobile').val('');
            $('#owner_address').val('');
            $('#owner-verified').val('');
        }

        function ownerDelete(n) {
            if ((hasOwner > 1) || (hasOwner >= 1 && hasDag == 0)) {
                console.log('hasOwner', hasOwner);
                console.log('ownerAreaCount', ownerAreaCount);
                const index = alreadyAddedOwnerIdentityNo.indexOf($('#tbl_identity_number' + n).val());
                if (index > -1) {
                    alreadyAddedOwnerIdentityNo.splice(index, 1);
                }
                hasOwner = hasOwner - 1;

                if (hasOwner == 0) {
                    ownerAreaCount = 0;
                } else {
                    ownerAreaCount = ownerAreaCount - $('#tbl_owner_area' + n).val();
                }

                console.log('hasOwner', hasOwner);
                console.log('ownerAreaCount', ownerAreaCount);


                $('#owner-delete' + n).closest('tr').remove();

                $("td.sno").each(function (index, element) {
                    let slNo = index + 1;
                    $(element).text(en2bn(slNo.toString()));
                });

                if ($('#owner-update').hasClass('d-none') == false) {
                    $('#owner-add-more').removeClass('d-none');
                    $('#owner-entry-finish').removeClass('d-none');
                    $('#owner-update').addClass('d-none');
                }
                resetOwnerFields();
                swal("মালিকের তথ্যাদি মুছে ফেলা হয়েছে!", "", "success");
            } else {
                swal("আগে সকল দাগ মুছে ফেলুন!", "", "error");
            }
        }

        $('#owner-add-more').on('click', function (e) {
            let nidOwnerVerified = $('#owner-verified').val();
            //let ownerNo = $('#owner_no').val();
            let ownerNo = hasOwner + 1;
            let ownerName = $('#owner_name').val();
            let ownerGuardianType = $("input[type='radio'].guardian_type:checked").val();
            let ownerGuardian = $('#guardian').val();
            let ownerMotherName = $('#mother_name').val();
            let ownerArea = $('#owner_area').val();
            let ownerGroup = bn2en($('#owner_group').val());
            let ownerMobile = $('#owner_mobile').val();
            let ownerIdentityType = $("input[type='radio'].identity_type:checked").val();

            let ownerIdentityNo = $('#identity_number').val();
            let ownerOngsho=ownerOngshoCheck($('#owner_area').val());// TODO:added area count(arman)

            if (ownerIdentityType === '4') {
                ownerIdentityNo = true;
            }
            let ownerDob = '';
            if ($('#identity_type_nid').is(':checked') == false && $('#dob').val() == '') {
                ownerDob = true;
            } else {
                ownerDob = $('#dob').val();
            }

            let ownerIdentityNumberAlreadyExists = false;
            if (alreadyAddedOwnerIdentityNo.indexOf(ownerIdentityNo) !== -1) {
                ownerIdentityNumberAlreadyExists = true;
            }

            let ownerAddress = $('#owner_address').val();

            if (nidOwnerVerified != 'verified' && $('#identity_type_nid').is(':checked')) {
                swal("জাতীয় পরিচয়পত্র যাচাই ভুল হয়েছে!", "সঠিক তথ্য দিয়ে আবার চেষ্টা করুন", "error");
            } else {
                if (ownerName && (ownerGuardianType === '1' || ownerGuardianType === '0') && ownerGuardian && (Number(ownerAreaCount) + Number(ownerArea) <= 1 && Number(ownerAreaCount) + Number(ownerArea) > 0) && ownerAddress && ownerDob && ownerIdentityNo && ownerIdentityNumberAlreadyExists == false && ownerOngsho !== false) {
                    ++countOwner;
                    let ownerDobCustom = '';
                    if (isNaN(ownerDob) && !isNaN(Date.parse(ownerDob))) {
                        ownerDobCustom = ownerDob;
                    }
                    $("#owner-table tbody").append(
                        '<tr>' +
                        '<input type="hidden" id="tbl_owner_no' + countOwner + '" name="owners[owner_no][' + countOwner + ']" value="' + ownerNo + '">' +
                        '<input type="hidden" id="tbl_owner_name' + countOwner + '" name="owners[owner_name][' + countOwner + ']" value="' + ownerName + '">' +
                        '<input type="hidden" id="tbl_guardian_type' + countOwner + '" name="owners[guardian_type][' + countOwner + ']" value="' + ownerGuardianType + '">' +
                        '<input type="hidden" id="tbl_guardian' + countOwner + '" name="owners[guardian][' + countOwner + ']" value="' + ownerGuardian + '">' +
                        '<input type="hidden" id="tbl_mother_name' + countOwner + '" name="owners[mother_name][' + countOwner + ']" value="' + ownerMotherName + '">' +
                        '<input type="hidden" id="tbl_owner_area' + countOwner + '" name="owners[owner_area][' + countOwner + ']" value="' + ownerArea + '">' +
                        '<input type="hidden" id="tbl_owner_group' + countOwner + '" name="owners[owner_group][' + countOwner + ']" value="' + ownerGroup + '">' +
                        '<input type="hidden" id="tbl_owner_mobile' + countOwner + '" name="owners[owner_mobile][' + countOwner + ']" value="' + ownerMobile + '">' +
                        '<input type="hidden" id="tbl_identity_type' + countOwner + '" name="owners[identity_type][' + countOwner + ']" value="' + ownerIdentityType + '">' +
                        '<input type="hidden" id="tbl_identity_number' + countOwner + '" name="owners[identity_number][' + countOwner + ']" value="' + ownerIdentityNo + '">' +
                        '<input type="hidden" id="tbl_dob' + countOwner + '" name="owners[dob][' + countOwner + ']" value="' + ownerDobCustom + '">' +
                        '<input type="hidden" id="tbl_owner_address' + countOwner + '" name="owners[owner_address][' + countOwner + ']" value="' + ownerAddress + '">' +
                        '<td style="vertical-align: middle;" class="sno">' +
                        '<span id="tbl_view_owner_no' + countOwner + '">' + en2bn(ownerNo.toString()) + '</span>' +
                        '</td>' +
                        '<td style="vertical-align: middle;"><span id="tbl_view_owner_name' + countOwner + '"> ' + ownerName + '</span></td>' +
                        '<td style="vertical-align: middle;"><span id="tbl_view_guardian' + countOwner + '"> ' + ownerGuardian + '</span></td>' +
                        '<td style="vertical-align: middle;"><span id="tbl_view_mother_name' + countOwner + '"> ' + ownerMotherName + '</span></td>' +
                        '<td style="vertical-align: middle;"><span id="tbl_view_owner_area' + countOwner + '"> ' + ownerArea + '</span></td>' +
                        '<td style="vertical-align: middle;"><span id="tbl_view_dob' + countOwner + '"> ' + ownerDobCustom + '</span></td>' +
                        '<td style="vertical-align: middle;">' +
                        '<div class="btn-group" role="group" aria-label="Basic example">' +
                        '<button type="button" class="btn btn-outline-info btn-group-sm" onclick="ownerEdit(' + countOwner + ')" id="owner-edit-' + countOwner + '">সম্পাদন</button>' +
                        '<button type="button" class="btn btn-outline-warning btn-group-sm" onclick="ownerDelete(' + countOwner + ')" id="owner-delete' + countOwner + '">মুছুন</button>' +
                        '</div>' +
                        '</tr>'
                    );

                    ownerNo = parseInt(ownerNo) + 1;
                    $('#owner_sl_no').val(en2bn(ownerNo.toString()));
                    ownerAreaCount = Number(ownerAreaCount) + Number(ownerArea);
                    if (ownerIdentityType !== '4') {
                        alreadyAddedOwnerIdentityNo.push(ownerIdentityNo);
                    }

                    hasOwner = hasOwner + 1;
                    swal("মালিকের তথ্যাদি যোগ করা হয়েছে!", "", "success");
                    resetOwnerFields();
                    console.log('hasOwner', hasOwner)

                } else {
                    e.preventDefault();
                    $("#muted_khotian_add_edit").validate().element('#owner_name');
                    $("#muted_khotian_add_edit").validate().element('.guardian_type');
                    $("#muted_khotian_add_edit").validate().element('#guardian');
                    $("#muted_khotian_add_edit").validate().element('#owner_area');
                    $("#muted_khotian_add_edit").validate().element('#owner_address');

                    if ($('#identity_number').prop('disabled', false) == true) {
                        $("#muted_khotian_add_edit").validate().element('#identity_number');
                    }
                    $("#muted_khotian_add_edit").validate().element('#dob');

                    if (ownerIdentityNumberAlreadyExists) {
                        swal("এই মালিকের তথ্য ইতিমধ্যেই যোগ করা হয়েছে!", "অনুগ্রহ করে NID অথবা জন্ম নিবন্ধন অথবা পাসপোর্ট নম্বর পরিবর্তন করুন ", "error");
                    }
                }

            }

        });

        let ownerFieldDisable = () => {
            $('#identity_type_nid').prop('disabled', true);
            $('#identity_type_birth_reg').prop('disabled', true);
            $('#identity_type_passport').prop('disabled', true);

            $('#identity_number').prop('disabled', true);
            $('#dob').prop('disabled', true);
            $('#user_check_submit').prop('disabled', true);


            $('#owner_no').prop('disabled', true);
            $('#owner_name').prop('disabled', true);
            $('#guardian_type_father').prop('disabled', true);
            $('#guardian_type_husband').prop('disabled', true);
            $('#guardian').prop('disabled', true);
            $('#mother_name').prop('disabled', true);
            $('#owner_area').prop('disabled', true);
            $('#owner_group').prop('disabled', true);
            $('#owner_mobile').prop('disabled', true);
            $('#identity_type').prop('disabled', true);
            $('#owner_address').prop('disabled', true);

            $('.ownerDetails').addClass('d-none');
            $('#owner-table-area').removeClass('col-md-6');
            $('#owner-table-area').addClass('col-md-12');
            $('#owner-add-more').addClass('d-none');
            $('#owner-entry-enable').removeClass('d-none');
            $('#owner-entry-finish').addClass('d-none');
        }
        let ownerFieldEnable = () => {
            $('#identity_type_nid').prop('disabled', false);
            $('#identity_type_birth_reg').prop('disabled', false);
            $('#identity_type_passport').prop('disabled', false);
            $('#identity_number').prop('disabled', false);
            $('#dob').prop('disabled', false);
            $('#user_check_submit').prop('disabled', false);
            $('#owner_no').prop('disabled', false);
            $('#owner_name').prop('disabled', false);
            $('#guardian_type_father').prop('disabled', false);
            $('#guardian_type_husband').prop('disabled', false);
            $('#guardian').prop('disabled', false);
            $('#mother_name').prop('disabled', false);
            $('#owner_area').prop('disabled', false);
            $('#owner_group').prop('disabled', false);
            $('#owner_mobile').prop('disabled', false);
            $('#identity_type').prop('disabled', false);
            $('#owner_address').prop('disabled', false);

            $('.ownerDetails').removeClass('d-none');
            $('#owner-table-area').removeClass('col-md-12');
            $('#owner-table-area').addClass('col-md-6');
            $('#owner-add-more').removeClass('d-none');
            $('#owner-entry-finish').removeClass('d-none');
            $('#owner-entry-enable').addClass('d-none');
        }

        $('#owner-entry-finish').on('click', function () {
            if (hasOwner === 0) {
                swal("কোনো মালিকের তথ্য যোগ করা হয়নি!", "কমপক্ষে একটি মালিক যোগ করুন!", "error");
            }
            else if(Number(ownerAreaCount)<1){
                swal("মালিকের মোট অংশ ভুল হয়েছে","মালিকের মোট অংশ ১ হতে হবে!", "error");
            }
            else {
                ownerFieldDisable();
            }
        });

        $('#owner-entry-enable').on('click', function () {
            ownerFieldEnable();
        });

        /**
         * Dags more item add/remove
         * **/

        function dagEdit(n) {
            dagEntryFieldsEnable();

            $('#dag-edit-array').val(n);

            $('#dag_number').prop('disabled', false);
            $('#land_owner_type_id').prop('disabled', false);
            $('#total_dag_area').prop('disabled', false);
            $('#khotian_dag_area').prop('disabled', false);
            $('#khotian_dag_portion').prop('disabled', false);
            $('#motamot').prop('disabled', false);

            $('#dag-add-more').addClass('d-none');
            $('#dag-entry-finish').addClass('d-none');
            $('#dag-update').removeClass('d-none');

            $('#dag_number').val($('#tbl_dag_number' + n).val());
            $('#land_owner_type_id').val($('#tbl_land_owner_type_id' + n).val());

            let tblAgriculturalUse = $('#tbl_agricultural_use' + n).val();
            if (tblAgriculturalUse === "1") {
                $('#ag_land_type_changer').prop('disabled', false);
                $('#ag_land_type').prop('disabled', false);

                $('#non_ag_land_type_changer').prop('disabled', true);
                $('#non_ag_land_type').prop('disabled', true);

                $('#ag_land_type_changer').val($('#tbl_agri_land_type' + n).val());
                $('#ag_land_type').val($('#tbl_agri_land_type' + n).val());
            } else {
                $('#ag_land_type_changer').prop('disabled', true);
                $('#ag_land_type').prop('disabled', true);

                $('#non_ag_land_type_changer').prop('disabled', false);
                $('#non_ag_land_type').prop('disabled', false);

                $('#non_ag_land_type_changer').val($('#tbl_non_agri_land_type' + n).val());
                $('#non_ag_land_type').val($('#tbl_non_agri_land_type' + n).val());
            }
            $('#khotian_dag_area').val($('#tbl_khotian_dag_area' + n).val());
            $('#total_dag_area').val($('#tbl_total_dag_area' + n).val());
            $('#khotian_dag_portion').val($('#tbl_khotian_dag_portion' + n).val());
            $('#motamot').val($('#tbl_remarks' + n).val());

        }

        $('#dag-update').on('click', function (e) {
            let n = $('#dag-edit-array').val();

            let isAgriculturalEdit = '';
            let agriLandTypeEdit = '';
            let nonAgriLandTypeEdit = '';
            if ($('#ag_land_type_changer').val() != '') {
                isAgriculturalEdit = 1;
                agriLandTypeEdit = $('#ag_land_type').val();
            } else if ($('#non_ag_land_type_changer').val() != '') {
                isAgriculturalEdit = 0;
                nonAgriLandTypeEdit = $('#non_ag_land_type').val();
            }

            let totalDagOngsho=dagOngshoCheck($('#total_dag_area').val()); // TODO: added

            let dagNumberEdit = $('#dag_number').val();
            let landOwnerTypeIdEdit = $('#land_owner_type_id').val();
            let khotianDagAreaEdit = $('#khotian_dag_area').val();
            let totalDagAreaEdit = $('#total_dag_area').val();
            let khotianDagPortionEdit = $('#khotian_dag_portion').val();
            let motamotEdit = $('#motamot').val();

            const indexDag = dagNoCount.indexOf($('#tbl_dag_number' + n).val());
            if (indexDag > -1) {
                dagNoCount.splice(indexDag, 1);
            }

            let dagNumberAlreadyExistsEdit = true;
            if (dagNoCount.indexOf(dagNumberEdit) !== -1) {
                dagNumberAlreadyExistsEdit = false;
            }
            if (dagNumberEdit && (khotianDagAreaEdit > 0 && khotianDagAreaEdit <= 1) && (!isNaN(totalDagAreaEdit) && totalDagAreaEdit > 0) && landOwnerTypeIdEdit && dagNumberAlreadyExistsEdit && totalDagOngsho !== false) {
                $('#tbl_dag_number' + n).val(dagNumberEdit);
                $('#tbl_land_owner_type_id' + n).val(landOwnerTypeIdEdit);
                $('#tbl_agricultural_use' + n).val(isAgriculturalEdit);
                $('#tbl_agri_land_type' + n).val(agriLandTypeEdit);
                $('#tbl_non_agri_land_type' + n).val(nonAgriLandTypeEdit);
                $('#tbl_total_dag_area' + n).val(totalDagAreaEdit);
                $('#tbl_khotian_dag_portion' + n).val(khotianDagPortionEdit);
                $('#tbl_khotian_dag_area' + n).val(khotianDagAreaEdit);
                $('#tbl_remarks' + n).val(motamotEdit);

                $('#tbl_view_dag_number' + n).html(dagNumberEdit);
                $('#tbl_view_agricultural_use' + n).html(isAgriculturalEdit ? 'কৃষি' : 'অকৃষি');
                $('#tbl_view_total_dag_area' + n).html(totalDagAreaEdit);
                $('#tbl_view_khotian_dag_area' + n).html(khotianDagAreaEdit);
                $('#tbl_view_khotian_dag_portion' + n).html(khotianDagPortionEdit);
                $('#tbl_view_remarks' + n).html(motamotEdit);

                $('#dag-add-more').removeClass('d-none');
                $('#dag-entry-finish').removeClass('d-none');
                $('#dag-update').addClass('d-none');
                dagNoCount.push(dagNumberEdit)
                console.log(dagNoCount);
                swal("দাগ আপডেট করা হয়েছে!", "", "success");
                resetDagFields();

            } else {
                e.preventDefault();
                $("#muted_khotian_add_edit").validate().element('#dag_number');
                $("#muted_khotian_add_edit").validate().element('#land_owner_type_id');
                $("#muted_khotian_add_edit").validate().element('#total_dag_area');
                $("#muted_khotian_add_edit").validate().element('#khotian_dag_area');

                if (dagNumberAlreadyExistsEdit == false) {
                    swal("এই দাগের তথ্য ইতিমধ্যেই যোগ করা হয়েছে!", "অনুগ্রহ করে নতুন দাগ প্রদান করুন!", "error");
                }
            }
        });

        function resetDagFields() {
            $('#dag_number').val('');
            $('#land_owner_type_id option:selected').removeAttr('selected');
            $('#land_owner_type_id option[value=""]').prop("selected", true);

            $('#ag_land_type_changer').val('');
            $('#ag_land_type_changer').prop('disabled', false);
            $('#ag_land_type').val('');
            $('#ag_land_type').prop('disabled', false);

            $('#non_ag_land_type_changer').val('');
            $('#non_ag_land_type_changer').prop('disabled', false);
            $('#non_ag_land_type').val('');
            $('#non_ag_land_type').prop('disabled', false);

            $('#total_dag_area').val('');
            $('#khotian_dag_area').val('');
            $('#khotian_dag_portion').val('');
            $('#motamot').val('');
        }

        function dagDelete(n) {
            const indexDag = dagNoCount.indexOf($('#tbl_dag_number' + n).val());
            if (indexDag > -1) {
                dagNoCount.splice(indexDag, 1);
            }
            $('#dag-delete' + n).closest('tr').remove();
            --hasDag;
            if ($('#dag-update').hasClass('d-none') == false) {
                $('#dag-add-more').removeClass('d-none');
                $('#dag-entry-finish').removeClass('d-none');
                $('#dag-update').addClass('d-none');
            }
            resetDagFields();
            swal("দাগের তথ্যাদি মুছে ফেলা হয়েছে!", "", "success");

            console.log('dagNoCount', dagNoCount)
        }

        $('#dag-add-more').on('click', function (e) {
            let isAgricultural = '';
            let agriLandType = '';
            let nonAgriLandType = '';
            if ($('#ag_land_type_changer').val() != '') {
                isAgricultural = 1;
                agriLandType = $('#ag_land_type').val();
            } else if ($('#non_ag_land_type_changer').val() != '') {
                isAgricultural = 0;
                nonAgriLandType = $('#non_ag_land_type').val();
            }

            let dagNumber = $('#dag_number').val();
            let landOwnerTypeId = $('#land_owner_type_id').val();
            let khotianDagArea = $('#khotian_dag_area').val();
            let totalDagArea = $('#total_dag_area').val();
            let khotianDagPortion = $('#khotian_dag_portion').val();
            let motamot = $('#motamot').val();

            let totalDagOngsho=dagOngshoCheck($('#total_dag_area').val()); // TODO: added

            let dagNumberAlreadyExists = true;
            if (dagNoCount.indexOf(dagNumber) !== -1) {
                dagNumberAlreadyExists = false;
            }

            if (dagNumber && (khotianDagArea > 0 && khotianDagArea <= 1) && (!isNaN(totalDagArea) && totalDagArea > 0) && landOwnerTypeId && dagNumberAlreadyExists && hasOwner > 0 && khotianDagPortion > 0 && totalDagOngsho !== false) {
                ++countDag;
                $("#dag-table tbody").append(
                    '<tr>' +
                    '<td style="vertical-align: middle;">' +
                    '<input type="hidden" id="tbl_dag_number' + countDag + '" name="dags[dag_number][' + countDag + ']" value="' + dagNumber + '">' +
                    '<input type="hidden" id="tbl_land_owner_type_id' + countDag + '" name="dags[land_owner_type_id][' + countDag + ']" value="' + landOwnerTypeId + '">' +
                    '<input type="hidden" id="tbl_agricultural_use' + countDag + '" name="dags[agricultural_use][' + countDag + ']" value="' + isAgricultural + '">' +
                    '<input type="hidden" id="tbl_agri_land_type' + countDag + '" name="dags[agri_land_type][' + countDag + ']" value="' + agriLandType + '">' +
                    '<input type="hidden" id="tbl_non_agri_land_type' + countDag + '" name="dags[non_agri_land_type][' + countDag + ']" value="' + nonAgriLandType + '">' +
                    '<input type="hidden" id="tbl_total_dag_area' + countDag + '" name="dags[total_dag_area][' + countDag + ']" value="' + totalDagArea + '">' +
                    '<input type="hidden" id="tbl_khotian_dag_portion' + countDag + '" name="dags[khotian_dag_portion][' + countDag + ']" value="' + khotianDagPortion + '">' +
                    '<input type="hidden" id="tbl_khotian_dag_area' + countDag + '" name="dags[khotian_dag_area][' + countDag + ']" value="' + khotianDagArea + '">' +
                    '<input type="hidden" id="tbl_remarks' + countDag + '" name="dags[remarks][' + countDag + ']" value="' + motamot + '">' +
                    '<span id="tbl_view_dag_number' + countDag + '"> ' + dagNumber + '</span></td>' +

                    '<td style="vertical-align: middle;"><span id="tbl_view_agricultural_use' + countDag + '"> ' + (isAgricultural ? "কৃষি" : "অকৃষি") + '</span></td>' +
                    '<td style="vertical-align: middle;"><span id="tbl_view_total_dag_area' + countDag + '"> ' + totalDagArea + '</span></td>' +
                    '<td style="vertical-align: middle;"><span id="tbl_view_khotian_dag_area' + countDag + '"> ' + khotianDagArea + '</span></td>' +
                    '<td style="vertical-align: middle;"><span id="tbl_view_khotian_dag_portion' + countDag + '"> ' + khotianDagPortion + '</span></td>' +
                    '<td style="vertical-align: middle;"><span id="tbl_view_remarks' + countDag + '"> ' + motamot + '</span></td>' +
                    '<td style="vertical-align: middle;">' +
                    '<div class="btn-group" role="group" aria-label="Basic example">' +
                    '<button type="button" class="btn btn-outline-info btn-group-sm" onclick="dagEdit(' + countDag + ')" id="dag-edit-' + countDag + '">সম্পাদন</button>' +
                    '<button type="button" class="btn btn-outline-warning btn-group-sm" onclick="dagDelete(' + countDag + ')" id="dag-delete' + countDag + '">মুছুন</button>' +
                    '</div>' +
                    '</tr>'
                );

                dagNoCount.push(dagNumber);
                $('#dag_sl_no').val(dagNumber);
                ++hasDag;
                swal("দাগের তথ্যাদি যোগ করা হয়েছে!", "", "success");
                resetDagFields();

            } else {
                e.preventDefault();
                $("#muted_khotian_add_edit").validate().element('#dag_number');
                $("#muted_khotian_add_edit").validate().element('#land_owner_type_id');
                $("#muted_khotian_add_edit").validate().element('#total_dag_area');
                $("#muted_khotian_add_edit").validate().element('#khotian_dag_area');
                $("#muted_khotian_add_edit").validate().element('#khotian_dag_portion');

                if (dagNumberAlreadyExists == false) {
                    swal("এই দাগের তথ্য ইতিমধ্যেই যোগ করা হয়েছে!", "অনুগ্রহ করে নতুন দাগ প্রদান করুন!", "error");
                }
                if (hasOwner < 1) {
                    swal("কোনো মালিকের তথ্য যোগ করা হয়নি!", "আগে কমপক্ষে একটি মালিক যোগ করুন!", "error");
                }


            }
        });

        function dagEntryFieldsDisable() {
            $('#dag_number').prop('disabled', true);
            $('#land_owner_type_id').prop('disabled', true);
            $('#ag_land_type_changer').prop('disabled', true);
            $('#ag_land_type').prop('disabled', true);
            $('#non_ag_land_type_changer').prop('disabled', true);
            $('#non_ag_land_type').prop('disabled', true);
            $('#total_dag_area').prop('disabled', true);
            $('#khotian_dag_area').prop('disabled', true);
            $('#khotian_dag_portion').prop('disabled', true);
            $('#motamot').prop('disabled', true);

            $('.dagDetails').addClass('d-none');
            $('#dag-table-area').removeClass('col-md-6');
            $('#dag-table-area').addClass('col-md-12');
            $('#dag-add-more').addClass('d-none');
            $('#dag-entry-enable').removeClass('d-none');
            $('#dag-entry-finish').addClass('d-none');
        }

        $('#dag-entry-finish').on('click', function () {
            let dagNumberCheck = $('#dag_sl_no').val();
            if (dagNumberCheck == '') {
                swal("কোনো দাগ যোগ করা হয়নি!", "কমপক্ষে একটি দাগ যোগ করুন!", "error");
            } else {
                dagEntryFieldsDisable();
            }
        });

        function dagEntryFieldsEnable() {
            $('#dag_number').prop('disabled', false);
            $('#land_owner_type_id').prop('disabled', false);
            $('#ag_land_type_changer').prop('disabled', false);
            $('#ag_land_type').prop('disabled', false);
            $('#non_ag_land_type_changer').prop('disabled', false);
            $('#non_ag_land_type').prop('disabled', false);
            $('#total_dag_area').prop('disabled', false);
            $('#khotian_dag_area').prop('disabled', false);
            $('#khotian_dag_portion').prop('disabled', false);
            $('#motamot').prop('disabled', false);

            $('.dagDetails').removeClass('d-none');
            $('#dag-table-area').removeClass('col-md-12');
            $('#dag-table-area').addClass('col-md-6');
            $('#dag-add-more').removeClass('d-none');
            $('#dag-entry-finish').removeClass('d-none');
            $('#dag-entry-enable').addClass('d-none');
        }

        $('#dag-entry-enable').on('click', function () {
            dagEntryFieldsEnable();
        });

        function calculateKhotianDagPortion() {
            let totalDagArea = $('#total_dag_area').val();
            let khotianDagArea = $('#khotian_dag_area').val();
            let khotianDagPortion = totalDagArea * khotianDagArea;

            if (!isNaN(khotianDagPortion) && totalDagArea > 0 && khotianDagArea <= 1) {
                $('#khotian_dag_portion').val(khotianDagPortion.toFixed(4));
            } else {
                $('#khotian_dag_portion').val('');
            }
        }

        /**
         * previous Khotian item add/remove
         * **/
        let previousKhotianTemplete = (CountPreviousKhotian) => {
            return '<div class="row next-referral-ref_khotian">' +
                '<div class="col-md-6 m-0">' +
                '<input class="form-control mb-1" id="ref_khotian_number_' + CountPreviousKhotian + '" name="ref_khotian[ref_khotian_number][' + CountPreviousKhotian + ']" placeholder="রেফারেল খতিয়ান নং">' +
                '</div> <div class="col-md-6 m-0">' +
                '<select class="form-control mb-1 select2" id="ref_khotian_type_' + CountPreviousKhotian + '" name="ref_khotian[ref_khotian_type][' + CountPreviousKhotian + ']">' +
                '<option> মিউটেটেড খতিয়ান</option>' +
                '<option>মিউটেটেড খতিয়ান</option>' +
                '</select>' +
                '</div>' +
                '</div>';
        }

        $('#ag_land_type_changer').on('change', function () {
            if ($(this).val() != '') {
                $("#ag_land_type").val(this.value);

                $('#non_ag_land_type_changer').prop('disabled', true);
                $('#non_ag_land_type').prop('disabled', true);
            } else {
                $("#ag_land_type").val('');

                $('#non_ag_land_type_changer').prop('disabled', false);
                $('#non_ag_land_type').prop('disabled', false);
            }


        });

        $('#ag_land_type').on('change', function () {
            if ($(this).val() != '') {
                $("#ag_land_type_changer").val(this.value);

                $('#non_ag_land_type_changer').prop('disabled', true);
                $('#non_ag_land_type').prop('disabled', true);
            } else {
                $("#ag_land_type_changer").val(this.value);

                $('#non_ag_land_type_changer').prop('disabled', false);
                $('#non_ag_land_type').prop('disabled', false);
            }
        });

        $('#non_ag_land_type_changer').on('change', function () {
            if ($(this).val() != '') {
                $("#non_ag_land_type").val(this.value);

                $("#ag_land_type_changer").val('');
                $("#ag_land_type_changer").prop('disabled', true);
                $("#ag_land_type").val('');
                $("#ag_land_type").prop('disabled', true);
            } else {
                $("#non_ag_land_type").val(this.value);
                $("#ag_land_type_changer").prop('disabled', false);
                $("#ag_land_type").prop('disabled', false);
            }
        });

        $('#non_ag_land_type').on('change', function () {
            console.log($(this).val() != '');
            if ($(this).val() != '') {
                $("#non_ag_land_type_changer").val(this.value);

                $("#ag_land_type_changer").val('');
                $("#ag_land_type_changer").prop('disabled', true);
                $("#ag_land_type").val('');
                $("#ag_land_type").prop('disabled', true);
            } else {
                $("#non_ag_land_type_changer").val(this.value);
                $("#ag_land_type_changer").prop('disabled', false);
                $("#ag_land_type").prop('disabled', false);
            }
        });

        $('#division_bbs_code').on('change', function () {
            showLoader();
            let divisionBbcCode = $(this).val();

            if (divisionBbcCode) {
                $('#district_bbs_code').prop('disabled', false);

                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.khotians.get-districts') }}',
                    data: {
                        'division_bbs_code': divisionBbcCode,
                    },
                    success: function (response) {
                        $('#district_bbs_code').html('');
                        $('#district_bbs_code').html('<option value="">নির্বাচন করুণ</option>');
                        $.each(response, function (key, value) {
                            $('#district_bbs_code').append(
                                '<option value="' + value.bbs_code + '">' + value.title + '</option>'
                            );
                        });
                        hideLoader();
                    },
                    error: function () {
                        console.log("error");
                    }
                });
            }
        });

        $('#district_bbs_code').on('change', function () {
            showLoader();
            let districtBbcCode = $(this).val();

            if (districtBbcCode) {
                $('#upazila_bbs_code').prop('disabled', false);

                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.khotians.get-upazilas') }}',
                    data: {
                        'district_bbs_code': districtBbcCode,
                    },
                    success: function (response) {
                        $('#upazila_bbs_code').html('');
                        $('#upazila_bbs_code').html('<option value="">নির্বাচন করুণ</option>');
                        $.each(response, function (key, value) {
                            $('#upazila_bbs_code').append(
                                '<option value="' + value.bbs_code + '">' + value.title + '</option>'
                            );
                        });
                        hideLoader();
                    },
                    error: function () {
                        console.log("error");
                    }
                });

            }
        });

        $('#upazila_bbs_code').on('change', function () {
            showLoader();
            let upazilaBbsCode = $(this).val();
            let districtBbsCode = $('#district_bbs_code').val();
            if (upazilaBbsCode) {
                $('#loc_all_mouja_id').prop('disabled', false);

                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.khotians.get-all-moujas') }}',
                    data: {
                        'upazila_bbs_code': upazilaBbsCode,
                        'district_bbs_code': districtBbsCode,
                    },
                    success: function (response) {
                        $('#loc_all_mouja_id').html('');
                        $('#loc_all_mouja_id').html('<option value="">নির্বাচন করুণ</option>');
                        $.each(response, function (key, value) {
                            $('#loc_all_mouja_id').append(
                                '<option value="' + key + '" data-dglr-code="' + key + '" >' + value + '</option>'
                            );
                        });
                        hideLoader();
                    },
                    error: function () {
                        console.log("error");
                    }
                });

            }
        });


        $('.has_dhara').on('click', function () {
            if ($(this).val() == 1) {
                $('#dhara_no').prop('disabled', false);
                $('#dhara_year').prop('disabled', false);
                $('#dhara_year_area').removeClass('d-none');
                $('#dhara_no_area').removeClass('d-none');
            } else {
                $('#dhara_no').prop('disabled', true);
                $('#dhara_year').prop('disabled', true);
                $('#dhara_year_area').addClass('d-none');
                $('#dhara_no_area').addClass('d-none');
            }
        });

        /**
         * NID Validation Start
         * **/
        $('#user_check_submit').on('click', function (e) {
            e.preventDefault();
            $("#muted_khotian_add_edit").validate().element('#identity_number');
            $("#muted_khotian_add_edit").validate().element('#dob');

            let nidNo = bn2en($('#identity_number').val());
            let nidDoB = $('#dob').val();
            if (!nidNo || !nidDoB) {
                return false;
            }
            apiDOB = nidDoB;
            showLoader();
            $.ajax({
                url: "{{route('admin.khotians.get-owners-info-from-nid-api')}}",
                data: {
                    nid: nidNo,
                    date_of_birth: formatDate(nidDoB.toString())
                },
                type: "POST",
                success: function (response) {
                    console.log(response)
                    if (response.name !== undefined) {
                        apiNID = response.nid;
                        apiName = response.name;
                        $('#owner_name').val(response.name_bn);
                        $('#owner_name').prop('readonly', true);

                        $('#guardian').val(response.father);
                        //$('#guardian').prop('readonly', true);

                        $('#mother_name').val(response.mother);
                        //$('#mother_name').prop('readonly', true);
                        $('#owner_mobile').val(response.mobile);
                        $('#owner_address').val(response.address);

                        $('#identity_number').val(response.nid);
                        $('#address').val(response.address);
                        $('#identity_number, #dob').attr('readonly', true);
                        $('#user_check_submit').attr('disabled', true);

                        $('#owner-verified').val('verified')
                        swal("সঠিক হয়েছে!", "ব্যবহারকারীর তথ্য পাওয়া গেছে", "success");
                    } else {
                        swal("ভুল হয়েছে!", "সঠিক তথ্য দিয়ে আবার চেষ্টা করুন", "error");
                    }
                    hideLoader();
                },
                complete: function () {
                    hideLoader();
                },
                error: function (xhr, status, error) {
                    console.log(xhr)
                    alert('অনাকাঙ্খিত ত্রুটি! ' + xhr.responseJSON.message);
                    hideLoader();
                }
            });

        });

        function formatDate(dateString) {
            let allDate = dateString.split(' ');
            let thisDate = allDate[0].split('-');
            let newDate = [thisDate[2], thisDate[1], thisDate[0]].join("-");
            return newDate;
        }

        /**
         * NID Validation End
         * **/

        $('.identity_type').on('click', function () {
            let ownerIdentityType = $(this).val();

            if (ownerIdentityType === "1") {
                $('#user_check_submit').prop('disabled', true);
                $('#user_check_submit').addClass('d-none');
                $('#owner_name').prop('readonly', false);
                $('#identity_number, #dob').attr('readonly', false);
                $('#identity_number').prop('disabled', false);


                $.validator.addClassRules('identity_number', {
                    required: true,
                    nidBn: false,
                });
            }

            if (ownerIdentityType === "2") {
                $('#user_check_submit').prop('disabled', false);
                $('#user_check_submit').removeClass('d-none');
                $('#identity_number').prop('disabled', false);

                $.validator.addClassRules('identity_number', {
                    required: true,
                    nidBn: true,
                });
            }

            if (ownerIdentityType === "3") {
                $('#user_check_submit').prop('disabled', true);
                $('#user_check_submit').addClass('d-none');
                $('#owner_name').prop('readonly', false);
                $('#identity_number, #dob').attr('readonly', false);
                $('#identity_number').prop('disabled', false);

                $.validator.addClassRules('identity_number', {
                    required: true,
                    nidBn: false,
                });
            }
            if (ownerIdentityType === "4") {
                console.log(ownerIdentityType)
                $('#user_check_submit').prop('disabled', true);
                $('#user_check_submit').addClass('d-none');
                $('#owner_name').prop('readonly', false);
                $('#identity_number, #dob').attr('readonly', false);
                $('#identity_number').prop('disabled', true);
                $('#identity_number').val('');
            }
        });

        /**
         * Start enToBn JS Code
         * **/
        function en2bn(input) {
            var numbers = {
                0: '০',
                1: '১',
                2: '২',
                3: '৩',
                4: '৪',
                5: '৫',
                6: '৬',
                7: '৭',
                8: '৮',
                9: '৯'
            };

            var output = [];
            for (var i = 0; i < input.length; i++) {
                if (numbers.hasOwnProperty(input[i])) {
                    output.push(numbers[input[i]]);
                } else {
                    output.push(input[i]);
                }
            }
            return output.join('').toString();
        }

        function bn2en(input) {
            var numbers = {
                '০': 0,
                '১': 1,
                '২': 2,
                '৩': 3,
                '৪': 4,
                '৫': 5,
                '৬': 6,
                '৭': 7,
                '৮': 8,
                '৯': 9
            };

            var output = [];
            for (var i = 0; i < input.length; i++) {
                if (numbers.hasOwnProperty(input[i])) {
                    output.push(numbers[input[i]]);
                } else {
                    output.push(input[i]);
                }
            }
            return output.join('').toString();
        }

        function toBnText(element, event, onlyNumber = false) {

            if (onlyNumber) {
                let numeric_input = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

                if ($.inArray(event.key, numeric_input) == "-1") {
                    return false;
                }
            }

            let current = $(element).val().split('');

            let new_input = en2bn(event.key);

            if (element.selectionStart < element.selectionEnd) {
                current.splice(element.selectionStart, (element.selectionEnd - element.selectionStart), new_input);
            } else {
                current.splice(element.selectionStart, 0, new_input);

            }
            let oldEnd = Number(element.selectionStart) + 1;

            $(element).val(current.join(""));

            setMyMapCaretPosition(element, oldEnd);
        }

        function toEnText(element, event, onlyNumber = false) {

            if (onlyNumber) {
                let numeric_input = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

                if ($.inArray(event.key, numeric_input) == "-1") {
                    return false;
                }
            }

            let current = $(element).val().split('');

            let new_input = bn2en(event.key);

            if (element.selectionStart < element.selectionEnd) {
                current.splice(element.selectionStart, (element.selectionEnd - element.selectionStart), new_input);
            } else {
                current.splice(element.selectionStart, 0, new_input);

            }
            let oldEnd = Number(element.selectionStart) + 1;

            $(element).val(current.join(""));

            setMyMapCaretPosition(element, oldEnd);
        }

        function setMyMapCaretPosition(ctrl, pos) {
            // Modern browsers
            if (ctrl.setSelectionRange) {
                ctrl.focus();
                ctrl.setSelectionRange(pos, pos);

                // IE8 and below
            } else if (ctrl.createTextRange) {
                let range = ctrl.createTextRange();
                range.collapse(true);
                range.moveEnd('character', pos);
                range.moveStart('character', pos);
                range.select();
            }
        }

        //english to bangla fields
        $(document).on("keypress", "#identity_number", function (event) {
            let txt = $(this).attr('id');
            toBnText(document.getElementById(txt), event, true);
            return false;
        });

        $(document).on("keypress", "#owner_group", function (event) {
            let txt = $(this).attr('id');
            toBnText(document.getElementById(txt), event, true);
            return false;
        });

        $(document).on("keypress", "#owner_mobile", function (event) {
            let txt = $(this).attr('id');
            toBnText(document.getElementById(txt), event, true);
            return false;
        });

        $(document).on("keypress", "#revenue", function (event) {
            let txt = $(this).attr('id');
            if (event.key === 'Enter') {
                return false;
            }
            toBnText(document.getElementById(txt), event, false);
            return false;
        });
        $(document).on("keypress", "#dhara_year", function (event) {
            let txt = $(this).attr('id');
            if (event.key === 'Enter') {
                return false;
            }
            toBnText(document.getElementById(txt), event, false);
            return false;
        });
        $(document).on("keypress", "#owner_area", function (event) {
            let txt = $(this).attr('id');
            if (event.key === 'Enter') {
                return false;
            }
            toEnText(document.getElementById(txt), event, false);
            return false;
        });

        $(document).on("keypress", "#dag_number", function (event) {
            let txt = $(this).attr('id');
            if (event.key === 'Enter') {
                return false;
            }
            toEnText(document.getElementById(txt), event, false);
            return false;
        });

        $(document).on("keypress", "#total_dag_area", function (event) {
            let txt = $(this).attr('id');
            if (event.key === 'Enter') {
                return false;
            }
            toEnText(document.getElementById(txt), event, false);
            return false;
        });

        $(document).on("keypress", "#khotian_dag_area", function (event) {
            let txt = $(this).attr('id');
            if (event.key === 'Enter') {
                return false;
            }
            toEnText(document.getElementById(txt), event, false);
            return false;
        });

        (function () {
            $('#total_dag_area').on('keyup', function () {
                console.log($(this).val());
                calculateKhotianDagPortion();
            });
            $('#khotian_dag_area').on('keyup', function () {
                console.log($(this).val());
                calculateKhotianDagPortion();
            });
        })();

        $.validator.addMethod(
            "numberEnOrBn",
            function (value, element) {
                let regexp = /^[0-9]*\.[0-9]*$|^[0-9]*$|^[০-৯]*$|^[০-৯]*\.[০-৯]*$/i;
                let re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "সঠিক সংখ্যার প্রদান করুন"
        );

        /**
         * End enToBn JS Code
         * **/


    </script>
@endpush
