<tr>
    <td>
        <input type="checkbox" class="checkbox-check" wire:click="updateSellected({{ $item->id }})"
            wire:model="mySelected" value="{{ $item->id }}" {{ in_array($mySelected, [$item->id]) ? 'selected' : '' }}>
    </td>
    <td>{{ $index }}</td>
    <td><a href="{{ getImage($item->background_image) }}"><img src="{{ getImageThumb($item->background_image) }}" alt="" width="75"></a></td>
    <td>
        {{  str_repeat('ـــ ', $item->level - 1) }}
        {{ @$item->trans->where('locale', $current_lang)->first()->title }}
    </td>
    <td>
        {{ substr(removeHTML(@$item->trans->where('locale', $current_lang)->first()->description), 0, 30) }}
    </td>
    <td>{{ $item->sort }}</td>

    <td>{{ $item->created_at }}</td>
    <td>{{ $item->updated_at }}</td>
    {{-- <td>
        @if (@$item->ads->first() == null)
            <a data-hover="@lang('admin.create')"
                href="{{ route('admin.ads.edit', ['id' => $item->id, 'model' => CategoryProjects::class]) }}"
                class="btn btn-neutral text-success btn-sm m-1"><i class="bx bx-plus-circle"></i></a>
        @else
            <a data-hover="@lang('admin.edit')"
                href="{{ route('admin.ads.edit', ['id' => $item->id, 'model' => CategoryProjects::class]) }}"
                class="btn btn-neutral text-primary btn-sm m-1"><i class="bx bxs-edit"></i></a>
            <a data-hover="@lang('admin.show')"
                href="{{ route('admin.ads.show', ['id' => $item->id, 'model' => CategoryProjects::class]) }}"
                class="btn btn-neutral text-info btn-sm m-1"><i class="bx bxs-show"></i></a>
        @endif
    </td> --}}
    <td>
        <div class="d-flex justify-content-center">
            @if ($item->status == 1)
                <a data-hover="@lang('admin.active')" class="btn btn-neutral text-success btn-sm m-1"
                    wire:click="update_status({{ $item->id }})"><i class="bx bxs-check-square"></i></a>
            @else
                <a data-hover="@lang('admin.dis_active')" class="btn btn-neutral text-warning btn-sm m-1"
                    wire:click="update_status({{ $item->id }})"><i class="bx bx-no-entry"></i></a>
            @endif

            @if ($item->feature == 1)
                <a data-hover="@lang('admin.feature')" class="btn btn-neutral text-success"
                    wire:click="update_featured({{ $item->id }})"><i class="bx bxs-star"></i></a>
            @else
                <a data-hover="@lang('admin.feature')" class="btn btn-neutral text-warning"
                    wire:click="update_featured({{ $item->id }})"><i class="bx bxs-star"></i></a>
            @endif
            <a data-hover="@lang('admin.show')" href="{{ route('admin.charity.categories.show', $item->id) }}"
                class="btn btn-neutral text-info" wire:click="show({{ $item->id }})"><i
                    class="bx bxs-show"></i></a>


            <a data-hover="@lang('admin.edit')" href="{{ route('admin.charity.categories.edit', $item->id) }}"
                class="btn btn-neutral text-primary"><i class="bx bxs-edit"></i></a>

            <button type="button" wire:click.prevent="deleteId({{ $item->id }})" data-hover="@lang('admin.delete')"
                class="btn btn-neutral text-danger"data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                <i class="bx bxs-trash"></i>
            </button>


        </div>

    </td>
</tr>
