@php
    $settings = App\Charity\Settings\SettingSingleton::getInstance();
    use Illuminate\Support\Facades\Auth;

@endphp

<header class="">
    <nav class="navbar navbar-expand-lg  position-relative ">
        <div class="nav-content container">

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <div class="d-flex nav-mobile p-0 m-0 justify-content-between w-100 mx-auto align-items-center">
                    <div onclick="window.location.href='/'" class="logoBox ">
                        <img src="{{ asset(getImage($settings->getItem('logo')) ?? site_path('img/logo.png')) }}"
                            class=" w-25 h-25 img-fluid logo-img" alt="" />
                    </div>


                    <div class="Name text-center">
                        <h2 class="text-center"> مرحبا بكم في جمعية يدا بيد</h2>
                    </div>

                    <div>
                        <ul class=" me-auto align-content-between mb-2 mb-lg-0 pe-0">

                            @php
                                $items = Cache::get('menus');
                                if ($items == null) {
                                    $items = Cache::rememberForever('menus', function () {
                                        return App\Models\Menue::with('trans')
                                            ->orderBy('sort', 'ASC')
                                            ->main()
                                            ->active()
                                            ->get();
                                    });
                                }
                            @endphp
                            <div class="d-flex links ">
                                <li class="nav-item"><a class="dropdown-item"
                                        href="{{ route('site.cashier.home') }}">الاقسام</a>
                                </li>
                                <li class="nav-item"><a class="dropdown-item"
                                        href="{{ route('site.cashier.home') }}">المشاريع</a>
                                </li>
                            </div>


                            {{-- @include('site.layouts.menuItem') --}}



                        </ul>
                    </div>
                    <div class="d-flex align-items-center ms-3">

                        {{-- cashier guard --}}
                        @if (Auth::guard('cashier')->check())
                            @php $user = Auth::guard('cashier')->user(); @endphp

                            <div class="dropdown">
                                <a class="d-flex cashier-user  align-items-center text-decoration-none dropdown-toggle"
                                    href="#" id="cashierMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (!empty($user->image))
                                        <img src="{{ asset(getImage($user->image)) }}" class="rounded-circle"
                                            style="width:36px;height:36px;object-fit:cover" alt="avatar">
                                    @else
                                        <i class="fa fa-user-circle fa-2x"></i>
                                    @endif
                                    <span
                                        class="ms-2">{{ $user->user_name ?? ($user->employee_name ?? $user->email) }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cashierMenu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('site.cashier.home') }}">
                                            <i class="fa fa-home me-2"></i> الرئيسية
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        {{-- logout form --}}
                                        <form id="cashier-logout-form" action="{{ route('site.cashier.logout') }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fa fa-sign-out-alt me-2"></i> تسجيل الخروج
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
    .cashier-user {
        color: #41555B !important;
    }
    .Name h2{
        font-weight: 0 !important;
    }

    .dropdown-menu {
        text-align: right !important;
    }

    @media screen and (max-width: 1215px) {

        .links li a {
            font-size: 19px !important;
            font-weight: 300 !important;
            padding: 0.3rem 0.5rem !important;
        }

        .Name {
            padding-left: 40px !important;
        }
        .Name h2 {
            font-size: 25px !important;
            font-weight: 300 !important;
        }

        .dropdown-item {
            padding: 0.3rem 0.2rem !important;
        }

        .cashier-user {
            i {
                font-size: 23px !important;
            }

            span {
                font-size: 15px !important;
            }
        }

        .dropdown .dropdown-menu {
            top: 20px !important;
        }

        .dropdown-menu {
            text-align: right !important;

        }

        .dropdown-menu .dropdown-item {
            padding: 0px !important;
            font-size: 12px !important;
        }

        .dropdown-menu-end[data-bs-popper] {

            right: auto !important;
        }
    }

    @media screen and (max-width: 991.9px) {
        .navbar {
            background-color: #CEC19C !important;
            padding-bottom: 120px !important;

            h2 {
                color: #fff !important;
                font-size: 22px !important;
                font-weight: 300 !important;
            }
        }

        .logo-img {
            width: 100px !important;
            height: 100px !important;
        }

        .links li a {
            font-size: 19px !important;
            font-weight: 300 !important;
        }

        .navbar ol,
        ul {
            padding-left: 0px !important;
        }


        .dropdown-item {
            padding: 0.3rem 0.2rem !important;
        }

        .cashier-user {
            i {
                font-size: 20px !important;
            }

            span {
                font-size: 12px !important;
            }
        }

        .dropdown .dropdown-menu {
            top: 20px !important;
        }

        .dropdown-menu {
            text-align: right !important;

        }

        .dropdown-menu .dropdown-item {
            padding: 0px !important;
            font-size: 12px !important;
        }

        .dropdown-menu-end[data-bs-popper] {

            right: auto !important;
        }
    }

    @media screen and (max-width: 576px) {
        .navbar {
            background-color: #CEC19C !important;
            padding-bottom: 90px !important;

            h2 {
                color: #fff !important;
                font-size: 15px !important;
                font-weight: 300 !important;
            }
        }

        .logo-img {
            width: 100px !important;
            height: 80px !important;
        }

        .links li a {
            font-size: 14px !important;
            font-weight: 300 !important;
        }

        .navbar ol,
        ul {
            padding-left: 0px !important;
        }

        .dropdown-item {
            padding: 0.3rem 0.2rem !important;
        }

        .cashier-user {
            i {
                font-size: 20px !important;
            }

            span {
                font-size: 12px !important;
            }
        }

        .dropdown .dropdown-menu {
            top: 20px !important;
        }

        .dropdown-menu {
            text-align: right !important;

        }

        .dropdown-menu .dropdown-item {
            padding: 0px !important;
            font-size: 12px !important;
        }

        .dropdown-menu-end[data-bs-popper] {

            right: auto !important;
        }
    }
</style>
