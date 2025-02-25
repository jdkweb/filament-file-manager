<?php

namespace Jdkweb\FilamentFileManager\Traits;

use Jdkweb\FilamentFileManager\Models\Folder;

trait InteractsWithMediaFolders
{
    public function folders()
    {
        return $this->morphToMany(config('filament-file-manager.model.folder'), 'model', 'folder_has_models', 'model_id', 'folder_id');
    }

    public function myFolders()
    {
        return $this->morphMany(config('filament-file-manager.model.folder'), 'user');
    }
}
