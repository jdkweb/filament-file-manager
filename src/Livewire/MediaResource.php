<?php

namespace Jdkweb\FilamentFileManager\Livewire;

use Jdkweb\FilamentFileManager\Models\Folder;
use Jdkweb\FilamentFileManager\Models\Media;
use Livewire\Attributes\On;
use Livewire\Component;

class MediaResource extends Component
{
    public ?int $model_id = null;

    public $modal_content;

    public function render()
    {
        $output = view('filament-file-manager::livewire.media-resource', [
            'records' => $this->getImageData()
        ])->render();

        //return $output;
        //dd($output);
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
        return Media::query()->where('model_id', $this->model_id)->get();
    }

    public function setModelId(?int $id): static
    {
        $this->model_id = $id;
        return $this;
    }
}
