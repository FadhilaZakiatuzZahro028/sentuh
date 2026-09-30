<?php

namespace App\Filament\Resources\Businesses\Tables;

use App\Models\Business;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BusinessesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->header(view('filament.businesses.table-header'))
            ->searchPlaceholder('Cari nama, kategori, atau slug...')
            ->columns([
                ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->disk('public')
                    ->visibility('public')
                    ->imageSize(48)
                    ->square()
                    ->defaultImageUrl(
                        asset('images/business-placeholder.svg')
                    )
                    ->alt(
                        fn (Business $record): string =>
                            'Logo ' . $record->name
                    ),

                TextColumn::make('name')
                    ->label('Nama Bisnis')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            Business::STATUS_DRAFT => 'Draft',
                            Business::STATUS_PUBLISHED => 'Terbit',
                            default => $state,
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            Business::STATUS_DRAFT => 'gray',
                            Business::STATUS_PUBLISHED => 'success',
                            default => 'warning',
                        }
                    ),

                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordClasses('sentuh-business-row')
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->button()
                    ->outlined(),
            ]);
    }
}