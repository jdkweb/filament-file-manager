<?php

namespace Jdkweb\FilamentFileManager\Resources\MediaResource\Actions;

use Filament\Notifications\Notification;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Jdkweb\FilamentFileManager\Models\Media;

class CreateEditAction
{
    public static function make(): EditAction
    {
        return EditAction::make()
            ->modalHeading(function (Media $record) {
                return new HtmlString('<span class="font-normal">' .__('filament-file-manager::messages.media.actions.create.form.filename') . ': </span>' . $record->file_name);
            })
            ->icon('heroicon-m-pencil-square')
            ->extraAttributes(['style' => 'margin-left: -30px; padding-right: 5px;'])
            ->size(ActionSize::ExtraLarge)
            ->modal()
            ->form(function (Media $record) {
                return Media::getForm($record);
            })
            ->fillForm(function (Media $record, Component $livewire) {
                return [
                    'file' => $record->id."/".$record->file_name,
                    'title' => (isset($record->custom_properties['title']) ? $record->custom_properties['title'] : ''),
                    'description' => (isset($record->custom_properties['description']) ? $record->custom_properties['description'] : ''),
                ];
            })
            ->action(function (array $data, Media $record) {

                $record->setCustomProperty('title', $data['title']);
                $record->setCustomProperty('description', $data['description']);

                // Change filename
                $originalFileName = $record->file_name;
                if ($data['change_filename']) {
                    // new filename
                    $data['name'] = strtolower(str_replace(['#', '/', '\\', ' '], '-', $data['name']));
                    $record->file_name = $data['name'].".".$data['extension'];
                    $record->name = $data['name'];
                }

                // Path to file
                $path = Storage::disk(config('media-library.disk_name'))->getConfig()['root']."/";
                // Current file
                $file = $path.$record->id."/".$originalFileName;
                $renamed_file = $path.$record->id."/".$record->file_name;
                // Edit file
                $new_file = $path.$data['file'];

                if (file_exists($new_file) && file_exists($file) && $new_file != $file) {
                    unlink($file);
                    rename($new_file, $renamed_file);
                    $record->size = filesize($renamed_file);
                } elseif ($data['change_filename']) {
                    rename($file, $renamed_file);
                }

                $record->save();

                // COPY
                //                              $record->addMedia($new_file)
                //                                    ->withCustomProperties([
                //                                        'title' => $data['title'],
                //                                        'description' => $data['description']
                //                                    ])
                //                                    ->toMediaCollection($record->folder()->first()->collection);


                Notification::make()->title(__('filament-file-manager::messages.media.notifications.create-media'))->send();
            });
    }
}
