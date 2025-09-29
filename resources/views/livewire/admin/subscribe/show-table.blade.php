    <tr>
        <td>
            <input type="checkbox" class="checkbox-check"  wire:click="updateSellected({{ $item->id }})"  wire:model="mySelected" value="{{ $item->id }}" {{ in_array($mySelected, [$item->id]) ?'selected': '' }}  >
        </td>
        <td>{{ $index  }}</td>
     
        <td>
            {!!  @$item->email   !!} <br>
        </td>

        <td>
            <div class="d-flex justify-content-center">
                @can('admin.subscribes.destroy')
                    <button type="button" wire:click="deleteIdRow({{ $item->id }})" class="btn btn-outline-danger btn-sm m-1"data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                        <i class="bx bxs-trash"></i>
                    </button>
                @endcan
    
            </div>
    
        </td>
    </tr>
    
