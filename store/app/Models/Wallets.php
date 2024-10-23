<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallets extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
        'name',
        'value',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'value' => 'float',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function walletRegisters(): HasMany
    {
        return $this->hasMany(WalletRegisters::class, 'wallet_id', 'id');
    }
}
