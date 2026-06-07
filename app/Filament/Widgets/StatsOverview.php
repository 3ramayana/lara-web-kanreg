<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Berita', \App\Models\Post::count())
                ->description('Seluruh berita dipublikasi & draft')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary'),
            Stat::make('Pengumuman Aktif', \App\Models\Announcement::where('is_active', 1)->count())
                ->description('Pengumuman yang sedang tayang')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('success'),
            Stat::make('Pertanyaan & Konsultasi', \App\Models\Question::count())
                ->description('Total tiket masuk')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('warning'),
            Stat::make('Total Layanan', \App\Models\Service::count())
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('info'),
            Stat::make('Dokumen Publik', \App\Models\Document::where('is_public', 1)->count())
                ->descriptionIcon('heroicon-m-document-text')
                ->color('gray'),
            Stat::make('Pengunjung Hari Ini', \App\Models\Visitor::whereDate('date', \Carbon\Carbon::today())->count())
                ->description('Total IP unik hari ini')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Total Pengunjung', \App\Models\Visitor::count())
                ->description('Keseluruhan pengunjung unik')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('primary'),
        ];
    }
}
