<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * class User
 *
 * @package App\Models
 * @package Authenticatable
 *
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $phone_number
 *
 * @property Collection<Orders> $ordersRelation
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @return HasMany
     */
    public function ordersRelations(): HasMany
    {
        return $this->hasMany(Orders::class,'order_id', 'id');
    }

    /**
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }
}
