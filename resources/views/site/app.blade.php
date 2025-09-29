<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if( app()->isLocale('ar') ) dir="ltr" @endif >

    <x-site.layouts.header />

  <body>

    @include('site.layouts.menus')


    @include('site.layouts.message')

    @yield('content')

    <x-site.layouts.footer />


    @include('site.layouts.script')

  </body>
</html>
