<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use App\Filament\Resources\QuestionResource\Widgets\StatsOverview;
use App\Models\Question;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListQuestions extends ListRecords
{
    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

		protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

		public function getTabs(): array
		{
			return [
				'Semua Pertanyaan' => Tab::make(),
				'Minggu Ini' => Tab::make()
				->modifyQueryUsing(fn(Builder $query) => $query->where('created_at', '>=', now()->subWeek()))
				->badge(Question::query()->where('created_at', '>=', now()->subWeek())->count()),
				'Bulan Ini' => Tab::make()
				->modifyQueryUsing(fn(Builder $query) => $query->where('created_at', '>=', now()->subMonth()))
				->badge(Question::query()->where('created_at', '>=', now()->subMonth())->count()),
				'Tahun Ini' => Tab::make()
				->modifyQueryUsing(fn(Builder $query) => $query->where('created_at', '>=', now()->subYear()))
				->badge(Question::query()->where('created_at', '>=', now()->subYear())->count()),
			];
		}
}
