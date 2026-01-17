<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'social_id',
        'social_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // sebagai seller
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    // sebagai buyer
    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    // sebagai kurir
    public function deliveries()
    {
        return $this->hasMany(Order::class, 'courier_id');
    }
}
