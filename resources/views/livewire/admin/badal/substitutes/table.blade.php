<tr>
    <td>
        <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{$item->id}}]" value={{ $item->id }}>
    </td>
    <td>{{ $index }}</td>
    <td>
        @if($item->image != null)
        <img src="{{ getImageThumb($item->image) }}" alt="" width="60">
        @else
        <span class="text-danger">@lang('rites.not_found_ image')</span>
        @endif
    </td>
    <td>{{ @$item->full_name }} </td>
    <td>{{ @$item->account->email }} </td>
    <td>{{ @$item->account->mobile }} </td>
    <td>{{ @$item->proportion }} </td>
    <td>{{ @$item->identity }} </td>
    <td>{{ @$item->nationality }} </td>
    <td>{{ @$item->gender }} </td>
    <td>
        @forelse(json_decode($item->languages) ?? [] as $language)
            <span class="badge bg-success">{{ $language }}</span>
        @empty
        @endforelse
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

            <a data-hover="@lang('admin.show')" href="{{ route('admin.badal.substitutes.show', $item->id) }}" class="btn btn-neutral text-info" wire:click="show({{ $item->id }})"><i class="bx bxs-show"></i></a>
            <a data-hover="@lang('admin.edit')" href="{{ route('admin.badal.substitutes.edit', $item->id) }}" class="btn btn-neutral text-primary"><i class="bx bxs-edit"></i></a>
            <button type="button" data-hover="@lang('admin.delete')" wire:click.prevent="deleteId({{ $item->id }})" class="btn btn-neutral text-danger" data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                <i class="bx bxs-trash"></i>
            </button>


        </div>
    </td>
</tr>