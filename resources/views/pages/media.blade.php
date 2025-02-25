@php
    $currentFolder = \TomatoPHP\FilamentMediaManager\Models\Folder::find($this->folder_id);
    if(filament('filament-file-manager')->allowSubFolders){
        $folders = \TomatoPHP\FilamentMediaManager\Models\Folder::query()
            ->where('model_type', \TomatoPHP\FilamentMediaManager\Models\Folder::class)
            ->where('model_id', $this->folder_id)
            ->get();
    }
    else {
        $folders = [];
    }
@endphp

<x-filament::actions :actions="$this->getActions()" />

@if(isset($records) || count($folders) > 0)
<div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 p-4">
    @if(isset($records))
        @foreach($records as $item)
            @if($item instanceof \TomatoPHP\FilamentMediaManager\Models\Folder)
                {{ ($this->folderAction($item))(['record' => $item]) }}
            @else
                <x-filament::modal width="3xl">
                    <x-filament-file-manager::card-slot :item="$item" />
                    <x-filament-file-manager::modal :item="$item" />
                </x-filament::modal>
            @endif
        @endforeach
    @endif
    @if(filament('filament-file-manager')->allowSubFolders)
        @foreach($folders as $folder)
            {{ ($this->folderAction($folder))(['record' => $folder]) }}
        @endforeach
    @endif
</div>
@else
    <div class="fi-ta-empty-state px-6 py-12">
        <div class="fi-ta-empty-state-content mx-auto grid max-w-lg justify-items-center text-center">
            <div class="fi-ta-empty-state-icon-ctn mb-4 rounded-full bg-gray-100 p-3 dark:bg-gray-500/20">
                <x-filament::icon
                    icon="heroicon-o-x-mark"
                    class="fi-ta-empty-state-icon h-6 w-6 text-gray-500 dark:text-gray-400"
                />
            </div>
            <x-filament-tables::empty-state.heading>
                {{ trans('filament-file-manager::messages.empty.title') }}
            </x-filament-tables::empty-state.heading>
        </div>
    </div>
@endif
