<div class="modal-header custom-bg-gradient-info">
    <h4 class="modal-title">
        <i class="fas fa-eye"></i> {{__('generic.view_mouja')}}
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
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.name_en')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->name ?? "" }}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.name_bn')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->name_bd ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.division')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->division_name ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.district')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->district_name ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.upazila')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->upazila_name ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.dglr_code')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->dglr_code ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.rsk_jl_no')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->rsk_jl_no ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.cs_jl_no')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->cs_jl_no ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.sa_jl_no')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->sa_jl_no ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.rs_jl_no')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->rs_jl_no ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.pety_jl_no')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->pety_jl_no ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.diara_jl_no')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->diara_jl_no ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.bs_jl_no')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->bs_jl_no ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.city_jl_no')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->city_jl_no ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-4 custom-view-box">
                        <p class="label-text">{{__('generic.brs_jl_no')}}</p>
                        <div class="input-box">
                            {{ $locAllMouja->brs_jl_no ?? ""}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12 text-right">
            <a href="javascript:;"
               data-url="{{ route('admin.loc-all-moujas.edit', $locAllMouja) }}"
               class="btn btn-sm btn-outline-warning rounded dt-edit button-from-view"><i
                    class="fas fa-edit"></i> {{ __('generic.edit_button_label') }}</a>
        </div>
    </div>
</div>
