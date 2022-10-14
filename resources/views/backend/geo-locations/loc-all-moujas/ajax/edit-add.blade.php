@php
    $edit = !empty($locAllMouja->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

<div class="modal-header custom-bg-gradient-info">
    <h4 class="modal-title">
        <i class="fas {{ !$edit ? 'fa-plus':'fa-edit'}}"></i> {{!$edit ? __('generic.add_new_mouja') : __('generic.edit_mouja') }}
    </h4>
    <button type="button" class="close" data-dismiss="modal"
            aria-label="{{ __('voyager::generic.close') }}">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="card card-outline">
        <div class="card-body">
            <form class="row edit-add-form" method="post"
                  action="{{$edit ? route('admin.loc-all-moujas.update', $locAllMouja->id) : route('admin.loc-all-moujas.store')}}"
                  enctype="multipart/form-data">
                @csrf
                @if($edit)
                    @method('put')
                @endif

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">{{ __('generic.name_en') }} <span style="color: red"> * </span></label>
                        <input type="text" class="form-control custom-form-control"
                               name="name"
                               value="{{$edit ? $locAllMouja->name : ''}}"/>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name_bd">{{ __('generic.name_bn') }} <span style="color: red"> * </span></label>
                        <input type="text" class="form-control custom-form-control"
                               name="name_bd"
                               value="{{$edit ? $locAllMouja->name_bd : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="loc_division_id">{{ __('generic.division') }} <span
                                style="color: red"> * </span></label>
                        <select class="form-control custom-form-control select2-ajax-wizard"
                                name="loc_division_id"
                                id="loc_division_id"
                                data-model="{{base64_encode(App\Models\LocDivision::class)}}"
                                data-label-fields="{title}"
                                @if($edit)
                                data-preselected-option="{{json_encode(['text' =>  $locDivision->title, 'id' =>  $locDivision->id])}}"
                                @endif
                                data-placeholder="{{ __('generic.select_placeholder') }}"
                        >
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="loc_district_id">{{ __('generic.district') }} <span
                                style="color: red"> * </span></label>
                        <select class="form-control custom-form-control select2-ajax-wizard"
                                name="loc_district_id"
                                id="loc_district_id"
                                data-model="{{base64_encode(App\Models\LocDistrict::class)}}"
                                data-label-fields="{title}"
                                data-depend-on="loc_division_id"
                                @if($edit)
                                data-preselected-option="{{json_encode(['text' =>  $locDistrict->title, 'id' =>  $locDistrict->id])}}"
                                @endif
                                data-placeholder="{{ __('generic.select_placeholder') }}"
                        >
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="loc_upazila_id">{{ __('generic.upazila') }} <span
                                style="color: red"> * </span></label>
                        <select class="form-control custom-form-control select2-ajax-wizard"
                                name="loc_upazila_id"
                                id="loc_upazila_id"
                                data-model="{{base64_encode(App\Models\LocUpazila::class)}}"
                                data-label-fields="{title}"
                                data-depend-on="loc_district_id"
                                @if($edit)
                                data-preselected-option="{{json_encode(['text' =>  $locUpazila->title, 'id' =>  $locUpazila->id])}}"
                                @endif
                                data-placeholder="{{ __('generic.select_placeholder') }}"
                        >
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mt-2">
                    <div class="form-group position-relative">
                        <label for="dglr_code">{{ __('generic.dglr_code') }} <span style="color: red"> * </span></label>
                        <input type="text" class="form-control custom-form-control" name="dglr_code"
                               value="{{$edit ? $locAllMouja->dglr_code : ''}}"/>
                    </div>
                </div>

                <div class="col-md-6 mt-2">
                    <div class="form-group">
                        <label for="rsk_jl_no">{{ __('generic.brs_jl_no') }} </label>
                        <input type="text" class="form-control custom-form-control" name="rsk_jl_no"
                               value="{{$edit ? $locAllMouja->rsk_jl_no : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cs_jl_no">{{ __('generic.brs_jl_no') }} </label>
                        <input type="text" class="form-control custom-form-control" name="cs_jl_no"
                               value="{{$edit ? $locAllMouja->cs_jl_no : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sa_jl_no">{{ __('generic.brs_jl_no') }} </label>
                        <input type="text" class="form-control custom-form-control" name="sa_jl_no"
                               value="{{$edit ? $locAllMouja->sa_jl_no : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rs_jl_no">{{ __('generic.brs_jl_no') }} </label>
                        <input type="text" class="form-control custom-form-control" name="rs_jl_no"
                               value="{{$edit ? $locAllMouja->rs_jl_no : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pety_jl_no">{{ __('generic.brs_jl_no') }} </label>
                        <input type="text" class="form-control custom-form-control" name="pety_jl_no"
                               value="{{$edit ? $locAllMouja->pety_jl_no : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="diara_jl_no">{{ __('generic.brs_jl_no') }} </label>
                        <input type="text" class="form-control custom-form-control" name="diara_jl_no"
                               value="{{$edit ? $locAllMouja->diara_jl_no : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bs_jl_no">{{ __('generic.brs_jl_no') }} </label>
                        <input type="text" class="form-control custom-form-control" name="bs_jl_no"
                               value="{{$edit ? $locAllMouja->bs_jl_no : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="city_jl_no">{{ __('generic.brs_jl_no') }} </label>
                        <input type="text" class="form-control custom-form-control" name="city_jl_no"
                               value="{{$edit ? $locAllMouja->city_jl_no : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="brs_jl_no">{{ __('generic.brs_jl_no') }}</label>
                        <input type="text" class="form-control custom-form-control" name="brs_jl_no"
                               value="{{$edit ? $locAllMouja->brs_jl_no : ''}}"/>
                    </div>
                </div>

                <div class="col-sm-12 text-right mt-2">
                    <button type="submit" class="btn btn-success">{{$edit ? __('generic.update') : __('generic.save') }}</button>
                </div>
            </form>
        </div><!-- /.card-body -->
        <div class="overlay" style="display: none">
            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
        </div>
    </div>
</div>
