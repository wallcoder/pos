<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Order;
class ProductOverview extends BaseWidget
{

    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Products', Product::query()->count()),
            Stat::make('Stocks', Stock::query()->count()),
            Stat::make('Total Earnings', Order::query()->sum('final_amount')),
        ];
    }
}
