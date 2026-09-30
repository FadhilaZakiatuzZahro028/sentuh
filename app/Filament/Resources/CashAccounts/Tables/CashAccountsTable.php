<?php

namespace App\Filament\Resources\CashAccounts\Tables;

use App\Models\CashAccount;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CashAccountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
    ->header(view('filament.cash-accounts.table-header'))
    ->searchPlaceholder('Cari nama rekening...')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Rekening')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            CashAccount::TYPE_CASH => 'Kas Tunai',
                            CashAccount::TYPE_BANK => 'Bank',
                            CashAccount::TYPE_E_WALLET => 'Dompet Digital',
                            default => 'Tidak diketahui',
                        }
                    )
                    ->color('info'),

                TextColumn::make('opening_balance')
                    ->label('Saldo Awal')
                    ->formatStateUsing(
                        fn ($state): string =>
                            'Rp' . number_format(
                                (float) $state,
                                0,
                                ',',
                                '.'
                            )
                    )
                    ->sortable(),

                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn ($state): string =>
                            $state ? 'Aktif' : 'Nonaktif'
                    )
                    ->color(
                        fn ($state): string =>
                            $state ? 'success' : 'gray'
                    ),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Jenis Rekening')
                    ->options([
                        CashAccount::TYPE_CASH => 'Kas Tunai',
                        CashAccount::TYPE_BANK => 'Bank',
                        CashAccount::TYPE_E_WALLET => 'Dompet Digital',
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
