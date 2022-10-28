@extends('master::layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(!empty($totalApplication)? count($totalApplication):0) }}</h3>
                        <p>মোট আবেদন</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.landless.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>

        .card-block .rotate i {
            color: rgba(20, 20, 20, 0.15);
            position: absolute;
            left: auto;
            right: 15px;
            bottom: 10px;
            display: block;
        }
    </style>
@endpush

@push('js')
    <script src="{{asset('/js/chart-js/chart.min.js')}}"></script>
    <script>
        let chartData = [{{ 0 }},{{ 0 }}];
        let xValuesKhasland = ["বিতরণযোগ্য খাস জমি " + chartData[0], "বিতরণকৃত খাস জমি " + chartData[1]];
        let yValuesKhasland = chartData;
        let barColorsKhasland = [
            "#f603ff",
            "#fff420",
        ];

        new Chart("khaslandChart", {
            type: "doughnut",
            data: {
                labels: xValuesKhasland,
                datasets: [{
                    backgroundColor: barColorsKhasland,
                    data: yValuesKhasland
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        displayColors: true
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: false,
                        },
                    },
                }
            }
        });
    </script>


    <script>
        let dataRegEightChart = {{ json_encode(0) }};

        //let xValues = ["প্রথম খণ্ড - জনগণের ব্যবহৃত বন্দোবস্তযোগ্য নহে", "দ্বিতীয় খণ্ড - বন্দোবস্তযোগ্য", "তৃতীয় খণ্ড - ক্রীত, পুনঃগ্রহনকৃত ও পরিব্যক্ত", "চতুর্থ খণ্ড - সিকস্তি জমি"];
        let xValues = ["প্রথম খণ্ড", "দ্বিতীয় খণ্ড", "তৃতীয় খণ্ড", "চতুর্থ খণ্ড"];
        let yValues = dataRegEightChart;
        let barColors = ["#028AFC", "#fff420", "#fc0287", "#0cfd2d"];

        let myRegEightChartChart = new Chart("regEightChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues,
                    borderWidth: 1,
                    borderRadius: 5,
                    borderSkipped: false,
                    barPercentage: 0.8,
                },

                ]
            },
            options: {
                plugins: {
                    tooltip: {
                        displayColors: false
                    },
                    legend: {
                        display: false,
                        position: 'bottom',
                        labels: {
                            usePointStyle: false,
                        },
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                        }
                    },
                    y: {
                        grid: {
                            display: true,
                            borderDash: [4, 4],
                            beginAtZero: true,
                        },
                    },
                },
            }

        });
    </script>
@endpush

