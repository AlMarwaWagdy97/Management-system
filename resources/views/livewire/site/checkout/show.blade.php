<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="cart-items-list cart-main p-3">

                @php $total = 0; @endphp
                @forelse ($items as $itemCart)
                    @php $total += ($itemCart['price'] * $itemCart['quantity'] ); @endphp

                    <div class="cart-item d-block donation-item">
                        <div class="donation-item-details">
                            <div class="cart-item-img-title">
                                <img src="{{ getImage($itemCart->item->cover_image) }}" alt="project"
                                    class="cart-item-img">
                                   
                                    <span class="cart-item-title"> 
                                        {{ @$itemCart->item_name }} 
                                        @if( @$itemCart->item_sub_type)({{ @$itemCart->item_sub_type }})   @endif
                                    </span>
                                  
                            </div>
                            <div class="cart-item-controls">
                                @if (json_decode(@$itemCart->gift_details)?->giver_mobile)
                                    <i class="fa-solid fa-gift text-success mx-1"></i>
                                @endif
                            </div>

                            <div class="cart-item-price d-flex flex-column">
                                <div>
                                      <span class="quantity-label fs-5 text-muted">العدد: </span>
                                     <span class="fs-5 quantity-value"> {{ $itemCart['quantity'] }} </span>
                                  
                                </div>

                                <div class="donation-item-price">
                                    <span class=""> {{ $itemCart['price'] * $itemCart['quantity'] }} </span>
                                    <span class="price-currency">ريال</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <li>
                        <span class="body text-center">
                            <h5>@lang('Empty Cart')</h5>
                        </span>
                    </li>
                @endforelse
                <div class="donation-total ">
                    <div class="total-row">
                        <div class="total-label">الاجمالي المطلوب</div>
                        <div class="total-amount">
                            <span class="total-value">{{ $total }}</span>
                            <span class="total-currency">ريال</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-12 col-lg-6">
            @if(@auth('account')->user()?->types->where('type', 'donor')->first() == null)
                @livewire('site.auth.index', ['type' => 'checkout'])
            @endif
            <div class="cart-main mb-0">
                <div class="cart-form">
                    @livewire('site.payments.index')

                </div>
            </div>


        </div>
    </div>
</div>
