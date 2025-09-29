@extends('admin.app')

@section('title', trans('gifts.show_occasions'))
@section('title_page',  trans('gifts.occasions'))
@section('title_route', route('admin.gifts.occasions.index') )
@section('button_page')
<a href="{{ route('admin.gifts.occasions.create') }}"  class="btn btn-outline-success">@lang('admin.create')</a>
@endsection

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    @livewireStyles
@endsection

@section('content')
        @livewire('admin.gifts.occasions.index')
@endsection

@section('script')    
    @livewireScripts
@endsection



