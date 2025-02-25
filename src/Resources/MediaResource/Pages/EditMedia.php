<?php

namespace Jdkweb\FilamentFileManager\Resources\MediaResource\Pages;

use App\Filament\Helpers\FormButtons;
use Filament\Forms\Form;
use Jdkweb\FilamentFileManager\Resources\MediaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedia extends EditRecord
{
    use FormButtons;

    protected static string $resource = MediaResource::class;



//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\DeleteAction::make(),
//        ];
//    }
}
