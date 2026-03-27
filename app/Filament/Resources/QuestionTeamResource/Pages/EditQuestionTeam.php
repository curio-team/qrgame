<?php

namespace App\Filament\Resources\QuestionTeamResource\Pages;

use App\Filament\Resources\QuestionTeamResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQuestionTeam extends EditRecord
{
    protected static string $resource = QuestionTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}