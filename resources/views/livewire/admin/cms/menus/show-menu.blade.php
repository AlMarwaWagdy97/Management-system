<tr style="background-color:{{  $item->position ==  App\Enums\MenuPositionEnum::MAIN ? "#72726929":""}}{{  $item->position ==  App\Enums\MenuPositionEnum::FOOTER? "#98d9e13b":"" }}">
    <td>
        <input type="checkbox" class="checkbox-check" wire:click="updateSellected({{ $item->id }})" wire:model="mySelected" value="{{ $item->id }}" {{ in_array($mySelected, [$item->id]) ?'selected': '' }}>
    </td>
    <td>{{ $index  }}</td>
    <td>
        {{ str_repeat('ـــ ', $item->level - 1) }}
        {{ $item->trans->where('locale',$current_lang)->first()->title }} <br>

    </td>
    <td>
        @if($item->type == App\Enums\MunesEnum::DYNAMIC)
        <a href="{{ @$item->dynamic_url }}" target="_blank" class="text-info">{{ $item->dynamic_url }} <i class="fas fa-external-link-alt"></i> </a>
        @elseif ($item->type == App\Enums\MunesEnum::STATIC)
        <a href="{{ @$item->url }}" target="_blank" class="text-info">{{ @$item->url }} <i class="fas fa-external-link-alt"></i> </a>
        @endif
    </td>
    <td width="120px">
        <div class="d-flex">
            <input type="number" name="sort" wire:model="sort" class="form-control p-0 mx-1">
            <span wire:click="update_sort({{ $item->id }})" class="btn btn-sm btn-primary py-0 px-1">@lang('admin.change')</span>
        </div>
    </td>
    <td>{{ $item->position }}</td>


    <td>{{ $item->created_at }}</td>
    <td>{{ $item->updated_at }}</td>
    <td>
        <div class="d-flex justify-content-center">
            @can('admin.menus.update-status')
                @if($item->status == 1)
                    <a title="@lang('admin.active')" class="btn btn-neutral text-success" wire:click="update_status({{ $item->id }})"><i class="bx bxs-check-square"></i></a>
                @else
                    <a title="@lang('admin.dis_active')" class="btn btn-neutral text-warning" wire:click="update_status({{ $item->id }})"><i class="bx bx-no-entry"></i></a>
                @endif
            @endcan

            {{-- @if($item->feature == 1)
                <a title="@lang('admin.feature')"  class="btn btn-xs btn-success btn-sm m-1" wire:click="update_featured({{ $item->id }})"><i class="bx bxs-star"></i></a>
            @else
            <a title="@lang('admin.feature')" class="btn btn-xs btn-outline-warning btn-sm m-1" wire:click="update_featured({{ $item->id }})"><i class="bx bxs-star"></i></a>
            @endif --}}

            <a title="@lang('admin.show')" href="{{ route('admin.menus.show', $item->id) }}" class="btn btn-neutral text-info"><i class="bx bx-show-alt"></i></a>


            <a title="@lang('admin.edit')" href="{{ route('admin.menus.edit', $item->id) }}" class="btn btn-neutral text-primary"><i class="bx bxs-edit"></i></a>

            @can('admin.menus.destroy')
                <button type="button" wire:click="deleteId({{ $item->id }})" class="btn btn-neutral text-danger" data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                    <i class="bx bxs-trash"></i>
                </button>
            @endcan

        </div>

    </td>
</tr>
