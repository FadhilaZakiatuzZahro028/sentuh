<?php

namespace App\Filament\Widgets;

use App\Models\Business;
use App\Models\Device;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SentuhStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = null;

    protected function getStats(): array
{
    return [
        Stat::make(
            'Total Bisnis',
            Business::query()->count()
        )
            ->description('Seluruh bisnis terdaftar')
            ->icon('heroicon-o-building-storefront')
            ->extraAttributes([
                'class' => 'sentuh-stat sentuh-stat--business',
            ]),

        Stat::make(
            'Halaman Terbit',
            Business::query()
                ->where('status', 'published')
                ->count()
        )
            ->description('Bisnis yang dipublikasikan')
            ->icon('heroicon-o-globe-alt')
            ->extraAttributes([
                'class' => 'sentuh-stat sentuh-stat--published',
            ]),

        Stat::make(
            'Perangkat Aktif',
            Device::query()
                ->where('status', Device::STATUS_ACTIVE)
                ->count()
        )
            ->description('Perangkat berstatus aktif')
            ->icon('heroicon-o-qr-code')
            ->extraAttributes([
                'class' => 'sentuh-stat sentuh-stat--device',
            ]),

        Stat::make('Total Akses', 'Belum tersedia')
            ->description('Menunggu pencatatan QR/NFC')
            ->icon('heroicon-o-chart-bar')
            ->extraAttributes([
                'class' => 'sentuh-stat sentuh-stat--pending',
            ]),
    ];
}
}
