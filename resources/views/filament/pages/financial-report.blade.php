<x-filament-panels::page>

    <div class="space-y-6">

        {{-- Header --}}
        <div
            style="
                padding: 28px;
                border: 1px solid #d5e4fa;
                border-radius: 20px;
                background: #edf4ff;
            "
        >
            <div
                style="
                    color: #2563eb;
                    font-size: 13px;
                    font-weight: 700;
                    letter-spacing: .12em;
                    margin-bottom: 8px;
                "
            >
                SENTUH / LAPORAN KEUANGAN
            </div>

            <h1
                style="
                    color: #10233f;
                    font-size: 32px;
                    font-weight: 800;
                    line-height: 1.2;
                    margin: 0;
                "
            >
                Ringkasan Keuangan
            </h1>

            <p
                style="
                    margin-top: 10px;
                    color: #64748b;
                    font-size: 15px;
                "
            >
                Pantau nilai penjualan, penerimaan,
                pengeluaran, saldo kas, dan sisa tagihan
                berdasarkan transaksi yang tercatat.
            </p>
        </div>

        <div
    style="
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 16px 20px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        flex-wrap: wrap;
    "
>
    <div>
        <div
            style="
                color: #10233f;
                font-size: 14px;
                font-weight: 700;
            "
        >
            Periode Laporan
        </div>

        <div
            style="
                color: #64748b;
                font-size: 12px;
                margin-top: 3px;
            "
        >
            Penjualan, uang masuk, dan pengeluaran
            mengikuti periode yang dipilih.
        </div>
    </div>

    <select
        wire:model.live="period"
        style="
            min-width: 190px;
            padding: 10px 36px 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            background: white;
            color: #10233f;
            font-weight: 600;
        "
    >
        @foreach ($this->getPeriodOptions() as $value => $label)
            <option value="{{ $value }}">
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

        {{-- KPI --}}
        <div
            style="
                display: grid;
                grid-template-columns: repeat(
                    auto-fit,
                    minmax(210px, 1fr)
                );
                gap: 16px;
            "
        >

            {{-- Total Penjualan --}}
            <div
                style="
                    padding: 22px;
                    background: white;
                    border: 1px solid #e2e8f0;
                    border-radius: 18px;
                "
            >
                <div
                    style="
                        color: #64748b;
                        font-size: 13px;
                        font-weight: 600;
                    "
                >
                    Total Penjualan
                </div>

                <div
                    style="
                        margin-top: 8px;
                        color: #10233f;
                        font-size: 26px;
                        font-weight: 800;
                    "
                >
                    Rp{{ number_format(
                        $summary['total_sales'],
                        0,
                        ',',
                        '.'
                    ) }}
                </div>

                <div
                    style="
                        margin-top: 6px;
                        color: #94a3b8;
                        font-size: 12px;
                    "
                >
                    Nilai pesanan selain yang dibatalkan
                </div>
            </div>

            {{-- Uang Masuk --}}
            <div
                style="
                    padding: 22px;
                    background: white;
                    border: 1px solid #e2e8f0;
                    border-radius: 18px;
                "
            >
                <div
                    style="
                        color: #64748b;
                        font-size: 13px;
                        font-weight: 600;
                    "
                >
                    Uang Masuk
                </div>

                <div
                    style="
                        margin-top: 8px;
                        color: #166534;
                        font-size: 26px;
                        font-weight: 800;
                    "
                >
                    Rp{{ number_format(
                        $summary['all_time_received'],
                        0,
                        ',',
                        '.'
                    ) }}
                </div>

                <div
                    style="
                        margin-top: 6px;
                        color: #94a3b8;
                        font-size: 12px;
                    "
                >
                    Pembayaran yang sudah diterima
                </div>
            </div>

            {{-- Pengeluaran --}}
            <div
                style="
                    padding: 22px;
                    background: white;
                    border: 1px solid #e2e8f0;
                    border-radius: 18px;
                "
            >
                <div
                    style="
                        color: #64748b;
                        font-size: 13px;
                        font-weight: 600;
                    "
                >
                    Pengeluaran
                </div>

                <div
                    style="
                        margin-top: 8px;
                        color: #b91c1c;
                        font-size: 26px;
                        font-weight: 800;
                    "
                >
                    Rp{{ number_format(
                        $summary['all_time_expenses'],
                        0,
                        ',',
                        '.'
                    ) }}
                </div>

                <div
                    style="
                        margin-top: 6px;
                        color: #94a3b8;
                        font-size: 12px;
                    "
                >
                    Uang keluar yang tercatat
                </div>
            </div>

            {{-- Saldo Kas --}}
            <div
                style="
                    padding: 22px;
                    background: #10233f;
                    border: 1px solid #10233f;
                    border-radius: 18px;
                "
            >
                <div
                    style="
                        color: #cbd5e1;
                        font-size: 13px;
                        font-weight: 600;
                    "
                >
                    Saldo Kas
                </div>

                <div
                    style="
                        margin-top: 8px;
                        color: white;
                        font-size: 26px;
                        font-weight: 800;
                    "
                >
                    Rp{{ number_format(
                        $summary['cash_balance'],
                        0,
                        ',',
                        '.'
                    ) }}
                </div>

                <div
                    style="
                        margin-top: 6px;
                        color: #94a3b8;
                        font-size: 12px;
                    "
                >
                    Saldo awal + uang masuk − pengeluaran
                </div>
            </div>

            {{-- Sisa Tagihan --}}
            <div
                style="
                    padding: 22px;
                    background: white;
                    border: 1px solid #e2e8f0;
                    border-radius: 18px;
                "
            >
                <div
                    style="
                        color: #64748b;
                        font-size: 13px;
                        font-weight: 600;
                    "
                >
                    Sisa Tagihan
                </div>

                <div
                    style="
                        margin-top: 8px;
                        color: #1d4ed8;
                        font-size: 26px;
                        font-weight: 800;
                    "
                >
                    Rp{{ number_format(
                        $summary['outstanding_receivables'],
                        0,
                        ',',
                        '.'
                    ) }}
                </div>

                <div
                    style="
                        margin-top: 6px;
                        color: #94a3b8;
                        font-size: 12px;
                    "
                >
                    Nilai pesanan yang belum dibayar
                </div>
            </div>

        </div>

        {{-- Breakdown --}}
        <div
            style="
                padding: 22px 24px;
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 18px;
            "
        >
            <div
                style="
                    color: #10233f;
                    font-size: 17px;
                    font-weight: 700;
                "
            >
                Ringkasan Saldo
            </div>

            <div
                style="
                    margin-top: 16px;
                    display: flex;
                    justify-content: space-between;
                    gap: 20px;
                    flex-wrap: wrap;
                    color: #64748b;
                    font-size: 14px;
                "
            >
                <span>
                    Saldo Awal:
                    <strong style="color:#10233f;">
                        Rp{{ number_format(
                            $summary['opening_balance'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </span>

                <span>
                    + Uang Masuk:
                    <strong style="color:#166534;">
                        Rp{{ number_format(
                            $summary['total_received'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </span>

                <span>
                    − Pengeluaran:
                    <strong style="color:#b91c1c;">
                        Rp{{ number_format(
                            $summary['total_expenses'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </span>

                <span>
                    = Saldo:
                    <strong style="color:#10233f;">
                        Rp{{ number_format(
                            $summary['cash_balance'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </span>
            </div>
        </div>

        <div
    style="
        display: grid;
        grid-template-columns:
            repeat(auto-fit, minmax(420px, 1fr));
        gap: 20px;
    "
>

    {{-- PEMBAYARAN MASUK --}}
    <div
        style="
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
        "
    >
        <div
            style="
                padding: 20px 22px;
                border-bottom: 1px solid #e2e8f0;
            "
        >
            <div
                style="
                    color: #10233f;
                    font-size: 17px;
                    font-weight: 700;
                "
            >
                Pembayaran Masuk Terbaru
            </div>

            <div
                style="
                    margin-top: 4px;
                    color: #64748b;
                    font-size: 13px;
                "
            >
                Periode:
                {{ $summary['period_label'] }}
            </div>
        </div>

        @forelse (
            $summary['recent_payments']
            as $payment
        )
            <div
                style="
                    padding: 16px 22px;
                    border-bottom: 1px solid #f1f5f9;
                    display: flex;
                    justify-content: space-between;
                    gap: 16px;
                "
            >
                <div style="min-width: 0;">
                    <div
                        style="
                            color: #10233f;
                            font-weight: 700;
                            font-size: 14px;
                        "
                    >
                        {{ $payment['order_number'] }}
                    </div>

                    <div
                        style="
                            color: #64748b;
                            font-size: 12px;
                            margin-top: 3px;
                        "
                    >
                        {{ $payment['customer_name'] }}
                    </div>

                    <div
                        style="
                            color: #94a3b8;
                            font-size: 11px;
                            margin-top: 5px;
                        "
                    >
                        {{ $payment['received_at'] }}
                        ·
                        {{ $payment['cash_account'] }}
                    </div>

                    @if ($payment['reference'])
                        <div
                            style="
                                color: #94a3b8;
                                font-size: 11px;
                                margin-top: 2px;
                            "
                        >
                            Ref:
                            {{ $payment['reference'] }}
                        </div>
                    @endif
                </div>

                <div
                    style="
                        color: #166534;
                        font-weight: 800;
                        white-space: nowrap;
                    "
                >
                    + Rp{{ number_format(
                        $payment['amount'],
                        0,
                        ',',
                        '.'
                    ) }}
                </div>
            </div>

        @empty
            <div
                style="
                    padding: 28px 22px;
                    text-align: center;
                    color: #94a3b8;
                    font-size: 13px;
                "
            >
                Belum ada pembayaran
                pada periode ini.
            </div>
        @endforelse
    </div>


    {{-- PENGELUARAN --}}
    <div
        style="
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
        "
    >
        <div
            style="
                padding: 20px 22px;
                border-bottom: 1px solid #e2e8f0;
            "
        >
            <div
                style="
                    color: #10233f;
                    font-size: 17px;
                    font-weight: 700;
                "
            >
                Pengeluaran Terbaru
            </div>

            <div
                style="
                    margin-top: 4px;
                    color: #64748b;
                    font-size: 13px;
                "
            >
                Periode:
                {{ $summary['period_label'] }}
            </div>
        </div>

        @forelse (
            $summary['recent_expenses']
            as $expense
        )
            <div
                style="
                    padding: 16px 22px;
                    border-bottom: 1px solid #f1f5f9;
                    display: flex;
                    justify-content: space-between;
                    gap: 16px;
                "
            >
                <div style="min-width: 0;">
                    <div
                        style="
                            color: #10233f;
                            font-weight: 700;
                            font-size: 14px;
                        "
                    >
                        {{ $expense['description'] }}
                    </div>

                    <div
                        style="
                            color: #64748b;
                            font-size: 12px;
                            margin-top: 3px;
                        "
                    >
                        {{ $expense['category'] }}
                    </div>

                    <div
                        style="
                            color: #94a3b8;
                            font-size: 11px;
                            margin-top: 5px;
                        "
                    >
                        {{ $expense['expense_date'] }}
                        ·
                        {{ $expense['cash_account'] }}
                    </div>

                    @if ($expense['reference'])
                        <div
                            style="
                                color: #94a3b8;
                                font-size: 11px;
                                margin-top: 2px;
                            "
                        >
                            Ref:
                            {{ $expense['reference'] }}
                        </div>
                    @endif
                </div>

                <div
                    style="
                        color: #b91c1c;
                        font-weight: 800;
                        white-space: nowrap;
                    "
                >
                    − Rp{{ number_format(
                        $expense['amount'],
                        0,
                        ',',
                        '.'
                    ) }}
                </div>
            </div>

        @empty
            <div
                style="
                    padding: 28px 22px;
                    text-align: center;
                    color: #94a3b8;
                    font-size: 13px;
                "
            >
                Belum ada pengeluaran
                pada periode ini.
            </div>
        @endforelse

    </div>
</div>

        {{-- Catatan demo --}}
        <div
            style="
                padding: 14px 18px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                color: #64748b;
                font-size: 13px;
            "
        >
            Angka laporan dihitung dari data transaksi yang
            tersimpan. Record dengan identitas
            <strong>TEST</strong> merupakan data simulasi
            pengembangan SENTUH.
        </div>

    </div>

</x-filament-panels::page>