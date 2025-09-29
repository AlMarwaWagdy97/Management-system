<div class="col-md-4">
    <div class="project shadow  projects-home">
        <div class="header d-flex">
            <h5 class="project-title">
                <a href="{{ route('site.charity-product.show', $product['slug']) }}">
                    {{ $product['title'] }}
                </a>
            </h5>

            <ul class="project-social p-0 nav flex-column" data-bs-toggle="collapse" href="#socialShare1{{  $product['id'] }}" role="button" aria-expanded="false" aria-controls="socialShare1{{  $product['id'] }}">
                <a class="social-share nav-link active">
                    <i class="icofont-share"></i>
                </a>
                <span class="collapse toggelShare" id="socialShare1{{  $product['id'] }}">
                    <a target="blank" class="nav-link">
                        <i class="icofont-facebook"></i>
                    </a>
                    <a target="blank" class="nav-link">
                        <i class="icofont-brand-whatsapp"></i>
                    </a>
                    <a target="blank" class="nav-link">
                        <i class="icofont-envelope"></i>
                    </a>
                    <a target="blank" class="nav-link">
                        <i class="icofont-twitter"></i>
                    </a>
                </span>
            </ul>
        </div>
        <div class="project-img" style="height: 250px;">
            <a class="" href="{{ route('site.charity-product.show', $product['slug']) }}" title="">
                <img class="" src="{{ getImage($product['cover_image']) }}" />
            </a>
        </div>

        <div class="project-details my-2">

            <div class="donation-now">
                <input type="text" class="form-control fs-6 text-center" disabled value="{{ @$donationAmt }} {{ $donationAmt > 0? trans('SAR'):''}}" />
                <a href="{{ route('site.charity-product.show', $product['slug']) }}" class="bg-main btn ">
                    @lang('Show')
                </a>
                <button type="button" class="btn bg-secound" wire:click="addToCart" data-bs-toggle="modal" data-bs-target=".modalCart">
                    <i class="icofont-cart"></i>
                </button>
            </div>



        </div>
        @include('site.layouts.cart-msg')
    </div>
</div>