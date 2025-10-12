@extends('admin.app')

@section('title', 'الطلبات')

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
            <form action="{{ route('admin.orders.index') }}" method="get">
                <div class="row mt-3 g-2 align-items-end">
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
                        <input type="date" name="date_from" value="{{ $dateFrom ?? '' }}" class="form-control" />
                    </div>
                    <div class="col-md-3 mt-1">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" name="date_to" value="{{ $dateTo ?? '' }}" class="form-control" />
                    </div>
                    <div class="col-md-2 mt-1">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" id="onlyCompleted" checked disabled>
                            <label class="form-check-label" for="onlyCompleted">يتم عرض الطلبات المكتملة فقط</label>
                        </div>
                    </div>
                    <div class="search-input col-md-2 mt-1 d-flex gap-1 align-items-end">
                        <button class="btn btn-primary btn-sm" type="submit" title="بحث"><i class="bx bx-search-alt"></i></button>
                        <a class="btn btn-success btn-sm" href="{{ route('admin.orders.index') }}" title="إعادة تعيين"><i class="bx bx-refresh"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(!empty($selectedDomainId))
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h5 class="mb-0">قائمة الطلبات</h5>
                    <span class="badge bg-primary" style="font-size: 0.95rem; padding: 0.45rem 0.6rem;">
                        العدد: {{ isset($ordersCount) && $ordersCount !== null ? number_format((int)$ordersCount) : number_format(($orders ?? collect())->count()) }}
                    </span>
                    @if(isset($totalAmount) && $totalAmount !== null)
                        <span class="badge bg-success" style="font-size: 0.95rem; padding: 0.45rem 0.6rem;">
                            إجمالي المبالغ: {{ number_format((float)$totalAmount, 2) }} @if(!empty($currency)) {{ $currency }} @endif
                        </span>
                    @endif
                    @if(($orders ?? collect())->isNotEmpty())
                        <a class="btn btn-outline-secondary btn-sm ms-auto" href="{{ route('admin.orders.index', array_merge(request()->all(), ['export' => 'csv'])) }}">
                            تنزيل CSV
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if(!empty($stats))
                    @php
                        $statsData = is_array($stats) ? ($stats['data'] ?? $stats) : [];
                        $labels = [
                            'total' => 'الإجمالي',
                            'total_orders' => 'عدد الطلبات',
                            'orders_count' => 'عدد الطلبات',
                            'paid_orders' => 'الطلبات المدفوعة',
                            'pending_orders' => 'طلبات قيد الانتظار',
                            'canceled_orders' => 'الطلبات الملغاة',
                            'refunded_orders' => 'الطلبات المُستردة',
                            'total_amount' => 'إجمالي المبالغ',
                            'sum_amount' => 'إجمالي المبالغ',
                            'average_amount' => 'متوسط المبلغ',
                            'from' => 'من تاريخ',
                            'to' => 'إلى تاريخ',
                        ];
                        // pick only scalar values for quick summary
                        $pairs = [];
                        foreach(($statsData ?: []) as $k => $v){
                            if (is_scalar($v)) { $pairs[$k] = $v; }
                        }
                    @endphp
                    @if(!empty($pairs))
                        <div class="alert alert-info py-2">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($pairs as $k => $v)
                                    <span class="badge bg-secondary">
                                        {{ $labels[$k] ?? str_replace('_',' ', strtoupper($k)) }}: {{ is_numeric($v) ? number_format((float)$v, 2) : $v }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif

                @if(!empty($statsByDomain))
                    @php(
                        $grandCount = 0);
                    @php($grandAmount = 0.0)
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">المتجر</th>
                                    <th class="text-center">النوع</th>
                                    <th class="text-center">عدد الطلبات</th>
                                    <th class="text-center">إجمالي المبالغ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statsByDomain as $s)
                                    @php($c = (int) ($s['orders_count'] ?? 0))
                                    @php($a = (float) ($s['total_amount'] ?? 0))
                                    @php($grandCount += $c)
                                    @php($grandAmount += $a)
                                    <tr>
                                        <td class="text-center">
                                            @php($params = ['domain_id' => $s['domain_id'] ?? null, 'only_completed' => 1])
                                            @if(!empty($dateFrom))
                                                @php($params['date_from'] = $dateFrom)
                                            @endif
                                            @if(!empty($dateTo))
                                                @php($params['date_to'] = $dateTo)
                                            @endif
                                            <a href="{{ route('admin.orders.index', $params) }}" class="text-decoration-underline">{{ $s['domain_name'] ?? '-' }}</a>
                                        </td>
                                        <td class="text-center">{{ strtoupper($s['type'] ?? '-') }}</td>
                                        <td class="text-center">{{ number_format($c) }}</td>
                                        <td class="text-center">{{ number_format($a, 2) }} @if(!empty($s['currency'])) {{ $s['currency'] }} @elseif(!empty($currency)) {{ $currency }} @endif</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">الإجمالي الكلي</th>
                                    <th></th>
                                    <th class="text-center">{{ number_format($grandCount) }}</th>
                                    <th class="text-center">{{ number_format($grandAmount, 2) }} @if(!empty($currency)) {{ $currency }} @endif</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif

                @if(($orders ?? collect())->isEmpty())
                    <div class="alert alert-secondary mb-0">لا توجد طلبات للعرض لهذا النطاق.</div>
                @else
                    @php
                        $first = (array) (($orders[0] ?? []) ?: []);
                        $common = [
                            'code','reference','status','payment_status','payment_method_display','customer_name','customer','mobile','phone','total','amount','grand_total','created_at','updated_at'
                        ];
                        $dynamicKeys = array_values(array_unique(array_merge(
                            array_values(array_intersect($common, array_keys($first))),
                            array_keys($first)
                        )));
                        // Exclude unwanted columns
                        $exclude = [
                            'store','donor','items',
                            'updated_at',
                            'payment_method_display','payment_method',
                            'id',
                            // exclude create date variants (keep created_at visible)
                            'create_date','createDate','create date','CREATE DATE',
                            'created date','created_date','createdDate'
                        ];
                        $dynamicKeys = array_values(array_filter($dynamicKeys, function($k) use ($exclude){ return !in_array($k, $exclude, true); }));
                        // Ensure payment method column is present exactly once at the beginning
                        array_unshift($dynamicKeys, 'payment_method_display');
                        // Arabic header mapping (extended)
                        $arabicMap = [
                            'payment_method_display' => 'طريقة الدفع',
                            'payment_method' => 'طريقة الدفع',
                            'payment_status' => 'حالة الدفع',
                            'order_id' => 'رقم الطلب',
                            'identifier' => 'معرّف الكود',
                            'code' => 'الكود',
                            'reference' => 'المرجع',
                            'status' => 'الحالة',
                            'customer_name' => 'اسم العميل',
                            'customer' => 'العميل',
                            'customer_email' => 'البريد الإلكتروني للعميل',
                            'email' => 'البريد الإلكتروني',
                            'mobile' => 'الجوال',
                            'mobile_number' => 'رقم الجوال',
                            'phone' => 'الهاتف',
                            'phone_number' => 'رقم الهاتف',
                            'address' => 'العنوان',
                            'city' => 'المدينة',
                            'country' => 'الدولة',
                            'source' => 'المصدر',
                            'notes' => 'ملاحظات',
                            'total' => 'الإجمالي',
                            'amount' => 'المبلغ',
                            'grand_total' => 'الإجمالي الكلي',
                            'quantity' => 'الكمية',
                            'qty' => 'الكمية',
                            'created_at' => 'تاريخ الإنشاء',
                        ];
                    @endphp
                    <div class="table-responsive">
                        @php($dynamicKeys = (isset($dynamicKeys) && is_array($dynamicKeys)) ? $dynamicKeys : [])
                        @php($arabicMap   = (isset($arabicMap) && is_array($arabicMap)) ? $arabicMap : [])
                        @if(empty($dynamicKeys))
                            @php($dynamicKeys = ['payment_method_display','code','status','customer_name','total','created_at'])
                        @endif
                        <table id="ordersTable" class="table table-bordered table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    @foreach($dynamicKeys as $key)
                                        <th class="text-center">{{ $arabicMap[$key] ?? str_replace('_',' ', strtoupper($key)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $i => $row)
                                    @php($r = is_array($row) ? $row : (array) $row)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        @foreach($dynamicKeys as $key)
                                            @php($val = $r[$key] ?? null)
                                            <td class="text-center">
                                                @if($key === 'payment_method_display')
                                                    {{ is_scalar($r['payment_method_display'] ?? null) ? $r['payment_method_display'] : '—' }}
                                                @else
                                                    @php($isScalar = is_scalar($val))
                                                    @if(!$isScalar)
                                                        <span class="text-muted">—</span>
                                                    @else
                                                        {{ is_numeric($val) ? (in_array($key, ['total','amount','grand_total']) ? number_format((float)$val, 2) : $val) : ($val ?? '') }}
                                                    @endif
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
    @endif
</div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script>
        $(function(){
            $('#ordersTable').DataTable({
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
