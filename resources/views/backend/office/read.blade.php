@extends('master::layouts.master')
@section('title')
    {{__('generic.landless')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{ __('generic.office') }} </h3>


                        <div class="card-tools">
                            <div class="btn-group">
                                @can('update', $office)
                                    <a href="{{route('admin.offices.edit', [$office->id])}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-plus-circle"></i> {{ __('generic.edit_button_label') }}
                                    </a>
                                @endcan
                                @can('viewAny', $office)
                                    <a href="{{route('admin.offices.index')}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                                    </a>
                                @endcan
                            </div>

                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.name_bn') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $office->name_bn }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.name_en') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $office->name_en }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.office_type') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($office->office_type)? __('generic.'.\App\Models\Office::OFFICE_TYPE[$office->office_type]):'' }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.jurisdiction') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($office->jurisdiction)? __('generic.'.\App\Models\Office::JURISDICTION[$office->jurisdiction]):'' }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.division') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($office->division_bbs_code) ? $office->locDivision->title :'' }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.district') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($office->district_bbs_code) ? $office->locDistrict->title :'' }}
                                </div>
                            </div>
                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.upazila') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($office->upazila_bbs_code) ? $office->locUpazila($office->district_bbs_code,$office->upazila_bbs_code) :'' }}
                                </div>
                            </div>

                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.union') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($office->union_bbs_code) ? $office->locUnion($office->district_bbs_code,$office->upazila_bbs_code, $office->union_bbs_code) :'' }}
                                </div>
                            </div>

                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.dglr_code') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $office->dglr_code }}
                                </div>
                            </div>

                            <div class="col-md-4 custom-view-box">
                                <p class="label-text">{{ __('generic.org_code') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $office->org_code }}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
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
                        src="{{ !empty($office->attached_file)? asset("storage/{$office->attached_file}"):'' }}"
                        alt="{{ __('generic.uploaded_file') }}" width="100%">
                </div>
            </div>
        </div>
    </div>
@endsection

