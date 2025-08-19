<?php

namespace App\Filament\Resources\LetterInResource\Widgets;

use App\Models\LetterIn;
// use Filament\Forms\Components\Card;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalSurat extends BaseWidget
{
    protected function getStats(): array
    {
        return [
					Stat::make('Total Pertanyaan', LetterIn::all()->count()),
        ];
    }

		protected function getCards(): array
		{
			return [
				Card::make('Total Surat', LetterIn::count())
						->description('Surat yang telah diarsipkan')
						->descriptionIcon('heroicon-o-document-text')
						->color('success'),
		];
		}
}
