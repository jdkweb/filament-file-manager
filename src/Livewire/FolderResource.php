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

//        return Action::make('folderAction'.$item->id)
//            ->label("Via Folder model")
//            ->requiresConfirmation(function (array $arguments){
//                if($arguments['record']['is_protected']){
//                    return true;
//                }
//                else {
//                    return false;
//                }
//            })
//            ->form(function (array $arguments){
//                if($arguments['record']['is_protected']){
//                    return [
//                        TextInput::make('password')
//                            ->password()
//                            ->revealable()
//                            ->required()
//                            ->maxLength(255),
//                    ];
//                }
//                else {
//                    return null;
//                }
//            })
//            ->action(function (array $arguments, array $data) {
//                dd("ACTION: ", $arguments);
//            })
//            ->action(function (array $arguments, array $data){
//                if($arguments['record']['is_protected']){
//                    if($arguments['record']['password'] != $data['password']){
//                        Notification::make()
//                            ->title('Password is incorrect')
//                            ->danger()
//                            ->send();
//
//                        return ;
//                    }
//                    else {
//                        session()->put('folder_password', $data['password']);
//                    }
//                }
//                if(!$arguments['record']['model_type']){
//                    if(filament()->getTenant()){
//                        return redirect()->to(url(filament()->getCurrentPanel()->getId() .'/'. filament()->getTenant()->id . '/media?folder_id='.$arguments['record']['id']));
//                    }
//                    else {
//                        return redirect()->route('filament.'.filament()->getCurrentPanel()->getId().'.resources.media.index', ['folder_id' => $arguments['record']['id']]);
//                    }
//                }
//                if(!$arguments['record']['model_id'] && !$arguments['record']['collection']){
//                    if(filament()->getTenant()){
//                        return redirect()->to(url(filament()->getCurrentPanel()->getId() .'/'. filament()->getTenant()->id . '/folders?model_type='.$arguments['record']['model_type']));
//                    }
//                    else {
//                        return redirect()->route('filament.'.filament()->getCurrentPanel()->getId().'.resources.folders.index', ['model_type' => $arguments['record']['model_type']]);
//                    }
//                }
//                else if(!$arguments['record']['model_id']){
//                    if(filament()->getTenant()){
//                        return redirect()->to(url(filament()->getCurrentPanel()->getId() .'/'. filament()->getTenant()->id . '/folders?model_type='.$arguments['record']['model_type'].'&collection='.$arguments['record']['collection']));
//                    }
//                    else {
//                        return redirect()->route('filament.'.filament()->getCurrentPanel()->getId().'.resources.folders.index', ['model_type' => $arguments['record']['model_type'], 'collection' => $arguments['record']['collection']]);
//                    }
//                }
//                else {
//                    if(filament()->getTenant()) {
//                        return redirect()->to(url(filament()->getCurrentPanel()->getId() .'/'. filament()->getTenant()->id . '/media?folder_id='.$arguments['record']['id']));
//                    }
//                    else {
//                        return redirect()->route('filament.'.filament()->getCurrentPanel()->getId().'.resources.media.index', ['folder_id' => $arguments['record']['id']]);
//                    }
//                }
//            })
//            ->view('filament-file-manager::pages.folder-action', ['item' => $item]);
    }
}
