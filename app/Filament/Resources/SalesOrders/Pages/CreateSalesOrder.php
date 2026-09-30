<?php

namespace App\Filament\Resources\SalesOrders\Pages;

use App\Filament\Resources\SalesOrders\SalesOrderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class CreateSalesOrder extends CreateRecord
{
    protected static string $resource = SalesOrderResource::class;

    public function getHeading(): string | Htmlable
    {
        return new HtmlString(<<<'HTML'
            <span class="sentuh-edit-heading">
                <span class="sentuh-edit-eyebrow">
                    MANAJEMEN PENJUALAN / DATA BARU
                </span>

                <span class="sentuh-edit-heading-main">
                    <span class="sentuh-edit-title">
                        Tambah Pesanan
                    </span>
                </span>
            </span>
        HTML);
    }

    public function getTitle(): string | Htmlable
    {
        return 'Tambah Pesanan';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah';
    }

    public function getSubheading(): ?string
    {
        return 'Catat pesanan pelanggan, produk yang dibeli, dan estimasi biaya produksi.';
    }

    public function getPageClasses(): array
    {
        return [
            ...parent::getPageClasses(),
            'sentuh-sales-create-page',
        ];
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan Pesanan');
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Simpan & Tambah Lagi');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }
}