<?php

namespace Jdkweb\FilamentFileManager\Facade;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static void register(MediaManagerType|array $type)
 * @method static array getTypes()
 */
class FilamentFileManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-file-manager';
    }
}
