<?php

namespace App\Filament\Resources\CashExpenses\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CashExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->searchPlaceholder('Cari pengeluaran...')
            ->columns([
                TextColumn::make('expense_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('cashAccount.name')
                    ->label('Rekening')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Keterangan')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('amount')
                    ->label('Nominal')
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
            ])
            ->defaultSort('expense_date', 'desc')
            ->recordClasses('sentuh-business-row')
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary'),
            ]);
    }
}