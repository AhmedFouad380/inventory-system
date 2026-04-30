<?php

namespace App\Filament\Widgets;

use App\Models\Warehouse;
use App\Models\WorkOrderStock;
use Filament\Widgets\ChartWidget;

class StockDistributionChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'توزيع المخزون حسب المستودع';

    public function getHeading(): string
    {
        return __('inventory.stock_distribution');
    }

    protected function getData(): array
    {
        $warehouses = Warehouse::withSum('stocks', 'balance')->get();

        return [
            'datasets' => [
                [
                    'label' => __('inventory.stock'),
                    'data' => $warehouses->pluck('stocks_sum_balance')->map(fn ($val) => $val ?? 0)->toArray(),
                    'backgroundColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                    ],
                ],
            ],
            'labels' => $warehouses->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
