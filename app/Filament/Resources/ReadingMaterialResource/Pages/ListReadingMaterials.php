<?php

namespace App\Filament\Resources\ReadingMaterialResource\Pages;

use App\Filament\Resources\ReadingMaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReadingMaterials extends ListRecords
{
    protected static string $resource = ReadingMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
