<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class IncomeChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        // Income Sum Data
        $sumData = Trend::model(Order::class)
            ->between(start: now()->subYear(), end: now())
            ->perMonth()
            ->sum('final_amount');

        // Order Count Data
        $countData = Trend::model(Order::class)
            ->between(start: now()->subYear(), end: now())
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Total Income',
                    'data' => $sumData->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'blue',
                    'backgroundColor' => 'rgba(0, 123, 255, 0.5)',
                ],
                [
                    'label' => 'Order Count',
                    'data' => $countData->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'red',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                ],
            ],
            'labels' => $sumData->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
