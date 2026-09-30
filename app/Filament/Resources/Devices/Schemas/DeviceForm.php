<?php

namespace App\Filament\Resources\Devices\Schemas;

use App\Models\Device;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
{
    return $schema
        ->components([
            Section::make('Pengaturan Perangkat')
                ->description(
                    'Atur identitas, hubungan bisnis, dan status perangkat.'
                )
                ->icon('heroicon-o-qr-code')
                ->iconColor('primary')
                ->extraAttributes([
                    'class' => 'sentuh-business-form-section',
                ])
                ->schema([
                    Select::make('business_id')
    ->label('Bisnis / Organisasi')
    ->placeholder('Pilih bisnis atau organisasi')
    ->relationship(
        name: 'business',
        titleAttribute: 'name'
    )
    ->searchable()
    ->preload()
    ->required(),

                    TextInput::make('label')
                        ->label('Nama Perangkat')
                        ->placeholder('Contoh: Acrylic Meja Kasir')
                        ->required()
                        ->maxLength(100),

                    Select::make('status')
                        ->label('Status Perangkat')
                        ->options([
                            Device::STATUS_INACTIVE => 'Nonaktif',
                            Device::STATUS_ACTIVE => 'Aktif',
                        ])
                        ->default(Device::STATUS_INACTIVE)
                        ->required()
                        ->native(false),
                ])
                ->columns(2)
                ->columnSpanFull(),
        ]);
}
}
