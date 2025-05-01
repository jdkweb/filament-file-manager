<?php

namespace Jdkweb\FilamentFileManager;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Jdkweb\FilamentFileManager\Console\FilamentMediaManagerPublishIcons;
use Jdkweb\FilamentFileManager\Livewire\TrixMediaEditResource;
use Jdkweb\FilamentFileManager\Livewire\MediaSelectorResource;
use Livewire\Livewire;
use Jdkweb\FilamentFileManager\Livewire\ModalResource;
use Jdkweb\FilamentFileManager\Livewire\MediaResource;
use Jdkweb\FilamentFileManager\Services\FilamentFileManagerServices;
use function PHPUnit\Framework\fileExists;


class FilamentFileManagerServiceProvider extends ServiceProvider
{
    const __DEVELOPMENT__ = false;

    /**
     * Register the service provider.
     * Binding Rdw class into Laravel service container.
     *
     * @return void
     */
    final public function register():void
    {

    }

    /**
     *
     * @return void
     */
    public function boot(): void
    {
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


        if($this->app->environment('local') && self::__DEVELOPMENT__) {
            FilamentAsset::register([
                Css::make('filament-file-manager', dirname(__DIR__ ) . '/resources/css/app.css'),
                Js::make('filament-file-manager', dirname(__DIR__ ) . '/resources/js/app.js')
            ]);
        }
        else {
            FilamentAsset::register([
                Css::make('filament-file-manager', dirname(__DIR__ ) . '/resources/dist/filament-file-manager.css')
            ], 'jdkweb/filament-file-manager');
        }
    }
}
