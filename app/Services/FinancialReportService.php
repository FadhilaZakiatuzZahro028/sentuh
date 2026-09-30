<?php

namespace App\Services;

use App\Models\CashAccount;
use App\Models\CashExpense;
use App\Models\SalesOrder;
use App\Models\SalesOrderPayment;
use Illuminate\Database\Eloquent\Builder;

class FinancialReportService
{
    public function summary(string $period = 'all'): array
    {
        [$start, $end, $periodLabel] = $this->resolvePeriod($period);

        $salesQuery = SalesOrder::query()
            ->where(
                'status',
                '!=',
                SalesOrder::STATUS_CANCELLED
            );

        $paymentQuery = SalesOrderPayment::query();

        $expenseQuery = CashExpense::query();

        $this->applySalesPeriod(
            $salesQuery,
            $start,
            $end
        );

        $this->applyPaymentPeriod(
            $paymentQuery,
            $start,
            $end
        );

        $this->applyExpensePeriod(
            $expenseQuery,
            $start,
            $end
        );

        /*
        |--------------------------------------------------------------------------
        | METRIK PERIODE
        |--------------------------------------------------------------------------
        */

        $totalSales = (int) $salesQuery
            ->clone()
            ->sum('subtotal');

        $totalReceived = (int) $paymentQuery
            ->clone()
            ->sum('amount');

        $totalExpenses = (int) $expenseQuery
            ->clone()
            ->sum('amount');

        $netCashFlow =
            $totalReceived - $totalExpenses;

        /*
        |--------------------------------------------------------------------------
        | POSISI KEUANGAN SAAT INI
        |--------------------------------------------------------------------------
        */

        $totalOpeningBalance = (int) CashAccount::query()
            ->sum('opening_balance');

        $allTimeReceived = (int) SalesOrderPayment::query()
            ->sum('amount');

        $allTimeExpenses = (int) CashExpense::query()
            ->sum('amount');

        $cashBalance =
            $totalOpeningBalance
            + $allTimeReceived
            - $allTimeExpenses;

        $outstandingReceivables = (int) SalesOrder::query()
            ->where(
                'status',
                '!=',
                SalesOrder::STATUS_CANCELLED
            )
            ->withSum('payments', 'amount')
            ->get()
            ->sum(function (SalesOrder $order): int {
                $subtotal = (int) $order->subtotal;

                $paid = (int) (
                    $order->payments_sum_amount ?? 0
                );

                return max(
                    0,
                    $subtotal - $paid
                );
            });

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERBARU SESUAI PERIODE
        |--------------------------------------------------------------------------
        */

        $recentPayments = $paymentQuery
            ->clone()
            ->with([
                'salesOrder:id,order_number,customer_name',
                'cashAccount:id,name',
            ])
            ->latest('received_at')
            ->limit(5)
            ->get()
            ->map(function (
                SalesOrderPayment $payment
            ): array {
                return [
                    'received_at' =>
                        $payment->received_at
                            ?->format('d/m/Y H:i'),

                    'order_number' =>
                        $payment->salesOrder
                            ?->order_number
                        ?? '-',

                    'customer_name' =>
                        $payment->salesOrder
                            ?->customer_name
                        ?? '-',

                    'cash_account' =>
                        $payment->cashAccount
                            ?->name
                        ?? '-',

                    'reference' =>
                        $payment->reference,

                    'amount' =>
                        (int) $payment->amount,
                ];
            })
            ->values()
            ->all();

        $recentExpenses = $expenseQuery
            ->clone()
            ->with('cashAccount:id,name')
            ->latest('expense_date')
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(function (
                CashExpense $expense
            ): array {
                return [
                    'expense_date' =>
                        $expense->expense_date
                            ?->format('d/m/Y'),

                    'category' =>
                        $expense->category,

                    'description' =>
                        $expense->description,

                    'cash_account' =>
                        $expense->cashAccount
                            ?->name
                        ?? '-',

                    'reference' =>
                        $expense->reference,

                    'amount' =>
                        (int) $expense->amount,
                ];
            })
            ->values()
            ->all();

        return [
            'period' => $period,
            'period_label' => $periodLabel,

            'total_sales' => $totalSales,
            'total_received' => $totalReceived,
            'total_expenses' => $totalExpenses,
            'net_cash_flow' => $netCashFlow,

            'opening_balance' =>
                $totalOpeningBalance,

            'all_time_received' =>
                $allTimeReceived,

            'all_time_expenses' =>
                $allTimeExpenses,

            'cash_balance' =>
                $cashBalance,

            'outstanding_receivables' =>
                $outstandingReceivables,

            'recent_payments' =>
                $recentPayments,

            'recent_expenses' =>
                $recentExpenses,
        ];
    }

    private function resolvePeriod(
        string $period
    ): array {
        $now = now();

        return match ($period) {
            'month' => [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfDay(),
                'Bulan Ini',
            ],

            '30_days' => [
                $now->copy()
                    ->subDays(29)
                    ->startOfDay(),

                $now->copy()->endOfDay(),

                '30 Hari Terakhir',
            ],

            default => [
                null,
                null,
                'Semua Waktu',
            ],
        };
    }

    private function applySalesPeriod(
        Builder $query,
        $start,
        $end
    ): void {
        if (
            $start === null ||
            $end === null
        ) {
            return;
        }

        $query->whereBetween(
            'order_date',
            [
                $start->toDateString(),
                $end->toDateString(),
            ]
        );
    }

    private function applyPaymentPeriod(
        Builder $query,
        $start,
        $end
    ): void {
        if (
            $start === null ||
            $end === null
        ) {
            return;
        }

        $query->whereBetween(
            'received_at',
            [
                $start,
                $end,
            ]
        );
    }

    private function applyExpensePeriod(
        Builder $query,
        $start,
        $end
    ): void {
        if (
            $start === null ||
            $end === null
        ) {
            return;
        }

        $query->whereBetween(
            'expense_date',
            [
                $start->toDateString(),
                $end->toDateString(),
            ]
        );
    }
}