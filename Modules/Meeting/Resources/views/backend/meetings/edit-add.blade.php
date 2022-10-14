@php
    $edit = !empty($meeting->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') != 'en';
@endphp


@extends('master::layouts.master')
@section('title')
    {{!$edit ? __('generic.add_new'): __('generic.edit')}}
@endsection
@section('content')
    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js"></script>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{!$edit ? __('generic.add_meeting'): __('generic.edit_meeting')}}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.meeting_management.meetings.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{$edit ? route('admin.meeting_management.meetings.update', $meeting->id) : route('admin.meeting_management.meetings.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    @if($edit)
                        @method('put')
                    @endif
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">{{ __('generic.title') }} </label>
                                <input type="text" class="form-control custom-form-control"
                                       name="title"
                                       id="title"
                                       value="{{$edit ? $meeting->title : ''}}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="meeting_no"> {{ __('generic.meeting_number') }} </label>
                                <input type="text" class="form-control custom-form-control"
                                       name="meeting_no"
                                       id="meeting_no"
                                       value="{{$edit ? $meeting->meeting_no : ''}}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="meeting_date">{{ __('generic.date') }} </label>
                                <div class="input-group">
                                    <input type="text"
                                           class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded date_of_birth"
                                           name="meeting_date"
                                           id="meeting_date"
                                           placeholder="{{ __('generic.select_date') }}"
                                           value="{{$edit ? $meeting->meeting_date : ''}}"/>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"
                                             style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                            <i class="fas fa-calendar-day"
                                               style="color: #959595; transform: rotateY(180deg);"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="committee_type_id">{{ __('generic.committee_type') }}</label>
                                <select class="form-control custom-form-control select2"
                                        name="committee_type_id"
                                        id="committee_type_id"
                                        data-placeholder="{{ __('generic.select_placeholder') }}">
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    @foreach($committeeTypes as $key =>$committeeType)
                                        <option
                                            value="{{ $committeeType->id }}" {{ $edit && $meeting->committee_type_id == $committeeType->id? 'selected' : '' }}>
                                            {{ $committeeType->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--<div class="col-md-6">
                            <div class="form-group">
                                <label for="meeting_type">{{ __('generic.meeting_type') }}</label>
                                <select class="form-control custom-form-control"
                                        name="meeting_type"
                                        id="meeting_type">
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    @foreach(\Modules\Meeting\Models\Meeting::MEETING_TYPE as $key=>$value)
                                        <option
                                            value="{{ $key }}" {{ $edit && $meeting->meeting_type == $key? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="template_id">{{ __('generic.template') }}</label>
                                <select class="form-control custom-form-control select2"
                                        name="template_id"
                                        id="template_id"
                                        data-placeholder="{{ __('generic.select_placeholder') }}">
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    @foreach($templates as $key=>$template)
                                        <option
                                            value="{{ $template->id }}" {{ $edit && $meeting->template_id == $template->id? 'selected' : '' }}>
                                            {{ $template->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="resolution_file">{{ __('generic.resolution_file') }} </label>
                                @if($edit && !empty($meeting->resolution_file))
                                    @if(pathinfo( !empty($meeting->resolution_file)? $meeting->resolution_file : '', PATHINFO_EXTENSION) === 'pdf')
                                        <a
                                            target="_blank"
                                            href="{{ asset("storage/{$meeting->resolution_file}") }}"
                                            style="color: #3f51b5;font-weight: bold;"
                                            type="button"
                                            class="btn p-0 float-right">
                                            {{ __('generic.show_uploaded_resolution_file') }}
                                        </a>
                                    @else
                                        <button
                                            style="color: #3f51b5;font-weight: bold;"
                                            type="button"
                                            class="btn p-0 float-right bg-warning"
                                            data-toggle="modal"
                                            data-target="#resolution_file_viewer">
                                            {{ __('generic.show_uploaded_resolution_file') }}
                                        </button>
                                    @endif
                                @endif

                                <div class="input-group" style="height: 45px">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01"
                                              style="background: #50177c33;">
                                           <i class="fas fa-upload"></i>&nbsp; {{ __('generic.upload') }}
                                        </span>
                                    </div>
                                    <div class="custom-file" style="height: 45px">
                                        <input type="file"
                                               class="custom-file-input custom-form-control"
                                               name="resolution_file"
                                               id="resolution_file">
                                        <label class="custom-file-label" for="resolution_file"
                                               style="height: 45px">
                                            {{ __('generic.no_file_chosen') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" id="worksheet-area">
                            <div class="form-group">
                                <label for="worksheet">{{ __('generic.worksheet') }}</label>
                                <textarea name="worksheet"
                                          id="worksheet">{{ $edit && !empty($meeting->worksheet) ? $meeting->worksheet : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit"
                                    class="btn btn-success form-submit">{{ __('generic.save') }}</button>
                        </div>
                    </div>
                    <div class="overlay" style="display: none">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal for  view -->
    <div class="modal fade" id="resolution_file_viewer" tabindex="-1" role="dialog"
         aria-labelledby="resolution_file_viewerTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resolution_file_viewerTitle">
                        {{ __('generic.uploaded_resolution_file') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img
                        src="{{ !empty($meeting->resolution_file)? asset("storage/{$meeting->resolution_file}"):'' }}"
                        alt="{{ __('generic.uploaded_file') }}" width="100%">
                </div>
            </div>
        </div>
    </div>



    <div id="loading-sniper"
         style="z-index: 99999; position: fixed; height: 100vh;width: 100%;top: 0px; left: 0; right: 0; bottom: 0px; background: rgba(0,0,0,.4); display: none; overflow: hidden;">
        <div class="holder" style="width: 200px;height: 200px;position: relative; margin: 10% auto;">
            <img src="/images/loading.gif" style="width: 75px;margin: 34%;">
        </div>
    </div>

@endsection

@push('css')
    <style>
        .custom-file-input:lang(en) ~ .custom-file-label::after {
            content: "Browse";
            height: 43px;
        }

    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{--    <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>--}}
    <script>
        (function () {
            function showLoader() {
                $('#loading-sniper').show();
                $('body').css('overflow', 'hidden');
            }

            function hideLoader() {
                $('#loading-sniper').hide();
                $('body').css('overflow', 'auto');
            }

            const EDIT = !!'{{$edit}}';

            const editAddForm = $('.edit-add-form');
            editAddForm.validate({

                rules: {
                    title: {
                        required: true,
                    },
                    meeting_no: {
                        required: true,
                        remote: {
                            type: "post",
                            url: "{!! route('admin.meeting_management.meetings.meeting-no-check') !!}",
                            data: {
                                'id': function () {
                                    return '{!! !empty($meeting->id)?$meeting->id:null !!}';
                                }
                            }
                        },
                    },
                    meeting_date: {
                        required: true,
                    },
                    committee_type_id: {
                        required: true,
                    },
                    template_id: {
                        required: true,
                    },
                    resolution_file: {
                        required: false,
                        extension: "jpg|pdf"
                    },

                },
                messages: {
                    title: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    meeting_no: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    meeting_date: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    committee_type_id: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    template_id: {
                        required: "{{ __('generic.field_is_required') }}",
                    },

                    resolution_file: {
                        required: "{{ __('generic.field_is_required') }}",
                        extension: "{{ __('generic.valid_extension') }} [ jpg/pdf ]"
                    },

                },
                submitHandler: function (htmlForm) {
                    $('.overlay').show();

                    const form = $(htmlForm);
                    const formData = new FormData(htmlForm);
                    const url = form.attr("action");
                    console.log('formData', form, formData, url)

                    $.ajax({
                        url: url,
                        data: formData,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log('response', response)
                            $('.overlay').hide();
                            let alertType = response.alertType;
                            let alertMessage = response.message;
                            let alerter = toastr[alertType];
                            alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");

                            if (response.redirectTo) {
                                setTimeout(function () {
                                    window.location.href = response.redirectTo;
                                }, 1000);
                            }

                        },
                    });

                    return false;
                }
            });

            tinymce.init({
                selector: '#worksheet',
                plugins: 'code lists advlist searchreplace searchreplace table textcolor',
                menubar: 'edit insert table',
                toolbar: 'undo redo |table| bold italic underline | fontselect fontsizeselect formatselect| alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat  | emoticons | preview | insertfile image  link | searchreplace code  ',
                table_grid: true,
                toolbar_sticky: true,
                image_advtab: true,
                importcss_append: true,
                image_caption: true,
                height: 600,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_noneditable_class: 'mceNonEditable',
                toolbar_mode: 'sliding',
                contextmenu: 'link image imagetools table',
                paste_data_images: true,
                content_css: 'default',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
            });

            $('#worksheet-area').mouseleave(function () {
                let editorContent = tinymce.get('worksheet').getContent();
                $('#worksheet').val(editorContent);
            });

            $('#template_id').on('change', function (){
                let templateId = $(this).val();
                $.ajax({
                    url: '{{ route('admin.meeting_management.templates.load-template-details') }}',
                    data: {
                        'template_id': templateId,
                    },
                    type: 'POST',
                    success: function (response) {
                        let loadTemplateDetails = response.data.description
                        tinyMCE.activeEditor.setContent(loadTemplateDetails);
                    },
                });
            });

            $('#resolution_file').on('change', function () {
                let fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

        })();
    </script>
@endpush


