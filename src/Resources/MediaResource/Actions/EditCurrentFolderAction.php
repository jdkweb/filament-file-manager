<?php

namespace Jdkweb\FilamentFileManager\Resources\MediaResource\Actions;

use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use TomatoPHP\FilamentIcons\Components\IconPicker;

class EditCurrentFolderAction
{
    public static function make(int $folder_id): Actions\Action
    {
        $form = config('filament-file-manager.model.folder')::query()->where('id',$folder_id)->with('users')->first()?->toArray();
        $form['users'] = collect($form['users'])->pluck('id')->toArray();

        return Actions\Action::make('edit_current_folder')
            ->hiddenLabel()
            ->mountUsing(function () use ($folder_id){
                session()->put('folder_id', $folder_id);
            })
            ->tooltip(trans('filament-file-manager::messages.media.actions.edit.label'))
            ->label(trans('filament-file-manager::messages.media.actions.edit.label'))
            ->icon('heroicon-o-pencil-square')
            ->extraAttributes(['style' => 'padding: 12px 22px; font-size: 14px;'])
            ->color('warning')
            ->form(function (){
                return [
                    Grid::make([
                        "sm" => 1,
                        "md" => 2
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(trans('filament-file-manager::messages.folders.columns.name'))
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label(trans('filament-file-manager::messages.folders.columns.description'))
                            ->columnSpanFull()
                            ->maxLength(255),
                        IconPicker::make('icon')
                            ->label(trans('filament-file-manager::messages.folders.columns.icon')),
                        Forms\Components\ColorPicker::make('color')
                            ->label(trans('filament-file-manager::messages.folders.columns.color')),
                        Forms\Components\Toggle::make('is_protected')
                            ->label(trans('filament-file-manager::messages.folders.columns.is_protected'))
                            ->live()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('password')
                            ->label(trans('filament-file-manager::messages.folders.columns.password'))
                            ->hidden(fn(Forms\Get $get) => !$get('is_protected'))
                            ->confirmed()
                            ->password()
                            ->revealable()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(trans('filament-file-manager::messages.folders.columns.password_confirmation'))
                            ->hidden(fn(Forms\Get $get) => !$get('is_protected'))
                            ->password()
                            ->required()
                            ->revealable()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_public')
                            ->visible(filament('filament-file-manager')->allowUserAccess)
                            ->label(trans('filament-file-manager::messages.folders.columns.is_public'))
                            ->live()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('has_user_access')
                            ->visible(filament('filament-file-manager')->allowUserAccess)
                            ->hidden(fn(Forms\Get $get) => $get('is_public'))
                            ->label(trans('filament-file-manager::messages.folders.columns.has_user_access'))
                            ->live()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('users')
                            ->required()
                            ->visible(filament('filament-file-manager')->allowUserAccess)
                            ->hidden(fn(Forms\Get $get) => !$get('has_user_access'))
                            ->label(trans('filament-file-manager::messages.folders.columns.users'))
                            ->searchable()
                            ->multiple()
                            ->options(User::query()->where('id', '!=', auth()->user()->id)->pluck(config('filament-file-manager.user.column_name'), 'id')->toArray())
                    ])
                ];
            })
            ->fillForm($form)
            ->action(function (array $data) use ($folder_id){
                $folder = config('filament-file-manager.model.folder')::find($folder_id);
                $folder->update($data);

                if(isset($data['users'])){
                    $folder->users()->sync($data['users']);
                }

                Notification::make()->title(trans('filament-file-manager::messages.media.notifications.edit-folder'))->send();
            });
    }
}
