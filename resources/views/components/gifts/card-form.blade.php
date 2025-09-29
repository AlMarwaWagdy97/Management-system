<div id="gift-form">
    <div class="gift-section"> 
        <div class="row">
            <form id="delete-form" class="text-start" hx-delete="{{ route('site.components.delete-form') }}" hx-target="closest #gift-form" hx-swap="outerHTML" hx-indicator="#loading">
                @csrf
                <button type="submit" class="btn bg-white btn-sm text-start text-danger" form="delete-form">
                    <i class="icofont-ui-delete"></i>
                </button>
            </form>
        </div>
    
        <form  id="save-gift mb-3">
    
            <div class="mb-3 row mt-3">
                <label for="input-1" class="col-sm-2 col-form-label">@lang('Name')</label>
                <div class="col-sm-10">
                    <input type="text" name="giver_name" class="form-control" id="input-1">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="input-2" class="col-sm-2 col-form-label"> @lang('Mobile') </label>
                <div class="col-sm-10">
                    <input type="tel" name="giver_mobile" class="form-control" id="input-2">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="input-2" class="col-sm-2 col-form-label"> @lang('Email') </label>
                <div class="col-sm-10">
                    <input type="email" name="giver_email" class="form-control" id="input-2">
                </div>
            </div>
    
            <div class="mb-3 row">
                <label for="input-2" class="col-sm-2 col-form-label"> @lang('Email') </label>
                <div class="col-sm-10">
                    <select name="giftType" hx-get="{{ route('site.components.card-img') }}" hx-trigger="change" hx-target="next #card-img" hx-boost="input[name=giftType]" name="giftType" hx-swap="innerHTML" class="form-control" hx-indicator="#loading">
                        <option value=""> @lang('Choose the gifting category') </option>
                        @forelse ( json_decode($cards, true) as $keyCard => $cardtitle)
                        <option value="{{ $keyCard }}"> {{ $cardtitle['title_' . app()->getLocale()] }} </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
    
            <div class="row mb-3" id="card-img">
                {{-- cards-------------------------------------------------- --}}
    
            </div>
            
            <div class="row mb-2">  
                <div class="text-center">
                    <button type="submit" class="btn btn-small bg-main col-md-3  fs-6" form="save-gift"> @lang('Save') </button>
                </div>
            </div>
        </form>
    </div>
    <hr>
</div>

<div id="add-cards">
</div>
