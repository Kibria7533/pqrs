@php
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') != 'en';
@endphp

@extends('master::layouts.master')
@section('title')
    {{ __('generic.add_notification') }}
@endsection
@section('content')
    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js"></script>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-paper-plane"></i> {{ __('generic.add_notification') }}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.meeting_management.meetings.meeting-committee-config', $meeting->id) }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{ route('admin.meeting_management.notifications.store', $meeting) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label for="title">{{ __('generic.meeting_name') }}: {{ $meeting->title }}</label>
                        </div>
                        <div class="col-md-12">
                            <input type="hidden" id="validation_field" name="validation_field">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 text-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           name="is_sms_enable"
                                           id="is_sms_enable" value="1">
                                    <label class="custom-control-label" for="is_sms_enable">
                                        {{ __('generic.sms_notification') }}
                                    </label>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email_template">{{ __('generic.sms_template') }}
                                    </label>
                                    <select class="form-control custom-form-control select2"
                                            name="sms_template"
                                            id="sms_template"
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                            disabled>
                                        <option value="">{{ __('generic.select_placeholder') }}</option>
                                        @foreach($smsTemplates as $key=>$smsTemplate)
                                            <option
                                                value="{{ $smsTemplate->id }}">
                                                {{ $smsTemplate->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" id="sms_notification_body-area">
                                <div class="form-group">
                                    <label for="sms_notification_body">{{ __('generic.sms_notification_body') }}
                                    </label>
                                    <textarea class="form-control"
                                              id="sms_notification_body"
                                              name="sms_notification_body"
                                              disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 text-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           name="is_email_enable"
                                           id="is_email_enable" value="1">
                                    <label class="custom-control-label" for="is_email_enable">
                                        {{ __('email_notification') }}
                                    </label>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email_template">{{ __('email_template') }}
                                    </label>
                                    <select class="form-control custom-form-control select2"
                                            name="email_template"
                                            id="email_template"
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                            disabled>
                                        <option value="">{{ __('generic.select_placeholder') }}</option>
                                        @foreach($emailTemplates as $key=>$emailTemplate)
                                            <option
                                                value="{{ $emailTemplate->id }}">
                                                {{ $emailTemplate->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" id="email_notification_body_area">
                                <div class="form-group">
                                    <label for="email_notification_body">{{ __('email_notification_body') }}
                                    </label>
                                    <textarea class="form-control"
                                              id="email_notification_body"
                                              name="email_notification_body" disabled></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" id="submit"
                                    class="btn btn-success form-submit">
                                <i class="fas fa-paper-plane"></i>
                                {{ __('generic.send_notification') }}
                            </button>
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
    <style>
        #validation_field-error{
            display: none !important;
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

            const editAddForm = $('.edit-add-form');
            editAddForm.submit(function (e) {
                e.preventDefault();
                if ($('#is_sms_enable').is(':checked')) {
                    $(".edit-add-form").validate().element('#sms_template');
                    $(".edit-add-form").validate().element('#sms_notification_body');

                    $('#validation_field').prop('disabled', true);
                } else if ($('#is_email_enable').is(':checked')) {
                    $(".edit-add-form").validate().element('#email_template');
                    $(".edit-add-form").validate().element('#email_notification_body');

                    $('#validation_field').prop('disabled', true);
                } else {
                    $('#validation_field').prop('disabled', false);
                    $(".edit-add-form").validate().element('#validation_field');
                    swal({
                        title: '{{ __('generic.something_wrong') }}',
                        text: '{{ __('generic.select_any_template') }}',
                        buttons: {
                            text: "{{ __('generic.cancel') }}",
                        },
                        icon: "warning",
                    });
                }


            }).validate({
                rules: {
                    sms_template: {
                        required: true,
                    },
                    sms_notification_body: {
                        required: true,
                    },
                    email_template: {
                        required: true,
                    },
                    email_notification_body: {
                        required: true,
                    },
                    validation_field: {
                        required: true,
                    },
                },
                messages: {

                    validation_field: {
                        required: '{{ __('generic.select_any_template') }}',
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
                },
                errorElement: "em",
                onkeyup: false,
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    element.parents(".form-group").addClass("has-feedback");

                    if (element.parents(".form-group").length) {
                        error.insertAfter(element.parents(".form-group").first().children().last());
                    } else if (element.hasClass('select2') || element.hasClass('select2-ajax-custom') || element.hasClass('select2-ajax')) {
                        error.insertAfter(element.parents(".form-group").first().find('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                    $(element).closest('.help-block').remove();
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                },
            });

            tinymce.init({
                selector: '#sms_notification_body',
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
                readonly: 1,
            });

            $('#sms_notification_body-area').mouseleave(function () {
                let editorContent = tinymce.get('sms_notification_body').getContent();
                $('#sms_notification_body').val(editorContent);
            });

            $('#sms_template').on('change', function () {
                let templateId = $(this).val();
                $.ajax({
                    url: '{{ route('admin.meeting_management.templates.load-template-details') }}',
                    data: {
                        'template_id': templateId,
                    },
                    type: 'POST',
                    success: function (response) {
                        let loadTemplateDetails = response.data.description
                        tinymce.get('sms_notification_body').setContent(loadTemplateDetails);
                    },
                });
            });

            tinymce.init({
                selector: '#email_notification_body',
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
                readonly: true,
            });

            $('#email_notification_body_area').mouseleave(function () {
                let editorContent = tinymce.get('email_notification_body').getContent();
                $('#email_notification_body').val(editorContent);
            });

            $('#email_template').on('change', function () {
                let templateId = $(this).val();
                $.ajax({
                    url: '{{ route('admin.meeting_management.templates.load-template-details') }}',
                    data: {
                        'template_id': templateId,
                    },
                    type: 'POST',
                    success: function (response) {
                        let loadTemplateDetails = response.data.description
                        tinymce.get('email_notification_body').setContent(loadTemplateDetails);
                    },
                });
            });

            $('#is_sms_enable').on('change', function (e) {
                if ($('#is_sms_enable').is(':checked')) {
                    $('#sms_template').prop('disabled', false);
                    $('#sms_notification_body').prop('disabled', false);
                    setMode('sms_notification_body', 'design');
                } else {
                    $('#sms_template').prop('disabled', true);
                    $('#sms_notification_body').prop('disabled', true);
                    setMode('sms_notification_body', 'readonly');
                }
            });

            $('#is_email_enable').on('change', function (e) {
                if ($('#is_email_enable').is(':checked')) {
                    $('#email_template').prop('disabled', false);
                    $('#email_notification_body').prop('disabled', false);
                    setMode('email_notification_body', 'design');
                } else {
                    $('#email_template').prop('disabled', true);
                    $('#email_notification_body').prop('disabled', true);
                    setMode('email_notification_body', 'readonly');
                }
            });

            function setMode(id, value) {
                tinymce.get(id).setMode(value);
            }

        })();

    </script>
@endpush


