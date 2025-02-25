<?php

return [
    "model" => [
        "folder" => \Jdkweb\FilamentFileManager\Models\Folder::class,
        "media" => \Jdkweb\FilamentFileManager\Models\Media::class,
    ],

    "api" => [
        "active" => true,
        "middlewares" => [
            "api",
            "auth:sanctum"
        ],
        "prefix" => "api/media-manager",
        "resources" => [
            "folders" => \Jdkweb\FilamentFileManager\Http\Resources\FoldersResource::class,
            "folder" => \Jdkweb\FilamentFileManager\Http\Resources\FolderResource::class,
            "media" => \Jdkweb\FilamentFileManager\Http\Resources\MediaResource::class
        ]
    ],

    "user" => [
      'column_name' => 'name', // Change the value if your field in users table is different from "name"
    ],
];
