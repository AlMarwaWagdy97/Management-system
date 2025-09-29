@extends('admin.app')

@section('title', 'عرض النطاق')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">عرض النطاق</h5>
        <div class="d-flex gap-2">
            @can('admin.domains.edit')
            <a href="{{ route('admin.domains.edit', $domain) }}" class="btn btn-warning btn-sm"><i class='bx bx-edit'></i> تعديل</a>
            @endcan
            <a href="{{ route('admin.domains.index') }}" class="btn btn-secondary btn-sm"><i class="bx bx-arrow-back"></i> رجوع</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="form-label">اسم النطاق</label>
                <div class="form-control bg-light">{{ $domain->domain_name }}</div>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">رابط النطاق</label>
                <div class="form-control bg-light">
                    @if($domain->domain_url)
                        <a href="{{ $domain->domain_url }}" target="_blank">{{ $domain->domain_url }}</a>
                    @endif
                </div>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">النوع</label>
                <div class="form-control bg-light">{{ strtoupper($domain->type) }}</div>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">التوكن</label>
                <div class="form-control bg-light"><code>{{ $domain->token }}</code></div>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">الحالة</label>
                <div>
                    @if($domain->status)
                        <span class="badge bg-success">مفعل</span>
                    @else
                        <span class="badge bg-secondary">غير مفعل</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
