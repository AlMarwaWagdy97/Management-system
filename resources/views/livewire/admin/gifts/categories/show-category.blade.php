
<tr>
    <td>
        <input type="checkbox" class="checkbox-check"  wire:click="updateSellected({{ $item->id }})"  wire:model="mySelected" value="{{ $item->id }}" {{ in_array($mySelected, [$item->id]) ?'selected': '' }}  >
    </td>
    <td>{{ $index  }}</td>
    <td>
        {{  str_repeat('ـــ ', $item->level - 1) }}
        {{  $item->trans->where('locale',$current_lang)->first()->title }} <br>

    </td>
    <td>{{ $item->sort }}</td>

    <td>{{ $item->created_at }}</td>
    <td>{{ $item->updated_at }}</td>
    
    <td>
        <div class="d-flex justify-content-center">
            @can('admin.gifts.categories.update-status')
                @if($item->status == 1)
                    <a title="@lang('admin.active')" class="btn btn-neutral text-success btn-sm m-1" wire:click="update_status({{ $item->id }})"><i class="bx bxs-check-square"></i></a>
                @else 
                    <a title="@lang('admin.dis_active')"  class="btn btn-neutral text-secondary btn-sm m-1"  wire:click="update_status({{ $item->id }})"><i class="bx bx-no-entry"></i></a>
                @endif
            @endcan
            
            <a  title="@lang('admin.show')" href="{{ route('admin.gifts.categories.show', $item->id) }}" class="btn btn-neutral text-info btn-sm m-1"><i class="bx bx-show-alt"></i></a>


            <a title="@lang('admin.edit')" href="{{ route('admin.gifts.categories.edit', $item->id) }}"   class="btn btn-neutral text-primary btn-sm m-1"><i class="bx bxs-edit"></i></a>
            @can('admin.gifts.categories.destroy')
                <button type="button" wire:click="deleteId({{ $item->id }})" class="btn btn-neutral text-danger btn-sm m-1"data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                <i class="bx bxs-trash"></i>
                </button>
            @endcan

        </div>

    </td>
</tr>
