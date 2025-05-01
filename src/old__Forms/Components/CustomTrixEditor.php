<?php

namespace Jdkweb\FilamentFileManager\Forms\Components;

use Filament\Forms\Components\RichEditor;
use Closure;

class CustomTrixEditor extends RichEditor
{
    protected string $view = 'filament-file-manager::components.editor.custom-trix-editor';

    protected array|Closure $toolbarButtons = [
        'attachFiles',
        'blockquote',
        'bold',
        'bulletList',
        'codeBlock',
        'h2',
        'h3',
        'italic',
        'link',
        'orderedList',
        'strike',
        'undo',
        'redo',
        'filemanager'
    ];

    public $options = [];
}
