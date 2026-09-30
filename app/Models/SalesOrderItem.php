<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

class SalesOrderItem extends Model
{
    protected $fillable = [
        'sales_order_id',
        'product_name',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function salesOrder(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class);
    }

    protected static function booted(): void
    {
        static::saving(function (self $item): void {

            // Produk tidak boleh dipindahkan ke pesanan lain.
            if (
                $item->exists &&
                $item->isDirty('sales_order_id')
            ) {
                throw ValidationException::withMessages([
                    'items' => 'Produk tidak dapat dipindahkan ke pesanan lain.',
                ]);
            }

            // Kunci rincian produk setelah pembayaran pertama.
            $isChanging = ! $item->exists ||
                $item->isDirty([
                    'product_name',
                    'quantity',
                    'unit_price',
                    'subtotal',
                ]);

            if (
                $isChanging &&
                SalesOrderPayment::query()
                    ->where('sales_order_id', $item->sales_order_id)
                    ->exists()
            ) {
                throw ValidationException::withMessages([
                    'items' =>
                        'Rincian produk tidak dapat diubah karena pesanan sudah memiliki pembayaran.',
                ]);
            }

            // Validasi dan hitung subtotal resmi.
            $quantity = (int) $item->quantity;
            $unitPrice = (string) $item->unit_price;

            if ($quantity < 1) {
                throw ValidationException::withMessages([
                    'quantity' => 'Jumlah produk minimal 1.',
                ]);
            }

            if (
                ! preg_match(
                    '/^(0|[1-9][0-9]*)(\.00)?$/',
                    $unitPrice
                )
            ) {
                throw ValidationException::withMessages([
                    'unit_price' =>
                        'Harga harus angka bulat dan tidak boleh negatif.',
                ]);
            }

            $subtotal = $quantity * (int) $unitPrice;

            if ($subtotal > 999999999999) {
                throw ValidationException::withMessages([
                    'unit_price' => 'Subtotal produk melebihi batas.',
                ]);
            }

            $item->subtotal = $subtotal;
        });

        static::deleting(function (self $item): void {
            if (
                SalesOrderPayment::query()
                    ->where('sales_order_id', $item->sales_order_id)
                    ->exists()
            ) {
                throw ValidationException::withMessages([
                    'items' =>
                        'Produk tidak dapat dihapus karena pesanan sudah memiliki pembayaran.',
                ]);
            }
        });

        static::saved(function (self $item): void {
            $item->recalculateOrderSubtotal();
        });

        static::deleted(function (self $item): void {
            $item->recalculateOrderSubtotal();
        });
    }

    private function recalculateOrderSubtotal(): void
    {
        $order = $this->salesOrder()->first();

        if ($order === null) {
            return;
        }

        $total = $order->items()->sum('subtotal');

        if ($total > 999999999999) {
            throw ValidationException::withMessages([
                'items' => 'Total pesanan melebihi batas.',
            ]);
        }

        $order->update([
            'subtotal' => $total,
        ]);
    }
}
