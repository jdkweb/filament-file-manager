<?php

return [
    'empty' => [
        'title' => "No Media or Folders Found",
    ],
    'folders' => [
        'title' => 'Media Manager',
        'single' => 'Folder',
        'columns' => [
            'name' => 'Name',
            'collection' => 'Collection',
            'description' => 'Description',
            'is_public' => 'Is Public',
            'has_user_access' => 'Has User Access',
            'users' => 'Users',
            'icon' => 'Icon',
            'color' => 'Color',
            'is_protected' => 'Is Protected',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ],
        'group' => 'Content',
    ],
    'media' => [
        'title' => 'Media',
        'single' => 'Media',
        'columns' => [
            'image' => 'Naam',
            'model' => 'Model',
            'description' => 'Omschrijving',
            'collection_name' => 'Collection Name',
            'size' => 'Bestandsgrootte',
            'order_column' => 'Upload volgorde',
        ],
        'actions' => [
            'sub_folder'=> [
              'label' => "Create Sub Folder"
            ],
            'create' => [
                'label' => 'Add Media',
                'form' => [
                    'file' => 'File',
                    'title' => 'Title',
                    'description' => 'Description',
                ],
            ],
            'delete' => [
                'label' => 'Delete Folder',
            ],
            'edit' => [
                'label' => 'Edit Folder',
            ],
        ],
        'notifications' => [
            'create-media' => 'Media created successfully',
            'delete-folder' => 'Folder deleted successfully',
            'edit-folder' => 'Folder edited successfully',
        ],
        'meta' => [
            'model' => 'Model',
            'file-name' => 'File Name',
            'type' => 'Type',
            'size' => 'Size',
            'disk' => 'Disk',
            'url' => 'URL',
            'delete-media' => 'Delete Media',
        ],
    ],
];
