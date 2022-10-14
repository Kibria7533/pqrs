@php
    $edit = !empty($locUnion->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

<div class="modal-header custom-bg-gradient-info">
    <h4 class="modal-title">
        <i class="fas {{ $edit? 'fa-edit':'fa-plus'}}"></i> {{!$edit ? __('generic.add_new_union'): __('generic.edit_union')}}
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
                  action="{{$edit ? route('admin.loc-unions.update', $locUnion->id) : route('admin.loc-unions.store')}}"
                  enctype="multipart/form-data">
                @csrf
                @if($edit)
                    @method('put')
                @endif

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title_en">{{ __('generic.name_en') }} <span style="color: red"> * </span></label>
                        <input type="text" class="form-control custom-form-control" name="title_en"
                               value="{{$edit ? $locUnion->title_en : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">{{ __('generic.name_bn') }}<span style="color: red"> * </span></label>
                        <input type="text" class="form-control custom-form-control" name="title"
                               value="{{$edit ? $locUnion->title : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bbs_code">{{ __('generic.bbs_code') }} <span style="color: red"> * </span></label>
                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                               value="{{$edit ? $locUnion->bbs_code : ''}}"/>
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
                                data-preselected-option="{{json_encode(['text' =>  $locUnion->division->title, 'id' =>  $locUnion->division->id])}}"
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
                                data-preselected-option="{{json_encode(['text' =>  $locUnion->district->title, 'id' =>  $locUnion->district->id])}}"
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
                                data-preselected-option="{{json_encode(['text' =>  $locUnion->upazila->title, 'id' =>  $locUnion->loc_upazila_id])}}"
                                @endif
                                data-placeholder="{{ __('generic.select_placeholder') }}"
                        >
                        </select>
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
