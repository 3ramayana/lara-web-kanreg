<?php

namespace App\Filament\Resources\QuestionResource\Widgets;

use App\Models\Answer;
use App\Models\Question;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
					Stat::make('Total Pertanyaan', Question::all()->count()),
					Stat::make('Pertanyaan Sudah Dijawab', Question::where('status', 'Sudah Dijawab')->count())
					->color('success'),
					Stat::make('Pertanyaan Belum Dijawab', Question::where('status', 'Belum Dijawab')->count()),
        ];
    }
}


