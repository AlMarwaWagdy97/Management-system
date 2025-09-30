<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>

            <div class="position-relative search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                <input class="form-control px-5" disabled type="search" placeholder="Search">
                <span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-5"><i class='bx bx-search'></i></span>
            </div>

            {{-- language - darkmode - icons - notfications - cart --}}
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">

                    <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                        <a class="nav-link" href="javascript:;"><i class='bx bx-search'></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">
                        
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                            <img src="{{ admin_path('images/flags/'. app()->getLocale() .'_flag.jpg')}}" width="22" alt="">
                            {{-- <img src="{{ admin_path('images/county/02.png') }}" width="22" alt=""> --}}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">

                            @foreach($locals as $local)
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="{{ \LaravelLocalization::getLocalizedURL($local , \Request::fullUrl() ) }}">
                                    <img src="{{ admin_path(path: 'images/flags/'. $local .'_flag.jpg')}}" alt="{{ $local }}" width="20">
                                    <span class="ms-2">{{ Locale::getDisplayName($local) }}</span>
                                </a>
                            </li>
                            @endforeach

                        </ul>
                    </li>
                    <li class="nav-item dark-mode d-none d-sm-flex">
                        <a class="nav-link dark-mode-icon" href="javascript:;">
                            @if(Cookie::get('mode') == "dark-theme")
                            <i class='bx bx-sun'></i>
                            @else
                            <i class='bx bx-moon'></i>
                            @endif
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown dropdown-app">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown" href="javascript:;"><i class='bx bx-grid-alt'></i></a>
                        <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="app-container p-2 my-2">
                                <div class="row gx-0 gy-2 row-cols-3 justify-content-center p-2">

                                    {{-- CMS ------------------------------- --}}
                                    <div class="col">
                                        <a href="{{ route('admin.home') }}">
                                            <div class="app-box text-center">
                                                <div class="app-icon">
                                                    <img src="{{ admin_path('images/app/CMS.jpeg') }}" width="30" alt="">
                                                </div>
                                                <div class="app-name">
                                                    <p class="mb-0 mt-1">@lang('admin.cms')</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                               
                                    {{-- Eccomerce ----------------------------}}
                                    {{-- <div class="col">
                                        <a href="{{ route('admin.eccommerce.products.index') }}">
                                            <div class="app-box text-center">
                                                <div class="app-icon">
                                                    <img src="{{ admin_path('images/app/eccomerce.png') }}" width="30" alt="">
                                                </div>
                                                <div class="app-name">
                                                    <p class="mb-0 mt-1">@lang('admin.eccomerce')</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div> --}}
                                    {{-- Haij & Umrah ---------------------- --}}
                                    {{-- <div class="col">
                                        <a href="{{ route('admin.badal.projects.index') }}">
                                            <div class="app-box text-center">
                                                <div class="app-icon">
                                                    <img src="{{ admin_path('images/app/ka3ba.jpeg') }}" width="30" alt="">
                                                </div>
                                                <div class="app-name">
                                                    <p class="mb-0 mt-1">@lang('admin.badal')</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div> --}}
                       
                            

                                    <div class="col">
                                        <a href="javascript:;">
                                            <div class="app-box text-center">
                                                <div class="app-icon">
                                                    <img src="{{ admin_path('images/app/google-calendar.png') }}" width="30" alt="">
                                                </div>
                                                <div class="app-name">
                                                    <p class="mb-0 mt-1">Calendar</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="javascript:;">
                                            <div class="app-box text-center">
                                                <div class="app-icon">
                                                    <img src="{{ admin_path('images/app/outlook.png') }}" width="30" alt="">
                                                </div>
                                                <div class="app-name">
                                                    <p class="mb-0 mt-1">Outlook</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('admin.home') }}">
                                            <div class="app-box text-center">
                                                <div class="app-icon">
                                                    <img src="{{ admin_path('images/app/google-photos.png') }}" width="30" alt="">
                                                </div>
                                                <div class="app-name">
                                                    <p class="mb-0 mt-1">Photos</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                                <!--end row-->

                            </div>
                        </div>
                    </li>
                    
                    @auth
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown">
                            <span class="alert-count">{{ Auth::user()->unreadNotifications->count() }}</span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title"> @lang('admin.notifications') </p>
                                    <p class="msg-header-badge">{{ Auth::user()->unreadNotifications->count() }}</p>
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                @forelse (Auth::user()->unreadNotifications as $notifications )
                                <a class="dropdown-item" href="{{ route('admin.contact-us.show',$notifications->data['contact_id']) }}">
                                    <div class="d-flex align-items-center">
                                        <div class="user-online">
                                            <img src="{{ admin_path('images/avatars/avatar-1.png') }}" class="msg-avatar" alt="user avatar">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name"> {{ $notifications->data['email'] }}
                                                <span class="msg-time float-end">
                                                    {{ $notifications->created_at }}
                                                </span>
                                            </h6>
                                            <p class="msg-info">{{ $notifications->data['subject'] }}</p>
                                        </div>
                                    </div>
                                </a>

                                @empty
                                @endforelse

                            </div>
                            @if (Auth::user()->unreadNotifications->count() != 0 )
                            <a href="{{ route('admin.home') }}">
                                <div class="text-center msg-footer">
                                    <button class="btn btn-primary w-100" disabled> @lang('admin.view_all') </button>
                                </div>
                            </a>
                            @else
                            {{-- <a>
                                    <div class="text-center msg-footer">
                                        <button class="btn btn-primary w-100"> @lang('admin.no_notfication')</button>
                                    </div>
                                </a> --}}
                            @endif
                        </div>
                    </li>
                    @endauth
                </ul>
            </div>

            @auth
            {{-- profile --}}
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->image ? getImageThumb(auth()->user()->image) : admin_path('images/avatars/avatar-1.png') }}" class="user-img" alt="user avatar">
                    <div class="user-info">
                        <p class="user-name mb-0">{{ auth()->user()->name }}</p>
                        <p class="designattion mb-0">{{ auth()->user()->roles->first()?->name }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile') }}"><i class="bx bx-user fs-5"></i><span>@lang('admin.profile')</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.home') }}"><i class="bx bx-cog fs-5"></i><span>@lang('admin.settings')</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.home') }}"><i class="bx bx-home-circle fs-5"></i><span>@lang('admin.dashboard')</span></a>
                    </li>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault();
                            this.closest('form').submit();"><span> @lang('admin.logout')</span></a>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </nav>
    </div>
</header>