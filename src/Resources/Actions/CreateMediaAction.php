<?php

namespace Jdkweb\FilamentFileManager\Resources\Actions;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Livewire\Component;
use Jdkweb\FilamentFileManager\Models\Folder;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;

class CreateMediaAction
{
    public static function make(int $folder_id): Actions\Action
    {
        return Actions\CreateAction::make('create_media')
            ->label(__('filament-file-manager::messages.media.actions.create.label'))
            ->icon('heroicon-o-plus')
            ->form([
                SpatieMediaLibraryFileUpload::make('file')
                    ->label(__('filament-file-manager::messages.media.actions.create.form.file'))
                    ->maxSize('100000')
                    //->columnSpanFull()
                    ->required()
                    ->conversion('preview')
                    ->reorderable()
                    ->imagePreviewHeight('500')
                    ->preserveFilenames()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ]),
                    //->storeFiles(false),
                    //->disk('media'),
                    //->directory('media'),
                    //->visibility('public'),
                Forms\Components\TextInput::make('title')
                    ->label(__('filament-file-manager::messages.media.actions.create.form.title'))
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->label(__('filament-file-manager::messages.media.actions.create.form.description'))
                    ->columnSpanFull(),
            ])
            ->action(function (array $data, Component $livewire) {
                $upload_file = reset($livewire->mountedActionsData[0]['file']);
                if($livewire->folder &&
                    $upload_file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile){
                    if($livewire->folder->model){
                        $livewire->folder->model->addMedia($livewire->mountedActionsData[0]['file'])
                            ->withCustomProperties([
                                'title' => $data['title'],
                                'description' => $data['description']
                            ])
                            ->toMediaCollection($livewire->folder->model->collection);
                    }
                    else {
                        $livewire->folder->addMedia($upload_file)
                            ->withCustomProperties([
                                'title' => $data['title'],
                                'description' => $data['description']
                            ])
                            ->toMediaCollection($livewire->folder->collection);
                    }

                }

                Notification::make()->title(__('filament-file-manager::messages.media.notifications.create-media'))->send();
            });
    }
}
