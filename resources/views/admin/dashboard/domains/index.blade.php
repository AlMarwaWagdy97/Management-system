@extends('admin.app')

@section('title', 'النطاقات')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
@endsection

@section('content')
<div class="row">

    <div class="card">
        <div class="card-body search-group">
            {{-- Start Form Search (domain_name, domain_url, type, status) --}}
            <form action="{{ route('admin.domains.index') }}" method="get">
                <div class="row mt-3">
                    <div class="col-md-3 mt-1">
                        <input type="text" name="domain_name" value="{{ request('domain_name','') }}" placeholder="اسم النطاق" class="form-control">
                    </div>
                    <div class="col-md-3 mt-1">
                        <input type="text" name="domain_url" value="{{ request('domain_url','') }}" placeholder="رابط النطاق" class="form-control">
                    </div>
                    <div class="col-md-3 mt-1">
                        <select class="select form-control" name="type">
                            @php($t = request('type'))
                            <option value="">اختر النوع</option>
                            <option value="zid" {{ $t==='zid' ? 'selected' : '' }}>ZID</option>
                            <option value="holol" {{ $t==='holol' ? 'selected' : '' }}>HOLOL</option>
                        </select>
                    </div>
                    <div class="col-md-2 mt-1">
                        <select class="select form-control" name="status">
                            @php($s = request('status'))
                            <option value=""> الحالة </option>
                            <option value="1" {{ $s==='1' ? 'selected' : '' }}>مفعل</option>
                            <option value="0" {{ $s==='0' ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="search-input col-md-1 mt-1 d-flex gap-1">
                        <button class="btn btn-primary btn-sm" type="submit" title="بحث"><i class="bx bx-search-alt"></i></button>
                        <a class="btn btn-success btn-sm" href="{{ route('admin.domains.index') }}" title="إعادة تعيين"><i class="bx bx-refresh"></i></a>
                    </div>
                </div>
            </form>
            {{-- End Form Search --}}
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">النطاقات</h5>
            <a href="{{ route('admin.domains.create') }}" class="btn btn-success btn-sm">
                @lang('admin.create')
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="domainsTable" class="table table-bordered table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم النطاق</th>
                            <th class="text-center">رابط النطاق</th>
                            <th>الحالة</th>
                            <th>التوكن</th>
                            <th>النوع</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($domains as $domain)
                            <tr>
                                <td>{{ $domain->id }}</td>
                                <td>{{ $domain->domain_name }}</td>
                                <td class="text-center">
                                    @if($domain->domain_url)
                                        <a href="{{ $domain->domain_url }}" target="_blank">{{ $domain->domain_url }}</a>
                                    @endif
                                </td>
                                <td>
                                    @if($domain->status)
                                        <span class="badge bg-success">مفعل</span>
                                    @else
                                        <span class="badge bg-secondary">غير مفعل</span>
                                    @endif
                                </td>
                                <td><code>{{ \Illuminate\Support\Str::limit($domain->token, 20) }}</code></td>
                                <td>{{ strtoupper($domain->type) }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.domains.show', $domain) }}" class="btn btn-neutral text-info btn-sm m-1" title="عرض"><i class='bx bx-show'></i></a>
                                        <a href="{{ route('admin.domains.edit', $domain) }}" class="btn btn-neutral text-warning btn-sm m-1" title="تعديل"><i class='bx bx-edit'></i></a>
                                        <form action="{{ route('admin.domains.destroy', $domain) }}" method="POST" onsubmit="return confirm('تأكيد الحذف؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-neutral text-danger btn-sm m-1" title="حذف"><i class='bx bx-trash'></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script>
        $(function(){
            $('#domainsTable').DataTable({
                ordering: true,
                pageLength: 10,
                lengthChange: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'print', text: "print <i class='bx bx-printer'></i>", className: 'btn btn-primary btn-sm' },
                    { extend: 'pdfHtml5', text: "PDF <i class='bx bxs-file-pdf'></i>", className: 'btn btn-primary btn-sm' },
                    { extend: 'excelHtml5', text: "Excel <i class='bx bxs-file-export'></i>", className: 'btn btn-primary btn-sm' },
                    { extend: 'copyHtml5', text: "Copy <i class='bx bx-copy'></i>", className: 'btn btn-primary btn-sm' }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
                }
            });
        });
    </script>
@endsection
