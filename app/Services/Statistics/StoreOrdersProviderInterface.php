<?php

namespace App\Services\Statistics;

use App\Models\Domain;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

interface StoreOrdersProviderInterface
{
    /**
     * Fetch aggregated orders per store for a given domain and optional date range.
     * Must return a collection of arrays with keys: store_name, store_slug, orders_count, total_amount
     *
     * @param Domain $domain
     * @param CarbonInterface|null $from
     * @param CarbonInterface|null $to
     * @return Collection<int, array{store_name:string|null, store_slug:string|null, orders_count:int, total_amount:float}>
     */
    public function fetch(Domain $domain, ?CarbonInterface $from, ?CarbonInterface $to): Collection;
}
