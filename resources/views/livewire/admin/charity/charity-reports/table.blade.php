<tr>
    <td>
        <input type="checkbox" class="checkbox-check" wire:click="updateSellected({{ $item->id }})"
            wire:model="mySelected" value="{{ $item->id }}"
            {{ in_array($mySelected, [$item->id]) ? 'selected' : '' }}>
    </td>
    <td>{{ $index }}</td>
    <td>
        {{ @$item->trans->where('locale', $current_lang)->first()->title }}
    </td>
    <td>{{ $item->number }}</td>
    {{-- <td> {{ $item->category?->trans->where('locale', $current_lang)->first()->title }}</td> --}}
    <td>
        @forelse ($item->categories as $categoryItem)
        <span class="badge bg-success">{{ $categoryItem->transNow->title }}</span>
            @empty
        @endforelse
         {{-- {{ $item->category?->trans->where('locale', $current_lang)->first()->title }} --}}
    </td>
    <td>{{ $item->created_at }}</td>
    <td>{{ $item->orderDetails?->count() }}</td>
    <td>{{ $item->orderDetails?->sum('total') . ' ريال ' }}</td>
    <td> {{  $item->orderDetails?->last()?->created_at }} </td>
    {{-- <td>{{ $order_count }}</td> --}}
    {{-- <td>{{ $total_amount }} ريال</td> --}}
    <td>
        <a class="btn btn-success btn-sm" target="_blank" href="{{ route('admin.order_details.index', ['search_product' =>  @$item->transNow->title]) }}"> @lang('admin.orders') </a>
    </td>
</tr>
