<!doctype html>
<html lang="en" @if (app()->getLocale() == 'ar') dir="rtl" @else dir="ltr" @endif class="{{ Cookie::get('mode') }} {{ Cookie::get('color-header') }} {{ Cookie::get('color-side') }}">
@include('admin.layouts.header')

<body @if (app()->getLocale() == 'ar') dir="rtl" @else dir="ltr" @endif>
    <div class="wrapper">

        <!--sidebar  -->
        @include('admin.layouts.sidebar')

        <!-- Navbar ---- -->
        @include('admin.layouts.navbar')

        <div class="page-wrapper">
            <div class="page-content">

                @include('admin.layouts.page-header')

                <!-- Messages ---- -->
                @include('admin.layouts.message')

                @yield('content')
            </div>
        </div>

        <!-- footer -->
        @include('admin.layouts.footer')

    </div>

    <!-- search Modal ---- -->
    @include('admin.layouts.search')

    <!-- Right Side Navbar ---- -->
    @include('admin.layouts.right-sidebar')

    <!-- JAVASCRIPT -->
    @include('admin.layouts.script')

    @stack('scripts')
</body>

</html>
