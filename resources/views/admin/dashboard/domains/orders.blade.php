@extends('admin.app')

@section('title', 'الطلبات')

@section('style')
@endsection

@section('content')
<div class="row">
    @if(!empty($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    <div class="card">
        <div class="card-body search-group">
            <form action="{{ route('admin.orders.index') }}" method="get">
                <div class="row mt-3">
                    <div class="col-md-6 mt-1">
                        <label class="form-label">النطاق</label>
                        <select name="domain_id" class="form-select" required>
                            <option value="">— اختر النطاق —</option>
                            @foreach($domains as $d)
                                <option value="{{ $d->id }}" {{ (string)$selectedDomainId === (string)$d->id ? 'selected' : '' }}>
                                    {{ $d->domain_name }} ({{ strtoupper($d->type) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-input col-md-2 mt-1 d-flex gap-1 align-items-end">
                        <button class="btn btn-primary btn-sm" type="submit" title="بحث"><i class="bx bx-search-alt"></i></button>
                        <a class="btn btn-success btn-sm" href="{{ route('admin.orders.index') }}" title="إعادة تعيين"><i class="bx bx-refresh"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('script')
@endsection
