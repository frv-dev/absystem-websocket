<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property float $price
 * @property string $wallet_id
 * @property string $payment_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Payment|null $payment
 * @property Wallet $wallet
 */
class WalletRegister extends Model
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
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }
}
