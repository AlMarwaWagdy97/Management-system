@foreach ($items->where('parent_id', $parent_id ?? 0)  as $item)
@php
    $totalChildren = $items->where('parent_id', $item->id)->count();
    $first = false;
@endphp
    @if($item->parent_id != null && $totalChildren)
        <li class="nav-item  dropdown">
            <a class="nav-link dropdown-toggle @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif
                @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active  @endif"
                 data-bs-toggle="dropdown"  >
                {{ @$item->trans?->where('locale', $current_lang)->first()->title }}
            </a>
            <ul class="dropdown-menu text-end @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active  current @endif" aria-labelledby="navbarDropdown" >
                @include('site.layouts.menuItem', ['parent_id' => $item->id])
            </ul>
        </li>
    @elseif ($totalChildren)
        <li class="nav-item  dropdown ">
            <a class="nav-link dropdown-toggle    @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif
                @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active  @endif"
                  data-bs-toggle="dropdown">
                {{ @$item->trans?->where('locale', $current_lang)->first()->title }}
            </a>
            <ul class="dropdown-menu text-end @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active  current @endif" aria-labelledby="navbarDropdown" >
                @include('site.layouts.menuItem', ['parent_id' => $item->id])
            </ul>
        </li>
    @else
    <li class="nav-item" >
        <a class="dropdown-item 
                @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif
                @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active @endif " aria-current="page"
                href="{{  @$item->type == "dynamic"?  @$item->dynamic_url : @$item->url }}">
                {{  @$item->trans?->where('locale', $current_lang)->first()->title }}
            </a>
        </li>
    @endif
@endforeach
