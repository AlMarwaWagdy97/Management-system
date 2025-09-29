<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if( app()->isLocale('ar') ) dir="ltr" @endif >

@include('cashier.site.partials.head')
<body>
    @include('cashier.site.partials.navbar')

    {{-- @include(view: 'site.layouts.message') --}}

    <main class="container py-4">
        @yield('content')
    </main>

        @include('cashier.site.partials.footer')

        @include('cashier.site.partials.script')


    @stack('scripts')
</body>
</html>


