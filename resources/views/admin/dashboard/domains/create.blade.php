@extends('admin.app')

@section('title', 'إضافة نطاق')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">إضافة نطاق</h5>
        <a href="{{ route('admin.domains.index') }}" class="btn btn-secondary btn-sm"><i class="bx bx-arrow-back"></i> رجوع</a>
    </div>
    <div class="card-body">
        @include('admin.dashboard.domains._form')
    </div>
</div>
@endsection
