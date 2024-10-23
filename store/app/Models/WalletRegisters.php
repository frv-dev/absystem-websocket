<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletRegisters extends Model
{
    protected $table = 'wallet_registers';

    protected $fillable = [
        'price',
        'wallet_id',
        'payment_id',
    ];

    protected $casts = [
        'id' => 'string',
        'price' => 'float',
        'wallet_id' => 'string',
        'payment_id' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payments::class, 'payment_id', 'id');
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallets::class, 'wallet_id', 'id');
    }
}
