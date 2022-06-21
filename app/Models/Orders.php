<?php

namespace App\Models;

use Database\Factories\OrdersFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * class Orders
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $phones_id
 * @property int $amount
 * @property double $total_price
 *
 * @property Collection<User> $userRelation
 * @property Collection<Phones> $phonesRelation
 */
class Orders extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'phone_id',
        'amount',
        'status',
        'total_price'
    ];

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @return BelongsTo
     */
    public function userRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function phoneRelation(): BelongsTo
    {
        return $this->belongsTo(Phones::class, 'phone_id', 'id');
    }

    /**
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return OrdersFactory::new();
    }
}
