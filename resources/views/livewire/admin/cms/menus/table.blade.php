<div>
    <div class="card">
        {{-- Start Form search --}}
        <div class="card-body  search-group">

            <div class="row">
                <div class="col-md-12 mb-3 text-end">
                    <a href="{{ route('admin.menus.show_tree', ['position' => App\Enums\MenuPositionEnum::MAIN]) }}" class="btn btn-outline-primary mb-1">@lang('menus.show_tree_menu')</a>
                    <a href="{{ route('admin.menus.show_tree',  ['position' => App\Enums\MenuPositionEnum::FOOTER]) }}" class="btn btn-outline-primary mb-1">@lang('menus.show_tree_footer')</a>
                    <a href="{{ route('admin.menus.create') }}" class="btn btn-outline-success mb-1">@lang('admin.create')</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <input type="text" value="{{ $search_title ?? '' }}" wire:model="search_title" placeholder="{{ trans('admin.title') }}" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <select class="form-select" wire:model="search_status" aria-label=".form-select-sm example">
                        <option selected value=""> @lang('admin.status') </option>
                        <option value="1" {{  $search_status == 1? 'selected':'' }}>@lang('admin.active') </option>
                        <option value="0" {{  $search_status != 1 &&  $search_status != null ? 'selected':'' }}> @lang('admin.dis_active') </option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    @foreach (App\Enums\MenuPositionEnum::values() as $pos)
                    <input type="radio" id="html" wire:model="search_position" value="{{ $pos }}" required>
                    <label for="html">{{ $pos }}</label><br>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- Start Form search --}}
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="main-datatable" class="table table-striped table-bordered ">
                    <thead>
                        <tr class="bluck-actions" @if(empty($mySelected)) style="display: none" @endif scope="row">
                            <td colspan="9">
                                <div class="col-md-12 mt-0 mb-0 text-center">
                                    @can('admin.menus.actions')
                                    <button wire:click.prevent="publishSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-success btn-sm" type="submit"> <i class="bx bxs-check-square"></i></button>
                                    <button wire:click.prevent="unpublishSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-warning btn-sm" type="submit"> <i class="bx bx-no-entry"></i></button>
                                    <button wire:click.prevent="deleteSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-danger btn-sm" type="submit"> <i class="bx bxs-trash"></i></button>
                                    @endcan
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <th style="width: 1px">
                                <input type="checkbox" id="check-all" wire:model="selectAll">
                            </th>
                            <th>#</th>
                            <th>{{ trans('admin.title') }}</th>
                            <th>{{ trans('admin.url') }}</th>
                            <th>{{ trans('admin.sort') }}</th>
                            <th>{{ trans('menus.position') }}</th>
                            <th>{{ trans('admin.created_at') }}</th>
                            <th>{{ trans('admin.updated_at') }}</th>
                            <th>{{ trans('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $key => $item)
                        @livewire('admin.cms.menus.show-menu', [
                        'item' => $item,
                        'index' => $links->firstItem() + $key,
                        'selected' =>$mySelected,
                        'selectAll'=>$selectAll], key($item->id))
                        @empty
                        <tr>
                            <th colspan="12">
                                <div class="alert alert-danger d-flex align-items-center " role="alert">
                                    <div class="text-center">
                                        {{ trans('message.admin.no_date') }}
                                    </div>
                                </div>
                            </th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 text-center mt-3">
                {{ $links->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- Start Modal Delete --}}
    @include('livewire.admin.layouts.delete')
    {{-- End Modal Delete --}}
</div>
