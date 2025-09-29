<div>
    <div class="card">
        <div class="card-body">
            {{-- Start Form search --}}
            <div class="card-body  search-group">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" value="{{ $search_name ?? '' }}" wire:model="search_name" placeholder="{{ trans('contact_us.search_name') }}" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" value="{{ $search_email ?? '' }}" wire:model="search_email" placeholder="{{ trans('contact_us.search_email') }}" class="form-control">
                    </div>
                    <div class="col-md-3 ">
                        <input type="text" value="{{ $search_phone ?? '' }}" wire:model="search_phone" placeholder="{{ trans('contact_us.search_phone') }}" class="form-control">
                    </div>
                </div>
            </div>
            {{-- Start Form search --}}
        </div>
    </div>
    <div class="card">
    
        <div class="card-body">
            <div class="table-responsive">
                <table id="main-datatable" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr class="bluck-actions" @if (empty($mySelected)) style="display: none" @endif scope="row">
                            <td colspan="16">
                                <div class="col-md-12 mt-0 mb-0 text-center">
                                    <button  wire:click.prevent="publishSelected" class="btn btn-neutral text-success btn-sm" type="submit" > 
                                        <i class="bx bxs-check-square"></i> 
                                    </button>
                                    <button  wire:click.prevent="unpublishSelected" class="btn btn-neutral text-warning btn-sm" type="submit">  
                                        <i class="bx bx-no-entry"></i>
                                    </button>
                                    <button  wire:click.prevent="deleteSelected"  class="btn btn-neutral text-danger btn-sm" type="submit">  
                                        <i class="bx bxs-trash"></i>
                                    </button>
                                </div>
                            </td>
    
                        </tr>
                        <tr>
                            <th style="width: 1px">
                                <input type="checkbox" id="check-all" wire:model="selectAll">
                            </th>
                            <th>#</th>
                            <th>{{ trans('orders.identifier') }}</th>
                            <th>{{ trans('orders.price') }}</th>
                            <th>{{ trans('orders.name') }}</th>
                            <th>{{ trans('orders.mobile') }}</th>
                            <th>{{ trans('orders.projects') }}</th>
                            <th>{{ trans('orders.source') }}</th>
                            <th>{{ trans('orders.payment_methods') }}</th>
                            <th>{{ trans('orders.bank_transfer') }}</th>
                            <th>{{ trans('orders.payment_configration') }}</th>
                            <th>{{ trans('orders.gifts') }}</th>
                            <th>{{ trans('admin.status') }}</th>
                            <th>{{ trans('admin.created_at') }}</th>
                            <th>{{ trans('admin.updated_at') }}</th>
                            <th>{{ trans('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
    
                        @forelse ($items as $key => $item)
                        <tr>
                            @php
                                $payment = 'payment_method_'. app()->getLocale();
                                $status = 'status_'. app()->getLocale();
                            @endphp
                            <td>
                                <input type="checkbox" class="form-check checkbox-check" wire:click="checkItem({{ $item->id }})" 
                                    {{ in_array($mySelected, [$item->id]) ? 'checked' : '' }}>

                            </td>
                            <td>{{$links->firstItem() + $key }}</td>
                            <td>{{ $item->identifier }}</td>
                            <td>{{ $item->total }}</td>
                            <td>{{ $item->full_name }}</td>
                            <td>{{ $item->mobile }}</td>
                            <td> projects</td>
                            <td>{{ $item->source }}</td>
                            <td> {{ $item->$payment }} </td>
                        
                            <td> {{-- bank transfer --}}
                                <button class="btn btn-secondary">
                                    @lang('admin.show')
                                </button>
                            </td>
                            <td> {{-- payment configraqtion --}}
                                <button class="btn btn-secondary">
                                    @lang('admin.show')
                                </button>
                            </td>
                            <td> {{-- gift --}}
                                <button class="btn btn-secondary">
                                    @lang('admin.show')
                                </button>
                            </td>
                        
                            <td> {{ $item->$status }} </td>
                        
                            <td> {{ $item->created_at }} </td>
                            <td> {{ $item->updated_at }} </td>
                        
                            
                            <td>
                                <div class="d-flex justify-content-center">
                                    @if ($item->status == 1)
                                        <a data-hover="@lang('admin.active')" class="btn btn-neutral text-success btn-sm m-1"
                                            wire:click="update_status({{ $item->id }})"><i class="bx bxs-check-square"></i></a>
                                    @else
                                        <a data-hover="@lang('admin.dis_active')" class="btn btn-neutral text-warning btn-sm m-1"
                                            wire:click="update_status({{ $item->id }})"><i class="bx bx-no-entry"></i></a>
                                    @endif
                        
                                  
                                    <a data-hover="@lang('admin.show')" href="{{ route('admin.orders.show', $item->id) }}" class="btn btn-neutral text-info" wire:click="show({{ $item->id }})">
                                        <i class="bx bxs-show"></i>
                                    </a>
                        
                                    <button type="button" wire:click.prevent="deleteId({{ $item->id }})" data-hover="@lang('admin.delete')"
                                        class="btn btn-neutral text-danger"data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                                        <i class="bx bxs-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
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
        {{-- @include('livewire.admin.layouts.delete') --}}
    
        {{-- End Modal Delete --}}
    
    
    </div>
</div>

