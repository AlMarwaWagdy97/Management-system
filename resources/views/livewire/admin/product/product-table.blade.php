<tr class="{{ $item->quantity == 0? 'out-stock':'' }} {{ $item->quantity <= 5 && $item->quantity >0 ? 'warinig-stock':'' }} ">
    <td>
        <input type="checkbox" class="checkbox-check" wire:click="updateSellected({{ $item->id }})" wire:model="mySelected" value="{{ $item->id }}" {{ in_array($mySelected, [$item->id]) ? 'selected' : '' }}>
    </td>
    <td>{{ $index }}</td>
    <td>{{ $item->vendor?->responsible_person }}</td>
    <td>
        {!! @$item->trans->where('locale',$current_lang)->first()->title !!}
    </td>
    <td>
        {{ @$item->vendor_price }}
    </td>
    <td>
        {{ @$item->price }}
    </td>
    {{-- <td>
        {{ @$item->quantity }}
    </td> --}}
    {{-- <td> {!! $stock !!} </td> --}}
    <td width="120px">
        <div class="d-flex">
            <input type="number" name="sort" wire:model="sort" class="form-control p-0 mx-1">
            <span wire:click="update_sort({{ $item->id }})" class="btn btn-sm btn-primary py-0 px-1">@lang('admin.change')</span>
        </div>
    </td>
    <td>
        {!! toHtml(@$item->status) !!}
    </td>
    {{-- {{ $item->sort }} --}}
    <td>{{ $item->created_at }}</td>
    <td>{{ $item->updated_at }}</td>
    <td>
        <div class="d-flex justify-content-center">
            {{-- Start Statue --}}
            <div style="width:110px">
                <select name="" class="form-control" wire:model="status">
                    @forelse(App\Enums\ProductStatusEnum::values() as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            {{-- Start Feature --}}
            @if ($item->feature == 1)
            <a data-hover="@lang('admin.feature')" class="btn btn-neutral text-success btn-sm m-1" wire:click="update_featured({{ $item->id }})"><i class="bx bxs-star"></i></a>
            @else
            <a data-hover="@lang('admin.feature')" class="btn btn-neutral text-warning btn-sm m-1" wire:click="update_featured({{ $item->id }})"><i class="bx bxs-star"></i></a>
            @endif
            {{-- End Feature --}}
            <a data-hover="@lang('admin.show')" href="{{ route('admin.eccommerce.products.show', $item->id) }}" class="btn btn-neutral text-info btn-sm m-1" wire:click="show({{ $item->id }})"><i class="bx bx-show-alt"></i></a>
            <a data-hover="@lang('admin.edit')" href="{{ route('admin.eccommerce.products.edit',$item->id) }}" class="btn btn-neutral text-primary btn-sm m-1"><i class="bx bxs-edit"></i></a>
            {{-- <a data-hover="@lang('admin.review')" href="{{ route('admin.eccommerce.reviews',$item->id) }}" class="btn btn-neutral text-warning btn-sm m-1"><i class="bx bxs-comment"></i></a> --}}

            <button type="button" wire:click.prevent="deleteId({{ $item->id }})" class="btn btn-neutral text-danger btn-sm m-1" data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                <i class="bx bxs-trash"></i>
            </button>


        </div>

    </td>
</tr>
