<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Businesses\BusinessResource;
use Filament\Widgets\Widget;

class SentuhHeroShowcase extends Widget
{
    protected string $view = 'filament.widgets.sentuh-hero-showcase';

    protected static ?int $sort = -10;

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'createBusinessUrl' => BusinessResource::getUrl('create'),
        ];
    }
}