<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'account_id',
        'slug',
        'name',
        'employee_name',
        'employee_number',
        'employee_image',
        'employee_department',
        'ax_store_name',
        'job',
        'whatsapp',
        'location',
        'details',
        'status',
        'is_group_manager',
        'code'
    ];

    protected $with = ['account'];
    
    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id', 'id')->withDefault([
            'user_name' => 'N/A',
            'email' => 'N/A',
            'mobile' => 'N/A'
        ]);
    }

    public function managers()
    {
        return $this->belongsToMany(Manager::class, 'manager_refers', 'refer_id', 'manager_id')
            ->withPivot('created_at', 'updated_at');
    }

    public function childrenGroup()
    {
        return $this->children()->where('is_group_manager', 1);
    }

    public function parentsGroup()
    {
        return $this->parents()->where('is_group_manager', 1);
    }

    public function children()
    {
        return $this->belongsToMany(
            Refer::class,
            'refer_refer',
            'parent_id',
            'child_id'
        );
    }

    public function parents()
    {
        return $this->belongsToMany(
            Refer::class,
            'refer_refer',
            'child_id',
            'parent_id'
        );
    }

    // Scopes ----------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }
}
