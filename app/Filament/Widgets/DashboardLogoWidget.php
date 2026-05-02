<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardLogoWidget extends Widget
{
    protected static ?int $sort = -10;

    protected string $view = 'filament.widgets.dashboard-logo-widget';

    protected int | string | array $columnSpan = 'full';
}
