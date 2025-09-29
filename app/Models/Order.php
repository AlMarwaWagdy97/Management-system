<?php

namespace App\Models;

use App\Enums\SourcesEnum;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'identifier',
        'total',
        'quantity',
        'source',
        'donor_id',
        'refer_id',
        'status_id',
        'payment_method_id',
        'payment_method_key',
        'payment_proof',
        'bank_id',
        'banktransferproof',
        'API_status',
        'API_odoo',
        'is_notified',
        'status',
        'cart_id',
    ];


    // relations -----------------------------------------
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function refer()
{
    return $this->belongsTo(Refer::class, 'refer_id');
}

    public function statusOrder()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
    public function details()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function referrer()
    {
        return $this->belongsTo(Refer::class);
    }

    public function badalOrder()
    {
        return $this->belongsTo(BadalOrder::class, 'id', 'order_id');
    }

    public function badalDetails()
    {
        return $this->belongsTo(OrderDetails::class, 'id', 'order_id');
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

    public function scopeBadal($query)
    {
        return $query->where('source', SourcesEnum::BADAL);
    }



    //  Mutators & Casting
    /**
     * @return mixed
     */
    public function getMobileAttribute()
    {
        return $this->donor->mobile;
    }
    //  End Mutators & Casting



    protected static function boot()
    {
        parent::boot();

        // // Generate a UUID when creating a new item
        // static::creating(function ($order) {
        //     // Generate a UUID and ensure it has at least 6 digits
        //     $uuid = Str::uuid()->getInteger();
        //     $order->identifier = str_pad($uuid, 6, '0', STR_PAD_LEFT);
        // });
    }
}
