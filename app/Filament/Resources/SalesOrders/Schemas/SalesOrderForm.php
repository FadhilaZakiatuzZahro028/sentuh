<?php

namespace App\Filament\Resources\SalesOrders\Schemas;

use App\Models\SalesOrder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SalesOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | INFORMASI PESANAN
                |--------------------------------------------------------------------------
                */

                Section::make('Informasi Pesanan')
                    ->description(
                        'Masukkan identitas pesanan dan pelanggan.'
                    )
                    ->icon('heroicon-o-clipboard-document-list')
                    ->extraAttributes([
                        'class' => 'sentuh-business-form-section',
                    ])
                    ->schema([

                        TextInput::make('order_number')
                            ->label('Nomor Pesanan')
                            ->placeholder('Contoh: SNT-2026-0001')
                            ->helperText(
                                'Untuk sementara, nomor pesanan diisi manual.'
                            )
                            ->required()
                            ->maxLength(30)
                            ->unique(ignoreRecord: true)
                            ->disabled(
    fn (?SalesOrder $record): bool =>
        $record?->payments()->exists() ?? false
),

                        DatePicker::make('order_date')
                            ->label('Tanggal Pesanan')
                            ->default(today())
                            ->required()
                            ->disabled(
    fn (?SalesOrder $record): bool =>
        $record?->payments()->exists() ?? false
),

                        TextInput::make('customer_code')
                            ->label('Kode Pelanggan')
                            ->placeholder('Contoh: PLG-001')
                            ->required()
                            ->maxLength(50),

                        TextInput::make('customer_name')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->maxLength(150),

                        TextInput::make('customer_contact')
                            ->label('Kontak Pelanggan')
                            ->placeholder('Nomor WhatsApp atau email')
                            ->maxLength(100),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | PRODUK PESANAN
                |--------------------------------------------------------------------------
                */

                Section::make('Produk Pesanan')
                    ->description(
                        'Tambahkan produk yang dibeli dalam pesanan ini.'
                    )
                    ->icon('heroicon-o-shopping-bag')
                    ->extraAttributes([
                        'class' => 'sentuh-business-form-section',
                    ])
                    ->schema([

                        Repeater::make('items')
    ->label('Daftar Produk')
    ->disabled(
        fn (?SalesOrder $record): bool =>
            $record?->payments()->exists() ?? false
    )
    ->relationship()
    ->schema([

                                TextInput::make('product_name')
                                    ->label('Nama Produk')
                                    ->placeholder(
                                        'Contoh: Acrylic QR + NFC'
                                    )
                                    ->required()
                                    ->maxLength(150)
                                    ->columnSpanFull(),

                                TextInput::make('quantity')
                                    ->label('Jumlah')
                                    ->integer()
                                    ->minValue(1)
                                    ->default(1)
                                    ->required()
                                    ->live(onBlur: true),

                                TextInput::make('unit_price')
                                    ->label('Harga Satuan')
                                    ->prefix('Rp')
                                    ->integer()
                                    ->minValue(0)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->formatStateUsing(
                                        fn ($state): ?string =>
                                            blank($state)
                                                ? null
                                                : (string) (int) $state
                                    )
                                    ->helperText(
                                        'Contoh: ketik 50000 untuk Rp50.000.'
                                    )
                                    ->validationMessages([
                                        'required' =>
                                            'Harga satuan wajib diisi.',

                                        'integer' =>
                                            'Harga harus berupa angka bulat tanpa titik.',

                                        'min' =>
                                            'Harga tidak boleh negatif.',
                                    ]),

                                /*
                                 * Pratinjau subtotal setiap produk.
                                 *
                                 * Nilai harga dibaca sebagai angka,
                                 * bukan sebagai teks berformat Rupiah.
                                 */

                                Text::make(
                                    function (Get $get): string {
                                        $quantity = max(
                                            0,
                                            (int) $get('quantity')
                                        );

                                        $price = max(
                                            0,
                                            (int) $get('unit_price')
                                        );

                                        $subtotal = $quantity * $price;

                                        return 'Subtotal produk: Rp ' .
                                            number_format(
                                                $subtotal,
                                                0,
                                                ',',
                                                '.'
                                            );
                                    }
                                )
                                    ->color('primary')
                                    ->columnSpanFull(),

                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->minItems(1)
                            ->addActionLabel('Tambah Produk')
                            ->reorderable(false)
                            ->columnSpanFull(),

                        /*
                         * Pratinjau total seluruh produk.
                         *
                         * Nilai resmi tetap dihitung ulang
                         * oleh model SalesOrderItem.
                         */

                        Text::make(
                            function (Get $get): string {
                                $items = $get('items') ?? [];

                                $total = 0;

                                foreach ($items as $item) {
                                    if (! is_array($item)) {
                                        continue;
                                    }

                                    $quantity = max(
                                        0,
                                        (int) ($item['quantity'] ?? 0)
                                    );

                                    $price = max(
                                        0,
                                        (int) ($item['unit_price'] ?? 0)
                                    );

                                    $total += $quantity * $price;
                                }

                                return 'Pratinjau Subtotal Pesanan: Rp ' .
                                    number_format(
                                        $total,
                                        0,
                                        ',',
                                        '.'
                                    );
                            }
                        )
                            ->color('primary'),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | BIAYA DAN STATUS
                |--------------------------------------------------------------------------
                */

                Section::make('Biaya dan Status')
                    ->description(
                        'Catat perkiraan biaya dan kondisi pesanan.'
                    )
                    ->icon('heroicon-o-document-currency-dollar')
                    ->extraAttributes([
                        'class' => 'sentuh-business-form-section',
                    ])
                    ->schema([

                        TextInput::make('estimated_direct_cost')
                            ->label('Estimasi Biaya Langsung')
                            ->prefix('Rp')
                            ->integer()
                            ->minValue(0)
                            ->default(0)
                            ->required()
                            ->formatStateUsing(
                                fn ($state): ?string =>
                                    blank($state)
                                        ? null
                                        : (string) (int) $state
                            )
                            ->helperText(
                                'Contoh: ketik 70000 untuk Rp70.000.'
                            )
                            ->validationMessages([
                                'required' =>
                                    'Estimasi biaya wajib diisi.',

                                'integer' =>
                                    'Masukkan angka bulat tanpa titik.',

                                'min' =>
                                    'Estimasi biaya tidak boleh negatif.',
                            ]),

                        TextInput::make('actual_direct_cost')
                            ->label('Biaya Langsung Aktual')
                            ->prefix('Rp')
                            ->integer()
                            ->minValue(0)
                            ->default(0)
                            ->required()
                            ->formatStateUsing(
                                fn ($state): ?string =>
                                    blank($state)
                                        ? null
                                        : (string) (int) $state
                            )
                            ->helperText(
                                'Biaya produksi yang benar-benar terjadi.'
                            )
                            ->validationMessages([
                                'required' =>
                                    'Biaya aktual wajib diisi.',

                                'integer' =>
                                    'Masukkan angka bulat tanpa titik.',

                                'min' =>
                                    'Biaya aktual tidak boleh negatif.',
                            ]),

                        Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                SalesOrder::STATUS_DRAFT =>
                                    'Draft',

                                SalesOrder::STATUS_CONFIRMED =>
                                    'Dikonfirmasi',

                                SalesOrder::STATUS_COMPLETED =>
                                    'Selesai',

                                SalesOrder::STATUS_CANCELLED =>
                                    'Dibatalkan',
                            ])
                            ->default(SalesOrder::STATUS_DRAFT)
                            ->native(false)
                            ->required(),

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
