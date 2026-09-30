<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Models\Device;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class EditDevice extends EditRecord
{
    protected static string $resource = DeviceResource::class;

    public function getHeading(): string | Htmlable
{
    $isActive = $this->record->status === Device::STATUS_ACTIVE;

    $statusLabel = $isActive ? 'Aktif' : 'Nonaktif';
    $statusClass = $isActive ? 'is-active' : 'is-inactive';

    $deviceName = e($this->record->label);

    return new HtmlString(<<<HTML
        <span class="sentuh-edit-heading">
            <span class="sentuh-edit-eyebrow">
                MANAJEMEN PERANGKAT / EDIT DATA
            </span>

            <span class="sentuh-edit-heading-main">
                <span class="sentuh-edit-title">
                    {$deviceName}
                </span>

                <span class="sentuh-edit-status {$statusClass}">
                    {$statusLabel}
                </span>
            </span>
        </span>
    HTML);
}

public function getSubheading(): ?string
{
    return 'Kelola perangkat yang terhubung dengan halaman bisnis.';
}

public function getPageClasses(): array
{
    return [
        ...parent::getPageClasses(),
        'sentuh-device-edit-page',
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
            DeleteAction::make()
    ->label('Hapus'),
        ];
    }
}
