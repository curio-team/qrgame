<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionTeamResource\Pages;
use App\Models\Question;
use App\Models\QuestionTeam;
use App\Models\Team;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuestionTeamResource extends Resource
{
    protected static ?string $model = QuestionTeam::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationLabel = 'Team Attempts';

    protected static string|\UnitEnum|null $navigationGroup = 'Game Content';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Attempt')
                ->schema([
                    Select::make('team_id')
                        ->label('Team')
                        ->options(fn () => Team::query()->orderBy('name')->pluck('name', 'id')->all())
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('question_id')
                        ->label('Question / item')
                        ->options(fn () => Question::query()->orderBy('slug')->get()->mapWithKeys(fn (Question $question) => [$question->id => sprintf('%s [%s]', $question->slug, $question->type)])->all())
                        ->searchable()
                        ->preload(),
                    DateTimePicker::make('started_at')
                        ->seconds(false),
                    DateTimePicker::make('finished_at')
                        ->seconds(false),
                    TextInput::make('points')
                        ->numeric()
                        ->required()
                        ->default(0),
                    TextInput::make('answer_given')
                        ->maxLength(255),
                    KeyValue::make('scans')
                        ->keyLabel('Index')
                        ->valueLabel('IP / Scan value')
                        ->columnSpanFull()
                        ->reorderable(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['team.game', 'question']))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('team.name')
                    ->label('Team')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('team.game.name')
                    ->label('Game')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('question.slug')
                    ->label('Slug')
                    ->placeholder('Manual score')
                    ->searchable(),
                Tables\Columns\TextColumn::make('question.type')
                    ->label('Type')
                    ->badge()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('points')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('answer_given')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('started_at')
                    ->dateTime('d-m-Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('finished_at')
                    ->dateTime('d-m-Y H:i')
                    ->placeholder('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('scans')
                    ->label('Scans')
                    ->formatStateUsing(fn ($state) => is_array($state) ? (string) count($state) : '0')
                    ->sortable(false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('team_id')
                    ->label('Team')
                    ->options(fn () => Team::query()->orderBy('name')->pluck('name', 'id')->all()),
                Tables\Filters\SelectFilter::make('question.type')
                    ->relationship('question', 'type'),
            ])
            ->defaultSort('started_at', 'desc')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestionTeams::route('/'),
            'create' => Pages\CreateQuestionTeam::route('/create'),
            'edit' => Pages\EditQuestionTeam::route('/{record}/edit'),
        ];
    }
}