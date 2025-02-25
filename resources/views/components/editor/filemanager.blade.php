@if($hasToolbarButton('filemanager'))
    <div class="flex items-center space-x-1 rtl:space-x-reverse">
        <x-filament::modal icon="heroicon-o-photo" id="file-selector" width="7xl" sticky-header>
            <x-slot name="heading">
                Bestandsbeheer
            </x-slot>
            <x-slot name="trigger">
                <x-filament::icon
                    icon="heroicon-m-gif"
                    class="h-5 w-5"
                />
            </x-slot>
            <div>
                <livewire:filament-file-manager.media-resource :wire:key="$id" />
            </div>
        </x-filament::modal>
    </div>
@endif
