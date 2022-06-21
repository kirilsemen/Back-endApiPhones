<?php

namespace App\Models;

use Database\Factories\PhonesFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * class Phones
 *
 * @package App\Models
 *
 * @property string $model
 * @property double $price
 * @property int $quantity
 *
 * @property Collection<Orders> $ordersRelations
 */
class Phones extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'model',
        'price',
        'quantity'
    ];

    /**
     * @return HasMany
     */
    public function ordersRelations(): HasMany
    {
        return $this->hasMany(Orders::class, 'phone_id', 'id');
    }

    /**
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return PhonesFactory::new();
    }
}
