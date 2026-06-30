<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class PostsChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Grafik Publikasi Berita (6 Bulan Terakhir)';

    protected function getData(): array
    {
        $posts = \App\Models\Post::where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->get()
            ->groupBy(function ($post) {
                return $post->created_at->format('M Y');
            });

        $counts = [];
        $labels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('M Y');
            $labels[] = $month;
            $counts[] = isset($posts[$month]) ? $posts[$month]->count() : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Berita',
                    'data' => $counts,
                    'fill' => 'start',
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
