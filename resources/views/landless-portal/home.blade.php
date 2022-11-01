@extends('master::layouts.landing-page-master')

@section('title')
    Home
@endsection

@section('content')
    <div class="container" id="main-container">

        @include('master::landless-portal.utils.slider')

        <div class="main-content-area p-3"
             style="margin-bottom: 150px; background: #ffffff; box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3" style="max-width: 540px;">
                                <a href="{{ route('landless.application') }}">
                                    <div class="row no-gutters py-3 px-4">
                                        <div class="col-2 col-md-4">
                                            <img style="height: 100px; width: 100px"
                                                 src="images/apply-icon.svg"
                                                 class="card-img rounded-circle align-middle application-icon"
                                                 alt="...">
                                        </div>
                                        <div class="col-10 col-md-8">
                                            <div class="card-body">
                                                <h4 class="text-success application-label" style="padding: 11px 0;">
                                                   Registration
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3" style="max-width: 540px;">
                                <a href="#">
                                    <div class="row no-gutters py-3 px-4">
                                        <div class="col-2 col-md-4">
                                            <img style="height: 100px; width: 100px"
                                                 src="images/application-track-icon.svg"
                                                 class="card-img rounded-circle align-middle application-icon"
                                                 alt="...">
                                        </div>
                                        <div class="col-10 col-md-8">
                                            <div class="card-body">
                                                <h4 class="text-success application-label" style="padding: 11px 0;">
                                                    Donate</h4>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>About CADT</h3>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-row">
                                        <p>Center for Alternative Development Trust (CADT) is a research driven development
                                            organization in Bangladesh. It aims to explore value-based knowledge and skills to devise
                                            human and social progress in line of the national and community development agenda.
                                            CADT is established and patronized by a group of philanthropist, activists and reputed
                                            corporate houses in response of societal responsibility.</p>

                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <h3>Scope of Work</h3>
                                            </div>

                                            <p>
                                                CADT is a dynamic organization ready to respond community in changing needs in a
                                                changing world. Currently, we have three institutions as follows:
                                                1. Academy of Quran is a high-end research facility to explore Quranic knowledge
                                                for the welfare of humankind
                                                2. Academy of Zakat is a community-based outlet to develop and test applications
                                                to use Zakat and charity
                                                3. Academy of Leadership, Innovation and Practice Area (ALIPA) is the front-line
                                                platform to develop and expand the scope of business opportunity around the
                                                humanitarian actions
                                            </p>
                                            <div class="col-md-12">
                                                <h3>Mission, Vision and Values</h3>
                                            </div>
                                            <p>
                                            CADT envisions a harmonious society based on our values and respond to the need of the
                                            community. We develop our portfolio in below areas:</p>
                                            ▪ Education and Skills
                                            ▪ Employability and Economic Wellbeing
                                            ▪ Resiliency and Tolerance
                                            CADT believes in human dignity, equal rights to live and compassion for all.
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-1"></div>

                <div class="col-md-3 ">
                    @include('master::landless-portal.utils.sidebar')
                </div>

                <div class="col-md-12">
                    <div class="p-4">
                        <h3 class="text-center">Our Recent Activities-2022</h3>
                        <div class="row">
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center">Webminers</th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">12</b>
                                            <p>Online</p>
                                        </td>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">32</b>
                                            <p>On-premise</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center">Our papers
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">0</b>
                                            <p>Accepted</p>
                                        </td>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">3</b>
                                            <p>Accepted</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center">
                                          Self development alignment
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success"
                                               style="font-size: 20px;display: block;padding: 20px;}">
                                                20
                                            </b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center"> Our satisfaction
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success"
                                               style="font-size: 20px;display: block;padding: 20px;}">
                                                100
                                            </b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        @media screen and (max-width: 680px) {
            /*.carousel-item{
                height: 30px!important;
            }*/
            .application-icon {
                height: 50px !important;
                width: 50px !important;
            }

            .application-label {
                padding: 0 !important;
                margin-top: -10px;
            }

            .site-footer {
                text-align: center;
            }
        }


    </style>
@endpush

