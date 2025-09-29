@extends('admin.app')

@section('title', trans('gifts.show_cards'))
@section('title_page',  trans('gifts.cards'))
@section('title_route', route('admin.gifts.cards.index') )
@section('button_page')
<a href="{{ route('admin.gifts.cards.create') }}"  class="btn btn-outline-success">@lang('admin.create')</a>
@endsection

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    @livewireStyles
@endsection

@section('content')
        @livewire('admin.gifts.cards.index')
@endsection

@section('script')    
    @livewireScripts
@endsection



