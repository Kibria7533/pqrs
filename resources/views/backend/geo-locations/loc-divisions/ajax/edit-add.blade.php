@php
    $edit = !empty($locDivision->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

<div class="modal-header custom-bg-gradient-info">
    <h4 class="modal-title">
        <i class="fas fa-eye"></i> {{!$edit ? __('generic.add_new_division') : __('generic.edit_division') }}
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
                  action="{{$edit ? route('admin.loc-divisions.update', $locDivision->id) : route('admin.loc-divisions.store')}}"
                  enctype="multipart/form-data">
                @csrf
                @if($edit)
                    @method('put')
                @endif

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title_en">{{ __('generic.name_en') }}<span style="color: red"> * </span></label>
                        <input type="text" class="form-control custom-form-control" name="title_en"
                               value="{{ $edit ? $locDivision->title_en : '' }}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">{{ __('generic.name_bn') }}<span style="color: red"> * </span></label>
                        <input type="text" class="form-control custom-form-control" name="title"
                               value="{{$edit ? $locDivision->title : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">{{ __('generic.bbs_code') }}<span style="color: red"> * </span></label>
                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                               value="{{$edit ? $locDivision->bbs_code : ''}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="has_khatian">{{ __('generic.has_khatian') }} <span style="color: red"> * </span></label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="has_khatian_yes" name="has_khatian"
                                       class="custom-control-input" value="1" {{ $edit && $locDivision->has_khatian==1 ? 'checked':'' }}>
                                <label class="custom-control-label" for="has_khatian_yes">{{ __('generic.yes') }}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="has_khatian_no" name="has_khatian"
                                       class="custom-control-input" value="0" {{ $edit && $locDivision->has_khatian==0 ? 'checked':'' }}>
                                <label class="custom-control-label" for="has_khatian_no">{{ __('generic.no') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="has_map">{{ __('generic.has_map') }} <span style="color: red"> * </span></label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="has_map_yes" name="has_map"
                                       class="custom-control-input"
                                       value="1" {{ $edit && $locDivision->has_map==1 ? 'checked':'' }}>
                                <label class="custom-control-label" for="has_map_yes">{{ __('generic.yes') }}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="has_map_no" name="has_map"
                                       class="custom-control-input"
                                       value="0" {{ $edit && $locDivision->has_map==0 ? 'checked':'' }}>
                                <label class="custom-control-label" for="has_map_no">{{ __('generic.no') }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 text-right mt-2">
                    <button type="submit" class="btn btn-success">{{$edit ? __('generic.update') : __('generic.save')}}</button>
                </div>
            </form>
        </div><!-- /.card-body -->
        <div class="overlay" style="display: none">
            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
        </div>
    </div>
</div>
