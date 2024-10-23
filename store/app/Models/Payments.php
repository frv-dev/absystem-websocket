<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payments extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'status',
        'order_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
        'status' => 'string',
        'order_id' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id');
    }

    public function walletRegisters(): HasMany
    {
        return $this->hasMany(WalletRegisters::class, 'payment_id', 'id');
    }
}
