<?php

namespace App\Filament\Widgets;

use App\Enums\DealStatus;
use App\Models\Deal;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DealCountByStatus extends BaseWidget
{
    protected static ?string $icon = 'heroicon-o-briefcase';

    protected ?string $heading = '';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $stats = [];
        $statusConfig = [
            DealStatus::Prospecting->value => ['icon' => 'heroicon-m-magnifying-glass', 'color' => 'gray'],
            DealStatus::Qualification->value => ['icon' => 'heroicon-m-chart-bar', 'color' => 'blue'],
            DealStatus::Negotiation->value => ['icon' => 'heroicon-m-chat-bubble-left', 'color' => 'yellow'],
            DealStatus::Won->value => ['icon' => 'heroicon-m-check-circle', 'color' => 'success'],
            DealStatus::Lost->value => ['icon' => 'heroicon-m-x-circle', 'color' => 'danger'],
        ];

        foreach (DealStatus::cases() as $case) {
            $count = Deal::where('status', $case->value)->count();
            $label = ucfirst(str_replace('_', ' ', $case->value));
            $config = $statusConfig[$case->value];
            $stats[] = Stat::make('Deals', $count)
                ->description($label)
                ->descriptionIcon($config['icon'], IconPosition::Before)
                ->color($config['color']);
        }

        return $stats;
    }
}
