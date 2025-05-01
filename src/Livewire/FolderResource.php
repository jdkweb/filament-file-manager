<?php

namespace Jdkweb\FilamentFileManager\Livewire;

use Filament\Actions\Action;
use Jdkweb\FilamentFileManager\Models\Folder;
use Jdkweb\FilamentFileManager\Models\Media;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Title;use Livewire\Component;

class FolderResource extends Component
{
    public ?string $modal_content = null;

    protected $listeners = ['triggerFolder'];

    public function render()
    {
        return view('filament-file-manager::livewire.folder-resource');
    }

    public function mount()
    {
        $this->folderAction();
    }

    public function triggerFolder(array $record)
    {
        $this->modal_content = ""; //app(MediaResource::class)->setModelId($record['id'])->render();
    }

    public function folderAction(?Folder $item = null)
    {
        $records = Folder::query()->whereNull('model_id')->get();

        foreach($records as $item) {
            $this->modal_content .= view('filament-file-manager::pages.folder-action', ['item' => $item])->render();
        }
    }
}
