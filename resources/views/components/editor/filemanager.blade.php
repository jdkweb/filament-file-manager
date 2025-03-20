@if($hasToolbarButton('filemanager'))
    <div class="flex items-center space-x-1 rtl:space-x-reverse">
        <form wire:submit.prevent="livewireSubmitMethodHere">
            <x-filament::modal icon="heroicon-o-folder" sticky-header slide-over>
                <x-slot name="trigger">
                    <button type="button" x-on:click="isOpen = true">Open</button>
                </x-slot>

                <x-slot name="header">
                    Modal heading
                </x-slot>

                <x-slot name="description">
                    Modal description
                </x-slot>

                Form components here

                <x-slot name="actions">
                    <button type="submit">
                         Submit form
                    </button>
                </x-slot>
            </x-filament::modal>
        </form>
        {{--
        <x-filament::modal icon="heroicon-o-folder"
                           icon-color="#FFF"
                           id="file-manager"
                           width="7xl" sticky-header>

            <!-- Icon button in the editor toolbar -->
            <x-slot name="trigger">
                <x-filament::icon
                    icon="heroicon-m-gif"
                    class="h-5 w-5"
                />
            </x-slot>

            <!-- Modal heading -->
            <x-slot name="heading">
                Bestandsbeheer
            </x-slot>

            <!-- Content in the modal -->
            <div>
                filemanager.blade.php
                <livewire:filament-file-manager.folder-resource :wire:key="$id" />
            </div>

        </x-filament::modal>
        --}}
    </div>
@endif
