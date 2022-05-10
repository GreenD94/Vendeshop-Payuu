<?php

namespace App\Models;


use App\Traits\Query;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Query;
    use HasFactory, Notifiable, HasApiTokens;
    use HasRoles;

    protected $with = ['avatar', 'roles', 'tickets', 'addresses'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'birth_date',
        'device_key',
        'avatar_id',
        'city',
        'address'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function avatar()
    {
    }

    static public function StoreAuth($email, $password, $device_key)
    {
    }

    static public function StoreGoogleAuth($device_key, $token)
    {
    }

    static public function StoreAppleAuth($device_key, $token)
    {
    }

    public function favorite_stock()
    {
    }

    public function tickets()
    {
    }


    public function addresses()
    {
    }

    public function scopeWhenRole($query, $role)
    {
    }
}
