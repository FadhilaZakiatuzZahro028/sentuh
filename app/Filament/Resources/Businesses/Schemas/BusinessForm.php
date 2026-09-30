<?php

namespace App\Filament\Resources\Businesses\Schemas;

use App\Models\Business;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;

class BusinessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Bisnis')
                ->icon('heroicon-o-building-storefront')
    ->iconColor('primary')
    ->extraAttributes([
        'class' => 'sentuh-business-form-section',
    ])
                ->description('Informasi dasar bisnis atau organisasi.')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                        TextInput::make('name')
                            ->label('Nama Bisnis / Organisasi')
                            ->required()
                            ->maxLength(150),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->placeholder('contoh: kopi-senja')
                            ->helperText('Gunakan huruf kecil, angka, dan tanda hubung.')
                            ->required()
                            ->maxLength(160)
                            ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                            ->unique(),

                        TextInput::make('category')
                            ->label('Kategori')
                            ->placeholder('Contoh: Kafe, Sekolah, Klinik')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('tagline')
                            ->label('Tagline')
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                            ]),
                Section::make('Tampilan Bisnis')
                ->icon('heroicon-o-photo')
    ->iconColor('primary')
    ->extraAttributes([
        'class' => 'sentuh-business-form-section',
    ])
                    ->description('Logo dan foto untuk halaman digital bisnis.')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logo Bisnis')
                            ->image()
                            ->imagePreviewHeight('180')
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->maxSize(2048)
                            ->disk('public')
                            ->directory('businesses/logos')
                            ->visibility('public')
                            ->preventFilePathTampering(),

                        FileUpload::make('cover_path')
                            ->label('Foto Sampul')
                            ->image()
                            ->imagePreviewHeight('180')
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->maxSize(2048)
                            ->disk('public')
                            ->directory('businesses/covers')
                            ->visibility('public')
                            ->preventFilePathTampering(),
                    ])
                    ->columnSpanFull(),

                Section::make('Tombol Bisnis')
                ->icon('heroicon-o-cursor-arrow-rays')
    ->iconColor('primary')
    ->extraAttributes([
        'class' => 'sentuh-business-form-section',
    ])
                    ->description('Kelola tombol yang akan tampil di halaman digital bisnis.')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('links')
                            ->label('Daftar Tombol')
                            ->relationship()
                            ->schema([
                                TextInput::make('label')
                                    ->label('Nama Tombol')
                                    ->placeholder('Contoh: Lihat Menu')
                                    ->required()
                                    ->maxLength(100),

                                Select::make('type')
                                    ->label('Jenis Tombol')
                                    ->options([
                                        'whatsapp' => 'WhatsApp',
                                        'maps' => 'Google Maps',
                                        'google_review' => 'Google Review',
                                        'instagram' => 'Instagram',
                                        'website' => 'Website',
                                        'custom' => 'Lainnya / Menu',
                                    ])
                                    ->required(),

                                TextInput::make('url')
                                    ->label('URL Tujuan')
                                    ->placeholder('https://contoh.com')
                                    ->helperText('Gunakan alamat HTTP atau HTTPS.')
                                    ->required()
                                    ->url()
                                    ->rule('regex:/^https?:\/\//i')
                                    ->maxLength(2048),

                                Toggle::make('is_active')
                                    ->label('Tombol Aktif')
                                    ->default(true),
                            ])
                            ->columns(2)
                            ->orderColumn('sort_order')
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Tombol')
                            ->collapsible()
                            ->columnSpanFull(),
                    ]),

                Section::make('Publikasi')
                ->icon('heroicon-o-globe-alt')
    ->iconColor('primary')
    ->extraAttributes([
        'class' => 'sentuh-business-form-section',
    ])
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                Business::STATUS_DRAFT => 'Draft',
                                Business::STATUS_PUBLISHED => 'Published',
                            ])
                            ->default(Business::STATUS_DRAFT)
                            ->required(),
                    ]),
            ]);
    }
}
