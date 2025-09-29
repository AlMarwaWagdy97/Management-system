@php
$settings = App\Charity\Settings\SettingSingleton::getInstance();
@endphp

<header>
    <div class="topBar">
        <img class="back" src="{{ site_path('img/nav-banner.png') }}" alt="">
        <div class="UserBox ">
            <div onclick="window.location.href='/'" class="logoBox p-4 d-none d-lg-block">
                <img src="{{ asset(getImage($settings->getItem('logo')) ?? site_path('img/logo.png')) }}" class="img-fluid logo-img" alt="" />
            </div>

            <div class="Name d-none d-lg-block">
                @php
                    $welcomeMessage = $settings->getItem('welcome_message_' . app()->getLocale());
                @endphp
                {{ $welcomeMessage ?? 'مرحبا بكم في جمعية يدا بيد' }}
            </div>


            <div class="useraction mx-auto mx-lg-0">
                <div onclick="window.location.href='/'" class="logoBoxModile  d-lg-none text-center">
                    <img src="{{ asset(getImage($settings->getItem('logo_mobile')) ?? site_path('img/logo.png')) }}" class="img-fluid" alt="" />
                </div>

                <div class="loginbox ">
                    <div class="user ">
                        <livewire:site.carts.cart-icon />

                        <livewire:site.profile.user-icon />
                    </div>

                    <div class="nav-left">
                        <div class="user-mobile ">
                            <livewire:site.carts.cart-icon />

                            <livewire:site.profile.user-icon />

                        </div>

                        <div class="nav-icon">
                            <button class="navbar-toggler custom-hamburger" type="button">
                                <span class="hamburger-bar"></span>
                                <span class="hamburger-bar"></span>
                                <span class="hamburger-bar"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg  position-relative ">
        <div class="blue-bar"></div>
        <div class="nav-content container">

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto align-content-between mb-2 mb-lg-0 pe-0">

                    @php
                    $items = Cache::get('menus');
                    if ($items == null) {
                    $items = Cache::rememberForever('menus', function () {
                    return App\Models\Menue::with('trans')->orderBy('sort', 'ASC')->main()->active()->get();
                    });
                    }
                    @endphp

                    @include('site.layouts.menuItem')

                    <!-- Blog Dropdown Menu -->
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="blogDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('site.blog') }}
                        </a>
                        <ul class="dropdown-menu text-end" aria-labelledby="blogDropdown">
                            @php
                            $blogCategories = \App\Models\Categories::query()
                            ->with('trans')
                            ->active()
                            ->feature()
                            ->orderBy('sort', 'ASC')
                            ->limit(5)
                            ->get();
                            @endphp
                            @foreach($blogCategories as $category)
                            <li><a class="dropdown-item" href="{{ route('site.blog-categories.show', $category->transNow->slug ?? '') }}">{{ $category->transNow->title ?? '' }}</a></li>
                            @endforeach
                        </ul>
                    </li> --}}

                </ul>
                {{-- <form class="search-form position-relative" role="search">
                    <input type="search" placeholder="البحث" aria-label="Search" />
                    <i class="fa-solid fa-magnifying-glass position-absolute"></i>
                </form> --}}
            </div>
        </div>
    </nav>
</header>
