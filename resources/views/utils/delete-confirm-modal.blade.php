<div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header custom-bg-gradient-info">
                <h4 class="modal-title">
                    <i class="fas fa-trash"></i> {{ __('generic.are_you_sure') }}
                </h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="{{ __('voyager::generic.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="delete_model_body">
                {{ __('generic.it_will_delete_permanently') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right"
                        data-dismiss="modal">{{ __('generic.cancel') }}</button>
                <form action="#" id="delete_form" method="POST">
                    {{ method_field("DELETE") }}
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-danger pull-right delete-confirm"
                           value="{{ __('generic.confirm') }}">
                </form>
            </div>
        </div>
    </div>
</div>
