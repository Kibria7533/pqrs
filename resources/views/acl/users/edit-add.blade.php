@php
    $edit = !empty($user->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ ! $edit ? __('generic.edit') : __('generic.update') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card card-outline">

            <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold text-primary">
                    {{ $edit ? __('generic.user_edit') : __('generic.user_create') }}
                </h3>
                <div class="card-tools">
                    <a href="{{route('admin.users.index')}}"
                       class="btn btn-sm btn-outline-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{__('generic.back_to_list')}}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form class="row edit-add-form" method="post"
                      action="{{$edit ? route('admin.users.update', $user->id) : route('admin.users.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    @if($edit)
                        @method('put')
                    @endif
                    <div class="col-md-12">
                        <div class="row justify-content-center align-content-center">
                            <div class="form-group" style="width: 200px; height: 200px">
                                <div class="input-group">
                                    <div class="profile-upload-section">
                                        <div class="avatar-preview text-center">
                                            <label for="profile_pic">
                                                <img class="img-thumbnail rounded-circle"
                                                     src="{{$edit && $user->profile_pic ? asset('storage/'.$user->profile_pic) : 'https://via.placeholder.com/350x350?text=Profile Picture'}}"
                                                     style="width: 200px; height: 200px"
                                                     alt="Profile pic"/>
                                                <span class="p-1 bg-gray"
                                                      style="position: absolute; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                            </label>
                                        </div>
                                        <input type="file" name="profile_pic" style="display: none"
                                               id="profile_pic">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">{{__('generic.name')}} <span style="color: red"> * </span></label>
                            <input type="text" class="form-control" id="name"
                                   name="name"
                                   value="{{$edit ? $user->name : old('name')}}"
                                   placeholder="{{__('generic.name')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">{{__('email')}} <span style="color: red"> * </span></label>
                            <input type="email" class="form-control" id="email"
                                   name="email"
                                   data-unique-user-email="{{ $edit ? $user->email : '' }}"
                                   value="{{$edit ? $user->email : old('email')}}"
                                   placeholder="{{__('email')}}">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_type_id">{{__('generic.user_type')}} <span
                                    style="color: red"> * </span></label>
                            <select class="form-control select2"
                                    name="user_type_id"
                                    id="user_type_id"
                                    data-placeholder="{{ __('generic.select_placeholder') }}"
                            >
                                <option value="" selected disabled>{{ __('generic.select_placeholder') }}</option>
                                @foreach($userTypes as $userType)
                                    <option value="{{$userType->code}}"
                                            @if($edit && $user->userType->code == $userType->code) selected @endif>
                                        {{$userType->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="office_id">{{ __('generic.office') }} <span id="office_id_required"
                                                                                    style="color: red"> {{ $edit && $user->office_id?'*':'' }} </span></label>
                            <select class="form-control select2"
                                    name="office_id"
                                    id="office_id"
                                    data-placeholder="{{ __('generic.select_placeholder') }}"
                                {{ $edit && $user->office_id?'':'disabled' }}
                            >
                                <option value="" selected disabled>{{ __('generic.select_placeholder') }}</option>
                                @foreach($offices as $office)
                                    <option value="{{$office->id}}"
                                            @if($edit && $user->office_id == $office->id) selected @endif>
                                        {{$office->name_bn}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if($edit && $authUser->id == $user->id && $authUser->can('changePassword', $user))
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="old_password">{{ __('generic.old_password') }}<span
                                        style="color: red"> * </span></label>
                                <input type="password"
                                       class="form-control"
                                       id="old_password"
                                       name="old_password"
                                       value=""
                                       placeholder="{{ __('generic.old_password') }}">
                            </div>
                        </div>
                    @endif

                    @if(!$edit || $authUser->can('changePassword', $user))
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label
                                    for="password">{{ __($edit ? __('generic.new_password') : __('password')) }}
                                    <span
                                        style="color: red"> * </span></label>
                                <input type="password" class="form-control" id="password"
                                       name="password"
                                       value=""
                                       placeholder="{{ __($edit ? __('generic.new_password') : __('password')) }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label
                                    for="password_confirmation">{{ __($edit ? __('generic.retype_new_password') : __('generic.retype_password')) }}
                                    <span style="color: red"> * </span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation"
                                       value=""
                                       placeholder="{{ __($edit ? __('generic.retype_new_password') : __('generic.retype_password')) }}">
                            </div>
                        </div>
                    @endif

                    @if($edit)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="row_status">{{ __('generic.status') }}</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="row_status_active"
                                           name="row_status"
                                           value="{{ \App\Models\BaseModel::ROW_STATUS_ACTIVE }}"
                                        {{ ($edit && $user->row_status == \App\Models\BaseModel::ROW_STATUS_ACTIVE) || old('row_status') == \App\Models\BaseModel::ROW_STATUS_ACTIVE ? 'checked' : '' }}>
                                    <label for="row_status_active"
                                           class="custom-control-label">{{ __('generic.active') }}</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="row_status_inactive"
                                           name="row_status"
                                           value="{{ \App\Models\BaseModel::ROW_STATUS_INACTIVE }}"
                                        {{ ($edit && $user->row_status == \App\Models\BaseModel::ROW_STATUS_INACTIVE) || old('row_status') == \App\Models\BaseModel::ROW_STATUS_INACTIVE ? 'checked' : '' }}>
                                    <label for="row_status_inactive"
                                           class="custom-control-label">{{ __('generic.inactive') }}</label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-success j8">{{$edit ? __('generic.update'):__('generic.save')}}</button>
                    </div>
                </form>
            </div><!-- /.card-body -->
            <div class="overlay" style="display: none">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';
        $(function () {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $('.avatar-preview img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $(document).on('change', "#profile_pic", function () {
                readURL(this);
            });

            $(".edit-add-form").validate({
                rules: {
                    profile_pic: {
                        accept: "image/*",
                    },
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        pattern: /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                    },
                    user_type_id: {
                        required: true
                    },
                    office_id: {
                        required: true
                    },

                    old_password: {
                        required: function () {
                            return !!$('#password').val().length;
                        },
                    },
                    password: {
                        required: !EDIT,
                    },
                    password_confirmation: {
                        equalTo: '#password',
                    },
                },
                messages: {
                    profile_pic: {
                        accept: "Please input valid image file",
                    },
                },
                submitHandler: function (htmlForm) {
                    $('.overlay').show();
                    htmlForm.submit();
                }
            });

            $('#user_type_id').on('change', function () {
                let userTypeId = $(this).val();
                if (userTypeId == 1 || userTypeId == 2 || userTypeId == null) {
                    $('#office_id').prop('disabled', true);
                    $('#office_id_required').html('');
                } else {
                    $('#office_id').prop('disabled', false);
                    $('#office_id_required').html('*');
                }
            });
        });

    </script>
@endpush
