<tr>
    <td>
        <input type="checkbox" class="checkbox-check" wire:click="updateSellected({{ $item->id }})" wire:model="mySelected" value="{{ $item->id }}" {{ in_array($mySelected, [$item->id]) ? 'selected' : '' }}>
    </td>
    <td>{{ $index }}</td>
    <td>
        {{ @$item->trans->where('locale', $current_lang)->first()->title  }}
    </td>
    <td>{{ $item->number }}</td>
    <td>{{$item->category ? $item->category->trans->where('locale', $current_lang)->first()->title :""  }}</td>
    <td>{{ @$item->badalField->badal_type }}</td>

    <td>{{ @json_decode($item->donation_type, true)['data'] }}</td>
    <td>{{ @$item->badalField->min_price }}</td>
    <td width="120px">
        <div class="d-flex">
            <input type="number" name="sort" wire:model="sort" class="form-control p-0 mx-1">
            <span wire:click="update_sort({{ $item->id }})" class="btn btn-sm btn-primary py-0 px-1">@lang('admin.change')</span>
        </div>
    </td>
    <td>{{ $item->created_at }}</td>
    <td>{{ $item->updated_at }}</td>

    <td>
        <div class="d-flex justify-content-center">
            {{-- Start Statue  --}}
            @if ($item->status == 1)
                <a data-hover="@lang('admin.active')" class="btn btn-neutral text-success" wire:click="update_status({{ $item->id }})"><i class="bx bxs-check-square"></i></a>
            @else
                <a data-hover="@lang('admin.dis_active')" class="btn btn-neutral text-secondary" wire:click="update_status({{ $item->id }})"><i class="bx bx-no-entry"></i></a>
            @endif
            {{-- End Statue  --}}

            {{-- Start Feature --}}
            @if ($item->featuer == 1)
                <a data-hover="@lang('admin.feature')" class="btn btn-neutral text-success" wire:click="update_featured({{ $item->id }})"><i class="bx bxs-star"></i></a>
            @else
                <a data-hover="@lang('admin.feature')" class="btn btn-neutral text-secondary" wire:click="update_featured({{ $item->id }})"><i class="bx bxs-star"></i></a>
            @endif
            {{-- End Feature  --}}

            <a data-hover="@lang('admin.show')" href="{{ route('admin.badal.projects.show', $item->id) }}" class="btn btn-neutral text-info" wire:click="show({{ $item->id }})"><i class="bx bxs-show"></i></a>


            <a data-hover="@lang('admin.edit')" href="{{ route('admin.badal.projects.edit', $item->id) }}" class="btn btn-neutral text-primary"><i class="bx bxs-edit"></i></a>
            <a data-hover="@lang('admin.review')" href="{{ route('admin.badal.projects.reviews',$item->id) }}" class="btn btn-neutral text-warning"><i class="bx bx-comment-dots""></i></a>


            <button type="button" data-hover="@lang('admin.delete')" wire:click.prevent="deleteId({{ $item->id }})" class="btn btn-neutral text-danger" data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                <i class="bx bxs-trash"></i>
            </button>


        </div>
    </td>
</tr>
