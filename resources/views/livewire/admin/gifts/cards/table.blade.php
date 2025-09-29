<div class="row">
    <div class="card">
        <div class="card-body">
            {{-- Start Form search --}}
            <div class="card-body  search-group">
                @include('admin.layouts.message')

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="example-number-input"> @lang('gifts.category')</label>
                        <select class="form-select" wire:model="search_category_id" >
                            <option value="" selected> {{ trans('categories.select_parent') }}</option>
                            @forelse ($categories as $category)
                            <option value="{{ $category->id }}" {{ $search_category_id == $category->id ? 'selected' : '' }}> {{ str_repeat('ـــ ', $category->level - 1) }} {{ @$category->trans->where('locale',$current_lang)->first()->title }} </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="example-number-input"> @lang('gifts.occasions')</label>
                        <select class="form-select"  wire:model="search_occasioin_id">
                            <option selected value=""> @lang('gifts.occasions') </option>
                            @forelse ($occasioins as $occasioin)
                            <option value="{{ $occasioin->id }}" {{ $search_occasioin_id ==  $occasioin->id ? 'selected' : '' }}> {{ @$occasioin->trans->where('locale',$current_lang)->first()->title }} </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="example-number-input"> @lang('gifts.occasions')</label>
                        <select class="form-select " wire:model="search_status" aria-label=".form-select-sm example">
                            <option selected value=""> @lang('admin.status') </option>
                            <option value="1" {{  $search_status == 1? 'selected':'' }}>@lang('admin.active') </option>
                            <option value="0" {{  $search_status != 1 &&  $search_status != null ? 'selected':'' }}> @lang('admin.dis_active') </option>
                        </select>
                    </div>
                </div>
            </div>
            {{-- Start Form search --}}
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="main-datatable" class="table table-bordered text-center table-striped table-table-success table-hover table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr class="bluck-actions" @if(empty($mySelected)) style="display: none" @endif scope="row">
                            <td colspan="8">
                                <div class="col-md-12 mt-0 mb-0 text-center">
                                    @can('admin.categories.actions')
                                    <button wire:click.prevent="publishSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-success" type="submit"> <i class="bx bxs-check-square"></i></button>
                                    <button wire:click.prevent="unpublishSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-warning" type="submit"> <i class="bx bx-no-entry"></i></button>
                                    <button wire:click.prevent="deleteSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-danger" type="submit"> <i class="bx bxs-trash"></i></button>
                                    @endcan
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <th style="width: 1px">
                                <input type="checkbox" id="check-all" wire:model="selectAll">
                            </th>
                            <th>#</th>
                            <th> @lang('admin.image')</th>
                            <th> @lang('gifts.category')</th>
                            <th> @lang('admin.price')</th>
                            <th> @lang('admin.sort') </th>
                            <th> @lang('admin.created_at') </th>
                            <th> @lang('admin.updated_at') </th>
                            <th> @lang('admin.actions') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $key => $item)
                        @livewire('admin.gifts.cards.show-cards', [
                        'item' => $item,
                        'index' => $links->firstItem() + $key,
                        'selected' =>$mySelected,
                        'selectAll'=>$selectAll], key($item->id))
                        {{-- <livewire:admin.categories.show-category :item="$item" :index="$items->firstItem()+$key" :wire:keys="$item->id" /> --}}
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

            {{-- Start Modal Delete --}}
            @include('livewire.admin.layouts.delete')
            {{-- End Modal Delete --}}
        </div>
    </div>


</div>
