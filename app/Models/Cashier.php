<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cashier extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'cashiers';

    protected $fillable = [
        'account_id',
        'name',
        'email',
        'mobile',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id', 'id');
    }

    public function setPasswordAttribute($value)
    {
        if ($value && \Illuminate\Support\Str::startsWith($value, '$2y$') === false) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }


    public function categories()
    {

        return $this->belongsToMany(CategoryProjects::class, 'cashier_category_project', 'cashier_id', 'category_project_id')->withTimestamps();
    }



    public function charityProjects()

    {

        return $this->belongsToMany(CharityProject::class, 'cashier_charity_project', 'cashier_id', 'charity_project_id')->withTimestamps();
    }
}
