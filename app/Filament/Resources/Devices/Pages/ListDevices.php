<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
{
    return view('filament.devices.list-header', [
        'createUrl' => static::getResource()::getUrl('create'),
    ]);
}

public function getBreadcrumb(): ?string
{
    return 'Daftar';
}
}
