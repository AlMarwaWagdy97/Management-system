@extends('admin.app')

@section('title', trans('news.show_news'))
@section('title_page', trans('news.show_news'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
@endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body mt-0 pt-0">
                    <iframe width="100%" height="500" src="{{ asset('backend/filemanager/dialog.php') }}?type=2&field_id=galery&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                </div>
        </div>
    </div>
</div> 

@endsection


@section('script')
        {{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection