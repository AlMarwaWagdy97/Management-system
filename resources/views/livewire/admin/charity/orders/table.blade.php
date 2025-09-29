<tr>
    @php
        $payment = 'payment_method_'. app()->getLocale();
        $status = 'status_'. app()->getLocale();
    @endphp
    <td>
        <input type="checkbox" class="checkbox-check" wire:click="updateSellected({{ $item->id }})"
            wire:model="mySelected" value="{{ $item->id }}" {{ in_array($mySelected, [$item->id]) ? 'selected' : '' }}>
    </td>
    <td>{{ $index }}</td>
    <td>{{ $item->identifier }}</td>
    <td>{{ $item->total }}</td>
    <td>{{ $item->full_name }}</td>
    <td>{{ $item->donor_mobile }}</td>
    <td>{{ $item->donor_email }}</td>
    <td> projects</td>
    <td>{{ $item->source }}</td>
    <td> {{ $item->payment_method_ar }} </td>

    <td> {{-- bank transfer --}}
        <button class="btn btn-secondary btn-sm">
            @lang('admin.show')
        </button>
    </td>
    <td> {{-- payment configraqtion --}}
        <button class="btn btn-secondary btn-sm">
            @lang('admin.show')
        </button>
    </td>
    <td> {{-- gift --}}
        <button class="btn btn-secondary btn-sm">
            @lang('admin.show')
        </button>
    </td>

    <td> {{ $item->$status }} </td>

    <td> {{ date('H:i:s d-m-Y', strtotime($item->created_at))  }} </td>
    {{-- <td> {{ date('H:i:s d-m-Y', strtotime($item->updated_at)) }} </td> --}}

    
    <td>
        <div class="d-flex justify-content-center bulk-order">
            @switch ($item->status) 
            @case('0')
                <a data-hover="@lang('Pending')" class="btn btn-neutral text-warning order-action" data-toggle="tooltip" title="" data-original-title="@lang('Pending')">
                    <i class="bx bx-no-entry"></i>
                </a>
                @break
            @case(1)
                <a data-hover="@lang('Confirmed')" class="btn btn-neutral text-success order-action" data-toggle="tooltip" title="" data-original-title="@lang('Confirmed')">
                    <i class='bx bx-check-circle'></i>
                </a>
                @break
            @case(3)
                <a data-hover="@lang('Waiting')" class="btn btn-neutral text-info order-action" data-toggle="tooltip" title="" data-original-title="@lang('Waiting')" aria-describedby="tooltip358766">
                    <i class='bx bx-history'></i>
                </a>
                @break
            @case(4)
                <a data-hover="@lang('Canceled')" class="btn btn-neutral text-danger order-action" data-toggle="tooltip" title="" data-original-title="@lang('Canceled')" aria-describedby="tooltip358766">
                    <i class='bx bx-window-close'></i>
                </a>
                @break
            @endswitch
        

          
            <a data-hover="@lang('admin.show')" href="{{ route('admin.orders.show', $item->id) }}"
                class="btn btn-neutral text-info" wire:click="show({{ $item->id }})"><i
                    class="bx bxs-show"></i></a>

            <button type="button" wire:click.prevent="deleteId({{ $item->id }})" data-hover="@lang('admin.delete')"
                class="btn btn-neutral text-danger"data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                <i class="bx bxs-trash"></i>
            </button>


        </div>

    </td>
</tr>