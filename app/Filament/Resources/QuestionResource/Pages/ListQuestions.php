<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQuestions extends ListRecords
{
    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('qr-export')
                ->label('QR PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->url(route('admin.questions.qr-export')),
            CreateAction::make(),
        ];
    }
}