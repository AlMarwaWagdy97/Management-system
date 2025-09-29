<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreStatistics extends Model
{
    use HasFactory;

    protected $table = 'stores_statistics';

    protected $fillable = [
        'store_id',
        'store_name',
        'api_url',
        'orders_count',
        'orders_total',
        'projects_count',
        'managers_count',
        'marketers_count',
        'statistics_date',
    ];

    protected $casts = [
        'statistics_date' => 'date',
        'orders_total' => 'decimal:2',
    ];

    // Relations
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    // Scopes
    public function scopeForDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('statistics_date', [$startDate, $endDate]);
    }

    public function scopeForStore($query, $storeId)
    {
        return $query->where('store_id', $storeId);
    }
}
