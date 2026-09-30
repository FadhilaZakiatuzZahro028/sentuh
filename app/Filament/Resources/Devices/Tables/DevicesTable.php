<?php

namespace App\Filament\Resources\Devices\Tables;

use App\Models\Device;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Support\DeviceQrCode;
use Filament\Actions\Action;
use Illuminate\Contracts\View\View;

class DevicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
    ->header(view('filament.devices.table-header'))
    ->searchPlaceholder('Cari perangkat atau nama bisnis...')
    ->columns([
                TextColumn::make('label')
                    ->label('Nama Perangkat')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('business.name')
                    ->label('Bisnis / Organisasi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Device::STATUS_ACTIVE => 'Aktif',
                        Device::STATUS_INACTIVE => 'Nonaktif',
                        default => 'Tidak diketahui',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        Device::STATUS_ACTIVE => 'success',
                        Device::STATUS_INACTIVE => 'gray',
                        default => 'warning',
                    }),

                TextColumn::make('public_code')
                    ->label('Kode Publik')
                    ->limit(18)
                    ->tooltip(fn (string $state): string => $state)
                    ->copyable()
                    ->copyMessage('Kode berhasil disalin'),
            ])
            ->defaultSort('created_at', 'desc')
->recordClasses('sentuh-business-row')
            ->recordActions([
    EditAction::make()
    ->label('Edit')
    ->icon('heroicon-o-pencil-square')
    ->button()
    ->outlined(),
    Action::make('showQr')
        ->label('Lihat QR')
        ->icon('heroicon-o-qr-code')
        ->color('primary')
        ->modalHeading(
            fn (Device $record): string =>
                'QR Code — ' . $record->label
        )

        ->registerModalActions([
    Action::make('downloadQr')
        ->label('Unduh QR Code (SVG)')
        ->color('primary')
        ->action(function (Device $record) {
            $generator = app(DeviceQrCode::class);

            return response()->streamDownload(
                function () use ($generator, $record): void {
                    echo $generator->svg($record);
                },
                'sentuh-qr-' . $record->public_code . '.svg',
                [
                    'Content-Type' => 'image/svg+xml',
                ]
            );
        }),
])
        ->modalContent(
    fn (Action $action, Device $record): View => view(
        'filament.devices.qr-preview',
        [
            'action' => $action,
            'qrImage' => app(DeviceQrCode::class)
                ->image($record),
            'deviceUrl' => app(DeviceQrCode::class)
                ->url($record),
        ]
    )
)
        ->modalSubmitAction(false)
        ->modalCancelActionLabel('Tutup'),
]);
    }
}
