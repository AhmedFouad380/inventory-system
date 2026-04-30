<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use App\Models\WorkOrderStock;
use App\Models\MaterialReceiptNote;
use App\Models\GatePass;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(__('inventory.items'), Item::count())
                ->description('Total items in system')
                ->descriptionIcon('heroicon-m-cube')
                ->color('success'),
            Stat::make(__('inventory.mrn'), MaterialReceiptNote::where('status', 'approved')->count())
                ->description('Approved receipt notes')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('primary'),
            Stat::make(__('inventory.gate_pass'), GatePass::where('status', 'approved')->count())
                ->description('Approved gate passes')
                ->descriptionIcon('heroicon-m-truck')
                ->color('warning'),
        ];
    }
}
