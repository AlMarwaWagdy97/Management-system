<div onclick="window.location.href='{{ route('site.cart.show') }}' " class="basket p-2 ms-3 position-relative">

    <i class="fa-solid fa-cart-shopping fs-4"></i>
    @if ($cartQuantity)
    <span class="Badge position-absolute top-0 start-100 translate-middle badge rounded-pill">
        {{ $cartQuantity }}
    </span>
    @endif
</div>