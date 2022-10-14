@extends('master::layouts.front-end')
@section('title')
    {{ env('APP_NAME')."-Login" }}
@endsection

@section('header')
    <style>
        .color-white{
            color: #fff;
        }
    </style>
@endsection
@section('footer', '')

@section('full_page_content')
    <div class="container-fluid login-page">
        <div class="row">
            <div class="col-md-12">
                <div class="login-box">
                    <div class="login-logo">
                        <a href="{{ url('/') }}"><b>{{__('generic.lrms_noakhali')}}</a>
                    </div>

                    <div class="card" style="background: #fff0;
    box-shadow: none;">
                        <div class="card-body login-card-body">
{{--                            <p class="login-box-msg">{{__('generic.lrms_login')}}</p>--}}
                            <form class="login-form" action="{{route('admin.login')}}" method="post">
                                {{ csrf_field() }}
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="{{__('email')}}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope color-white"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" placeholder="{{__('password')}}" autocomplete="off" name="password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock color-white"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        {{--<div class="icheck-primary">
                                            <input type="checkbox" id="remember">
                                            <label for="remember">
                                                Remember Me
                                            </label>
                                        </div>--}}
                                    </div>

                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-block">{{__('generic.login')}}</button>
                                    </div>

                                </div>
                            </form>
                            {{--<div class="social-auth-links text-center mb-3">
                                <p>- OR -</p>
                                <a href="#" class="btn btn-block btn-primary">
                                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                                </a>
                                <a href="#" class="btn btn-block btn-danger">
                                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                                </a>
                            </div>

                            <p class="mb-1">
                                <a href="forgot-password.html">I forgot my password</a>
                            </p>
                            <p class="mb-0">
                                <a href="register.html" class="text-center">Register a new membership</a>
                            </p>--}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <x-generic-validation-error-toastr/>
    <script>
        const loginForm = $('.login-form');
        loginForm.validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush
