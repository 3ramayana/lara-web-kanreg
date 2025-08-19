<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Filament\Resources\QuestionResource\RelationManagers\AnswerRelationManager;
use App\Models\Question;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter as FiltersFilter;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Builder;


class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Manajemen Helpdesk';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $pluralModelLabel = 'Daftar Pertanyaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('city_id')
                        ->label('Kab/Kota Domisili')
                        ->relationship(name: 'city', titleAttribute: 'name')
                        ->required(),
                    Select::make('question_category_id')
                        ->label('Kategori Pertanyaan')
                        ->relationship(name: 'question_category', titleAttribute: 'name')
                        ->required(),
                    Select::make('ministry_id')
                    ->label('Instansi Yang Dilamar')
                    ->relationship(name: 'ministry', titleAttribute: 'name')
                    ->required(),
                    // TextInput::make('nip')
                    //     ->label('NIP')
                    //     ->placeholder('NIP')
                    //     ->required()
                    //     ->numeric(),
                    // Select::make('instansi')
                    //     ->label('Instansi Yang Dilamar')
                    //     ->options([
                    //         'KEMENKUMHAM' => 'KEMENKUMHAM',
                    //         'KEMENKEU' => 'KEMENKEU'
                    //     ]),
                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->placeholder('Nama Lengkap')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('wa')
                        ->label('Nomor WA')
                        ->placeholder('Nomor WA')
                        ->required()
                        ->maxLength(255),
                    RichEditor::make('pesan')
                        ->required(),
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'Belum Dijawab' => 'Belum Dijawab',
                            'Sudah Dijawab' => 'Sudah Dijawab'
                        ])
                ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('city.name')
                    ->label('Kab/Kota'),
                TextColumn::make('question_category.name')
                    ->label('Kategori'),
                // TextColumn::make('nip')
                //     ->label('NIP')
                //     ->searchable(),
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
                    ->limit(40),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Belum Dijawab' => 'warning',
                        'Sudah Dijawab' => 'success',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->defaultGroup('created_at', Question::whereMonth('created_at', date('m'))
            // ->whereDate('created_at', date('d')))
            ->filters([
                SelectFilter::make('question_category_id')
                    ->relationship(name: 'question_category', titleAttribute: 'name')
                    ->label('Kategori Pertanyaan'),
                // SelectFilter::make('status')
                // ->relationship(name: 'answer', titleAttribute: 'status')
                // ->label('Status Pertanyaan'),
                SelectFilter::make('city_id')
                    ->relationship(name: 'city', titleAttribute: 'name')
                    ->label('Kab/Kota'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Tanggal Awal'),
                        DatePicker::make('created_until')
                            ->label('Tanggal Akhir'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                // Tables\Actions\Action::make('status')
                // ->visible(fn (Schedule $record): bool => in_array($record->status->value, ScheduleStatusEnum::incomplete()))
                // ->icon('heroicon-m-pencil-square')
                // ->form([
                //     Select::make('status')
                //         ->label('Status')
                //         ->options([
                //             'Belum Dijawab' => 'Belum Dijawab',
                //             'Sudah Dijawab' => 'Sudah Dijawab'
                //         ])
                // ])
                // ->action(fn (Schedule $record, array $data)=> $record->update(['status' => $data['status'], 'status' => ScheduleStatusEnum::complete])),
                Tables\Actions\EditAction::make()
                ->label('Jawab'),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AnswerRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            QuestionResource\Widgets\StatsOverview::class,
        ];
    }
}
