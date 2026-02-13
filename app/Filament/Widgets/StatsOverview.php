<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $icon = 'heroicon-o-chart-bar';

    protected ?string $heading = 'Overview';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        return [
            Stat::make('Total Deals', Deal::count())
                ->description('Deals')
                ->descriptionIcon('heroicon-m-briefcase'),
            Stat::make('Total Tasks', Task::count())
                ->description('Tasks')
                ->descriptionIcon('heroicon-m-inbox-stack'),
            Stat::make('Total Contacts', Contact::count())
                ->description('Contacts')
                ->descriptionIcon('heroicon-m-users'),
            Stat::make('Total Organizations', Company::count())
                ->description('Companies')
                ->descriptionIcon('heroicon-m-building-office'),
        ];
    }
}
