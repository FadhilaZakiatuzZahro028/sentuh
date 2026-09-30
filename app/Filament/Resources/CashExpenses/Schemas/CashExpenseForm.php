<?php

namespace App\Filament\Resources\CashExpenses\Schemas;

use App\Models\CashAccount;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengeluaran')
                    ->description(
                        'Catat uang keluar dari rekening SENTUH.'
                    )
                    ->icon('heroicon-o-arrow-up-on-square')
                    ->extraAttributes([
                        'class' => 'sentuh-business-form-section',
                    ])
                    ->schema([
                        Select::make('cash_account_id')
                            ->label('Rekening Kas')
                            ->options(
                                fn (): array => CashAccount::query()
                                    ->where('is_active', true)
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->all()
                            )
                            ->searchable()
                            ->native(false)
                            ->placeholder('Pilih rekening')
                            ->required(),

                        DatePicker::make('expense_date')
                            ->label('Tanggal Pengeluaran')
                            ->default(today())
                            ->required(),

                        TextInput::make('category')
                            ->label('Kategori')
                            ->placeholder('Contoh: Bahan Produksi')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('description')
                            ->label('Keterangan')
                            ->placeholder('Contoh: Pembelian acrylic')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('amount')
                            ->label('Nominal Pengeluaran')
                            ->prefix('Rp')
                            ->integer()
                            ->minValue(1)
                            ->maxValue(999999999999)
                            ->required()
                            ->helperText(
                                'Masukkan angka tanpa titik. Contoh: 50000.'
                            )
                            ->validationMessages([
                                'required' => 'Nominal pengeluaran wajib diisi.',
                                'integer' => 'Masukkan angka bulat tanpa titik.',
                                'min' => 'Nominal pengeluaran minimal Rp1.',
                                'max' => 'Nominal pengeluaran melebihi batas.',
                            ]),

                        TextInput::make('reference')
                            ->label('Referensi')
                            ->placeholder('Opsional, misalnya nomor nota')
                            ->maxLength(100),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}