<div class="modal-header custom-bg-gradient-info">
    <h4 class="modal-title">
        <i class="fas fa-eye"></i> {{__('generic.view_upazila')}}
    </h4>
    <button type="button" class="close" data-dismiss="modal"
            aria-label="{{ __('voyager::generic.close') }}">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-body row">
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('generic.name_en') }}</p>
                        <div class="input-box">
                            {{ $locUpazila->title_en ?? "" }}
                        </div>
                    </div>

                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('generic.name_bn') }}</p>
                        <div class="input-box">
                            {{ $locUpazila->title ?? ""}}
                        </div>
                    </div>

                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('generic.bbs_code') }}</p>
                        <div class="input-box">
                            {{ $locUpazila->bbs_code ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('generic.division') }}</p>
                        <div class="input-box">
                            {{ $locUpazila->division->title ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('generic.district') }}</p>
                        <div class="input-box">
                            {{ $locUpazila->district->title ?? ""}}
                        </div>
                    </div>

                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('generic.has_map') }}</p>
                        <div class="input-box">
                            {{ $locUpazila->has_map ? __('generic.yes') : __('generic.no') }}
                        </div>
                    </div>

                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('generic.has_khatian') }}</p>
                        <div class="input-box">
                            {{ $locUpazila->has_khatian ? __('generic.yes') : __('generic.no') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 text-right">
            <a href="javascript:;"
               data-url="{{ route('admin.loc-upazilas.edit', $locUpazila) }}"
               class="btn btn-sm btn-outline-warning rounded-0 dt-edit button-from-view"><i
                    class="fas fa-edit"></i> {{ __('generic.edit_button_label') }}</a>
        </div>
    </div>
</div>
