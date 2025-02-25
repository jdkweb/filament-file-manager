<?php

namespace Jdkweb\FilamentFileManager\Livewire;

use Jdkweb\FilamentFileManager\Models\Folder;
use Jdkweb\FilamentFileManager\Models\Media;
use Livewire\Attributes\On;
use Livewire\Component;

class MediaResource extends Component
{
    public function render()
    {
        return view('filament-file-manager::livewire.media-resource', [
            'records' => $this->getImageData()
        ]);
    }

    #[On('selectMediaItem')]
    public function selectMediaItem(int $id)
    {
        // Set ook de Filters op de juiste waarde
        // x-on:setfilters in filters.blade.php
        $this->dispatch('setrecord', Media::find($id)->file());
    }

    // Fetch data for the table with search
    protected function getImageData()
    {
        return Folder::query()->whereNull('model_id')->get();
    }
}
