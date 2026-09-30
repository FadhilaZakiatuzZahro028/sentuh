<?php

namespace App\Filament\Resources\CashAccounts\Pages;

use App\Filament\Resources\CashAccounts\CashAccountResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListCashAccounts extends ListRecords
{
    protected static string $resource = CashAccountResource::class;

    public function getHeader(): ?View
    {
        return view('filament.cash-accounts.list-header', [
            'createUrl' => CashAccountResource::getUrl('create'),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumb(): ?string
    {
        return 'Daftar';
    }
}