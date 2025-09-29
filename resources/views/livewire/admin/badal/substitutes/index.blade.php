<div>
    <div class="card">
        {{-- Start Form search --}}
        <div class="card-body search-group">
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-sm-12 col-form-label">@lang('substitutes.full_name') </label>
                    <input type="text" wire:model="search_full_name" placeholder="{{ trans('substitutes.full_name') }}" class="form-control">
                </div>
                <div class="col-sm-3">
                    <label class="col-sm-12 col-form-label">@lang('admin.email') </label>
                    <input type="text"  wire:model="search_email" placeholder="{{ trans('admin.email') }}" class="form-control">
                </div>
                <div class="col-sm-3">
                    <label class="col-sm-12 col-form-label">@lang('substitutes.mobile') </label>
                    <input type="text" wire:model="search_mobile" placeholder="{{ trans('substitutes.mobile') }}" class="form-control">
                </div>
                <div class="col-sm-3">
                    <label class="col-sm-12 col-form-label">@lang('substitutes.proportion_from')</label>
                    <input type="number" step="any" wire:model="search_proportion_from" placeholder="{{ trans('substitutes.proportion_from') }}" class="form-control">
                </div>
                <div class="col-sm-3">
                    <label class="col-sm-12 col-form-label">@lang('substitutes.identity')</label>
                    <input type="text" wire:model="search_identity" placeholder="{{ trans('substitutes.identity') }}" class=" form-control">
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="example-number-input" class="col-sm-12 col-form-label">
                                @lang('substitutes.gender')</label>
                                <select name="search_gender" class="form-control select2 @error('gender') is-invalid @enderror">
                                    <option value="" selected disabled></option>
                                    <option value="male" {{ $search_gender == 'male' ? 'selected' : '' }}>  @lang('substitutes.male') </option>
                                    <option value="female" {{ $search_gender == 'female' ? 'selected' : '' }}>  @lang('substitutes.femail') </option>
                                </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="row">
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

                <div class="col-sm-3">
                    <label class="col-sm-12 col-form-label">@lang('substitutes.proportion_to')</label>
                    <input type="number" step="any" wire:model="search_proportion_to" placeholder="{{ trans('substitutes.proportion_to') }}" class=" form-control">
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
                        <td colspan="14">
                            <div class="mt-0 mb-0 text-center col-md-12">
                                <button wire:click.prevent="publishSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-success btn-sm" type="submit"> <i class="bx bxs-check-square"></i></button>
                                <button wire:click.prevent="unpublishSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-warning btn-sm" type="submit"> <i class="bx bx-no-entry"></i></button>
                                <button wire:click.prevent="deleteSelected" @if(empty($mySelected)) disabled @endif class="btn btn-neutral text-danger btn-sm" type="submit"> <i class="bx bxs-trash"></i></button>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <th tyle="width: 1px">
                            <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                        </th>
                        <th>#</th>
                        <th>@lang('admin.image')</th>
                        <th>@lang('substitutes.full_name')</th>
                        <th>@lang('admin.email')</th>
                        <th>@lang('substitutes.phone')</th>
                        <th>@lang('substitutes.proportion')</th>
                        <th>@lang('substitutes.identity')</th>
                        <th>@lang('substitutes.nationality')</th>
                        <th>@lang('substitutes.gender')</th>
                        <th>@lang('substitutes.languages')</th>
                        <th>@lang('admin.created_at')</th>
                        <th>@lang('admin.updated_at')</th>
                        <th>@lang('articles.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $key => $item)
                    @livewire('admin.badal.substitutes.table', [
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
