<div>
    <div class="card">
        <div class="card-body">
            {{-- Start Form search --}}
            <div class="card-body  search-group">
                @include('admin.layouts.message')
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="text" value="{{ $search_title ?? '' }}" wire:model="search_title" placeholder="{{ trans('admin.title') }}" class="form-control">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" value="{{ $search_description ?? '' }}" wire:model="search_description" placeholder="{{ trans('admin.description') }}" class="form-control">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-select" wire:model="search_status" aria-label=".form-select-sm example">
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
            <table id="main-datatable" class="table table-bordered text-center table-striped table-table-success table-hover table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr class="bluck-actions" @if(empty($mySelected)) style="display: none" @endif scope="row">
                        <td colspan="10">
                            <div class="col-md-12 mt-0 mb-0 text-center">
                                <button  wire:click.prevent="publishSelected" @if(empty($mySelected)) disabled  @endif class="btn btn-neutral text-success btn-sm" type="submit" > <i class="bx bxs-check-square"></i></button>
                                <button  wire:click.prevent="unpublishSelected" @if(empty($mySelected)) disabled  @endif class="btn btn-neutral text-warning btn-sm" type="submit">  <i class="bx bx-no-entry"></i></button>
                                <button  wire:click.prevent="deleteSelected" @if(empty($mySelected)) disabled  @endif class="btn btn-neutral text-danger btn-sm" type="submit">  <i class="4"></i></button>
                            </div>
                        </td>
    
                    </tr>
                    <tr>
                        <th style="width: 1px">
                            <input type="checkbox" id="check-all" wire:model="selectAll">
                        </th>
                        <th>#</th>
                        <th>{{ trans('admin.image') }}</th>
                        <th>{{ trans('categories.title') }}</th>
                        <th>{{ trans('categories.description') }}</th>
                        <th>{{ trans('categories.sort') }}</th>
                        <th>{{ trans('categories.created_at') }}</th>
                        <th>{{ trans('categories.updated_at') }}</th>
                        {{-- <th>{{ trans('categories.ads') }}</th> --}}
                        <th>{{ trans('categories.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
    
                    @forelse ($items as $key => $item)
                    @livewire('admin.charity.categories.table', [
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
    
        {{-- Start Modal Delete --}}
        @include('livewire.admin.layouts.delete')
        {{-- End Modal Delete --}}
    
    
    </div>

    
</div>