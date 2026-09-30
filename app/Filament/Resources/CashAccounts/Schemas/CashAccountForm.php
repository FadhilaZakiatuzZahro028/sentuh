<?php

namespace App\Filament\Resources\CashAccounts\Schemas;

use App\Models\CashAccount;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashAccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Rekening')
                    ->description(
                        'Kelola rekening untuk penerimaan dan pengeluaran SENTUH.'
                    )
                    ->icon('heroicon-o-banknotes')
                    ->extraAttributes([
                        'class' => 'sentuh-business-form-section',
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Rekening')
                            ->placeholder('Contoh: Kas Tunai SENTUH')
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true),

                        Select::make('type')
                            ->label('Jenis Rekening')
                            ->options([
                                CashAccount::TYPE_CASH => 'Kas Tunai',
                                CashAccount::TYPE_BANK => 'Rekening Bank',
                                CashAccount::TYPE_E_WALLET => 'Dompet Digital',
                            ])
                            ->default(CashAccount::TYPE_CASH)
                            ->required()
                            ->native(false),

                        TextInput::make('opening_balance')
                            ->label('Saldo Awal')
                            ->prefix('Rp')
                            ->integer()
                            ->minValue(0)
                            ->maxValue(999999999999)
                            ->default(0)
                            ->required(
                                fn (?CashAccount $record): bool =>
                                    $record === null
                            )
                            ->formatStateUsing(
                                fn ($state): ?string =>
                                    blank($state)
                                        ? null
                                        : (string) (int) $state
                            )
                            ->disabled(
                                fn (?CashAccount $record): bool =>
                                    $record !== null
                            )
                            ->dehydrated(
                                fn (?CashAccount $record): bool =>
                                    $record === null
                            )
                            ->helperText(
                                'Saldo awal hanya ditentukan ketika rekening dibuat. Masukkan angka tanpa titik.'
                            )
                            ->validationMessages([
                                'required' => 'Saldo awal wajib diisi.',
                                'integer' => 'Masukkan angka bulat tanpa titik.',
                                'min' => 'Saldo awal tidak boleh negatif.',
                                'max' => 'Saldo awal melebihi batas.',
                            ]),

                        Toggle::make('is_active')
                            ->label('Rekening Aktif')
                            ->default(true)
                            ->helperText(
                                'Rekening nonaktif nantinya tidak dapat digunakan untuk mencatat pembayaran baru.'
                            )
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
