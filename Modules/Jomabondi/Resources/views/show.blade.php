@extends('master::layouts.master')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,300;1,400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Roboto", sans-serif!important;
        }

        .jomabondi-form p{
            margin-bottom: 0px;
        }

        .jomabondi-header{
            padding: 0px 20px;
        }

        table.table-bordered,
        table.table-bordered thead tr th,
        table.table-bordered tbody tr td{
            border:1px solid black;
            border-collapse: collapse;
        }

        .rotate{
            transform: rotate(-90deg);
            width: 90px;
            translate: -23px 32px;
        }

        table{
            table-layout: fixed;
            font-size: 13px;
            font-weight: normal;
        }

        table th, table td {
            overflow: hidden;
        }

        .table thead th{
            vertical-align: top;
        }

        @media print {
            #print-btn {
                display: none;
            }

            .main-footer{
                display: none;
            }

            table.table-bordered,
            table.table-bordered thead tr th,
            table.table-bordered tbody tr td{
                border:solid #000 !important;
                border-width:1px !important;
            }

        }
    </style>
@endpush
@section('content')
    <div class="container-fluid jomabondi-form">
        <div class="row">
            <div class="col-md-12">
                <button class="float-right btn btn-outline-info px-4" id="print-btn"
                        onclick="window.print()"><i
                        class="fas fa-print"></i> {{ __('generic.print') }}</button>
            </div> <br> <br>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row jomabondi-header">
                            <div class="col-md-8">
                                <p>S.A Form No. 34 </p>
                                <p>Jamabandi Of Land Of Mouza: 28/4 charbalua</p>
                                <h5><b>Rev. Circle :</b> Company Garage</h5>
                            </div>
                            <div class="col-md-4 text-right">
                                <p>Under Touzi No. <br><b>District Noakhali</b></p>
                            </div>
                        </div>
                        <p class="text-center" style="font-size: 1.25rem;"><b>Settlement Case No. 72/22-23 of 19 &emsp; 19</b></p>
                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th rowspan="2">Sl. No.</th>
                                        <th rowspan="2" style="width: 15%">Name Of Tenants with Address In Full </th>
                                        <th rowspan="2">Plot No.</th>
                                        <th rowspan="2">Area</th>
                                        <th rowspan="2">Total Area</th>
                                        <th rowspan="2">Rate Of Rent</th>
                                        <th rowspan="2">Rent</th>
                                        <th rowspan="2">Cess</th>
                                        <th rowspan="2">
                                            <p class="rotate">Education Cess</p>
                                        </th>
                                        <th rowspan="2">Salami</th>
                                        <th rowspan="1" colspan="3">
                                            Salami Realised
                                        </th>
                                        <th rowspan="2"><p style="rotate: -90deg;width: 55px;translate: -5px 30px;">Remarks</p></th>
                                    </tr>
                                    <tr>
                                        <th><p style="rotate: -90deg;width: 68px;translate:-16px -8px;">Amount Realised</p></th>
                                        <th><p style="rotate: -90deg;width: 55px;translate: -7px -5px;">Chalan No.</p></th>
                                        <th><p style="rotate: -90deg;width: 55px;translate: -7px;">Date</p></th>
                                    </tr>
                                    <tr class="text-center" style="line-height: 5px;">
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th>7</th>
                                        <th>8</th>
                                        <th>9</th>
                                        <th>10</th>
                                        <th>11</th>
                                        <th>12</th>
                                        <th>13</th>
                                        <th>14</th>
                                    </tr>
                                </thead>
                                <tbody class="text-top">
                                    <tr style="height: 600px;">
                                        <td>1</td>
                                        <td>sxas</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="line-height: 3px;">
                                        <td colspan="2">Installments: - 1<sup>st</sup></td>
                                        <td colspan="8"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="line-height: 3px;text-align: right;">
                                        <td colspan="2">2<sup>nd</sup></td>
                                        <td colspan="8"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="line-height: 3px;text-align: right;">
                                        <td colspan="2">3<sup>rd</sup></td>
                                        <td colspan="8"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="line-height: 3px;text-align: right;">
                                        <td colspan="2">4<sup>th</sup></td>
                                        <td colspan="8"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="line-height: 3px;text-align: right;">
                                        <td colspan="2">5<sup>th</sup></td>
                                        <td colspan="8"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="line-height: 3px;text-align: right;">
                                        <td colspan="2">6<sup>th</sup></td>
                                        <td colspan="8"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="line-height: 3px;text-align: right;">
                                        <td colspan="2">7<sup>th</sup></td>
                                        <td colspan="8"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="line-height: 3px;text-align: right;">
                                        <td colspan="2">8<sup>th</sup></td>
                                        <td colspan="8"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="line-height: 3px;text-align: right;">
                                        <td colspan="2">9<sup>th</sup></td>
                                        <td colspan="8"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="line-height: 3px;text-align: right;">
                                        <td colspan="2">10<sup>th</sup></td>
                                        <td colspan="8"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
