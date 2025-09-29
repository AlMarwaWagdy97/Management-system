<div>
    <div class="card mb-3">
        <div class="card-body">
            <ul class="product-list">
                @foreach ($items as $itemCart)
                <li>
                    <span class="img">
                        <img src="{{ getImage($itemCart->item->background_image) }}" alt="" />
                    </span>
                    <span class="body cart-title">
                        <h5 class="title"> {{ $itemCart['item_sub_type'] }} </h5>
                    </span>
                    <span class="">
                        <button wire:click="minus({{ $itemCart->id }}) type="button" class="btn-danger btn-number">
                            <i class="icofont-minus"></i>

                        </button>
                        <span class="px-2">{{ $itemCart['quantity'] }}</span>
                        <button wire:click="plus({{ $itemCart->id }}) type="button" class="btn-success btn-number">
                            <i class="icofont-plus"></i>
                        </button>
                    </span>
                    <span class="price">{{ $itemCart['price'] }} <small> &#65020;</small></span>
                    <span class="price">{{ $itemCart['price'] * $itemCart['quantity']  }} <small> &#65020;</small></span>
                    <a wire:click="removeItem({{ $itemCart->id }})" class="text-danger"><i class="icofont-trash"></i></a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="cart-total">
            <span class="title">اجمالى مبلغ التبرع</span>
            <span class="price">150 ريال</span>
            <a wire:click="emptyCart()" class="text-danger"><i class="icofont-trash"></i></a>
        </div>
    </div>
</div>
