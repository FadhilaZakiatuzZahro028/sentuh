<?php

namespace App\Filament\Resources\SalesOrders\Pages;

use App\Filament\Resources\SalesOrders\SalesOrderResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListSalesOrders extends ListRecords
{
    protected static string $resource = SalesOrderResource::class;

    public function getHeader(): ?View
    {
        return view('filament.sales-orders.list-header', [
            'createUrl' => SalesOrderResource::getUrl('create'),
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