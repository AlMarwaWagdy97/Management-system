
@php
$settings = App\Charity\Settings\SettingSingleton::getInstance();
@endphp
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title> {{ @$settings->getItem('site_name') }} | @yield('title', @$settings->getItem('meta_title_' . $current_lang)) </title>

    <meta name="keywords" content="@yield('meta_key', $settings->getItem('meta_key_' . $current_lang))">
    <meta name="description" content="@yield('meta_description', $settings->getItem('meta_description_' . $current_lang))">

    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="author" content="holol" />

    <!-- OpenGraph -->
    <meta property="og:title" content=" {{ $settings->getItem('site_name') }}  | @yield('title', $settings->getItem('meta_title_' . $current_lang))" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content=" " />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta name="og:image" content="{{ asset($settings->getItem('logo')) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content />
    <meta property="twitter:title" content />
    <meta property="twitter:description" content=" " />
    <meta property="twitter:image" content />

    <!-- pixel script -->
    @if ($settings->getItem('show_pixel'))
        {!! $settings->getItem('script_pixel') !!}
    @endif

    <!--  Fonts -->
    <link rel="preload" href="{{ asset('resources/assets/Cashier/fonts/4.TTF') }}" as="font" type="font/ttf"
        crossorigin>
    <link rel="preload" href="{{ asset('resources/assets/Cashier/fonts/4_0.TTF') }}" as="font" type="font/ttf"
        crossorigin>
    <link rel="preload" href="{{ asset('resources/assets/Cashier/fonts/4_1.TTF') }}" as="font" type="font/ttf"
        crossorigin>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

    <!-- App Icons -->
    <link rel="shortcut icon" href="{{ asset(getImage($settings->getItem('icon'))) }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- VITE CSS -->
    @vite(['resources/assets/Cashier/app.css'])

    <!-- VITE EN CSS -->
    @if (app()->isLocale('en'))
        @vite(['resources/assets/Cashier/app_en.css'])
    @endif

    <!-- Page custom head JS -->
    @yield('head-script')

    <!-- page custom styles -->
    @yield('style')

    <!-- Livewire Styles -->
    @livewireStyles

    {{-- <style>
        .topBar,
        .custom-card-header-bg,
        .navbar,
        .navbar-nav,
        .bg-fast-pay,
        .project-header-container,
        .checkout-btn,
        .money-collected {
            background-color: {{ $main_color }} !important;
        }

        .bg_footer1 {
            background-color: {{ $bg_footer1 }} !important;
        }

        .bg_footer2 {
            background-color: {{ $bg_footer2 }} !important;
        }

        .title_footer {
            color: {{ $title_footer }} !important;
        }

        .a,
        .nav-link,
        .dropdown-item {
            color: {{ $secound_color }} !important;

        }

        .title {
            color: {{ $secound_color }} !important;
        }

        .category-desc {
            color: {{ $third_color }} !important;
        }


        /* main */
        .bg-main,
        .bg-main:hover,
        .btn-main,
        .btn.active,
        .home-icon,
        .bg-green,
        .nav-pills .nav-link.active,
        .btn-send,
        .categories-nav .nav-item .active,
        .categories-nav .nav-item .active,
        #projects .projects-more,
        .cart-total,
        .login_form .head,
        .btn-success {
            background-color: {{ $main_color }} !important;
        }

        .text-main,
        .footer-list .nav-item-icon,
        .footer-list .nav-item-icon,
        .social-list .list-item,
        .breadcrumb .breadcrumb-item:not(.active) a,
        .categories-nav .nav-item .nav-link,
        .btn-out,
        .text-Zakat .aya,
        .profile .active h1 {
            color: {{ $main_color }} !important;
        }

        .meun-li:hover,
        .profile .active {

            a,
            i {
                color: {{ $main_color }} !important;
            }
        }

        #projects .project-title {
            background-color: {{ $main_color }} !important;
        }

        #footer,
        #quick-donation .quick-donation-head .icon {
            background-color: {{ $main_color }} !important;
        }

        .categories-nav .nav-item,
        .btn-out {
            border-color: {{ $main_color }} !important;
        }

        .categories-nav .nav-item .active {
            color: white !important;
        }

        /* secound */
        .bg-secound,
        .bg-secound:hover,
        .btn-secound,
        .btn.active,
        #projects .project-social .social-share,
        .cart-count,
        .heading--border-left::after {
            background-color: {{ $secound_color }} !important;
        }

        .text-secound,
        .bottom-navbar .dropdown-toggle:after,
        .contact-us__item-icon,
        .contact-us__item-info .label {
            color: {{ $secound_color }} !important;
        }

        #footer {
            border-top: 5px solid {{ $secound_color }};
        }
    </style>
   --}}
</head>
