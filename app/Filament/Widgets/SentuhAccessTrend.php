<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class SentuhAccessTrend extends Widget
{
    protected string $view =
    'filament.widgets.sentuh-access-trend';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
    'md' => 'full',
    'xl' => 2,
];
}