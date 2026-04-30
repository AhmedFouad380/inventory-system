<?php

namespace App\Filament\Widgets;

use App\Models\MaterialDisposalRequest;
use App\Models\MaterialReturnRequest;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class DisposalReturnChart extends ChartWidget
{
    protected static ?int $sort = 4;
    protected ?string $heading = 'الإتلاف مقابل المرتجعات';

    public function getHeading(): string
    {
        return __('inventory.disposal_vs_returns');
    }

    protected function getData(): array
    {
        $months = [];
        $disposals = [];
        $returns = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->translatedFormat('M Y');

            $disposals[] = MaterialDisposalRequest::where('status', 'approved')
                ->whereMonth('mdr_date', $month->month)
                ->whereYear('mdr_date', $month->year)
                ->count();

            $returns[] = MaterialReturnRequest::where('status', 'approved')
                ->whereMonth('mrr_date', $month->month)
                ->whereYear('mrr_date', $month->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => __('inventory.mdr'),
                    'data' => $disposals,
                    'backgroundColor' => '#FF6384',
                ],
                [
                    'label' => __('inventory.mrr'),
                    'data' => $returns,
                    'backgroundColor' => '#FFCE56',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
