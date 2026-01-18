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
        'balance',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // sebagai buyer
    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    // sebagai seller
    public function sellerOrders()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    // sebagai kurir
    public function courierOrders()
    {
        return $this->hasMany(Order::class, 'courier_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
