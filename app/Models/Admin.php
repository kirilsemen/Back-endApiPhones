<?php

namespace App\Models;

use Database\Factories\AdminFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * class Admin
 *
 * @package App\Models
 *
 * @property string $name
 * @property string $email
 * @property int $password
 * @property boolean $owner
 */
class Admin extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'owner'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password'
    ];

    /**
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return AdminFactory::new();
    }

}
