<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use App\Models\Office;
use App\Models\Staff;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Staff', Staff::count()),
            Card::make('Inventory Items', Item::count()),
            Card::make('Offices', Office::count()),
        ];
    }
}
