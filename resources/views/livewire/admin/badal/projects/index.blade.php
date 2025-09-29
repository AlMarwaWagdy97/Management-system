<div>
    <div class="card">
        {{-- Start Form search --}}
        <div class="card-body search-group">
            <div class="row">
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="col-sm-12 col-form-label">@lang('admin.title_search') </label>
                            <input type="text" value="{{ $search_title ?? '' }}" wire:model="search_title" placeholder="{{ trans('admin.title') }}" class="form-control">
                        </div>
                        
                        <div class="col-sm-12">
                            <label class="col-sm-12 col-form-label">@lang('charityProject.number')</label>
                            <input type="number" wire:model="search_number" placeholder="{{ trans('charityProject.number') }}" class=" form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="col-sm-12 col-form-label">@lang('admin.target_price_from')</label>


                            <input type="number" step="any" wire:model="search_price_from" placeholder="{{ trans('products.price_from') }}" class="form-control">
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-12 col-form-label">@lang('admin.target_price_to')</label>



                            <input type="number" step="any" wire:model="search_price_to" placeholder="{{ trans('products.price_to') }}" class=" form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="col-sm-12 col-form-label">@lang('products.created_from')</label>

                            <input type="date" wire:model="search_created_from" placeholder="{{ trans('products.created_from') }}" class="form-control">
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-12 col-form-label">@lang('products.created_to')</label>


                            <input type="date" wire:model="search_created_to" placeholder="{{ trans('products.created_to') }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="col-sm-12 col-form-label">@lang('charityProject.category')</label>
                            <select class=" form-select select2" wire:model="category_search" aria-label=".form-select-sm example">
                                <option value="">@lang('charityProject.choose_category')</option>
                                @forelse($categories as $category)
                                {{-- <option value="{{ $category->id }}" {{ in_array($category->id, $category_search ??[])  ? "selected":""}}> --}}
                                <option value="{{ $category->id }}">
                                    {{ $category->trans->where('locale', $current_lang)->first()->title }}
                                </option>
                                @empty
                                @endforelse
                            </select>

                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-12 mt-2 col-form-label">@lang('admin.hidden')</label>
                            <select class="form-select " wire:model="search_hidden" aria-label=".form-select-sm example">
                                <option selected value=""> @lang('charityProject.please_select_hidden') </option>
                                <option value="1" {{  $search_hidden == 1? 'selected':'' }}>@lang('admin.hidden') </option>
                                <option value="0" {{  $search_hidden != 1 &&  $search_hidden != null ? 'selected':'' }}> @lang('admin.show') </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        
                        <div class="col-sm-12">
                            <label class="col-sm-12 col-form-label">@lang('charityProject.badal_type')</label>
                            <select class="form-select " wire:model="search_badal_type" aria-label=".form-select-sm example">
                                <option value=""  selected>@lang('charityProject.choose_type')</option>
                                @foreach (App\Enums\BadalTypeEnum::values() as $type)
                                <option value="{{ $type }}" {{ $type == $search_badal_type  ? 'selected' : '' }}>
                                    {{ $type}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            {{-- <span class="mt-2 fs-5 fw-medium">@lang('admin.status')</span> --}}
                            <label for="example-number-input" class="col-sm-12 col-form-label">
                                @lang('admin.status')</label>
                            <select class=" form-select" wire:model="search_status" aria-label=".form-select-sm example">
                                <option selected value=""> @lang('admin.status') </option>
                                <option value="1" {{  $search_status == 1? 'selected':'' }}>@lang('admin.active') </option>
                                <option value="0" {{  $search_status != 1 &&  $search_status != null ? 'selected':'' }}> @lang('admin.dis_active') </option>
                            </select>
                        </div>
                    </div>
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
                            <td colspan="11">
                                <div class="mt-0 mb-0 text-center col-md-12">
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
                            <th>{{ trans('admin.title') }}</th>
                            <th>{{ trans('charityProject.number') }}</th>
                            <th>{{ trans('charityProject.category') }}</th>
                            <th>{{ trans('charityProject.badal_type') }}</th>
                            <th>{{ trans('charityProject.amount') }}</th>
                            <th>{{ trans('charityProject.min_price') }}</th>
                            <th>{{ trans('admin.sort') }}</th>
                            <th>{{ trans('admin.created_at') }}</th>
                            <th>{{ trans('admin.updated_at') }}</th>
                            <th>{{ trans('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $key => $item)
                        @livewire('admin.badal.projects.table', [
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
                <div class="col-md-12 text-center mt-3">
                    {{ $links->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>


    {{-- Start Modal Delete --}}
    @include('livewire.admin.layouts.delete')
    {{-- End Modal Delete --}}



    
</div>
