<div class="row">
    <div class="card">
        {{-- Start Form search --}}
        <div class="card-body  search-group">
            @include('admin.layouts.message')

            <div class="row mt-3">
                <div class="col-md-3">
                    <input type="text" wire:model="search_title" placeholder="@lang('admin.title')" class="form-control">
                    <select class="form-select mt-2" wire:model="search_status">
                        <option selected value=""> @lang('admin.status') </option>
                        @forelse(App\Enums\ProductStatusEnum::values() as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model="search_vendor">
                        <option selected value=""> @lang('admin.vendors') </option>
                        @forelse($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{  $vendor->translate(app()->getLocale())->title }}</option>
                        @empty
                        @endforelse
                    </select>

                    <select class="form-select mt-2" wire:model="search_category">
                        <option selected value=""> @lang('admin.category') </option>
                        @forelse($cateories as $cateory)
                            <option value="{{ $cateory->id }}">{{  $cateory->translate(app()->getLocale())->title }}</option>
                        @empty
                        @endforelse
                    </select>

                </div>
                <div class="col-md-2">
                    <input type="number" step="any" wire:model="search_price_from" placeholder="@lang('products.price_from')" class="form-control">
                    <input type="number" step="any" wire:model="search_price_to" placeholder="@lang('products.price_to')" class="form-control mt-2">
                </div>
                {{-- <div class="col-md-3">
                    <input type="number" wire:model="search_quantity_from" placeholder="@lang('products.quantity_from')" class="form-control">
                    <input type="number" wire:model="search_quantity_to" placeholder="@lang('products.quantity_to')" class="form-control mt-2">
                </div> --}}
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <label> @lang("products.created_from") </label>
                                </div>
                                <div class="col-8">
                                    <input type="date" wire:model="search_created_from" placeholder="@lang('products.created_from')" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row">
                                <div class="col-4">
                                    <label> @lang("products.created_to") </label>
                                </div>
                                <div class="col-8">
                                    <input type="date" wire:model="search_created_to" placeholder="@lang('products.created_to')" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Start Form search --}}

        <div class="table-responsive">
            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr class="bluck-actions" @if(empty($mySelected)) style="display: none" @endif scope="row">
                        <td colspan="11">

                            <div class="col-md-12 mt-0 mb-0 text-center">
                                <button wire:click.prevent="publishSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-success btn-sm" type="submit"> <i class="bx bxs-check-square"></i></button>
                                <button wire:click.prevent="unpublishSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-warning btn-sm" type="submit"> <i class="bx bx-no-entry"></i></button>
                                <button wire:click.prevent="deleteSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-danger btn-sm" type="submit"> <i class="bx bxs-trash"></i></button>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <th style="width: 1px">
                            <input type="checkbox" id="check-all" wire:model="selectAll">
                        </th>
                        <th>#</th>
                        <th>{{ trans('admin.vendor') }}</th>
                        <th>{{ trans('products.title') }}</th>
                        <th>{{ trans('products.vendor_price') }}</th>
                        <th>{{ trans('products.price') }}</th>
                        {{-- <th>{{ trans('products.quantity') }}</th> --}}
                        {{-- <th>{{ trans('products.stock') }}</th> --}}
                        <th>{{ trans('products.sort') }}</th>
                        <th>{{ trans('products.status') }}</th>
                        <th>{{ trans('admin.created_at') }}</th>
                        <th>{{ trans('admin.updated_at') }}</th>
                        <th>{{ trans('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($items as $key => $item)
                    @livewire('admin.product.product-table', [
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
            {{ $links->links('pagination::bootstrap-5') }}
        </div>

        {{-- Start Modal Delete --}}
        @include('livewire.admin.layouts.delete')
        {{-- End Modal Delete --}}


    </div>
</div>
