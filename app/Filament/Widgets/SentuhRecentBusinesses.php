<?php

namespace App\Filament\Widgets;

use App\Models\Business;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\ImageColumn;

class SentuhRecentBusinesses extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Bisnis Terbaru')
            ->description('Bisnis dan organisasi yang baru didaftarkan')
            ->query(
                Business::query()
                    ->latest()
                    ->limit(5)
            )
            ->recordClasses('sentuh-business-row')
            ->columns([
                ImageColumn::make('logo_path')
    ->label('Logo')
    ->disk('public')
    ->visibility('public')
    ->imageSize(42)
    ->square()
    ->alt(fn (Business $record): string => 'Logo ' . $record->name)
    ->defaultImageUrl(asset('images/business-placeholder.svg')),

                TextColumn::make('name')
                    ->label('Nama Bisnis')
                    ->weight('bold'),

                TextColumn::make('category')
                    ->label('Kategori'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            'published' => 'Terbit',
                            'draft' => 'Draft',
                            default => 'Tidak diketahui',
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            'published' => 'success',
                            'draft' => 'gray',
                            default => 'warning',
                        }
                    ),

                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->date('d M Y'),
            ])
            ->paginated(false);
    }
}
