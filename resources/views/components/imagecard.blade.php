<div>
    <div class="media_card border rounded-lg overflow-hidden relative">
        <figure>
            <img class="media_card_image" src="{{ $record->getListingImage() }}" alt="" />
        </figure>
        <div class="media_overlay">
            <h2 class="text-white text-lg my-0 py-0 font-semibold">
                {{ $record->getCustomProperty('title') ?? $record->getCustomProperty('name') }}
                <span class="block max-h-2 mx-auto -mb-8 text-xs text-white">
                    @php
                    $file_path = Storage::disk($record->disk)->path($record->id."/".$record->file_name);
                    $a = getimagesize($file_path);
                    @endphp
                    @if($a)
                    {{ $a[1] }} x {{ $a[0] }}px
                    @endif
                </span>
            </h2>
            <div class="justify-self-start align-content-start">
                <div class="media_text_block text-white text-md">
                    {{ $record->getCustomProperty('description') }}
                </div>
            </div>
            <div class="media_overlay_links px-2 py-1 bg-gray-400 rounded-lg">
                <a title="Huidige afmeting" href="#" wire:click="selectMediaItem({{ $record->id }}, 1)">
                    <div class="resize full"></div>
                </a>
                <a title="3/4" href="#" wire:click="selectMediaItem({{ $record->id }}, 0.75)">
                    <div class="resize kwart"></div>
                </a>
                <a title="1/2" href="#" wire:click="selectMediaItem({{ $record->id }}, 0.5)">
                    <div class="resize half"></div>
                </a>
                <a title="1/3" href="#" wire:click="selectMediaItem({{ $record->id }}, 0.33)">
                    <div class="resize driekwart"></div>
                </a>
            </div>
        </div>
    </div>
</div>
