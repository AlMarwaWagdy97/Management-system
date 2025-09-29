@extends('admin.app')

@section('title', trans('gifts.show_categories'))
@section('title_page',  trans('gifts.categories'))
@section('title_route', route('admin.gifts.categories.index') )
@section('button_page')
<a href="{{ route('admin.gifts.categories.show_tree') }}"  class="btn btn-outline-primary">@lang('categories.show_tree')</a>
<a href="{{ route('admin.gifts.categories.create') }}"  class="btn btn-outline-success">@lang('admin.create')</a>
@endsection

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    @livewireStyles
@endsection

@section('content')
        @livewire('admin.gifts.categories.index')
@endsection

@section('script')    
    @livewireScripts
@endsection



