<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Products extends Model
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
        return $this->belongsToMany(Orders::class, 'order_items', 'product_id', 'order_id');
    }
}
