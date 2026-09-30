<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\ValidationException;

class SalesOrder extends Model
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'order_number',
        'order_date',
        'customer_code',
        'customer_name',
        'customer_contact',
        'subtotal',
        'estimated_direct_cost',
        'actual_direct_cost',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'order_date' => 'date',
            'subtotal' => 'decimal:2',
            'estimated_direct_cost' => 'decimal:2',
            'actual_direct_cost' => 'decimal:2',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SalesOrderPayment::class);
    }

    protected static function booted(): void
    {
        static::updating(function (self $order): void {

            // Belum memiliki pembayaran: pesanan boleh diedit.
            if (! $order->payments()->exists()) {
                return;
            }

            // Identitas utama dan total pesanan dikunci.
            if ($order->isDirty([
                'order_number',
                'order_date',
                'subtotal',
            ])) {
                throw ValidationException::withMessages([
                    'subtotal' =>
                        'Nomor, tanggal, dan total pesanan tidak dapat diubah setelah pembayaran diterima.',
                ]);
            }

            // Pesanan dengan pembayaran tidak boleh dibatalkan.
            if (
                $order->isDirty('status') &&
                $order->status === self::STATUS_CANCELLED
            ) {
                throw ValidationException::withMessages([
                    'status' =>
                        'Pesanan yang sudah menerima pembayaran tidak dapat langsung dibatalkan.',
                ]);
            }
        });
    }
}