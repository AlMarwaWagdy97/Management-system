@php($editing = isset($domain))
<form method="POST" action="{{ $editing ? route('admin.domains.update', $domain) : route('admin.domains.store') }}">
    @csrf
    @if($editing)
        @method('PUT')
    @endif

    <div class="row g-3">
        <div class="col-12 col-md-6">
            <label class="form-label">اسم النطاق</label>
            <input type="text" name="domain_name" class="form-control @error('domain_name') is-invalid @enderror"
                   value="{{ old('domain_name', $domain->domain_name ?? '') }}" required>
            @error('domain_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">رابط النطاق</label>
            <input type="url" name="domain_url" class="form-control @error('domain_url') is-invalid @enderror"
                   value="{{ old('domain_url', $domain->domain_url ?? '') }}" required>
            @error('domain_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">النوع</label>
            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                @php($value = old('type', $domain->type ?? ''))
                <option value="">اختر النوع</option>
                <option value="zid" {{ $value==='zid' ? 'selected' : '' }}>ZID</option>
                <option value="holol" {{ $value==='holol' ? 'selected' : '' }}>HOLOL</option>
            </select>
            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">التوكن</label>
            <input type="text" name="token" class="form-control @error('token') is-invalid @enderror"
                   value="{{ old('token', $domain->token ?? '') }}">
            @error('token')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12 col-md-6">
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="statusCheckbox"
                       {{ old('status', $domain->status ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="statusCheckbox">
                    مفعل
                </label>
            </div>
            @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary" type="submit">
            <i class="bx bx-save"></i> حفظ
        </button>
        <a href="{{ route('admin.domains.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> رجوع
        </a>
    </div>
</form>
