    <!-- sample modal content -->
    <div id="show{{ $item->id }}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog table-responsivee">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">{{ $item->first_name }} {{ $item->last_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  ">
                    <h5>{{ $item->subject }}</h5>
                    <p class="msg-text">{{ $item->message }}</p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<style>

</style>