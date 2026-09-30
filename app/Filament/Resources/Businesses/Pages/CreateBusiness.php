<?php

namespace App\Filament\Resources\Businesses\Pages;

use App\Filament\Resources\Businesses\BusinessResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class CreateBusiness extends CreateRecord
{
    protected static string $resource = BusinessResource::class;

    public function getHeading(): string | Htmlable
    {
        return new HtmlString(<<<'HTML'
            <span class="sentuh-edit-heading">
                <span class="sentuh-edit-eyebrow">
                    MANAJEMEN BISNIS / DATA BARU
                </span>

                <span class="sentuh-edit-heading-main">
                    <span class="sentuh-edit-title">
                        Tambah Bisnis
                    </span>
                </span>
            </span>
        HTML);
    }

    public function getSubheading(): ?string
    {
        return 'Daftarkan bisnis atau organisasi dan kelola halaman digitalnya.';
    }

    public function getPageClasses(): array
    {
        return [
            ...parent::getPageClasses(),
            'sentuh-business-create-page',
        ];
    }
}