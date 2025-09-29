<div class="card my-4">
    <div class="card">
        {{-- Start Form search --}}
        <div class="card-body  search-group">

            <div class="d-flex flex-column flex-md-row">
                <div class="col-md-7 text-center text-md-end col-12 mt-3">
                    <h1 class="fs-4"> @lang('Products') </h1>
                </div>
            </div>

            @include('admin.layouts.message')
            <div class="row mt-3">
                <div class="col-md-3 mt-3">
                    <input type="text" wire:model="search_title" placeholder="{{ trans('admin.title') }}" class="form-control">
                    <select class="form-select mt-2" wire:model="search_status" aria-label=".form-select-sm example">
                        <option selected value=""> @lang('admin.status') </option>
                        @forelse(App\Enums\ProductStatusEnum::values() as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="col-md-3 mt-3">
                    <input type="number" step="any" wire:model="search_price_from" placeholder="{{ trans('products.price_from') }}" class="form-control">
                    <input type="number" step="any" wire:model="search_price_to" placeholder="{{ trans('products.price_to') }}" class="form-control mt-2">
                </div>

                <div class="col-md-3 mt-3">
                    <input type="date" wire:model="search_created_from" placeholder="{{ trans('products.created_from') }}" class="form-control">
                    <input type="date" wire:model="search_created_to" placeholder="{{ trans('products.created_to') }}" class="form-control mt-2">
                </div>

            </div>
        </div>
        {{-- Start Form search --}}

        <div class="table-responsive mx-3">
            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('products.title') }}</th>
                        <th>{{ trans('products.price') }}</th>
                        <th>{{ trans('products.sort') }}</th>
                        <th>{{ trans('products.status') }}</th>
                        <th>{{ trans('admin.feature') }}</th>
                        <th>{{ trans('products.created_at') }}</th>
                        <th>{{ trans('products.actions') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($items as $key => $item)

                    @livewire('site.vendor.products.table', [
                    'item' => $item,
                    'index' => $links->firstItem() + $key], key($item->id))
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
        @include('livewire.site.layouts.delete')
        {{-- End Modal Delete --}}
    </div>
</div>
