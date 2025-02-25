<?php

namespace Jdkweb\FilamentFileManager\Resources\MediaResource\Actions;

use Illuminate\Support\Str;
use TomatoPHP\FilamentIcons\Components\IconPicker;
use Jdkweb\FilamentFileManager\Models\Folder;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;

class CreateSubFolderAction
{
    public static function make(int $folder_id): Actions\Action
    {
        return Actions\Action::make('create_sub_folder')
            ->hidden(fn()=> filament('filament-file-manager')->allowSubFolders)
            ->mountUsing(function () use ($folder_id){
                session()->put('folder_id', $folder_id);
            })
            ->color('info')
            ->hiddenLabel()
            ->tooltip(__('filament-file-manager::messages.media.actions.sub_folder.label'))
            ->label(__('filament-file-manager::messages.media.actions.sub_folder.label'))
            ->icon('heroicon-o-folder-minus')
            ->extraAttributes(['style' => 'padding: 12px 22px; font-size: 14px;'])
            ->form([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament-file-manager::messages.folders.columns.name'))
                    ->columnSpanFull()
                    ->lazy()
                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                        $set('collection', Str::slug($get('name')));
                    })
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('collection')
                    ->label(__('filament-file-manager::messages.folders.columns.collection'))
                    ->columnSpanFull()
                    ->unique(Folder::class)
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label(__('filament-file-manager::messages.folders.columns.description'))
                    ->columnSpanFull()
                    ->maxLength(255),
                IconPicker::make('icon')
                    ->label(__('filament-file-manager::messages.folders.columns.icon')),
                Forms\Components\ColorPicker::make('color')
                    ->label(__('filament-file-manager::messages.folders.columns.color')),
                Forms\Components\Toggle::make('is_protected')
                    ->label(__('filament-file-manager::messages.folders.columns.is_protected'))
                    ->live()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('password')
                    ->label(__('filament-file-manager::messages.folders.columns.password'))
                    ->hidden(fn(Forms\Get $get) => !$get('is_protected'))
                    ->password()
                    ->revealable()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password_confirmation')
                    ->label(__('filament-file-manager::messages.folders.columns.password_confirmation'))
                    ->hidden(fn(Forms\Get $get) => !$get('is_protected'))
                    ->password()
                    ->required()
                    ->revealable()
                    ->maxLength(255)
            ])
            ->action(function (array $data) use ($folder_id) {
                $folder = Folder::find($folder_id);
                if($folder){
                    $data['user_id'] = auth()->user()->id;
                    $data['user_type'] = get_class(auth()->user());
                    $data['model_id'] = $folder_id;
                    $data['model_type'] = Folder::class;
                    Folder::query()->create($data);
                }

                Notification::make()
                    ->title('Folder Created')
                    ->body('Folder Created Successfully')
                    ->success()
                    ->send();
            });
    }
}
