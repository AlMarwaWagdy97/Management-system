<div>
    <div class="card">
        {{-- Start Form search --}}
        <div class="card-body search-group">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <label class="col-sm-12 col-form-label">@lang('admin.title_search') </label>
                    <input type="text" value="{{ $search_title ?? '' }}" wire:model="search_title" placeholder="{{ trans('admin.title') }}" class="form-control">
                </div>
                <div class="col-md-3 col-sm-12">
                    <label class="col-sm-12 col-form-label">@lang('charityProject.number')</label>
                    <input type="number" wire:model="search_number" placeholder="{{ trans('charityProject.number') }}" class=" form-control">
                </div>
                <div class="col-md-3 col-sm-12">
                    <label class="col-sm-12 col-form-label">@lang('products.created_from')</label>
                    <input type="date" wire:model="search_created_from" placeholder="{{ trans('products.created_from') }}" class="form-control">
                </div>
                <div class="col-md-3 col-sm-12">
                    <label class="col-sm-12 col-form-label">@lang('products.created_to')</label>
                    <input type="date" wire:model="search_created_to" placeholder="{{ trans('products.created_to') }}" class="form-control">
                </div>
                <div class="col-md-3 col-sm-12">
                    <label class="col-sm-12 col-form-label">@lang('charityProject.category')</label>
                    <select class=" form-select" wire:model="category_search" aria-label=".form-select-sm example">
                        <option value="">@lang('charityProject.choose_category')</option>
                        @forelse($categories?? [] as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->trans->where('locale', $current_lang)->first()->title }}
                        </option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="col-md-3 col-sm-12">
                    <label class="col-sm-12 col-form-label">@lang('charityProject.type')</label>
                    <select class="form-select" wire:model="search_location_type" aria-label=".form-select-sm example">
                        <option value="" selected>@lang('charityProject.choose_type')</option>
                        @foreach (App\Enums\LocationTypeEnum::values() as $type)
                        <option value="{{ $type }}" {{ $type == $search_location_type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-12">
                        <button class="btn-success btn-sm btn text-white mt-4" wire:click="exportExcel()"> Excel </button>
                    </span>
                </div>

                
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="main-datatable" class="table table-striped table-bordered ">
                    <thead>
                        <tr class="bluck-actions" @if (empty($mySelected)) style="display: none" @endif scope="row">
                            <td colspan="8">
                                <div class="mt-0 mb-0 text-center col-md-12">
                                    <button wire:click.prevent="publishSelected" @if (empty($mySelected)) disabled @endif class="btn btn-neutral text-success btn-sm" type="submit"> <i class="bx bxs-check-square"></i></button>
                                    <button wire:click.prevent="unpublishSelected" @if (empty($mySelected)) disabled @endif class="btn btn-neutral text-warning btn-sm" type="submit"> <i class="bx bx-no-entry"></i></button>
                                    <button wire:click.prevent="deleteSelected" @if (empty($mySelected)) disabled @endif class="btn btn-neutral text-danger btn-sm" type="submit"> <i class="bx bxs-trash"></i></button>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <th style="width: 1px">
                                <input type="checkbox" id="check-all" wire:model="selectAll">
                            </th>
                            <th>#</th>
                            <th>{{ trans('admin.title') }}</th>
                            <th>{{ trans('charityProject.number') }}</th>
                            <th>{{ trans('charityProject.category') }}</th>
                            <th>{{ trans('admin.created_at') }}</th>
                            <th>{{ trans('admin.count_order') }}</th>
                            <th>{{ trans('admin.total_sum') }}</th>
                            <th>{{ trans('admin.last_order') }}</th>
                            <th>{{ trans('admin.show') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($items as $key => $item)
                        @livewire(
                        'admin.charity.charity-reports.table',
                        [
                        'item' => $item,
                        'index' => $links->firstItem() + $key,
                        'selected' => $mySelected,
                        'selectAll' => $selectAll,
                        ],
                        key($item->id)
                        )
                        @empty
                        <tr>
                            <th colspan="8">
                                <div class="alert alert-danger d-flex align-items-center " role="alert">
                                    <div class="text-center">
                                        {{ trans('message.admin.no_date') }}
                                    </div>
                                </div>
                            </th>
                        </tr>
                        @endforelse


                        <tr style="background-color: lightblue;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>الكمية : {{ $totalOrderCount }}</td>
                            <td>المجموع : {{ $totalAmount }} ريال</td>

                        </tr>
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
