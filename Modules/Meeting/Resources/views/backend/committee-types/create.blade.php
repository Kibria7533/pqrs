@php
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
    $langBn = Session::get('locale') != 'en';
@endphp


@extends('master::layouts.master')
@section('title')
    {{ __('generic.add_new_committee_type') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header custom-header-bg">
                <h3 class="card-title font-weight-bold">
                    {{ __('generic.add_new_committee_type') }}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.meeting_management.committee-types.index') }}"
                       class="btn btn-sm btn-primary btn-rounded">
                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="edit-add-form" method="post"
                      action="{{ route('admin.meeting_management.committee-types.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">{{ __('generic.committee_type_title') }} </label>
                                <input type="text" class="form-control custom-form-control"
                                       name="title"
                                       id="title"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title_en">{{ __('generic.committee_type_title_en') }} </label>
                                <input type="text" class="form-control custom-form-control"
                                       name="title_en"
                                       id="title_en"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="office_type">{{ __('generic.office_type') }}</label>
                                <select class="form-control custom-form-control"
                                        name="office_type"
                                        id="office_type">
                                    <option value="">{{ __('generic.select_placeholder') }}</option>
                                    @foreach(\Modules\Meeting\Models\committeeType::OFFICE_TYPE as $key=>$value)
                                        <option
                                            value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
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

    <div id="loading-sniper"
         style="z-index: 99999; position: fixed; height: 100vh;width: 100%;top: 0px; left: 0; right: 0; bottom: 0px; background: rgba(0,0,0,.4); display: none; overflow: hidden;">
        <div class="holder" style="width: 200px;height: 200px;position: relative; margin: 10% auto;">
            <img src="/images/loading.gif" style="width: 75px;margin: 34%;">
        </div>
    </div>

@endsection

@push('css')
    <style>
        em#gender-error {
            position: absolute;
            width: 160px;
            left: 0;
            bottom: -22px;
        }

        em#file_type-error {
            position: absolute;
            width: 160px;
            left: -13px;
            bottom: -31px;
        }

        em#father_is_alive-error {
            position: absolute;
            width: 160px;
            left: -13px;
            bottom: -31px;
        }

        .custom-file-input:lang(en) ~ .custom-file-label::after {
            content: "Browse";
            height: 43px;
        }

    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(function () {
            function showLoader() {
                $('#loading-sniper').show();
                $('body').css('overflow', 'hidden');
            }

            function hideLoader() {
                $('#loading-sniper').hide();
                $('body').css('overflow', 'auto');
            }

            $.validator.addMethod(
                "nidBn",
                function (value, element) {
                    let regexp = /^([০-৯]{10}|[০-৯]{17})$/i;
                    let regexp1 = /^(\d{10}|\d{17})$/i;
                    let re = new RegExp(regexp);
                    let re1 = new RegExp(regexp1);
                    return this.optional(element) || re.test(value) || re1.test(value);
                },
                "সঠিক এন.আই.ডি প্রদান করুন [শুধুমাত্র ১০/১৭ সংখ্যার এন.আই.ডি প্রদান করুন] "
            );

            const editAddForm = $('.edit-add-form');
            editAddForm.validate({
                rules: {
                    title: {
                        required: true,
                    },
                    title_en: {
                        required: true,
                    },
                    office_type: {
                        required: true,
                    }
                },
                messages: {
                    title: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    title_en: {
                        required: "{{ __('generic.field_is_required') }}",
                    },
                    office_type: {
                        required: "{{ __('generic.field_is_required') }}",
                    }
                },
                submitHandler: function (htmlForm) {
                    $('.overlay').show();

                    // Get some values from elements on the page:
                    const form = $(htmlForm);
                    const formData = new FormData(htmlForm);
                    const url = form.attr("action");

                    // Send the data using post
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

            let langEn = {{ Session::get('locale') == 'en' ? 1: 0 }};

        });
    </script>
@endpush


