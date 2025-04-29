<?php

namespace Jdkweb\FilamentFileManager\Livewire;

use Illuminate\Support\Facades\Storage;
use Jdkweb\FilamentFileManager\Enums\Icons;
use Jdkweb\FilamentFileManager\Models\Folder;
use Jdkweb\FilamentFileManager\Models\Media;
use Livewire\Attributes\On;
use Livewire\Component;

class MediaSelectorResource extends Component
{
    public ?string $modal_content = null;

    public ?int $folder_id = null;

    public ?int $doc_id = null;

    public ?string $type = null;

    public ?string $editor_id;

    public function render()
    {
        return view('filament-file-manager::livewire.media-selector-resource');
    }

    public function mount()
    {;
        // $this->getFolders();
    }

    #[On('open-modal')]
    public function openModal($type)
    {
        $this->type = $type;
        $this->folder_id = null;
        $this->getFolders();
    }

    /**
     * Show files inside selected folder
     * @return void
     */
    #[On('container-resource:triggerFolders')]
    public function triggerFolder(int $folder_id): void
    {
        session()->put('folder_id', $folder_id);
        $records = Media::query()
            ->where('model_id', $folder_id)
            ->where('mime_type', ($this->type=='file' ? 'NOT LIKE' : 'LIKE'), 'image/%')
            ->get();

        $this->modal_content  = "<div class='-mt-6'>";
        $this->modal_content .= view('filament-file-manager::livewire.media-resource', ['records' => $records]);
        $this->modal_content .= "</div>";
    }

    #[On('selectMediaItem')]
    public function selectMediaItem(int $id, $factor)
    {
        // Set ook de Filters op de juiste waarde
        // x-on:setrecord in media-recourse.blade.php
        $file = Media::find($id);
        //$file->blob = $file->blob();
        $file->factor = $factor;
        $file_path = Storage::disk($file->disk)->path($file->id."/".$file->file_name);
        $file->height = '';
        $file->width = '';
        if(file_exists($file_path) && $a = getimagesize($file_path)) {
            $file->height = $a[1];
            $file->width = $a[0];
        }

        $file->editor_id = $this->editor_id;

        // Return data to toobar.js there is an eventlistener waiting on this dispatch
        $this->dispatch('from_php_dispatched_insertimage', $file);
    }

    /**
     * Livewire aangeroepen vauit filecard.blade.php
     *
     * Dispatched in code-editor event listener in toolbar.js
     *
     * @param  int  $id
     * @param  string  $type
     * @return void
     */
    #[On('selectMediaFile')]
    public function selectMediaFile(int $id, string $type): void
    {
        // Set ook de Filters op de juiste waarde
        // x-on:setrecord in media-recourse.blade.php
        $file = Media::find($id);
        //$file->blob = $file->blob();
        $file->linktype = $type;
        if($type == 'icon') {
            $file->typeicon = Icons::getFileType($file->mime_type)->getIconPath();
        }
        $file_path = Storage::disk($file->disk)->path($file->id."/".$file->file_name);

        $file->editor_id = $this->editor_id;

        $this->dispatch('from_php_dispatched_insertfile', $file);
    }

    #[On('triggerBack')]
    public function triggerBack()
    {
        $this->getFolders();
    }

    /**
     * Show folders
     * @return void
     */
    public function getFolders()
    {
        // Alleen folders met juiste inhoud (images/files)
        $records = Folder::query()
                    ->whereNull('folders.model_id')
                    ->join('media', 'media.model_id', '=', 'folders.id')
                    ->where('media.mime_type', ($this->type=='file' ? 'NOT LIKE' : 'LIKE'), 'image/%')
                    ->select('folders.*')
                    ->distinct()
                    ->get();

        $this->modal_content = "<div class='grid grid-cols-1 md:grid-cols-3 gap-4 p-4 -mt-4'>";
        foreach($records as $item) {
            $this->modal_content .= view('filament-file-manager::components.folder-action-livewire', ['item' => $item]);
        }
        $this->modal_content .= "</div>";
    }
}
