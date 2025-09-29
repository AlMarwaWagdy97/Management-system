@extends('admin.app')

@section('title', 'المديرين (Managers)')

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
            <form action="{{ route('admin.managers.index') }}" method="get">
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
                        <a class="btn btn-success btn-sm" href="{{ route('admin.managers.index') }}" title="إعادة تعيين"><i class="bx bx-refresh"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">قائمة المديرين</h5>
            <span class="badge bg-primary">العدد: {{ number_format(($managers ?? collect())->count()) }}</span>
        </div>
        <div class="card-body">
            @if(($managers ?? collect())->isEmpty())
                <div class="alert alert-secondary mb-0">لا توجد بيانات للعرض. برجاء اختيار نطاق والبحث.</div>
            @else
                <div class="table-responsive">
                    <table id="managersTable" class="table table-bordered table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">ID</th>
                                <th class="text-center">الاسم</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">Account ID</th>
                                <th class="text-center">User Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Mobile</th>
                                <th class="text-center">تاريخ الإنشاء</th>
                                <th class="text-center">تاريخ التعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($managers as $i => $row)
                                @php($row = is_array($row)? $row : (array)$row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="text-center">{{ $row['id'] }}</td>
                                    <td class="text-center">{{ $row['name'] }}</td>
                                    <td class="text-center">
                                        @if(isset($row['status']))
                                            <span class="badge {{ $row['status'] ? 'bg-success' : 'bg-secondary' }}">{{ $row['status'] ? 'مفعل' : 'غير مفعل' }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $row['account_id'] }}</td>
                                    <td class="text-center">{{ $row['account_user_name'] }}</td>
                                    <td class="text-center">{{ $row['account_email'] }}</td>
                                    <td class="text-center">{{ $row['account_mobile'] }}</td>
                                    <td class="text-center">{{ $row['created_at'] }}</td>
                                    <td class="text-center">{{ $row['updated_at'] }}</td>
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
            $('#managersTable').DataTable({
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
