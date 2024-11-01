<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property float $price
 * @property string $customer_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Customer $customer
 * @property Collection $products
 * @property Collection $payments
 */
class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'price',
        'customer_id'.
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
        'price' => 'float',
        'customer_id' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'order_id', 'id');
    }
}
