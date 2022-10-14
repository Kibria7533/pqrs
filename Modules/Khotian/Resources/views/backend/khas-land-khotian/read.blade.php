@extends('master::layouts.master')
@section('title')
    {{__('cadt')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{ __('generic.landless') }} </h3>


                        <div class="card-tools">
                            <div class="btn-group">
                                @can('update', $landless)
                                    <a href="{{route('admin.landless.edit', [$landless->id])}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-plus-circle"></i> {{ __('generic.edit_button_label') }}
                                    </a>
                                @endcan
                                @can('viewAny', $landless)
                                    <a href="{{route('admin.landless.index')}}"
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
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.name_of_the_applicant') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $landless->fullname }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.mobile_number') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $landless->mobile }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('email') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $landless->email }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.identity_type') }}</p>
                                <div class="input-box custom-form-control">
                                    <div class="form-group">
                                        <div class="d-flex">
                                            @foreach(\Modules\Landless\App\Models\Landless::IDENTITY_TYPE as $key=>$value)
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input identity_type"
                                                           value="{{ $key }}"
                                                        {{ $landless->identity_type == $key ? 'checked': '' }}>
                                                    <label class="custom-control-label">
                                                        {{  __('generic.'.$value) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.identity_number') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $landless->identity_number }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.date_of_birth') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ $landless->date_of_birth }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.landless_type') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($landless->landless_type)? \Modules\Landless\App\Models\Landless::LANDLESS_TYPE[$landless->landless_type] :'' }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.gender') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($landless->gender)?  __('generic.'.\Modules\Landless\App\Models\Landless::GENDER[$landless->gender]) :'' }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.submitted_papers') }}</p>
                                <div class="input-box custom-form-control">
                                    {{ !empty($landless->file_type)? __('generic.'.\Modules\Landless\App\Models\Landless::FILE_TYPE[$landless->file_type]) :'' }}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('generic.uploaded_file') }}</p>
                                <div class="input-box custom-form-control">
                                    @if(!empty($landless->attached_file))
                                        @if(pathinfo( !empty($landless->attached_file)? $landless->attached_file : '', PATHINFO_EXTENSION) === 'pdf')
                                            <a
                                                target="_blank"
                                                href="{{ asset("storage/{$landless->attached_file}") }}"
                                                style="color: #3f51b5;font-weight: bold;"
                                                type="button"
                                                class="btn p-0">
                                                {{ __('generic.show_uploaded_file') }}
                                            </a>
                                        @else
                                            <button
                                                style="color: #3f51b5;font-weight: bold;"
                                                type="button"
                                                class="btn p-0"
                                                data-toggle="modal"
                                                data-target="#scan_file_viewer">
                                                {{ __('generic.show_uploaded_file') }}
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.applicant_father_name') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $landless->father_name }}
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.date_of_birth') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $landless->father_dob }}
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text"> &nbsp;</p>
                                    <div class="input-box custom-form-control">
                                        {{ __('generic.'. \Modules\Landless\App\Models\Landless::IS_ALIVE[$landless->father_is_alive]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.applicant_mother_name') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $landless->mother_name }}
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.date_of_birth') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $landless->mother_dob }}
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text"> &nbsp;</p>
                                    <div class="input-box custom-form-control">
                                        {{ __('generic.'. \Modules\Landless\App\Models\Landless::IS_ALIVE[$landless->mother_is_alive]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.applicant_spouse_name') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $landless->spouse_name }}
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.date_of_birth') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $landless->spouse_dob }}
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.p_s_m') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $landless->po_sho_mo }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.applicant_spouse_father_name') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $landless->spouse_father }}
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.applicant_spouse_mother_name') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $landless->spouse_mother }}
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.division') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $locDivision }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.district') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $locDistrict }}
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.upazila') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $locUpazila }}
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <p class="label-text">{{ __('generic.union') }}</p>
                                    <div class="input-box custom-form-control">
                                        {{ $locUnion }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-4 custom-view-box">
                                    <div class="form-group">
                                        <p class="label-text">{{ __('generic.village') }}</p>
                                        <div class="input-box custom-form-control">
                                            {{ $landless->village }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <p class="label-text">{{ __('generic.present_address') }}</p>
                                        <div class="input-box" style="min-height: 62px">
                                            {{ $landless->present_address }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <p class="label-text">{{ __('generic.freedom_fighters_details') }}</p>
                                        <div class="input-box" style="min-height: 62px">
                                            {{ $landless->freedom_fighters_details }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <div class="form-group">
                                        <p class="label-text">{{ __('generic.family_member_name') }}</p>
                                        <div class="input-box custom-form-control">
                                            {{ $landless->family_member_name }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <p class="label-text">{{ __('generic.gurdian_khasland_details') }}</p>
                                        <div class="input-box" style="min-height: 62px">
                                            {{ $landless->gurdian_khasland_details }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <p class="label-text">{{ __('generic.khasland_details') }}</p>
                                        <div class="input-box" style="min-height: 62px">
                                            {{ $landless->khasland_details }}
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-4 custom-view-box">
                                    <div class="form-group">
                                        <p class="label-text">{{ __('generic.bosot_vita_details') }}</p>
                                        <div class="input-box" style="min-height: 62px">
                                            {{ $landless->bosot_vita_details }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <p class="label-text">{{ __('generic.nodi_vanga_family_details') }}</p>
                                        <div class="input-box" style="min-height: 62px">
                                            {{ $landless->nodi_vanga_family_details }}
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
@endsection

