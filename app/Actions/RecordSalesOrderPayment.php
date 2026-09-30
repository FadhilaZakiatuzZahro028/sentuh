<?php

namespace App\Actions;

use App\Models\CashAccount;
use App\Models\SalesOrder;
use App\Models\SalesOrderPayment;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RecordSalesOrderPayment
{
    public function handle(
        int $salesOrderId,
        int $cashAccountId,
        int $amount,
        ?CarbonInterface $receivedAt = null,
        ?string $reference = null,
        ?string $notes = null,
    ): SalesOrderPayment {
        if ($amount < 1 || $amount > 999999999999) {
            throw ValidationException::withMessages([
                'amount' => 'Masukkan nominal pembayaran yang valid.',
            ]);
        }

        if ($reference !== null && mb_strlen($reference) > 100) {
            throw ValidationException::withMessages([
                'reference' => 'Referensi maksimal 100 karakter.',
            ]);
        }

        return DB::transaction(function () use (
            $salesOrderId,
            $cashAccountId,
            $amount,
            $receivedAt,
            $reference,
            $notes,
        ): SalesOrderPayment {
            // Kunci pesanan selama pembayaran diproses.
            $order = SalesOrder::query()
                ->lockForUpdate()
                ->findOrFail($salesOrderId);

            if ($order->status === SalesOrder::STATUS_CANCELLED) {
                throw ValidationException::withMessages([
                    'sales_order_id' =>
                        'Pesanan yang dibatalkan tidak dapat menerima pembayaran.',
                ]);
            }

            // Hanya rekening aktif yang boleh menerima pembayaran.
            $account = CashAccount::query()
                ->lockForUpdate()
                ->find($cashAccountId);

            if ($account === null || ! $account->is_active) {
                throw ValidationException::withMessages([
                    'cash_account_id' =>
                        'Pilih rekening kas yang masih aktif.',
                ]);
            }

            $totalPesanan = (int) $order->subtotal;

            $totalDibayar = (int) SalesOrderPayment::query()
                ->where('sales_order_id', $order->id)
                ->sum('amount');

            $sisaTagihan = $totalPesanan - $totalDibayar;

            if ($sisaTagihan <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Pesanan ini tidak memiliki sisa tagihan.',
                ]);
            }

            if ($amount > $sisaTagihan) {
                throw ValidationException::withMessages([
                    'amount' =>
                        'Pembayaran melebihi sisa tagihan sebesar Rp' .
                        number_format($sisaTagihan, 0, ',', '.'),
                ]);
            }

            return SalesOrderPayment::create([
                'sales_order_id' => $order->id,
                'cash_account_id' => $account->id,
                'amount' => $amount,
                'received_at' => $receivedAt ?? now(),
                'reference' => $reference,
                'notes' => $notes,
            ]);
        }, 3);
    }
}
