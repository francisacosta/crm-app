<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TaskStatusStats extends BaseWidget
{
    protected static ?string $icon = 'heroicon-o-check-circle';

    protected ?string $heading = 'Task Status Overview';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $stats = [];
        $statusConfig = [
            'open' => ['icon' => 'heroicon-m-exclamation-circle', 'color' => 'warning'],
            'in_progress' => ['icon' => 'heroicon-m-arrow-path', 'color' => 'info'],
            'completed' => ['icon' => 'heroicon-m-check', 'color' => 'success'],
            'cancelled' => ['icon' => 'heroicon-m-no-symbol', 'color' => 'danger'],
        ];

        foreach ($statusConfig as $status => $config) {
            $count = Task::where('status', $status)->count();
            $label = str_replace('_', ' ', ucfirst($status));
            $stats[] = Stat::make('Tasks', $count)
                ->description($label)
                ->descriptionIcon($config['icon'], IconPosition::Before)
                ->color($config['color']);
        }

        return $stats;
    }
}
