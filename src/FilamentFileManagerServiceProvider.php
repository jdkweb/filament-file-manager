<?php

namespace Jdkweb\FilamentFileManager;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Jdkweb\FilamentFileManager\Livewire\ModalResource;
use Jdkweb\FilamentFileManager\Livewire\MediaResource;
use Jdkweb\FilamentFileManager\Services\FilamentFileManagerServices;


class FilamentFileManagerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * Binding Rdw class into Laravel service container.
     *
     * @return void
     */
    final public function register():void
    {
        $this->app->singleton(FilamentFileManagerServices::class, function ($app) {
            return new FilamentFileManagerServices();
        });

        // Alias
        $this->app->alias(FilamentFileManagerServices::class, 'filament-file-manager');
    }

    /**
     *
     * @return void
     */
    public function boot(): void
    {
        //Register generate command
//        $this->commands([
//           \Jdkweb\FilamentFileManager\Console\FilamentMediaManagerInstall::class,
//        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-file-manager.php', 'filament-file-manager');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-file-manager.php' => config_path('filament-file-manager.php'),
        ], 'filament-file-manager-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'filament-file-manager-migrations');

        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-file-manager');


        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/filament-file-manager'),
        ], 'filament-file-manager-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-file-manager');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-file-manager'),
        ], 'filament-file-manager-lang');

        // Api routes
        if(config('filament-file-manager.api.active')){
            //Register Routes
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        }

        // Icons for file-types
        $this->loadRoutesFrom(__DIR__.'/../routes/icons.php');

        Livewire::component('filament-file-manager.modal-resource', ModalResource::class);
        Livewire::component('filament-file-manager.folder-resource', ModalResource::class);
        Livewire::component('filament-file-manager.media-resource', MediaResource::class);

        // reloaded by dump-autoload
        FilamentAsset::register([
            Css::make('filament-file-manager-css', dirname(__DIR__ ) . '/resources/css/media.css'),
            // Js::make('custom-trix-editor', dirname(__DIR__ ) . '/resources/js/custom-trix-editor.js'),
        ]);

//        $this->app->bind('filament-file-manager', function () {
//            return new FilamentMediaManagerServices();
//        });
    }


}
