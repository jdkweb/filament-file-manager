<div>
    <x-filament::modal
        icon="heroicon-o-photo"
        icon-color="#FFF"
        id="filament-file-edit"
        width="lg" sticky-header>

        <!-- Hidden trigger -->
        <x-slot name="trigger">
            <button id="modalTrigger" class="hidden">{{ __('filament-file-manager::image_settings.button') }}</button>
        </x-slot>

        <!-- Modal heading -->
        <x-slot name="heading">
            {{ __('filament-file-manager::image_settings.editimage') }}
        </x-slot>


        <!-- Content in the modal -->
        <div class="m-0 p-0" x-data="{}" x-on:settings.window="function(settings) { console.log( settings ); updateSettings(settings); }">
            <form wire:submit.prevent="submit">
                {{ $this->form }}
                <div class="flex justify-between pt-6">
                    <x-filament::button
                        type="submit"
                        icon="heroicon-m-pencil-square"
                        color="success">
                        {{ __('filament-file-manager::image_settings.save') }}
                    </x-filament::button>
                    <x-filament::button
                        wire:click="$dispatch('close-modal', { id: 'filament-file-edit' })"
                        icon="heroicon-m-x-circle"
                        color="gray">
                        {{ __('filament-file-manager::image_settings.cancel') }}
                    </x-filament::button>
                </div>
            </form>
        </div>
    </x-filament::modal>
</div>
