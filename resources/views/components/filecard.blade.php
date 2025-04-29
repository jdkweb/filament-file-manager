<div>
    <div class="media_card border rounded-lg overflow-hidden relative">
        <figure>
            <img class="media_card_image" src="{{ $record->getListingImage() }}" alt="" />
        </figure>
        <div class="media_overlay">
            <h2 class="text-white text-lg my-0 py-0 font-semibold">
                {{ $record->getCustomProperty('title') ?? $record->getCustomProperty('name') }}
            </h2>
            <div class="justify-self-start align-content-start">
                <div class="media_text_block text-white text-md">
                    {{ $record->getCustomProperty('description') }}
                </div>
            </div>
            <div class="media_overlay_links files px-2 py-1 bg-gray-400 rounded-lg">
                <a class="justify-self-center" title="Wrap text link" href="#" wire:click="selectMediaFile({{ $record->id }}, 'text')">
                    <x-filament::icon icon="heroicon-o-link" class="text-white" />
                </a>
                <a class="justify-self-center" title="Icoon link" href="#" wire:click="selectMediaFile({{ $record->id }}, 'icon')">
                    <x-filament::icon icon="heroicon-o-gif" class="text-white" />
                </a>
            </div>
        </div>
    </div>
</div>
