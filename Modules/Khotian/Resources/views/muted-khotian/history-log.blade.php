@if(count($historyLogs) == 0)
    <h4 class="text text-danger">কোন হিস্টরি লগ পাওয়া যায়নি</h4>
@else
<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <td>ক্রম</td>
                <td>অবস্থা</td>
                <td>তারিখ</td>
                <td>নাম</td>
                <td>মন্তব্য</td>
            </tr>
        </thead>
        <tbody>
            @foreach($historyLogs as $key => $historyLog)
                <tr>
                    <td>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(++$key) }}</td>
                    <td>
                        @php
                            $status = '';
                            if($historyLog->is_taken_action == 3){
                                $status = 'নকল';
                            }elseif ($historyLog->is_taken_action == 4){
                                $status = 'অনুমোদিত';
                            }elseif ($historyLog->status == 2 && $historyLog->stage == 2 && $historyLog->is_taken_action == 2){
                                $status = 'নকল';
                            }elseif ($historyLog->status == 2 && $historyLog->stage == 3 && $historyLog->is_taken_action == 2){
                                $status = 'তুলনা';
                            }elseif ($historyLog->status == 4 && $historyLog->stage == 2 && $historyLog->is_taken_action == 2){
                                $status = 'পুনঃনকল';
                            }elseif ($historyLog->status == 4 && $historyLog->stage == 3 && $historyLog->is_taken_action == 2){
                                $status = 'পুনঃতুলনা';
                            }elseif ($historyLog->status == 2 && $historyLog->stage == 4 && ($historyLog->is_taken_action == 0 || $historyLog->is_taken_action == 1)){
                                $status = 'সংশোধন প্রয়োজন';
                            }elseif ($historyLog->status == 4 && $historyLog->stage == 4 && ($historyLog->is_taken_action == 0 || $historyLog->is_taken_action == 1)){
                                $status = 'সংশোধন প্রয়োজন';
                            }elseif ($historyLog->status == 2 && $historyLog->stage == 3 && ($historyLog->is_taken_action == 0 || $historyLog->is_taken_action == 1)){
                                $status = 'সংশোধন প্রয়োজন';
                            }elseif ($historyLog->status == 4 && $historyLog->stage == 3 && ($historyLog->is_taken_action == 0 || $historyLog->is_taken_action == 1)){
                                $status = 'সংশোধন প্রয়োজন';
                            }
                        @endphp
                        {{ $status }}
                    </td>
                    <td>{{ \App\Helpers\Classes\EnglishToBanglaDate::dateFormatEnglishToBangla($historyLog->created_at) }}</td>
                    <td>{{ $historyLog->name??'' }}</td>
                    <td>{{ $historyLog->remark }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
