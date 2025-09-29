@foreach (!empty(@$searchItem ) && $first == true ? @$searchItem : $items->where('parent_id', $parent_id ?? 0)  as $item)
@php
    $totalChildren = $items->where('parent_id', $item->id)->count();
    $first = false;
@endphp
    @if ($totalChildren)
        <li>
            <div class="toggler p-1 @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active  current @endif">
                <i class='bx bx-folder' ></i>
                {{ optional( $item->trans)->where('locale', $current_lang)->first()->title }} 
                {{-- <div class="toggler-remain float-end"> --}}
                    {{-- <a href="{{ route('admin.menus.create', @$item->id??0) }}" data-hover="@lang('admin.create')" class="text-success" ><i class="fas fa-plus"></i></a> --}}
                    {{-- <div class="togger-edit"><a href="{{ route('admin.menus.edit', $item->id) }}" class="text-warning" data-hover="@lang('admin.edit')"><i class="bx bxs-edit"></i></a></div> --}}
                    {{-- @if (@$item->url)
                        <a href="{{ @$item->url }}" data-hover="@lang('admin.url')" target="_blank"  class="text-info"  data-bs-toggle="tooltip"  data-bs-original-title="url">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    @endif --}}
                {{-- </div> --}}
            </div>
      
            <ul class="toggler-target @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active  current @endif">
                @include('admin/dashboard/cms/menus/tree', ['parent_id' => $item->id])
            </ul>
       
        </li>    
    @else
        <li class="todo  @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active  current @endif">
            <i class='bx bx-file-blank'></i>
            {{ optional( $item->trans)->where('locale', $current_lang)->first()->title }} 
            {{-- <div class="toggler-remain float-end">
                <a href="{{ route('admin.menus.create', @$item->id??0) }}" data-hover="@lang('admin.create')" class="text-success " ><i class="fas fa-plus"></i></a>
                <div class="togger-edit"><a href="{{ route('admin.menus.edit', $item->id) }}" class="text-warning " data-hover="@lang('admin.edit')"><i class="bx bxs-edit"></i></a></div>
                @if (@$item->url)
                    <a href="{{ @$item->url }}" data-hover="show url"  target="_blank" class="text-info " data-bs-toggle="tooltip" data-bs-original-title="url">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                @endif
            </div> --}}
        </li>
    @endif
@endforeach
{{-- <li class="todo-plus">
    <a href="{{ route('admin.menus.create', @$item->parent_id??0) }}" data-hover="@lang('admin.create')" class="text-success" ><i class="fas fa-plus"></i></a>
</li> --}}
