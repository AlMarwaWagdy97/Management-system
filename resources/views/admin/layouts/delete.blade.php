<div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">@lang('admin.delete_item')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2 class="swal2-title" id="swal2-title" style="display: flex;">@lang('admin.are_you_sure')</h2>
            </div>
            <div class="modal-footer">
                <form action="{{ route($route, $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">@lang('admin.no')</button>
                    <button type="submit" class="btn btn-danger">@lang('admin.yes')</button>
                </form>
            </div>
        </div>
    </div>
</div>