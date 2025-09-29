<div wire:ignore.self class="modal fade"  id="exampleModalLabel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('admin.delete_item')</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <h2 class="swal2-title" id="swal2-title" style="display: flex;">  @lang('admin.are_you_sure')</h2>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('button.cancel')</button>
            <button type="button" class="btn btn-danger" wire:click="delete()" class="btn btn-danger close-modal" data-bs-dismiss="modal">
              @lang('button.delete')
            </button>
          </div>
      </div>
    </div>
  </div>
</div>
