<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Domain\StoreDomainRequest;
use App\Http\Requests\Admin\Domain\UpdateDomainRequest;
use App\Models\Domain;
use App\Models\Order;
use App\Services\Statistics\StoreOrdersProviderFactory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Domain::class, 'domain');
    }

    public function index(Request $request)
    {
        $query = Domain::query()->orderByDesc('id');

        if ($request->filled('domain_name')) {
            $query->where('domain_name', 'like', '%'.$request->domain_name.'%');
        }
        if ($request->filled('domain_url')) {
            $query->where('domain_url', 'like', '%'.$request->domain_url.'%');
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $status = (int) $request->status;
            $query->where('status', $status === 1);
        }

        $domains = $query->get(); // client-side DataTables

        return view('admin.dashboard.domains.index', compact('domains'));
    }

    public function create()
    {
        return view('admin.dashboard.domains.create');
    }

    public function store(StoreDomainRequest $request)
    {
        Domain::create($request->validated());
        return redirect()->route('admin.domains.index')->with('success', __('تم إنشاء النطاق بنجاح'));
    }

    public function show(Domain $domain)
    {
        return view('admin.dashboard.domains.show', compact('domain'));
    }

    public function edit(Domain $domain)
    {
        return view('admin.dashboard.domains.edit', compact('domain'));
    }

    public function update(UpdateDomainRequest $request, Domain $domain)
    {
        $domain->update($request->validated());
        return redirect()->route('admin.domains.index')->with('success', __('تم تحديث النطاق بنجاح'));
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();
        return redirect()->route('admin.domains.index')->with('success', __('تم حذف النطاق بنجاح'));
    }

    /**
     * عرض إحصائيات الطلبات لكل متجر (store) مع فلتر التاريخ من/إلى
     */
    public function statistics(Request $request)
    {
        // Load active domains only
        $domains = Domain::query()->where('status', 1)->orderBy('domain_name')->get();
        $selectedDomainId = $request->input('domain_id');
        $from = $request->filled('date_from') ? Carbon::parse($request->input('date_from'))->startOfDay() : null;
        $to   = $request->filled('date_to') ? Carbon::parse($request->input('date_to'))->endOfDay() : null;

        $stats = collect();
        $error = null;

        if ($selectedDomainId) {
            try {
                $domain = Domain::findOrFail($selectedDomainId);
                $provider = StoreOrdersProviderFactory::make($domain);
                $stats = $provider->fetch($domain, $from, $to);
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                $stats = collect();
            }
        } else {
            // No specific domain selected: fetch for all active domains
            foreach ($domains as $domain) {
                try {
                    $provider = StoreOrdersProviderFactory::make($domain);
                    $domainStats = $provider->fetch($domain, $from, $to);

                    // Aggregate to a single row per domain (association)
                    $ordersCount = (int) $domainStats->sum('orders_count');
                    $totalAmount = (float) $domainStats->sum('total_amount');

                    $stats->push([
                        'store_name'   => $domain->domain_name,
                        'store_slug'   => parse_url($domain->domain_url ?? '', PHP_URL_HOST) ?: null,
                        'store_url'    => $domain->domain_url ? rtrim($domain->domain_url, '/') : null,
                        'orders_count' => $ordersCount,
                        'total_amount' => $totalAmount,
                    ]);
                } catch (\Throwable $e) {
                    // Accumulate errors but continue with other domains
                    $error = trim(($error ? $error." | " : '').$e->getMessage());
                }
            }
        }

        return view('admin.dashboard.domains.statistics', [
            'domains' => $domains,
            'selectedDomainId' => $selectedDomainId,
            'stats' => $stats,
            'date_from' => $from ? $from->toDateString() : null,
            'date_to' => $to ? $to->toDateString() : null,
            'error' => $error,
        ]);
    }
}
