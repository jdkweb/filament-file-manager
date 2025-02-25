<?php

namespace Jdkweb\FilamentFileManager;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Nwidart\Modules\Module;
use TomatoPHP\FilamentArtisan\Pages\Artisan;
use Jdkweb\FilamentFileManager\Facade\FilamentFileManager;
use Jdkweb\FilamentFileManager\Pages\FoldersPage;
use Jdkweb\FilamentFileManager\Resources\FolderResource;
use Jdkweb\FilamentFileManager\Resources\MediaResource;
use Jdkweb\FilamentFileManager\Services\Contracts\FileManagerType;


class FilamentFileManagerPlugin implements Plugin
{
    private bool $isActive = false;


    public ?bool $allowSubFolders = true;
    public ?bool $allowUserAccess = false;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-file-manager';
    }

    public function allowSubFolders(bool $condation = true): static
    {
        $this->allowSubFolders = $condation;
        return $this;
    }

    public function allowUserAccess(bool $condation = true): static
    {
        $this->allowUserAccess = $condation;
        return $this;
    }

    public function register(Panel $panel): void
    {
//        if(class_exists(Module::class) && \Nwidart\Modules\Facades\Module::find('FilamentMediaManager')?->isEnabled()){
//            $this->isActive = true;
//        }
//        else {
//            $this->isActive = true;
//        }
//
//        if($this->isActive) {
            $panel->resources([
                FolderResource::class,
                MediaResource::class
            ]);
//        }

    }

    public function boot(Panel $panel): void
    {
//        FilamentMediaManager::register([
//           MediaManagerType::make('.pdf')
//               ->icon('heroicon-o-academic-cap')
//               //->preview('media-manager.pdf')
//       ]);
    }
}
