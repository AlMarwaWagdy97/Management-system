@extends('site.app')

@section('title', __('Review Order'))

@section('style')
<style>
    .star-rating {
        display: flex;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        font-size: 3rem;
        color: #ccc;
        margin: 0 0.2rem;
        cursor: pointer;
    }

    .star-rating input[type="radio"]:checked~label {
        color: gold;
    }

</style>
@endsection


@section('content')

<section>
    <div class="container mt-5">
        <h2 class="sec-title">
            <a href="{{ route('site.home') }}" class="text-secondary">@lang('Home') </a>
            <span class="px-4 text-main"> @lang('Review Order') </span>
        </h2>

        <div class="row">

            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('site.vendors.products.show', @$orderDetail->item->id) }}" target="_blank">
                            <img src="{{ getImage(@$orderDetail->item->cover_image) }}" width="30%" class="rounded">
                        </a>
                        <h3 class="text-black my-3">{{ @$orderDetail->item_name }}</h3>
                        <p> @lang('quantity') : {{ @$orderDetail->quantity }}</p>
                        <p> @lang('price') : {{ @$orderDetail->price }}</p>
                        <p> @lang('settings.giver_name') : {{ @$orderDetail->giver->name }} </p>
                        <p> @lang('settings.giver_mobile') : {{ @$orderDetail->giver->mobile }} </p>
                        <p> @lang('settings.giver_address') : {{ @$orderDetail->giver->address }} </p>
                        @if(@$orderDetail->giver?->card?->image)
                        <p> @lang('gifts.card') : <img src="{{ getImageThumb(@$orderDetail->giver?->card?->image) }}" width="30px" alt="" class="rounded"> </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('site.review.save-order') }}" method="POST">
                          @csrf
                            <input type="hidden" name="id" value="{{ @$orderDetail->id }}" >
                            <div class="mb-3">
                                <label for="rating" class="form-label">التقييم : </label>
                                <div class="star-rating">
                                    <input type="radio" id="star1" name="rate" value="1" required />
                                    <label for="star1">★</label>
                                    <input type="radio" id="star2" name="rate" value="2" required />
                                    <label for="star2">★</label>
                                    <input type="radio" id="star3" name="rate" value="3" required />
                                    <label for="star3">★</label>
                                    <input type="radio" id="star4" name="rate" value="4" required />
                                    <label for="star4">★</label>
                                    <input type="radio" id="star5" name="rate" value="5" required />
                                    <label for="star5">★</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="feedback" class="form-label">تعليق :</label>
                                <textarea class="form-control" name="review" id="feedback" rows="6" placeholder=""></textarea>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success text-center">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
