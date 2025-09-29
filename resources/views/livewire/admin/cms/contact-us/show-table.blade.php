<tr>
    <td>
        <input type="checkbox" class="checkbox-check" wire:click="updateSellected({{ $item->id }})"
            wire:model="mySelected" value="{{ $item->id }}" {{ in_array($mySelected, [$item->id]) ? 'selected' : '' }}>
    </td>
    <td>{{ $index }}</td>
    <td> {!! @$item->full_name !!} </td>
    <td> {!! @$item->phone !!} </td>
    <td> {!! @$item->email !!} </td>
    {{-- <td> {!! @$item->type !!} </td> --}}
    <td> {!! @$item->city !!} </td>
    <td> {!! @$item->title !!} </td>
    
    
    
    <td>
        {{ substr(removeHTML(@$item->message), 0, 30) }}
    </td>
    <td> {{ @$item->created_at }} </td>
    <td>
        <div class="d-flex justify-content-center">
            @can('admin.contact-us.read')
                @if ($item->status == 1)
                    <a title="@lang('contact_us.active')" class="btn btn-neutral text-success"
                        wire:click="update_status({{ $item->id }})"><i class='bx bx-check-double'></i></a>
                @else
                    <a title="@lang('contact_us.dis_active')" class="btn  btn-neutral text--secondary"
                        wire:click="update_status({{ $item->id }})"><i class='bx bx-check-double'></i></a>
                @endif
            @endcan

            <button type="button" class="btn btn-neutral text-primary" data-bs-toggle="modal"
                data-bs-target="#show{{ $item->id }}">
                <i class="bx bxs-show"></i></button>

            @can('admin.contact-us.destroy')
                <button type="button" wire:click="deleteId({{ $item->id }})"
                    class="btn btn-neutral text-danger"data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                    <i class="bx bxs-trash"></i>
                </button>
            @endcan

        </div>

    </td>
</tr>
<style>
 


</style>