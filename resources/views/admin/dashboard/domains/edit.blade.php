@extends('admin.app')

@section('title', 'تعديل نطاق')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">تعديل نطاق</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.domains.show', $domain) }}" class="btn btn-info btn-sm"><i class="bx bx-show"></i> عرض</a>
            <a href="{{ route('admin.domains.index') }}" class="btn btn-secondary btn-sm"><i class="bx bx-arrow-back"></i> رجوع</a>
        </div>
    </div>
    <div class="card-body">
        @include('admin.dashboard.domains._form', ['domain' => $domain])
    </div>
</div>
@endsection
