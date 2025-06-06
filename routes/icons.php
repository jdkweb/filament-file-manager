<?php

use Illuminate\Support\Facades\Route;

Route::get('/filament_file_manager/images/{filename}', function ($filename) {

    $path =  dirname(__DIR__) . '/assets/icons/' . $filename;

    if (!file_exists($path)) {
        abort(404);
    }

    $file = file_get_contents($path);
    $type = mime_content_type($path);

    return Response::make($file, 200)->header('Content-Type', $type);
});
