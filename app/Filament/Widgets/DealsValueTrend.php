<?php

namespace App\Filament\Widgets;

use App\Models\Deal;
use Elemind\FilamentECharts\Widgets\EChartWidget;
use Illuminate\Support\Facades\DB;

class DealsValueTrend extends EChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'dealsValueTrend';

    /**
     * Icon
     */
    protected static ?string $icon = 'heroicon-o-chart-line';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Deals Value Trend';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://echarts.apache.org/en/option.html
     */
    protected function getOptions(): array
    {
        $rows = Deal::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COALESCE(SUM(value), 0) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($r) {
                return [
                    'date' => $r->date,
                    'total' => (float) $r->total,
                ];
            });

        $dates = $rows->pluck('date')->all();
        $totals = $rows->pluck('total')->all();

        return [
            'tooltip' => [
                'trigger' => 'axis',
            ],
            'xAxis' => [
                'type' => 'category',
                'data' => $dates,
                'boundaryGap' => false,
            ],
            'yAxis' => [
                'type' => 'value',
                'axisLabel' => [
                    'formatter' => '{value}',
                ],
            ],
            'series' => [
                [
                    'name' => 'Pipeline Value',
                    'type' => 'line',
                    'data' => $totals,
                    'smooth' => true,
                    'areaStyle' => [],
                ],
            ],
        ];
    }
}
