<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestQuestions extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Konsultasi / Pertanyaan Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\Question::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengirim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pesan')
                    ->label('Isi Pertanyaan')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'primary' => 'Menunggu',
                        'warning' => 'Diproses',
                        'success' => 'Selesai',
                        'danger' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('Lihat')
                    ->url(fn (\App\Models\Question $record): string => \App\Filament\Resources\QuestionResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-m-eye'),
            ])
            ->paginated(false);
    }
}
