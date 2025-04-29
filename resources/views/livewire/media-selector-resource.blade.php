<div style="margin-top: 7px;">
    <x-filament::modal
        icon="heroicon-m-photo"
        icon-color="#FFF"
        id="filament-file-manager"
        width="7xl" sticky-header>

        <!-- Icon button in the editor toolbar -->
        {{--
        <x-slot name="trigger">
            <x-filament::icon
                icon="heroicon-m-photo"
                class="h-6 w-6"
            />
        </x-slot>
        --}}

        <!-- Modal heading -->
        <x-slot name="heading">
           {{ ($this->type == 'file' ? 'Bestanden' : 'Afbeeldingen') }}
        </x-slot>

        <!-- Content in the modal -->
        <div class="m-0 p-0" x-data="{}">
            {!!  $this->modal_content !!}
        </div>
    </x-filament::modal>
</div>
