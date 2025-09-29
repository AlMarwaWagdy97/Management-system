<!-- Slider -->
<section id="slider" class="mt-5">
    <div class="container">
      <div id="carouselExampleIndicators" class="carousel slide" data-interval="200" data-touch="true" >
        <div class="carousel-indicators">
            @foreach ($slides as $key => $slide)
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}" aria-label="Slide {{ $key + 1 }}" 
                class="{{$key == 0 ? 'active' : null }}"> 
                </button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach ($slides as $key => $slide)
            <div class="carousel-item  {{$key == 0 ? 'active' : null}}">
                
                @if( @$slide->trans?->where('locale',$current_lang)->first()->title )
                    <div class="carousel-content position-absolute">
                        <h2 class="item-title"> {{ @$slide->trans?->where('locale',$current_lang)->first()->title }} </h2>
                        <p class=""> {{$slide->trans?->where('locale',$current_lang)->first()->description }} </p>
                            <a href="{{$slide->url}}" class="carousel-content-btn btn rounded-pill">
                               @lang('Donate Now')
                            </a>
                    </div>
                @endif
                <a class="large-screen" href="{{ $slide->url }}">
                    <img class="" src="{{ getImage($slide->image) }}" class="d-block w-100" alt="{{ @$slide->trans?->where('locale',$current_lang)->first()->title }} " />
                </a>
                <a class="small-screen" href="{{ $slide->url }}">
                    <img class="" src="{{ getImage($slide->mobile_image) }}" class="d-block w-100" alt="{{ @$slide->trans?->where('locale',$current_lang)->first()->title }} " />
                </a>
            </div>
            @endforeach
        </div>
        <!-- slider content  -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
</section>
