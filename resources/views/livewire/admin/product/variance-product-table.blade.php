<div>
    <div class="d-flex justify-content-between">
        {{-- Start Modal Create --}}
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalForm">
            @lang('products.create_new_vairiance')
        </button>
        {{-- Start Modal Create --}}
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#editAttributeSet">
            @lang('products.editAttributeSet')
        </button>
    </div>
    {{-- Start Modal Edit Attributes Set --}}
    <div class="modal fade" id="editAttributeSet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('products.editAttributeSet')</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @livewire('admin.product.edit-attributeset',['unique_attributeSet' => $unique_attributeSet,'product_id' => $product->id])

            </div>
        </div>
    </div>
    {{-- End Modal Edit Attributes Set --}}
    <!-- Modal -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('products.vairiance')</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- @livewire('post-form') --}}
                    @livewire('admin.product.variance-product-form',['unique_attributeSet' => $unique_attributeSet,'product_id' => $product->id])
                </div>
            </div>
        </div>
    </div>
    {{-- End Model Create --}}
    {{--Start Model delete --}}
    <div class="modal fade" id="modalFormDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('admin.delete_item')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 class="swal2-title" id="swal2-title" style="display: flex;"> @lang('admin.are_you_sure')</h2>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('button.cancel')</button>
                        <button type="button" class="btn btn-danger" wire:click="delete" class="btn btn-danger close-modal" data-bs-dismiss="modal">
                            @lang('button.delete')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Start Model delete --}}
    {{-- Start table-responsive --}}
    <div class="table-responsive">
        <table class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th>@lang('admin.image')</th>
                    @foreach ($unique_attributeSet as $item)
                    <th>{{ @$item->trans->where('locale', $current_lang)->first()->title }}</th>
                    @endforeach
                    <th>@lang('articles.sort')</th>
                    <th>@lang('products.quantity')</th>
                    <th>@lang('products.price')</th>
                    <th>@lang('products.sku')</th>
                    <th>@lang('products.default')</th>
                    <th>@lang('articles.actions')</th>
                </tr>
            </thead>
            <tbody>

                <style>
                    .img-wrap {
                        position: relative;
                    }
                    .img-wrap .close {
                        position: absolute;
                        top: -30px;
                        right: 6px;
                        z-index: 100;
                        font-size: 2rem;
                        color: red;
                    }

                </style>
                @forelse ($variances as $key => $item)
                <tr>

                    <td>
                        @forelse( hinddelImage(@$item->productVariance->image) as $key => $img)
                        <a class="img-wrap">
                            <span class="close" wire:click="remove_image('{{ $img }}',{{ $item->productVariance }} )">&times;</span>
                            <img src="{{ asset(pathImage($img)) }}" alt="Card image" width="90px">
                        </a>
                        @empty
                        @endforelse
                        <div class="m-1">

                            <div class="">
                                <input type="hidden" id="galery_{{ $item->productVariance->id }}" readonly name="image_var_{{ $item->productVariance->id }}"   class="form-control image_val" type="text" value="{{ @$item->productVariance->image}}" {{ @$item->productVariance->image != null ?'addimage()':''}}>
                                <a data-toggle="modal" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $key }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm mt-1" type="button"><i class="fas fa-plus"></i></a>
                                <a href=""></a>
                            </div>
                            <!-- /.modal -->
                            <div class="modal fade" id="exampleModal{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">

                                        <div class="card-body mt-0 pt-0">
                                            <iframe width="100%" height="500" src="{{ asset('backend/filemanager/dialog.php') }}?type=2&field_id=galery_{{ $item->productVariance->id }}&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal -->
                        </div>
                    </td>


                    @forelse ($unique_attributeSet as $attributeSet)
                    @php
                    $varianceAttributeValues = @$item->attributeValue->pluck('id')->toArray();
                    $value = @$attributeSet->attribute->whereIn('id', $varianceAttributeValues )->first();
                    $title = $value != null ? @$value->trans->where('locale', $current_lang)->first()->title : "";
                    @endphp
                    <td>
                        {{ $title }}
                    </td>
                    @empty
                    @endforelse
                    <td>
                        {{ @$item->productVariance->sort }}
                    </td>
                    <td>
                        {{ @$item->productVariance->quantity }}
                    </td>
                    <td>
                        {{ @$item->productVariance->price }}
                    </td>
                    <td>
                        {{ @$item->productVariance->sku }}
                    </td>
                    <td class="text-center">
                        <input class="form-check-input" type="radio" wire:model="default" wire:click="changeDefault({{ $item->id }})" checked="{{ $item->default }}" value="{{ $item->id }}">
                    </td>

                    <td>
                        <button type="button" class="btn btn-primary  m-1"><i class="bx bxs-edit" wire:click="selectItem({{@$item->productVariance->id }},'update')"></i></button>
                        <a class="btn btn-danger  m-1"><i class="bx bxs-trash" wire:click="selectItem({{ @$item->id}},'delete')"></i></a>

                    </td>
                </tr>

                @empty

                @endforelse
            </tbody>

        </table>
    </div>
    {{-- End table-responsive --}}

</div>
<script>
    window.addEventListener('closeModal', event => {
        $("#modalForm").modal('hide');
    })
    window.addEventListener('openModal', event => {
        $("#modalForm").modal('show');
    })
    window.addEventListener('openDeleteModal', event => {
        $("#modalFormDelete").modal('show');
    })
    window.addEventListener('closeDeleteModal', event => {
        $("#modalFormDelete").modal('hide');
    })
    window.addEventListener('closeAttributesModal', event => {
        $("#editAttributeSet").modal('hide');
    })
    $(document).ready(function() {
        // This event is triggered when the modal is hidden       
        $("#modalForm").on('hidden.bs.modal', function() {
            livewire.emit('forcedCloseModal');
        });
    });

</script>
