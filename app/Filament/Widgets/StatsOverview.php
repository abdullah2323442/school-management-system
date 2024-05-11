<?php

namespace App\Filament\Widgets;

use App\Models\Classes;
use App\Models\Section;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Classes', Classes::count()),
            Stat::make('Total sections', Section::count()),
            Stat::make('Total Students', User::where('role', User::ROLE_STUDENT)->count()),
            Stat::make('Total Teachers', User::where('role', User::ROLE_TEACHER)->count()),
            
        ];
    }
}
