<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class NewStudentsChart extends ChartWidget
{
    protected static ?string $heading = 'Pendaftaran Siswa Baru';

    protected static string $color = 'primary';

    protected function getData(): array
    {
        $data = Trend::model(User::class)
            ->between(
                start: now()->subWeek(),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Siswa baru',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}