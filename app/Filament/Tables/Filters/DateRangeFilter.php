<?php

namespace App\Filament\Tables\Filters;

use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class DateRangeFilter
{
    public static function make(string $column = 'created_at', string $label = 'التاريخ'): Filter
    {
        return Filter::make($column . '_range')
            ->label($label)
            ->form([
                DatePicker::make('from')->label('من تاريخ'),
                DatePicker::make('to')->label('إلى تاريخ'),
            ])
            ->query(function (Builder $query, array $data) use ($column): Builder {
                return $query
                    ->when(
                        $data['from'],
                        fn (Builder $query, $date): Builder => $query->whereDate($column, '>=', $date),
                    )
                    ->when(
                        $data['to'],
                        fn (Builder $query, $date): Builder => $query->whereDate($column, '<=', $date),
                    );
            })
            ->indicateUsing(function (array $data) use ($label): array {
                $indicators = [];
                if ($data['from'] ?? null) {
                    $indicators[] = "{$label} من: " . Carbon::parse($data['from'])->format('Y-m-d');
                }
                if ($data['to'] ?? null) {
                    $indicators[] = "{$label} إلى: " . Carbon::parse($data['to'])->format('Y-m-d');
                }
                return $indicators;
            });
    }
}
