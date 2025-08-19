<?php

namespace App\Filament\Resources\QuestionCategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionRelationManager extends RelationManager
{
    protected static string $relationship = 'question';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pesan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('pesan')
            ->columns([
							TextColumn::make('city.name')
							->label('Kab/Kota'),
							TextColumn::make('question_category.name')
							->label('Kategori'),
							TextColumn::make('nip')
									->label('NIP')
									->searchable(),
							TextColumn::make('name')
									->label('Nama Lengkap')
									->searchable(),
							TextColumn::make('wa')
									->label('Nomor WA')
									->searchable(),
							TextColumn::make('pesan')
									->label('Pertanyaan')
									->searchable()
									->html()
									->wrap()
									->limit(30),
							// BadgeColumn::make('answer.status')
							// ->colors([
							// 		'secondary' => static fn ($state): bool => $state === '0',
							// 		'warning' => static fn ($state): bool => $state === 'reviewing',
							// 		'success' => static fn ($state): bool => $state === '1',
							// 		'danger' => static fn ($state): bool => $state === 'rejected',
							// ]),
							TextColumn::make('created_at')
									->dateTime()
									->sortable()
									->toggleable(isToggledHiddenByDefault: true),
							TextColumn::make('updated_at')
									->dateTime()
									->sortable()
									->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
