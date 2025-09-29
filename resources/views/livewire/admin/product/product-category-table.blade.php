<tr>
    <td>
        <input type="checkbox" class="checkbox-check" wire:click="updateSellected({{ $item->id }})"
            wire:model="mySelected" value="{{ $item->id }}"
            {{ in_array($mySelected, [$item->id]) ? 'selected' : '' }}>
    </td>
    <td>{{ $index }}</td>
    <td>
        {!! @$item->trans()->where('locale', $current_lang)->first()->title !!} <br>
    </td>
    <td>
        {{ substr(removeHTML(@$item->translate()->description), 0, 30) }}
    </td>
    <td>{{ $item->sort }}</td>

    <td>{{ $item->created_at }}</td>
    <td>{{ $item->updated_at }}</td>

    <td>
        <div class="d-flex justify-content-center">
            @if ($item->status == 1)
                <a data-hover="@lang('admin.active')" class="btn btn-xs btn-neutral text-success btn-sm m-1"
                    wire:click="update_status({{ $item->id }})"><i class="bx bxs-check-square"></i></a>
            @else
                <a data-hover="@lang('admin.dis_active')" class="btn btn-xs btn-neutral text-warning btn-sm m-1"
                    wire:click="update_status({{ $item->id }})"><i class="bx bx-no-entry"></i></a>
            @endif

            @if ($item->feature == 1)
                <a data-hover="@lang('admin.feature')" class="btn btn-xs btn-neutral text-success btn-sm m-1"
                    wire:click="update_featured({{ $item->id }})"><i class="bx bxs-star"></i></a>
            @else
                <a data-hover="@lang('admin.feature')" class="btn btn-xs btn-neutral text-warning btn-sm m-1"
                    wire:click="update_featured({{ $item->id }})"><i class="bx bxs-star"></i></a>
            @endif
            <a data-hover="@lang('admin.show')" href="{{ route('admin.eccommerce.categories.show', $item->id) }}"
                class="btn btn-xs btn-neutral text-info btn-sm m-1"><i
                    class="bx bxs-show"></i></a>


            <a data-hover="@lang('admin.edit')" href="{{ route('admin.eccommerce.categories.edit', $item->id) }}"
                class="btn btn-neutral text-primary btn-sm m-1"><i class="bx bxs-edit"></i></a>

            <button type="button" wire:click.prevent="deleteId({{ $item->id }})"
                class="btn btn-neutral text-danger btn-sm m-1"data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                <i class="bx bxs-trash"></i>
            </button>


        </div>

    </td>
</tr>
