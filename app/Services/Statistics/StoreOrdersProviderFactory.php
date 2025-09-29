<?php

namespace App\Services\Statistics;

use App\Models\Domain;
use InvalidArgumentException;

class StoreOrdersProviderFactory
{
    public static function make(Domain $domain): StoreOrdersProviderInterface
    {
        $type = strtolower(trim((string) $domain->type));
        $name = strtolower(trim((string) $domain->domain_name));

        // Prefer explicit mapping by name for now; can be moved to 'type' later
        if ($name === 'yadbeyad') {
            return new YadBeYadOrdersProvider();
        }

        // Normalize synonyms
        $type = match ($type) {
            'holo' => 'holol',
            default => $type,
        };

        return match ($type) {
            'zid'   => new ZidOrdersProvider(),
            'holol' => new HololOrdersProvider(),
            default => throw new InvalidArgumentException("Unsupported domain type/name: {$domain->type} / {$domain->domain_name}"),
        };
    }
}
