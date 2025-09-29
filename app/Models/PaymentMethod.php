<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentMethodTranslation;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    public $translatedAttributes = ['title', 'content', 'payment_id', 'locale'];
    protected $translationForeignKey = 'payment_id';
    protected $fillable = [
        'min_price',
        'payment_key',
        'meta',
        'image',
        'cart_show',
        'name_holder',
        'status',
        'creared_by',
        'updated_by',
    ];

    // relations ---------------
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function trans()
    {
        return $this->hasMany(PaymentMethodTranslation::class, 'payment_id', 'id');
    }

    public function transNow()
    {
        return $this->hasOne(PaymentMethodTranslation::class, 'payment_id', 'id')->where('locale' , app()->getLocale());
    }

    public function trans_ar()
    {
        return $this->hasOne(PaymentMethodTranslation::class, 'payment_id', 'id')->where('locale', 'ar');
    }
    public function banks()
    {
        return $this->hasMany(PaymentBank::class, 'payment_method_id', 'id');
    }



    // scope --------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
