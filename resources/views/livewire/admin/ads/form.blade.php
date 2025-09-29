
    <div class="ads" >
        <h2>index : {{ @$index }}</h2>
        @if( @$ad->image!= null)
        <div class="col-12">
            <div class="row mb-3">
                <div class="col-sm-12">
                    <a href="{{ asset( @$ad->image) }}" target="_blank">
                        <img src="{{asset(@$ad->image)}}" alt=""  style="width:100%">
                    </a>
                </div>
            </div>
        </div>
        @endif
        <div class="col-12">
            <div class="row mb-3">
                <label for="example-number-input"  > @lang("categories.background_image")</label>
                <div class="col-sm-12">
                    <input type="file"  wire:model="ads.image.{{ @$index }}"   class="form-control" >
                </div>
            </div>
        </div>
    
        <div class="col-12">
            <div class="row mb-3">
                <label for="example-number-input"  > @lang("categories.link")</label>
                <div class="col-sm-12">
                    <input type="text" wire:keyup="getads()" wire:model="ads.link.{{ @$index }}" class="form-control" >
                </div>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-danger delete_ads form-control"><i class="bx bxs-trash"></i></button>
        </div>
    <hr>
