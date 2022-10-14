@php
    $edit = !empty($template->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();

$langBn = Session::get('locale') != 'en';
@endphp


@extends('master::layouts.master')
@section('title')
    {{!$edit ? __('generic.add_new'): __('generic.update')}}
@endsection
@section('content')
    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js"></script>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{!$edit ? __('generic.add_new'): __('generic.update')}}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.meeting_management.templates.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{$edit ? route('admin.meeting_management.templates.update', $template->id) : route('admin.meeting_management.templates.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    @if($edit)
                        @method('put')
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">{{ __('generic.title_bn') }}
                                    <span class="text-danger"> *</span>
                                </label>
                                <input type="text" class="form-control custom-form-control"
                                       name="title"
                                       id="title"
                                       value="{{$edit ? $template->title : ''}}"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title_en">{{ __('generic.title_en') }}
                                    <span class="text-danger"> *</span>
                                </label>
                                <input type="text" class="form-control custom-form-control"
                                       name="title_en"
                                       id="title_en"
                                       value="{{$edit ? $template->title_en : ''}}"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="template_type">{{ __('generic.template_type') }}
                                    <span class="text-danger"> *</span>
                                </label>
                                <select class="form-control custom-form-control"
                                        name="template_type"
                                        id="template_type">
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    @foreach(\Modules\Meeting\Models\Template::TEMPLATE_TYPE as $key=>$value)
                                        <option
                                            value="{{ $key }}" {{ $edit && $key== $template->template_type?'selected':''}}>
                                            {{ __('generic.'.$value) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" id="description-area">
                            <div class="form-group">
                                <label for="description">{{ __('generic.description') }}
                                    <span class="text-danger"> *</span>
                                </label>
                                <textarea class="form-control"
                                          id="description"
                                          name="description">{!! $edit ? $template->description : '' !!}</textarea>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" name="status" value="3"
                                    class="btn btn-success form-submit">{{ /*$edit ?__('generic.update') : */__('generic.save') }}</button>
                        </div>
                    </div>
                    <div class="overlay" style="display: none">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>

                </form>
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
{{--    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">--}}
    <style>
        em#description-error {
            position: absolute;
            bottom: -7px;
            left: 10px;
        }

    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                    title_en: {
                        required: true,
                    },
                    template_type: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },

                },
                messages: {
                    title: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    title_en: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    template_type: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    description: {
                        required: "{{ __('generic.field_is_required') }}",
                    },

                },
                submitHandler: function (htmlForm) {
                    $('.overlay').show();

                    const form = $(htmlForm);
                    const formData = new FormData(htmlForm);
                    const url = form.attr("action");

                    $.ajax({
                        url: url,
                        data: formData,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            $('.overlay').hide();
                            let alertType = response.alertType;
                            let alertMessage = response.message;
                            let alerter = toastr[alertType];
                            alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");

                            if (response.redirectTo) {
                                setTimeout(function () {
                                    window.location.href = response.redirectTo;
                                }, 100);
                            }

                        },
                    });

                    return false;
                }
            });

            tinymce.init({
                selector: '#description',
                plugins: 'code lists advlist searchreplace searchreplace table textcolor',
                menubar: 'edit insert table',
                toolbar: 'undo redo |table| bold italic underline | fontselect fontsizeselect formatselect| alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat  | emoticons | preview | insertfile image  link | searchreplace code  ',
                table_grid: true,
                toolbar_sticky: true,
                image_advtab: true,
                importcss_append: true,
                image_caption: true,
                height: 300,
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

            $('#description-area').mouseleave(function(){
                let editorContent = tinymce.get('description').getContent();
                $('#description').val(editorContent);

                /*if ($('#description').val().length > 0) {
                    $('#description').valid(true);
                } else {
                    $('#description').valid(false);
                }*/
            });

        })();

    </script>
@endpush


