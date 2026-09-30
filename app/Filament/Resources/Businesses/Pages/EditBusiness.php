<?php

namespace App\Filament\Resources\Businesses\Pages;

use App\Filament\Resources\Businesses\BusinessResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Models\Business;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class EditBusiness extends EditRecord
{
    protected static string $resource = BusinessResource::class;

    public function getHeading(): string | Htmlable
{
    $isPublished = $this->record->status === Business::STATUS_PUBLISHED;

    $statusLabel = $isPublished ? 'Terbit' : 'Draft';
    $statusClass = $isPublished ? 'is-published' : 'is-draft';
    $businessName = e($this->record->name);

    return new HtmlString(<<<HTML
        <span class="sentuh-edit-heading">
            <span class="sentuh-edit-eyebrow">
                MANAJEMEN BISNIS / EDIT DATA
            </span>

            <span class="sentuh-edit-heading-main">
                <span class="sentuh-edit-title">
                    {$businessName}
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
    return 'Kelola identitas dan halaman digital bisnis.';
}

public function getPageClasses(): array
{
    return [
        ...parent::getPageClasses(),
        'sentuh-business-edit-page',
    ];
}

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function (DeleteAction $action): void {
                    $hasLinks = $this->record
                        ->links()
                        ->exists();

                    $hasDevices = $this->record
                        ->devices()
                        ->exists();

                    if ($hasLinks || $hasDevices) {
                        Notification::make()
                            ->warning()
                            ->title('Bisnis tidak dapat dihapus')
                            ->body(
                                'Bisnis masih memiliki tautan atau perangkat. '
                                . 'Hapus seluruh data terkait sebelum menghapus bisnis.'
                            )
                            ->send();

                        $action->cancel();
                    }
                }),
        ];
    }
}
