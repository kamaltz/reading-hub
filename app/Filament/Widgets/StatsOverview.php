<?php

namespace App\Filament\Widgets;

use App\Models\Chapter;
use App\Models\ReadingMaterial;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Siswa', User::where('role', 'student')->count())
                ->description('Jumlah siswa terdaftar')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Materi', ReadingMaterial::count())
                ->description('Jumlah materi bacaan')
                ->color('info'),
            Stat::make('Total Chapter', Chapter::count())
                ->description('Jumlah chapter tersedia')
                ->color('warning'),
        ];
    }
}