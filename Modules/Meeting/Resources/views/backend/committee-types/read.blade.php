@php
    $edit = !empty($committeeType->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') != 'en';
@endphp


@extends('master::layouts.master')
@section('title')
    {{ __('generic.add_new_committee_type') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{ __('generic.committee_type') }}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.meeting_management.committee-types.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.committee_type_title') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $committeeType->title }}
                                </div>
                            </div>

                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.committee_type_title_en') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $committeeType->title_en }}
                                </div>
                            </div>

                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.office_type') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($committeeType->office_type)?  \Modules\Meeting\Models\committeeType::OFFICE_TYPE[$committeeType->office_type]:'' }}
                                </div>
                            </div>

                        </div>
                    </div>

                    @if(!empty($committeeSetting))
                        <div class="col-md-12" id="committee-setting-area">
                            <div class="row">
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.number_of_member') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ !empty($committeeSetting)? $committeeSetting->number_of_member:'' }}
                                    </div>
                                </div>

                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.min_attendance') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ !empty($committeeSetting)? $committeeSetting->min_attendance:'' }}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr class="m-0">
                                </div>

                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="text-center">
                                            <th scope="col" width="20px">{{ __('generic.sl_no') }}</th>
                                            <th scope="col">{{ __('generic.org_member_designation') }}</th>
                                            <th scope="col">{{ __('generic.committee_member_designation') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">

                                        <?php $sl = 0?>
                                        @foreach($committeeSetting->member_config as $key=>$committeeSettingConfig)

                                            <tr>
                                                <td>{{ ++$sl }}</td>
                                                <td>{{ $committeeSettingConfig['org_designation'] }}</td>
                                                <td>{{ $committeeSettingConfig['committee_designation'] }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{--<div class="col-md-12 text-right my-3">
                        <button type="submit"
                                class="btn btn-success form-submit px-4"><i
                                class="fas fa-print"></i> {{ __('generic.print') }}</button>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>


    </style>
@endpush

@push('js')
    <script>
        $(function () {

        });
    </script>
@endpush


