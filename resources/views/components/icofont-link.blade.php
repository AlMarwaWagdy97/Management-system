<div>

    @switch ($status) 
    @case('0')
        <button class="btn btn-warning btn-sm py-1" data-toggle="tooltip" title="" data-original-title="@lang('Pending')">
            <i class="text-light fa fa-ban"></i>
        </button>
    @break

    @case(1)
        <button class="btn btn-success btn-sm py-1" data-toggle="tooltip" title="" data-original-title="@lang('Confirmed')">
            <i class="text-light fa fa-check-circle"></i>
        </button>
    @break
    @case(3)
        <button class="btn btn-info btn-sm py-1" data-toggle="tooltip" title="" data-original-title="@lang('Waiting')" aria-describedby="tooltip358766">
            <i class="text-light fa fa-history"></i>
        </button>
    @break

    @case(4)
        <button class="btn btn-danger btn-sm py-1" data-toggle="tooltip" title="" data-original-title="@lang('Canceled')" aria-describedby="tooltip358766">
            <i class='fa fa-times text-light'></i>
        </button>
    @break
    @endswitch
</div>

