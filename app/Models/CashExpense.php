<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

class CashExpense extends Model
{
    protected $fillable = [
        'cash_account_id',
        'expense_date',
        'category',
        'description',
        'amount',
        'reference',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'expense_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function cashAccount(): BelongsTo
    {
        return $this->belongsTo(CashAccount::class);
    }

    protected static function booted(): void
    {
        static::saving(function (self $expense): void {
            $amount = (int) $expense->amount;

            if ($amount < 1 || $amount > 999999999999) {
                throw ValidationException::withMessages([
                    'amount' => 'Nominal pengeluaran harus lebih dari Rp0.',
                ]);
            }

            $account = CashAccount::query()
                ->find($expense->cash_account_id);

            if ($account === null || ! $account->is_active) {
                throw ValidationException::withMessages([
                    'cash_account_id' =>
                        'Pengeluaran hanya dapat dicatat pada rekening yang aktif.',
                ]);
            }
        });
    }
}