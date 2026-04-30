<?php

namespace App\Filament\Widgets;

use App\Models\MaterialReceiptNote;
use App\Models\GatePass;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockMovementChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $heading = 'حركة المخزون (آخر 6 أشهر)';
    protected string $color = 'info';

    public function getHeading(): string
    {
        return __('inventory.stock_movement');
    }

    protected function getData(): array
    {
        $months = [];
        $receipts = [];
        $issues = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->translatedFormat('M Y');

            $receipts[] = MaterialReceiptNote::where('status', 'approved')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            $issues[] = GatePass::where('status', 'approved')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => __('inventory.mrn'),
                    'data' => $receipts,
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => '#36A2EB',
                ],
                [
                    'label' => __('inventory.gate_pass'),
                    'data' => $issues,
                    'borderColor' => '#FF6384',
                    'backgroundColor' => '#FF6384',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
