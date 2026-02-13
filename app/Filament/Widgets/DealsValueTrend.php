<?php

namespace App\Filament\Widgets;

use App\Models\Deal;
use Elemind\FilamentECharts\Widgets\EChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
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
        $monthExpression = match (DB::getDriverName()) {
            'sqlite' => "strftime('%Y-%m-01', created_at)",
            'pgsql' => "to_char(created_at, 'YYYY-MM-01')",
            default => "DATE_FORMAT(created_at, '%Y-%m-01')",
        };

        $rows = Deal::query()
            ->selectRaw($monthExpression.' as month')
            ->selectRaw('COALESCE(SUM(value), 0) as total')
            ->groupByRaw($monthExpression)
            ->orderByRaw($monthExpression)
            ->get()
            ->map(function ($r) {
                return [
                    'month' => $r->month,
                    'total' => (float) $r->total,
                ];
            });

        [$labels, $totals] = $this->buildMonthlySeries($rows);

        return [
            'tooltip' => [
                'trigger' => 'axis',
            ],
            'xAxis' => [
                'type' => 'category',
                'data' => $labels,
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

    private function buildMonthlySeries(Collection $rows): array
    {
        if ($rows->isEmpty()) {
            return [[], []];
        }

        $totalsByMonth = $rows
            ->mapWithKeys(function ($row) {
                return [$row['month'] => $row['total']];
            })
            ->all();

        $start = Carbon::createFromFormat('Y-m-d', $rows->first()['month'])->startOfMonth();
        $end = Carbon::createFromFormat('Y-m-d', $rows->last()['month'])->startOfMonth();

        $labels = [];
        $totals = [];
        $cursor = $start->copy();

        while ($cursor->lessThanOrEqualTo($end)) {
            $monthKey = $cursor->format('Y-m-01');
            $labels[] = $cursor->format('M Y');
            $totals[] = (float) ($totalsByMonth[$monthKey] ?? 0);
            $cursor->addMonth();
        }

        return [$labels, $totals];
    }
}
