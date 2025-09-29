@extends('admin.app')

@section('title', trans('categories.show_all'))
@section('title_page',  trans('categories.categories'))
@section('title_route', route('admin.categories.index') )
@section('button_page')
<a href="{{ route('admin.categories.show_tree') }}"  class="btn btn-outline-primary">@lang('categories.show_tree')</a>
<a href="{{ route('admin.categories.create') }}"  class="btn btn-outline-success">@lang('admin.create')</a>
@endsection

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    @livewireStyles
@endsection

@section('content')
        @livewire('admin.cms.categories.index')
@endsection

@section('script')    
    @livewireScripts
@endsection



