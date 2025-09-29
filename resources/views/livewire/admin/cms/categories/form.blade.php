@extends('admin.app')

@section('title', trans('categories.categories'))
@section('title_page', trans('categories.categories'))

@section('style')
    @livewireStyles
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('admin.cms.categories.form', ['editMode' => @$editMode, 'showMode' => @$showMode, 'categoryID' =>@$categoryID])
    </div>
@endsection

@section('script')    
    @livewireScripts
@endsection






