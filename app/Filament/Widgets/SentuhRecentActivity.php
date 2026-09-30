<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class SentuhRecentActivity extends Widget
{
    protected string $view =
        'filament.widgets.sentuh-recent-activity';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = [
    'md' => 'full',
    'xl' => 1,
];
}
