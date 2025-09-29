<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderView extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_view';

    public function paymentMethodTranslationEn()
    {
        return $this->hasOne(PaymentMethodTranslation::class, 'payment_id', 'payment_method_id')->where('locale', 'en');
    }

    public function details() {
        return $this->hasMany(OrderDetails::class);
    }
 

    public function paymentMethodTranslationAr()
    {
        return $this->hasOne(PaymentMethodTranslation::class, 'payment_id', 'payment_method_id')->where('locale', 'ar');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class, 'donor_id', 'id');
    }

    // scope
    public function scopePending($query)
    {
        return $query->where('status', 0);
    }
    public function scopeConfirmed($query)
    {
        return $query->where('status', 1);
    }
    public function scopeForMonth($query, $year, $month)
    {
        $start = Carbon::createFromDate($year, $month, 1);
        $end = $start->copy()->endOfMonth();
        return $query->whereBetween('created_at', [$start, $end]);
    }
}
