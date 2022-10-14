@extends('master::layouts.master')

@section('title')
    User Dashboard
@endsection
@section('content')
    <section class="routine-calendar mt-5">
        <div class="container pb-3">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-heading">{{__('generic.routines')}}</h2>
                </div>
            </div>
        </div>
        <div class="container p-5 card">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="accordion-heading"
                                id="eventDateTime"></h3>
                            <!-- Accordion -->
                            <div id="eventArea" class="accordion">

                            </div>
                            <!-- End -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 rounded">
                    <div id='calendar'></div>
                </div>
            </div>

        </div>
    </section>
@endsection
