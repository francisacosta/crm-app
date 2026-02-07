<?php

namespace App\Filament\Resources\DealResource\Widgets;

use App\Enums\DealStatus;
use App\Models\Deal;
use Elemind\FilamentECharts\Widgets\EChartWidget;
use Illuminate\Support\Facades\DB;

class DealStatusChart extends EChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'dealStatusChart';

    /**
     * Icon
     */
    protected static ?string $icon = 'heroicon-o-chart-pie';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Deals by Status';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://echarts.apache.org/en/option.html
     */
    protected function getOptions(): array
    {
        $statusColors = [
            DealStatus::Prospecting->value => '#9CA3AF',
            DealStatus::Qualification->value => '#60A5FA',
            DealStatus::Negotiation->value => '#FBBF24',
            DealStatus::Won->value => '#10B981',
            DealStatus::Lost->value => '#EF4444',
        ];

        $rows = Deal::query()
            ->select('status', DB::raw('COUNT(*) as value'))
            ->groupBy('status')
            ->orderBy('status')
            ->get()
            ->map(fn ($r) => [
                'value' => $r->value,
                'name' => ucfirst(str_replace('_', ' ', $r->status)),
                'itemStyle' => [
                    'color' => $statusColors[$r->status] ?? '#999999',
                ],
            ])
            ->all();

        return [
            'grid' => [
                'top' => '0',
                'left' => '0',
                'bottom' => '0',
                'right' => '0',
            ],
            'title' => [
                'text' => 'Deals by Status',
                'left' => 'center',
            ],
            'tooltip' => [
                'trigger' => 'item',
                'formatter' => '{a} <br/>{b}: {c} ({d}%)',
            ],
            'legend' => [
                'orient' => 'vertical',
                'left' => 'left',
            ],
            'series' => [
                [
                    'name' => 'Deals',
                    'type' => 'pie',
                    'radius' => '50%',
                    'data' => $rows,
                    'emphasis' => [
                        'itemStyle' => [
                            'shadowBlur' => 10,
                            'shadowOffsetX' => 0,
                            'shadowColor' => 'rgba(0, 0, 0, 0.5)',
                        ],
                    ],
                ],
            ],
        ];
    }
}
