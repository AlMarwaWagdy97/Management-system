@extends('admin.app')

@section('title', 'إحصائيات الطلبات لكل متجر')

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
            <form action="{{ route('admin.domains.statistics') }}" method="get">
                <div class="row mt-3">
                    <div class="col-md-4 mt-1">
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
                    <div class="col-md-3 mt-1">
                        <label class="form-label">من تاريخ</label>
                        <input type="date" name="date_from" value="{{ request('date_from', $date_from) }}" class="form-control">
                    </div>
                    <div class="col-md-3 mt-1">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" name="date_to" value="{{ request('date_to', $date_to) }}" class="form-control">
                    </div>
                    <div class="search-input col-md-2 mt-1 d-flex gap-1 align-items-end">
                        <button class="btn btn-primary btn-sm" type="submit" title="بحث"><i class="bx bx-search-alt"></i></button>
                        <a class="btn btn-success btn-sm" href="{{ route('admin.domains.statistics') }}" title="إعادة تعيين"><i class="bx bx-refresh"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">إحصائيات الطلبات لكل متجر</h5>
        </div>
        <div class="card-body">
            @if(empty($selectedDomainId))
                <div class="alert alert-secondary">لم يتم اختيار نطاق محدد — يتم عرض إحصائيات جميع النطاقات.</div>
            @endif
            <div class="table-responsive">
                <table id="statsTable" class="table table-bordered table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">المتجر</th>
                            <th class="text-center">عدد الطلبات</th>
                            <th class="text-center">إجمالي المبالغ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($totalOrders = 0)
                        @php($totalAmount = 0)
                        @foreach($stats as $index => $row)
                            @php($ordersCount = (int)($row['orders_count'] ?? 0))
                            @php($amount = (float)($row['total_amount'] ?? 0))
                            @php($totalOrders += $ordersCount)
                            @php($totalAmount += $amount)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-center">
                                    {{ $row['store_name'] ?? 'N/A' }}
                                    @if(!empty($row['store_slug']))
                                        @php($storeUrl = $row['store_url'] ?? (isset($row['store_slug']) ? ('https://' . $row['store_slug']) : null))
                                        @if($storeUrl)
                                            <small class="d-block">
                                                <a href="{{ $storeUrl }}" target="_blank" rel="noopener" class="text-primary text-decoration-underline">
                                                    {{ $row['store_slug'] }}
                                                </a>
                                            </small>
                                        @else
                                            <small class="text-muted d-block">{{ $row['store_slug'] }}</small>
                                        @endif
                                    @endif
                                </td>
                                <td class="text-center">{{ number_format($ordersCount) }}</td>
                                <td class="text-center">{{ number_format($amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-end">الإجمالي:</th>
                            <th class="text-center">{{ number_format($totalOrders) }}</th>
                            <th class="text-center">{{ number_format($totalAmount, 2) }}</th>
                        </tr>
                    </tfoot>
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
            $('#statsTable').DataTable({
                ordering: true,
                pageLength: 25,
                lengthChange: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'print', text: "طباعة <i class='bx bx-printer'></i>", className: 'btn btn-primary btn-sm' },
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
