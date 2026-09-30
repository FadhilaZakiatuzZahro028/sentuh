<?php

namespace App\Filament\Resources\SalesOrders\Pages;

use App\Filament\Resources\SalesOrders\SalesOrderResource;
use App\Models\SalesOrder;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use App\Actions\RecordSalesOrderPayment;
use App\Models\CashAccount;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class EditSalesOrder extends EditRecord
{
    protected static string $resource = SalesOrderResource::class;

    public function getHeading(): string | Htmlable
    {
        $status = match ($this->record->status) {
            SalesOrder::STATUS_DRAFT => 'Draft',
            SalesOrder::STATUS_CONFIRMED => 'Dikonfirmasi',
            SalesOrder::STATUS_COMPLETED => 'Selesai',
            SalesOrder::STATUS_CANCELLED => 'Dibatalkan',
            default => 'Tidak diketahui',
        };

        $statusClass = match ($this->record->status) {
            SalesOrder::STATUS_DRAFT => 'is-draft',
            SalesOrder::STATUS_CONFIRMED => 'is-confirmed',
            SalesOrder::STATUS_COMPLETED => 'is-completed',
            SalesOrder::STATUS_CANCELLED => 'is-cancelled',
            default => 'is-unknown',
        };

        $orderNumber = e($this->record->order_number);

        return new HtmlString(<<<HTML
            <span class="sentuh-edit-heading">
                <span class="sentuh-edit-eyebrow">
                    MANAJEMEN PENJUALAN / EDIT DATA
                </span>

                <span class="sentuh-edit-heading-main">
                    <span class="sentuh-edit-title">
                        {$orderNumber}
                    </span>

                    <span class="sentuh-edit-status sentuh-sales-status {$statusClass}">
                        {$status}
                    </span>
                </span>
            </span>
        HTML);
    }

    public function getTitle(): string | Htmlable
    {
        return 'Edit Pesanan';
    }

    public function getBreadcrumb(): string
    {
        return 'Edit';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola informasi pelanggan, rincian produk, dan biaya pesanan.';
    }

    public function getPageClasses(): array
    {
        return [
            ...parent::getPageClasses(),
            'sentuh-sales-edit-page',
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Simpan Perubahan'),

            $this->getCancelFormAction()
                ->label('Batal'),
        ];
    }

    protected function getHeaderActions(): array
{
    return [
        Action::make('recordPayment')
            ->label('Catat Pembayaran')
            ->icon('heroicon-o-banknotes')
            ->color('success')
            ->visible(function (): bool {
                $total = (int) $this->record->subtotal;

                $paid = (int) $this->record
                    ->payments()
                    ->sum('amount');

                return $this->record->status
                    !== SalesOrder::STATUS_CANCELLED
                    && $total > $paid;
            })
            ->modalHeading('Catat Pembayaran')
            ->modalDescription(function (): string {
                $total = (int) $this->record->subtotal;

                $paid = (int) $this->record
                    ->payments()
                    ->sum('amount');

                $remaining = max(0, $total - $paid);

                return 'Sisa tagihan: Rp' .
                    number_format($remaining, 0, ',', '.');
            })
            ->modalSubmitActionLabel('Simpan Pembayaran')
            ->schema([
                Select::make('cash_account_id')
                    ->label('Rekening Penerima')
                    ->options(
                        fn (): array => CashAccount::query()
                            ->where('is_active', true)
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->all()
                    )
                    ->searchable()
                    ->native(false)
                    ->required(),

                TextInput::make('amount')
                    ->label('Nominal Pembayaran')
                    ->prefix('Rp')
                    ->integer()
                    ->minValue(1)
                    ->maxValue(999999999999)
                    ->required()
                    ->helperText(
                        'Masukkan angka tanpa titik. Contoh: 50000.'
                    )
                    ->validationMessages([
                        'required' => 'Nominal wajib diisi.',
                        'integer' => 'Nominal harus angka bulat.',
                        'min' => 'Pembayaran minimal Rp1.',
                        'max' => 'Nominal melebihi batas.',
                    ]),

                TextInput::make('reference')
                    ->label('Referensi Pembayaran')
                    ->placeholder('Opsional')
                    ->maxLength(100),

                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3),
            ])
            ->action(function (array $data): void {
                app(RecordSalesOrderPayment::class)->handle(
                    salesOrderId: $this->record->getKey(),
                    cashAccountId: (int) $data['cash_account_id'],
                    amount: (int) $data['amount'],
                    reference: $data['reference'] ?? null,
                    notes: $data['notes'] ?? null,
                );

                Notification::make()
                    ->title('Pembayaran berhasil dicatat.')
                    ->success()
                    ->send();
            }),

        DeleteAction::make()
            ->label('Hapus')
            ->visible(
                fn (): bool =>
                    ! $this->record->payments()->exists()
            ),
    ];
}
}