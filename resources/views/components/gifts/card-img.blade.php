    <div class=" owl-carousel owl-rtl owl-loaded owl-drag">
        <div class="row">
            @forelse(json_decode($cardImages, true) as $keyImg => $img)
                <div class="gift-item col-md-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="gift-{{ $keyImg }}" class="radio-label">
                                <input type="radio" value="{{ $img }}" id="gift-{{ $keyImg }}"
                                    name="imgSelect{{ $randName }}" class="">
                                <span class="radio m-auto mt-2"></span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <a href="{{ getImageFileManger($img) }}" target="_blank">
                                <img src="{{ getImageFileManger($img) }}" alt="">
                            </a>
                        </div>
                    </div>

                </div>
            @empty
            @endforelse
        </div>
    </div>
