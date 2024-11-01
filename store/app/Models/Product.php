<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $id
 * @property string $name
 * @property float $price
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Collection $orders
 */
class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'price' => 'float',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id');
    }
}
