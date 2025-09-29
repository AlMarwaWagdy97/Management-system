<section id="projects">
    <div class="container mt-md-5">
        

        <div class="categories-nav mb-3">
            <ul class="navbar-nav">
                @if($categories->count() > 1 )
                <li class="nav-item" wire:click="selectCategory(0)">
                    <a class="nav-link {{  $selectedCategory == 0 ? 'active' : null  }}" aria-current="page"> @lang('All') </a>
                </li>
                @endif
                @if ($categories && $categories->count() <= 3) 
                    @forelse ($categories as $category) <li class="nav-item" wire:click="selectCategory({{ $category->id }})">
                    <a class="nav-link {{ $selectedCategory == $category->id ? 'active' : null }} " aria-current="page" role="button">
                        {{ $category->trans->where('locale', $current_lang)->first()->title }}
                    </a>
                    </li>
                    @empty
                    @endforelse
                @else
                    <!-- 0, 1, 2 indeces -->
                    <li class="nav-item" wire:click="selectCategory({{ $categories[0]->id }})">
                        <a class="nav-link {{ $selectedCategory == $categories[0]->id ? 'active' : null }}" aria-current="page" role="button">{{ $categories[0]->trans->where('locale', $current_lang)->first()->title }}</a>
                    </li>
                    <li class="nav-item" wire:click="selectCategory({{ $categories[1]->id }})">
                        <a class="nav-link {{ $selectedCategory == $categories[1]->id ? 'active' : null }}" aria-current="page" role="button">{{ $categories[1]->trans->where('locale', $current_lang)->first()->title }}</a>
                    </li>
                    <li class="nav-item" wire:click="selectCategory({{ $categories[2]->id }})">
                        <a class="nav-link {{ $selectedCategory == $categories[2]->id ? 'active' : null }}" aria-current="page" role="button">{{ $categories[2]->trans->where('locale', $current_lang)->first()->title }}</a>
                    </li>
                    <!-- show the reminder indeces in a dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                            {{ !in_array($selectedCategory, [0, $categories[0]->id, $categories[1]->id, $categories[2]->id]) ? 'active' : null }}" role="button" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            أخـــــــرى
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @forelse ($categories as $key => $category)
                                @if ($key < 3) @continue @endif <!-- skip index 0, 1, 2 -->
                                <li wire:click="selectCategory({{ $category->id }})">
                                    <a class="dropdown-item {{ $selectedCategory == $category->id ? 'active' : null }} " {{ $selectedCategory == $category->id ? 'style=color:white!important;' : null }} role="button"> {{ $category->trans->where('locale', $current_lang)->first()->title }}</a>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </li>
                    @endif
            </ul>
        </div>



        <!-- PROJECT CLUSTERS (start) -->
        <div class="row projects-body g-3">
            @forelse ($productsCarousels as $key => $carousel)
            <div class="projects-body {{  $key % 2 == 0? 'wow bounceInLeft' : ' wow bounceInRight' }}">
                <div class="">
                    <div class="row">
                        @forelse ($carousel as $key => $product)
                        <livewire:site.home.products :product="$product" :wire:key="$product['id']" />
                        @empty
                            <h2 class="text-secondary text-center py-5">@lang('No products available')</h2>
                        @endforelse
                    </div>
                </div>
            </div>
            @empty
            <h2 class="text-secondary text-center py-5"> @lang('No_projects_available') </h2>
            @endforelse
            <!-- PROJECT CLUSTERS (end) -->
        </div>

        @if ($productsCount - (count($productsCarousels) * 3) > 0)
        <div class="text-center my-2">
            <a wire:click="loadProducts" class="projects-more text-decoration-none" role="button"> @lang('More') </a>
        </div>
        @endif
        @livewire('site.carts.add-modal')
    </div>

    <script>
         $(".gifts").trigger('destroy.owl.carousel').owlCarousel({
            rtl:true,
            loop:false,
            margin:10,
            nav:false,
            dots: true,
        });

        window.addEventListener('owlCarouselUpdate', event => {
            setTimeout(() => {
                console.log("gifts");
                $(".gifts").trigger('destroy.owl.carousel').owlCarousel({
                    rtl:true,
                    loop:false,
                    margin:10,
                    nav:false,
                    dots: true,
                });
            }, 0); // Adjust the delay as needed
        });

    </script>
</section>


