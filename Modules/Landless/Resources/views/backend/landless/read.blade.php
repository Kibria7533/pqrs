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
                            <div class="col-md-12 mb-3">
                                <label>
                                    {{ __('generic.applicant_info') }}
                                </label>
                                <div class="border rounded p-3">
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
                                                            <div
                                                                class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio"
                                                                       class="custom-control-input identity_type"
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
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>
                                    {{ __('generic.family_info') }}
                                </label>
                                <div class="border rounded p-3">
                                    <div class="row">
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
                                        <div class="col-md-4 custom-view-box mb-0">
                                            <div class="form-group">
                                                <p class="label-text">{{ __('generic.jl_number') }}</p>
                                                <div class="input-box custom-form-control">
                                                    {{ $landless->jl_number }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 custom-view-box mb-0">
                                            <div class="form-group">
                                                <p class="label-text">{{ __('generic.village') }}</p>
                                                <div class="input-box custom-form-control">
                                                    {{ $landless->village }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 custom-view-box mb-0">
                                            <div class="form-group">
                                                <p class="label-text">{{ __('generic.present_address') }}</p>
                                                <div class="input-box" style="min-height: 62px">
                                                    {{ $landless->present_address }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 custom-view-box mb-0">
                                            <div class="form-group">
                                                <p class="label-text">{{ __('generic.freedom_fighters_details') }}</p>
                                                <div class="input-box" style="min-height: 62px">
                                                    {{ $landless->freedom_fighters_details }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 custom-view-box mb-0">
                                            <div class="form-group">
                                                <p class="label-text">{{ __('generic.gurdian_khasland_details') }}</p>
                                                <div class="input-box" style="min-height: 62px">
                                                    {{ $landless->gurdian_khasland_details }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 custom-view-box mb-0">
                                            <div class="form-group">
                                                <p class="label-text">{{ __('generic.khasland_details') }}</p>
                                                <div class="input-box" style="min-height: 62px">
                                                    {{ $landless->khasland_details }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 custom-view-box mb-0">
                                            <div class="form-group">
                                                <p class="label-text">{{ __('generic.bosot_vita_details') }}</p>
                                                <div class="input-box" style="min-height: 62px">
                                                    {{ $landless->bosot_vita_details }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 custom-view-box mb-0">
                                            <div class="form-group">
                                                <p class="label-text">{{ __('generic.nodi_vanga_family_details') }}</p>
                                                <div class="input-box" style="min-height: 62px">
                                                    {{ $landless->nodi_vanga_family_details }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>
                                                {{ __('generic.family_members_info') }}
                                            </label>
                                            <div class="border rounded p-3">
                                                <div class="row">
                                                    @foreach($landless->family_members as $key=>$familyMember)
                                                        <div class="col-md-4 custom-view-box"
                                                             id="family_member_{{ ++$key }}">
                                                            @if($key==1)
                                                                <p class="label-text">{{ __('generic.name') }}</p>
                                                            @endif
                                                            <div class="input-box custom-form-control">
                                                                {{$familyMember['name']}}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 custom-view-box">
                                                            @if($key==1)
                                                                <p class="label-text">{{ __('generic.mobile') }}</p>
                                                            @endif
                                                            <div class="input-box custom-form-control">
                                                                {{$familyMember['mobile']}}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 custom-view-box">
                                                            @if($key==1)
                                                                <p class="label-text">{{ __('generic.profession') }}</p>
                                                            @endif

                                                            <div class="input-box custom-form-control">
                                                                {{$familyMember['profession']}}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>
                                    {{ __('generic.submitted_attachments') }}
                                </label>
                                <div class="border rounded p-3">
                                    @foreach($landlessApplicationAttachments as $key=>$landlessApplicationAttachment)
                                        <div class="row"
                                             id="attachment_{{++$key}}">
                                            <div class="col-md-4 custom-view-box">
                                                @if($key==1)
                                                    <p class="label-text">{{ __('generic.file_type') }}</p>
                                                @endif
                                                <div class="input-box custom-form-control">
                                                    {{ $landlessApplicationAttachment->fileType->title }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 custom-view-box">
                                                @if($key==1)
                                                    <p class="label-text">{{ __('generic.file') }}</p>
                                                @endif
                                                <div class="">
                                                    @if(!empty($landlessApplicationAttachment->attachment_file))
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="inputGroupFileAddon02">
                                                                @if((pathinfo(!empty($landlessApplicationAttachment->attachment_file)? $landlessApplicationAttachment->attachment_file : '', PATHINFO_EXTENSION) === 'pdf'))
                                                                    <a
                                                                        target="_blank"
                                                                        href="{{ asset("storage/{$landlessApplicationAttachment->attachment_file}") }}"
                                                                        style="color: #3f51b5;font-weight: bold;"
                                                                        type="button">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                @else
                                                                    <span
                                                                        class="file_modal_show"
                                                                        data-action="{{ asset("storage/{$landlessApplicationAttachment->attachment_file}") }}"
                                                                        style="color: #3f51b5;font-weight: bold;"
                                                                        type="button"
                                                                    >
                                                                    <i class="fa fa-eye"></i>
                                                                </span>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-4 custom-view-box">
                                                @if($key==1)
                                                    <p class="label-text">{{ __('generic.title') }}</p>
                                                @endif
                                                <div class="input-box custom-form-control">
                                                    {{ $landlessApplicationAttachment->title }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>
                                    {{ __('generic.others_info') }}
                                </label>
                                <div class="border rounded p-3">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label>
                                                {{ __('generic.references') }}
                                            </label>
                                            <div class="border rounded p-3">
                                                <div class="row">
                                                    @foreach($landless->references as $key=>$reference)
                                                        <div class="col-md-4 custom-view-box"
                                                             id="family_member_{{ ++$key }}">
                                                            @if($key==1)
                                                                <p class="label-text">{{ __('generic.name') }}</p>
                                                            @endif
                                                            <div class="input-box custom-form-control">
                                                                {{$reference['name']}}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 custom-view-box">
                                                            @if($key==1)
                                                                <p class="label-text">{{ __('generic.mobile') }}</p>
                                                            @endif
                                                            <div class="input-box custom-form-control">
                                                                {{$reference['mobile']}}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 custom-view-box">
                                                            @if($key==1)
                                                                <p class="label-text">{{ __('generic.profession') }}</p>
                                                            @endif

                                                            <div class="input-box custom-form-control">
                                                                {{$reference['profession']}}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 custom-view-box">
                                            <p class="label-text">{{ __('generic.expected_lands') }}</p>
                                            <div class="input-box custom-form-control">
                                                {{ $landless->expected_lands }}
                                            </div>
                                        </div>
                                        <div class="col-md-3 custom-view-box">
                                            <p class="label-text">{{ __('generic.application_received_date') }}</p>
                                            <div class="input-box custom-form-control">
                                                {{ $landless->application_received_date }}
                                            </div>
                                        </div>
                                        <div class="col-md-3 custom-view-box">
                                            <p class="label-text">{{ __('generic.receipt_number') }}</p>
                                            <div class="input-box custom-form-control">
                                                {{ $landless->receipt_number }}
                                            </div>
                                        </div>
                                        <div class="col-md-3 custom-view-box">
                                            <p class="label-text">{{ __('generic.nothi_number') }}</p>
                                            <div class="input-box custom-form-control">
                                                {{ $landless->nothi_number }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label>
                                                {{ __('generic.meeting') }}
                                            </label>
                                            <div class="border rounded p-3">
                                                <div class="row">
                                                    @foreach($meetings as $key=>$meeting)
                                                        <div class="col-md-4 custom-view-box"
                                                             id="family_member_{{ ++$key }}">
                                                            @if($key==1)
                                                                <p class="label-text">{{ __('generic.name') }}</p>
                                                            @endif
                                                            <div class="input-box custom-form-control">
                                                                {{$meeting['title']}}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 custom-view-box">
                                                            @if($key==1)
                                                                <p class="label-text">{{ __('generic.date') }}</p>
                                                            @endif
                                                            <div class="input-box custom-form-control">
                                                                {{$meeting['meeting_date']}}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 custom-view-box">
                                                            @if($key==1)
                                                                <p class="label-text">{{ __('generic.action') }}</p>
                                                            @endif
                                                            <div class="input-box custom-form-control">
                                                               <a  href="{{route('admin.meeting_management.meetings.worksheet', $meeting->meeting_id)}}"   class="btn btn-outline-info btn-sm" ><i class="fas fa-eye"></i>{{__('generic.show_button_label')}}</a>
                                                            </div>
                                                        </div>
                                                    @endforeach
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
                    <img id="modal_img" src=""
                         alt="{{ __('generic.uploaded_file') }}" width="100%">
                </div>
            </div>
        </div>
    </div>



    <!-- Modal for  meeting view -->
    <div class="modal fade" id="meeting_viewer" tabindex="-1" role="dialog"
         aria-labelledby="meeting_viewerTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meeting_viewerTitle">
                        {{ __('generic.meeting') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .input-group-append {
            margin: 0;
            height: 45px;
            display: flex !important;
            align-content: center;
            align-items: center;
        }
    </style>
@endpush

@push('js')
    <script>
        /**
         * Modal img showing
         * **/
        $('.file_modal_show').click(function (i, j) {
            $('#modal_img').attr('src', $(this)[0].dataset.action);
            $('#scan_file_viewer').modal('show');
        });

        $('#meeting_modal_show').click(function (i, j) {
            $('#meeting_viewer').modal('show');
        });
    </script>
@endpush

