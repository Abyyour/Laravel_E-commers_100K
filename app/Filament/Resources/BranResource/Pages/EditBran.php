<?php

namespace App\Filament\Resources\BranResource\Pages;

use App\Filament\Resources\BranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBran extends EditRecord
{
    protected static string $resource = BranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
