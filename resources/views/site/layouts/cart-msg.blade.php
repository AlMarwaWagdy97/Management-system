<div>
    @if (@$msg['type'] == "warning")
    <div class="alert alert-warning alert-dismissible fade show p-1" role="alert">
        <small>{{ $msg['value'] }}</small>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding: 0.7rem 1rem; font-size: 13px;"></button>
    </div>
    @endif
    {{-- @if (@$msg['type'] == "success")
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <small>{{ $msg['value'] }}</small>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif --}}
</div>
