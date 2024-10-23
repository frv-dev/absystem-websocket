<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
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
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Products::class, 'order_items', 'order_id', 'product_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payments::class, 'order_id', 'id');
    }
}
