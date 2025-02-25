<?php

namespace Jdkweb\FilamentFileManager\Resources\FolderResource\Pages;

use Jdkweb\FilamentFileManager\Resources\FolderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFolder extends EditRecord
{
    protected static string $resource = FolderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
