<?php

namespace App\Filament\Pages;

use App\Services\FinancialReportService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class FinancialReport extends Page
{
    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedChartBarSquare;

    protected static ?string $navigationLabel = 'Laporan';

    protected static ?string $title = 'Laporan Keuangan';

    protected static ?int $navigationSort = 50;

    protected string $view = 'filament.pages.financial-report';

    public string $period = 'all';

    public array $summary = [];

    public function mount(
        FinancialReportService $financialReportService
    ): void {
        $this->summary = $financialReportService->summary(
            $this->period
        );
    }

    public function updatedPeriod(string $value): void
    {
        if (! in_array(
            $value,
            ['all', 'month', '30_days'],
            true
        )) {
            $this->period = 'all';
        }

        $this->refreshSummary();
    }

    public function getPeriodOptions(): array
    {
        return [
            'all' => 'Semua Waktu',
            'month' => 'Bulan Ini',
            '30_days' => '30 Hari Terakhir',
        ];
    }

    private function refreshSummary(): void
    {
        $this->summary = app(
            FinancialReportService::class
        )->summary($this->period);
    }
}