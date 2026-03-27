<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Models\Question;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationLabel = 'Questions & QR Items';

    protected static string|\UnitEnum|null $navigationGroup = 'Game Content';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Item details')
                ->schema([
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Select::make('type')
                        ->options([
                            'question' => 'Question',
                            'loot' => 'Loot',
                            'flag' => 'Flag',
                            'bomb' => 'Bomb',
                            'assignment' => 'Assignment',
                        ])
                        ->required()
                        ->native(false)
                        ->live(),
                    Textarea::make('text')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),
            Section::make('Answer options')
                ->schema([
                    TextInput::make('answer_a')
                        ->label('Answer A')
                        ->maxLength(255),
                    TextInput::make('answer_b')
                        ->label('Answer B')
                        ->maxLength(255),
                    TextInput::make('answer_c')
                        ->label('Answer C')
                        ->maxLength(255),
                    Select::make('correct_answer')
                        ->options([
                            'a' => 'A',
                            'b' => 'B',
                            'c' => 'C',
                        ])
                        ->native(false),
                ])
                ->columns(2)
                ->visible(fn (Get $get) => $get('type') === 'question'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'info' => 'question',
                        'success' => 'loot',
                        'warning' => 'assignment',
                        'danger' => 'bomb',
                        'gray' => 'flag',
                    ]),
                Tables\Columns\TextColumn::make('text')
                    ->limit(60)
                    ->searchable(),
                Tables\Columns\TextColumn::make('correct_answer')
                    ->label('Correct')
                    ->formatStateUsing(fn (?string $state) => $state ? strtoupper($state) : '-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'question' => 'Question',
                        'loot' => 'Loot',
                        'flag' => 'Flag',
                        'bomb' => 'Bomb',
                        'assignment' => 'Assignment',
                    ]),
            ])
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}