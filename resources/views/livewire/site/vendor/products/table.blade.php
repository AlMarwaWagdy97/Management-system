<tr class="{{ $item->quantity == 0? 'out-stock':'' }} {{ $item->quantity <= 5 && $item->quantity >0 ? 'warinig-stock':'' }} ">

    <td>{{ $index }}</td>
    <td>
        {!! @$item->trans->where('locale',$current_lang)->first()->title !!}
    </td>
    <td>
        {{ @$item->vendor_price }}
    </td>

    <td width="120px">
        <div class="d-flex">
            <input type="number" name="sort" wire:model="sort" class="form-control p-0 mx-1">
            <span wire:click="update_sort({{ $item->id }})" class="btn btn-sm btn-primary py-0 px-1">@lang('admin.change')</span>
        </div>
    </td>

    <td>
        {!! toHtml(@$item->status) !!}
    </td>

    <td>
        @if($item->feature)
            @lang('Yes')
        @else
            @lang('No')
        @endif
    </td>

    {{-- {{ $item->sort }} --}}
    <td>{{ $item->created_at }}</td>
    
    <td>
        <div class="d-flex justify-content-center">
            <a href="{{ route('site.vendors.products.show', $item->id) }}" class="btn btn-info btn-sm m-1" ><i class="icofont-eye-alt text-white"></i></a>
            <a  href="{{ route('site.vendors.products.edit',$item->id) }}" class="btn btn-primary btn-sm m-1"><i class="icofont-edit-alt text-white"></i></a>

            <button type="button" wire:click.prevent="deleteId({{ $item->id }})" class="btn btn-danger btn-sm m-1" data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                <i class="icofont-trash text-white"></i>
            </button>
        </div>
    </td>
</tr>
