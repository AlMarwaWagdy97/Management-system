@extends('admin.app')

@section('title', trans('menus.show_menus'))
@section('title_page', trans('menus.show_menus'))

@section('style')
    @livewireStyles
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('admin.cms.menus.index')
    </div>
@endsection

@section('script')    
    @livewireScripts
@endsection



