<style>
    table {
        margin: 20px;
        border: #ccc 1px solid;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px !important;
    }

    table th {
        padding: 4px 10px
    }

    table td {
        background: #fff;
        padding: 2px 10px 4px 10px
    }

    table tr.even td {
        background: #eee
    }

    table tr:last-child td:first-child {
        -moz-border-radius-bottomleft: 10px;
        -webkit-border-bottom-left-radius: 10px;
        border-bottom-left-radius: 10px
    }

    table tr:last-child td:last-child {
        -moz-border-radius-bottomright: 10px;
        -webkit-border-bottom-right-radius: 10px;
        border-bottom-right-radius: 10px
    }

    table.collapsed {
        border-collapse: collapse
    }

</style>

<div>
    <h3 style="text-align: center; width: 100%" class="text-danger">প্রাথমিকভাবে বাছাইকৃত ভূমিহীন সমূহ</h3>

    <table class="table" style="text-align: center; width: 100%; border: none">
        <thead>
        <tr>
            @if(\App\Helpers\Classes\AuthHelper::getAuthUser()->isDcUser())
                <td>{{ __('generic.district') }}: {{ $district }}</td>
            @else
                <td>{{ __('generic.upazila') }}: {{ $upazila }}</td>
                <td>{{ __('generic.district') }}: {{ $district }}</td>
            @endif

        </tr>
        </thead>
    </table>

    <table class="table table-bordered rounded" style="text-align: center; width: 100%; border-radius: 10px">
        <thead>
        <tr>
            <td>{{ __('generic.sl_no') }}</td>
            <td>{{ __('generic.name') }}</td>
            <td>{{ __('generic.father_or_husband') }}</td>
            <td>{{ __('generic.address') }}</td>
            {{--<td>{{ __('generic.status') }}</td>--}}
        </tr>
        </thead>
        <tbody>
        @if(!empty($landless))
        @foreach($landless as $key=>$landlessItem)
            <tr class="{{ $key%2==0?'even':'' }}">
                <td>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(++$key) }}</td>
                <td>{{ $landlessItem->fullname }}</td>
                <td>{{ $landlessItem->father_name }}</td>
                <td>{{ $landlessItem->present_address }}</td>
                {{--<td>{{ $landlessItem->meeting_id? __('generic.included'): __('generic.not_included')}}</td>--}}
            </tr>
        @endforeach
        @else
            <tr style="border: 1px solid #333;" class="even">
                <td colspan="4" style="padding:10px; color: red">
                    {{ __('generic.empty_table') }}
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>


