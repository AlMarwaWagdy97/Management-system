<div wire:ignore.self class="modal fade"  id="exampleModalLabel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
          <h2 class="swal2-title mt-3" id="swal2-title">  @lang('admin.are_you_sure')</h2>
          <div class="modal-footer">
            <button type="button" class="btn btn-info text-white" data-bs-dismiss="modal">@lang('button.cancel')</button>
            <button type="button" wire:click="delete()" class="btn btn-danger close-modal" data-bs-dismiss="modal">
              @lang('button.delete')
            </button>
          </div>
      </div>
    </div>
  </div>
</div>
