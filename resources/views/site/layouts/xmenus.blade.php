<div>
    <!-- navbar -->
    <header id="top-bar">
        <div class="container text-light">
            <div class="row">
                <div class="col-lg-3 d-flex justify-content-center">
                    @php
                        $settings = App\Charity\Settings\SettingSingleton::getInstance();
                    @endphp
                    <a href="{{ route('site.home') }}" class="navbar-brand font-weight-bold pr-0 me-1">
                        <img src="{{ getImage($settings->getItem('logo')) ?? site_path('img/logo.png') }}" alt="{{ env('APP_NAME') }}" height="100" class=" d-none d-lg-inline" />
                        <img src="{{ getImage($settings->getItem('logo')) ?? site_path('img/logo.png') }}" alt="{{ env('APP_NAME') }}" height="40" class=" d-inline d-lg-none" />
                    </a>
                </div>
                <div class="col-lg-9 position-relative">
                    <!-- top link -->
                    <div class="top-bar bg-main d-flex py-2 px-3 gap-2">
                        <button class="navbar-toggler main-menu-toogle-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="icofont-navigation-menu"></i>
                        </button>
                        <form class="d-flex nav-search rounded">
                            <input class="form-control search-input d-none d-lg-inline" type="search" placeholder="Search" aria-label="Search" />
                            <button class="btn btn-search d-none d-lg-inline" type="submit"> <i class="icofont-search"></i> </button>
                        </form>
                        <div class="lang">
                            @foreach ($locals as $local)
                                <a href="{{ \LaravelLocalization::getLocalizedURL($local, \Request::fullUrl()) }}">
                                    <p class="h5 mb-0">{{ strtoupper($local) }}</p>
                                </a>
                            @endforeach
                        </div>

                        <livewire:site.profile.user-icon />

                        <livewire:site.carts.cart-icon />
                    </div>

                    <nav class="navbar navbar-light navbar-expand-lg bottom-navbar shadow py-2 px-3">
                        <!-- <a class="navbar-brand" href="#">Navbar</a> -->

                        <a href="{{ route('site.home') }}" class="home-icon shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21.624" height="23.475" viewBox="0 0 21.624 23.475">
                                <g id="homeicon" transform="translate(-8769.442 -71.45)">
                                    <path id="Path_8605" data-name="Path 8605" d="M8772.3,81.531V94.383h4.985V86.67h5.938v7.713h4.984V81.531l-7.954-6.431Z" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.084" />
                                    <path id="Path_8606" data-name="Path 8606" d="M8790.3,80.113l-10.05-8.121-10.049,8.121" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.084" />
                                </g>
                            </svg>
                        </a>
                        <div class="collapse navbar-collapse" id="navbarMenu">
                            <div class="collapse-toogle-bg" data-bs-toggle="collapse" data-bs-target="#navbarMenu"></div>
                            <div class="navbar-content">
                                <div class="top">
                                    <button class="navbar-toggler main-menu-toogle-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu">
                                        <i class="icofont-close"></i>
                                    </button>
                                </div>
                                <a href="#" class="text-center mb-3 navbar-collapse-logo">
                                    <img src="{{ site_path('img/logo.png') }}" alt="" height="100" />
                                </a>

                                @php
                                    $items = Cache::get('menus');
                                    if ($items == null) {
                                        $items = Cache::rememberForever('menus', function () {
                                            return App\Models\Menue::with('trans')->orderBy('sort', 'ASC')->main()->active()->get();
                                        });
                                    }
                                @endphp

                                <ul class="navbar-nav text-center align-content-between me-auto mb-2 mb-lg-0 pe-0">
                                    @include('site.layouts.menuItem')

                                </ul>
                            </div>
                        </div>
                    </nav>

                </div>
            </div>
        </div>
    </header>
</div>
