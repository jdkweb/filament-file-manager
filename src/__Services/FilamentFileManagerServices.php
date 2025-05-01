<?php

namespace Jdkweb\FilamentFileManager\Services;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Jdkweb\FilamentFileManager\Services\Contracts\FileManagerType;

class FilamentFileManagerServices
{
    protected array $types = [];

    public function register(FileManagerType|array $type)
    {
        if (is_array($type)) {
            foreach ($type as $t) {
                $this->register($t);
            }
        } else {
            if($type->js){
                foreach ($type->js as $key=>$jsItem){
                    FilamentAsset::register([
                        Js::make($type->exstantion.'_js_'.$key, $jsItem),
                    ]);
                }
            }
            if($type->css){
                foreach ($type->css as $key=>$cssItem){
                    FilamentAsset::register([
                        Css::make($type->exstantion.'_css_'.$key, $cssItem),
                    ]);
                }
            }

            $this->types[] = $type;
        }
    }

    public function getTypes()
    {
        return $this->types;
    }
}
