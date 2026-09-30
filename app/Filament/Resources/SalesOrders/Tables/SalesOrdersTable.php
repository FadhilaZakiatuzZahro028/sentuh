<?php

namespace App\Filament\Resources\SalesOrders\Tables;

use App\Models\SalesOrder;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SalesOrdersTable
{
    public static function configure(Table $table): Table
    {
       return $table
    ->header(view('filament.sales-orders.table-header'))
    ->searchPlaceholder('Cari nomor pesanan atau pelanggan...')
    ->columns([
                TextColumn::make('order_number')
                    ->label('Nomor Pesanan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('order_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('subtotal')
                    ->label('Total Penjualan')
                    ->formatStateUsing(
                        fn ($state): string =>
                            'Rp' . number_format(
                                (float) $state,
                                0,
                                ',',
                                '.'
                            )
                    )
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            SalesOrder::STATUS_DRAFT => 'Draft',
                            SalesOrder::STATUS_CONFIRMED => 'Dikonfirmasi',
                            SalesOrder::STATUS_COMPLETED => 'Selesai',
                            SalesOrder::STATUS_CANCELLED => 'Dibatalkan',
                            default => 'Tidak diketahui',
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            SalesOrder::STATUS_DRAFT => 'gray',
                            SalesOrder::STATUS_CONFIRMED => 'info',
                            SalesOrder::STATUS_COMPLETED => 'success',
                            SalesOrder::STATUS_CANCELLED => 'danger',
                            default => 'warning',
                        }
                    ),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        SalesOrder::STATUS_DRAFT => 'Draft',
                        SalesOrder::STATUS_CONFIRMED => 'Dikonfirmasi',
                        SalesOrder::STATUS_COMPLETED => 'Selesai',
                        SalesOrder::STATUS_CANCELLED => 'Dibatalkan',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
->recordClasses('sentuh-business-row')
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary'),
            ]);
    }
}