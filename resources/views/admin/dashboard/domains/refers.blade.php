@extends('admin.app')

@section('title', 'المسوقين (Refers)')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
@endsection

@section('content')
<div class="row">
    @if(!empty($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    <div class="card">
        <div class="card-body search-group">
            <form action="{{ route('admin.refers.index') }}" method="get">
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
                        <a class="btn btn-success btn-sm" href="{{ route('admin.refers.index') }}" title="إعادة تعيين"><i class="bx bx-refresh"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">قائمة المسوقين</h5>
        </div>
        <div class="card-body">
            @php
                // Build dynamic flat columns from first 25 items
                $refersArray = collect($refers)->take(25)->map(function($r){ return is_array($r)? $r : (array)$r; });
                $allKeys = $refersArray->flatMap(function($r){ return array_keys($r); })->unique()->values();
                // Preferred columns order if present
                $preferred = collect(['id','name','full_name','username','email','phone','mobile','code','ref_code','orders_count','orders','total_amount','total','total_price','created_at']);
                $orderedKeys = $preferred->filter(fn($k) => $allKeys->contains($k))
                    ->merge($allKeys->reject(fn($k) => $preferred->contains($k)))->values();
            @endphp

            @if(($refers ?? collect())->isEmpty())
                <div class="alert alert-secondary mb-0">لا توجد بيانات للعرض. برجاء اختيار نطاق والبحث.</div>
            @else
                <div class="table-responsive">
                    <table id="refersTable" class="table table-bordered table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                @foreach($orderedKeys as $k)
                                    <th class="text-center">{{ str_replace('_',' ', $k) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($refers as $i => $row)
                                @php($row = is_array($row)? $row : (array)$row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    @foreach($orderedKeys as $k)
                                        @php($val = $row[$k] ?? '')
                                        <td class="text-center">
                                            @if(is_array($val) || is_object($val))
                                                <code style="white-space: pre;">{{ json_encode($val, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) }}</code>
                                            @else
                                                {{ $val }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script>
        $(function(){
            $('#refersTable').DataTable({
                ordering: true,
                pageLength: 25,
                lengthChange: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'print', text: "طباعة", className: 'btn btn-primary btn-sm' },
                    { extend: 'pdfHtml5', text: "PDF", className: 'btn btn-primary btn-sm' },
                    { extend: 'excelHtml5', text: "Excel", className: 'btn btn-primary btn-sm' },
                    { extend: 'copyHtml5', text: "Copy", className: 'btn btn-primary btn-sm' }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
                }
            });
        });
    </script>
@endsection
