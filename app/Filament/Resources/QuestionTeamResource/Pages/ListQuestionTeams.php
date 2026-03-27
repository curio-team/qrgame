<?php

namespace App\Filament\Resources\QuestionTeamResource\Pages;

use App\Filament\Resources\QuestionTeamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQuestionTeams extends ListRecords
{
    protected static string $resource = QuestionTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}