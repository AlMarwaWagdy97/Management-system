<div>
    <div wire:ignore id="gift-block">
        <label class="form-check-label checkbox-label">
            <input class="form-check-input" type="checkbox" data-bs-toggle="collapse" data-bs-target="#gift-body">
            <span class="checkbox"></span>
            @lang('I would like to dedicate this donation')
        </label>

        <div class="row">
            <div class="col-md-6">
                
            </div>
        </div>

        <div class="collapse py-3" id="gift-body">
            {{-- Given info ---------------------------------- --}}
            <h5 class="fs-6 text-center my-3"> @lang('The information of then given') </h5>
            <div class="mb-3 row">
                <label for="input-1" class="col-sm-2 col-form-label">@lang('Name')</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="input-1">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="input-2" class="col-sm-2 col-form-label"> @lang('Mobile') </label>
                <div class="col-sm-10">
                    <input type="text" name="mobile" class="form-control" id="input-2" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="input-2" class="col-sm-2 col-form-label"> @lang('Email') </label>
                <div class="col-sm-10">
                    <input type="text" name="email" class="form-control" id="input-2">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="input-2" class="col-sm-2 col-form-label"> @lang('Email') </label>
                <div class="col-sm-10">
                    <select  wire:model="gift_type" wire:change="onSelectGiftType($event.target.value)" class="form-control">
                        <option value=""> @lang('Choose the gifting category') </option>
                        @forelse ($cards as $cardtitle)
                            <option value="{{ $cardtitle->{'title_' . app()->getLocale()} }}"> {{ $cardtitle->{'title_' . app()->getLocale()} }} </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>



            {{-- cards-------------------------------------------------- --}}
            <div class="gifts owl-carousel owl-rtl owl-loaded owl-drag">

                <div class="gift-item">
                    <img src="asset/images/charities/charity.jpg" alt="">
                    <label for="gift-1" class="radio-label">
                        <input type="radio" id="gift-1" value="" name="gift_type" required="">
                        <span class="radio"></span>
                    </label>
                </div>
                <div class="gift-item">
                    <img src="asset/images/charities/charity.jpg" alt="">
                    <label for="gift-2" class="radio-label">
                        <input type="radio" id="gift-2" value="" name="gift_type" required="">
                        <span class="radio"></span>
                    </label>
                </div>
                <div class="gift-item">
                    <img src="asset/images/charities/charity.jpg" alt="">
                    <label for="gift-3" class="radio-label">
                        <input type="radio" id="gift-3" value="" name="gift_type" required="">
                        <span class="radio"></span>
                    </label>
                </div>
                <div class="gift-item">
                    <img src="asset/images/charities/charity.jpg" alt="">
                    <label for="gift-4" class="radio-label">
                        <input type="radio" id="gift-4" value="" name="gift_type" required="">
                        <span class="radio"></span>
                    </label>
                </div>
            </div>

            <hr>
            <label class="form-check-label checkbox-label">
                <input class="form-check-input" type="checkbox">
                <span class="checkbox"></span>
                @lang('Send a copy of the card to my mobile phone')
            </label>
            <hr />
            <label class="form-check-label checkbox-label">
                <input class="form-check-input" type="checkbox">
                <span class="checkbox"></span>
                اضافة اهداء لشخص اخر
            </label>
        </div>

    </div>
</div>