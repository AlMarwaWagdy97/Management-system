<div>
    <div class="card">
        <div class="card-body">
            {{-- Start Form search --}}
            <div class="card-body  search-group">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" value="{{ $search_name ?? '' }}" wire:model="search_name"
                            placeholder="{{ trans('contact_us.search_name') }}" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" value="{{ $search_email ?? '' }}" wire:model="search_email"
                            placeholder="{{ trans('contact_us.search_email') }}" class="form-control">
                    </div>
                    <div class="col-md-3 ">
                        <input type="text" value="{{ $search_phone ?? '' }}" wire:model="search_phone"
                            placeholder="{{ trans('contact_us.search_phone') }}" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" value="{{ $title ?? '' }}" wire:model="title"
                            placeholder="{{ trans('contact_us.topic') }}" class="form-control">
                    </div>
                </div>
            </div>
            {{-- Start Form search --}}
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive rm-ws">
                <table id="main-datatable" class="table table-striped table-bordered "
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr class="bluck-actions" @if (empty($mySelected)) style="display: none" @endif
                            scope="row">
                            <td colspan="10">
                                <div class="col-md-12 mt-0 mb-0 text-center">
                                    @can('admin.contact-us.destroy')
                                        <button wire:click.prevent="deleteSelected"
                                            @if (empty($mySelected)) disabled @endif
                                            class="btn btn-neutral text-danger border-0" data-hover="@lang('button.delete_all')"
                                            type="submit"> <i class="bx bxs-trash"></i></button>
                                    @endcan
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <th style="width: 1px">
                                <input type="checkbox" id="check-all" wire:model="selectAll">
                            </th>
                            <th>#</th>
                            <th>{{ trans('contact_us.full_name') }}</th>
                            <th>{{ trans('contact_us.phone') }}</th>
                            <th>{{ trans('contact_us.email') }}</th>
                            {{-- <th>{{ trans('contact_us.type') }}</th> --}}
                            <th>{{ trans('contact_us.city') }}</th>

                            <th>{{ trans('contact_us.topic') }}</th>
                            <th>{{ trans('contact_us.message') }}</th>
                            <th>{{ trans('admin.created_at') }}</th>
                            <th>{{ trans('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($items as $key => $item)
                            @livewire(
                                'admin.cms.contact-us.show-table',
                                [
                                    'item' => $item,
                                    'index' => $links->firstItem() + $key,
                                    'selected' => $mySelected,
                                    'selectAll' => $selectAll,
                                ],
                                key($item->id)
                            )
                            @include('livewire.admin.layouts.show_message_modal')

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

        </div>
        {{-- Start Modal Delete --}}
        @include('livewire.admin.layouts.delete')

        {{-- End Modal Delete --}}


    </div>
</div>
