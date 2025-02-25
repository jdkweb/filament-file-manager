<?php

namespace Jdkweb\FilamentFileManager\Resources\MediaResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;
use Jdkweb\FilamentFileManager\Resources\MediaResource;

class ViewMedia extends ViewRecord
{
    protected static string $resource = MediaResource::class;
}
