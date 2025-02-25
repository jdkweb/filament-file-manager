<?php

namespace Jdkweb\FilamentFileManager\Resources\MediaResource\Actions;

use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Jdkweb\FilamentFileManager\Models\Media;

class CreateViewAction
{
    public static function make(): ViewAction
    {
        return ViewAction::make()
            ->modalHeading(function (Media $record) {
                return new HtmlString('<span class="font-normal">' .__('filament-file-manager::messages.media.actions.create.form.filename') . ': </span>' . $record->file_name);
            })
            ->color('gray')
            ->size(ActionSize::ExtraLarge)
            ->modal()
            ->modalFooterActions([
                Action::make('close')
                    ->label(__('filament-file-manager::messages.media.actions.view.buttons.close'))
                    ->color('gray')
                    ->close()
//                Action::make('open')
//                    ->label(__('filament-file-manager::messages.media.actions.view.buttons.open'))
//                    ->color('info')
//                    ->requiresConfirmation()
//                    ->action(function ($record) {
//                        $record->name = "test";
//                        $record->save();
//                    }),
//                    //->slideOver()
//                    //->modalContent(fn (Action $action) => "AAAHAHAHAHAHHAA"),
//                Action::make('edit')
//                    ->label(__('filament-file-manager::messages.media.actions.view.buttons.edit'))
//                    ->color('warning')
//                    ->modalActions([
//                        CreateEditAction::make()
//                    ]),
//                Action::make('copy')
//                    ->label(__('filament-file-manager::messages.media.actions.view.buttons.copy'))
//                    ->color('gray')
//                    ->close(),
            ])
//            ->infolist([
//                ImageEntry::make('file_name')
//                    ->label(false)
//                    ->width('100%')
//                    ->extraAttributes(['style' => 'width: 500px; height: auto']),
//                TextEntry::make('title')
//                    ->inlineLabel(trans('filament-file-manager::messages.media.actions.create.form.title'))
//                    ->state(fn(Media $record) => (isset($record->custom_properties['title']) ? $record->custom_properties['title'] : '-'))
//                    ->columnSpanFull(),
//                TextEntry::make('description')
//                    ->inlineLabel(trans('filament-file-manager::messages.media.actions.create.form.description'))
//                    ->state(fn(Media $record) => (isset($record->custom_properties['description']) ? $record->custom_properties['description'] : '-'))
//                    ->columnSpanFull(),
//            ])
            ->form(function (Media $record) {
                return Media::getForm($record, true);
            })
            ->fillForm(function (Media $record, Component $livewire) {
                return [
                    'file' => $record->id."/".$record->file_name,
                    'title' => (isset($record->custom_properties['title']) ? $record->custom_properties['title'] : ''),
                    'description' => (isset($record->custom_properties['description']) ? $record->custom_properties['description'] : ''),
                ];
            });
//            ->action(function (array $data, Component $livewire) {
//                dd($data);
//            });
    }
}
