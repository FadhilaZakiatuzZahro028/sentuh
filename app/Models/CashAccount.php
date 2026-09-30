<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CashAccount extends Model
{
    public const TYPE_CASH = 'cash';
    public const TYPE_BANK = 'bank';
    public const TYPE_E_WALLET = 'e_wallet';

    protected $fillable = [
        'name',
        'type',
        'opening_balance',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'opening_balance' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::updating(function (self $account): void {
            if ($account->isDirty('opening_balance')) {
                throw ValidationException::withMessages([
                    'opening_balance' =>
                        'Saldo awal tidak dapat diubah setelah rekening dibuat.',
                ]);
            }
        });
    }
}
