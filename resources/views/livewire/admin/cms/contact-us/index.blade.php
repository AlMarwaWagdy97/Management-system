@extends('admin.app')

@section('title', trans('contact_us.contact_show'))
@section('title_page', trans('contact_us.contact_show'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    @livewireStyles
@endsection

@section('content')
    @livewire('admin.cms.contact-us.index')
@endsection

@section('script')    
    @livewireScripts
@endsection



