<?php

namespace Jdkweb\FilamentFileManager\Models;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\HtmlString;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Jdkweb\FilamentFileManager\Enums\Icons;

class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media  implements HasMedia
{
    use InteractsWithMedia;

    protected static function booted(): void
    {
        static::addGlobalScope('folder', function (Builder $query) {
            $folder = Folder::find(session()->get('folder_id'));
            if($folder){
                if(!$folder->model_type){
                    $query->where('collection_name', $folder->collection);
                }
                else {
                    $query->where('model_type', $folder->model_type)
                        ->where('model_id', $folder->model_id)
                        ->where('collection_name', $folder->collection);
                }
            }
        });
    }

    public function getIcon(): ?Icons
    {
        return Icons::getFileType($this->mime_type);
    }

    public function getExtension(): ?string
    {
        // get name
        $arr = preg_split("/\./",$this->file_name);
        return array_pop($arr);
    }


    /**
     * Media upload form
     *
     * @return array
     */
    public static function getForm(?Media $record = null, bool $view = false): array
    {
        $view = (is_null($record) ? true : $view);

        return [
            Grid::make('')
                ->hidden($view)
                ->schema([
                    Toggle::make('change_filename')
                        ->label(__('filament-file-manager::messages.media.actions.create.form.change_filename'))
                        ->reactive()
                        ->afterStateUpdated(function ($set, $state, $record) {
                            if($state) {
                                $set('change_filename', true);
                                $set('name', $record->name);
                                $set('extension', $record->getExtension());
                            }
                            else {
                                $set('change_filename', false);
                            }
                        })
                        ->onIcon('heroicon-m-pencil-square')
                        ->offIcon('heroicon-m-lock-closed')
                        ->columnSpan(1),
                    Hidden::make('extension')
                        ->required(fn ($get, $record): bool => $get('change_filename')),
                    TextInput::make('name')
                        ->inlineLabel(__('filament-file-manager::messages.media.actions.create.form.filename'))
                        ->suffix(function($record) {
                            if(!is_null($record)) {
                                return ".".$record->getExtension();
                            }
                        })
                        ->hidden(
                            fn ($get, $record): bool => $get('change_filename') == false && $record !== null
                        )
                        ->required(fn ($get, $record): bool => $get('change_filename')),
                ]),
            self::getFileUploadImage(is_null($record))
                ->label(false)
//                ->label(function() use ($view) {
//                    return ($view ? '' : __('filament-file-manager::messages.media.actions.create.form.file'));
//                })
                ->maxSize('10240')
                ->columnSpanFull()
//                ->helperText(function () use ($view) {
//                    return ($view ? '' : implode(", ",Icons::extensions()));
//                })
                //->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp']) // @TODO Icons::
                ->required()
                ->downloadable()
                //->conversion('preview')
                ->reorderable()
                ->imagePreviewHeight('500')
                ->preserveFilenames()
                ->imageEditor(!$view)
                ->imageEditorAspectRatios([
                    null,
                    '16:9',
                    '4:3',
                    '1:1',
                ])
                ->disk('media')
                ->directory((is_null($record) ? '' : $record->id)),
            TextInput::make('title')
                ->inlineLabel(__('filament-file-manager::messages.media.actions.create.form.title'))
                ->columnSpanFull(),
            TextInput::make('description')
                ->inlineLabel(__('filament-file-manager::messages.media.actions.create.form.description'))
                ->columnSpanFull(),
        ];
    }

    protected static function getFileUploadImage(bool $edit)
    {
        if($edit) {
            return SpatieMediaLibraryFileUpload::make('file');
        }
        else {
            return FileUpload::make('file');
        }
    }

    public function folder(): HasOne
    {
        return $this->hasOne(Folder::class, 'id', 'model_id');
    }

    public function file()
    {

    }

    public function getImageUrl()
    {

    }
}
