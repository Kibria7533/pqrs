@php
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

<form action="{{ route('admin.meeting_management.meetings.landless-meeting-list-update',$meeting->id) }}"
      id="landless-meeting-list-form"
      method="post">
    {{ method_field("PUT") }}
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped" id="landless-meeting-list-table">
                <thead>
                <tr>
                    <th scope="col">{{ __('generic.sl_no') }}</th>
                    <th scope="col">ভূমিহীন (নাম)</th>
                    <th scope="col">সভায় অন্তর্ভুক্ত কিনা</th>
                    <th scope="col">অনুমোদনের অবস্থা</th>
                </tr>
                </thead>
                <tbody>
                @if(count($landless))
                    @foreach($landless as $key=>$landlessItem)
                        <tr>
                            <td>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(++$key) }}</td>
                            <td>{{ $landlessItem->fullname }}</td>
                            <td>{{ $landlessItem->meeting_id?__('generic.included'): __('generic.not_included') }}</td>
                            <td>{{ $landlessItem->stage == \Modules\Landless\App\Models\Landless::STAGE_UNO_APPROVED?__('generic.approved'): __('generic.not_approved') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">{{ __('generic.empty_table') }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-12 text-right">
            <span type="button" class="btn btn-warning pull-right"
                  data-dismiss="modal">{{ __('generic.cancel') }}</span>
            @if($authUser->can('updateMeetingLandless', $meeting))
                <a href="{{ route('admin.meeting_management.meetings.landless-pdf',$meeting->id) }}" type="submit"
                   class="btn btn-info pull-right" id="download-pdf">
                    <i class="fas fa-arrow-alt-circle-down"></i>
                    {{ __('generic.download') }}
                </a>
                <button type="submit" class="btn btn-success pull-right">
                    <i class="fas fa-sync-alt"></i>
                    {{ __('generic.update_landless_meeting') }}
                </button>
            @endif
        </div>
    </div>

</form>
