<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Filament\Actions\Action;

class CreateDevice extends CreateRecord
{
    protected static string $resource = DeviceResource::class;

    public function getHeading(): string | Htmlable
{
    return new HtmlString(<<<'HTML'
        <span class="sentuh-edit-heading">
            <span class="sentuh-edit-eyebrow">
                MANAJEMEN PERANGKAT / DATA BARU
            </span>

            <span class="sentuh-edit-heading-main">
                <span class="sentuh-edit-title">
                    Tambah Perangkat
                </span>
            </span>
        </span>
    HTML);
}

public function getSubheading(): ?string
{
    return 'Daftarkan perangkat QR/NFC baru dan hubungkan dengan bisnis atau organisasi.';
}

public function getPageClasses(): array
{
    return [
        ...parent::getPageClasses(),
        'sentuh-device-create-page',
    ];
}

protected function getCreateFormAction(): Action
{
    return parent::getCreateFormAction()
        ->label('Buat Perangkat');
}

protected function getCreateAnotherFormAction(): Action
{
    return parent::getCreateAnotherFormAction()
        ->label('Buat & Tambah Lagi');
}

protected function getCancelFormAction(): Action
{
    return parent::getCancelFormAction()
        ->label('Batal');
}

public function getBreadcrumb(): string
{
    return 'Tambah';
}

public function getTitle(): string | Htmlable
{
    return 'Tambah Perangkat';
}
}
