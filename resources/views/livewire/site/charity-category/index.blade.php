<section class="sections home">
    <div class="category-container">
        <p class="title text-center">الأقســـــــام</p>

        <div class="grid-container mt-5">
            @forelse ($categoriesCarousels as $carouselIndex => $carousel)
                @forelse ($carousel as $key => $category)
                    <div class="grid-item col-12 col-md-6 col-lg-3">
                        <a href="{{ route('site.projectCategories.show', @$category['trans'][0]['slug']) }}">
                            <div class="category-content Card {{ ($category['id'] % 2) + 1 }}">
                                @if ($category['background_image'])
                                    <img src="{{ asset(getImage($category['background_image']) ?? 'site/img/icon3.png') }}"
                                        class="category-img" alt="{{ @$category['trans'][0]['title'] }}" />
                                @endif
                                @if ($category['image'])
                                    {{-- <img src="{{ asset(getImage($category['image']) ?? 'site/img/icon3.png') }}"
                                        class="sub-category-img" alt="{{ @$category['trans'][0]['title'] }}" /> --}}
                                @endif
                                
                                @if(strlen($title = $category['trans'][0]['title'] ) > 10 )
                                    <div class="category-desc category-title">
                                        {{$title }}
                                    </div>
                                
                                @else
                                    <div class="category-desc">
                                        {{ $title }}
                                    </div>
                                @endif
                            
                            </div>
                        </a>
                    </div>
                @empty
                @endforelse
            @empty
            @endforelse
        </div>

        <div class="infoBox text-center mt-3">
            @if ($categoriesCount - count($categoriesCarousels) * 8 > 0)
                <a class="btn btn-primary px-5 d-inline-block" wire:click="loadCategories" role="button">
                    @lang('More') </a>
            @endif
        </div>
    </div>
</section>
