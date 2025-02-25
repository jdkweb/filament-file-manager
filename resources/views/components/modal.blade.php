
<x-slot name="heading">
    {{ $item->uuid }}
</x-slot>

<x-slot name="description">
    {{ $item->file_name }}
</x-slot>

<div>
    <div class="flex flex-col justify-start w-full h-full">

        @if(str($item->mime_type)->contains('image'))
            <a href="{{ $item->getUrl() }}" target="_blank" class="flex flex-col items-center justify-center  p-4 h-full border dark:border-gray-700 rounded-lg">
                <img src="{{ $item->getUrl() }}" />
            </a>

        @elseif(str($item->mime_type)->contains('video'))
            <a href="{{ $item->getUrl() }}" target="_blank" class="flex flex-col items-center justify-center  p-4 h-full border dark:border-gray-700 rounded-lg">
                <video class="w-full h-full" controls>
                    <source src="{{ $item->getUrl() }}" type="{{ $item->mime_type }}">
                </video>
            </a>

        @elseif(str($item->mime_type)->contains('audio'))
            <a href="{{ $item->getUrl() }}" target="_blank" class="flex flex-col items-center justify-center  p-4 h-full border dark:border-gray-700 rounded-lg">
                <video class="w-full h-full" controls>
                    <source src="{{ $item->getUrl() }}" type="{{ $item->mime_type }}">
                </video>
            </a>
        @else
            @php
                $hasPreview = false;
                $loadTypes = \TomatoPHP\FilamentMediaManager\Facade\FilamentMediaManager::getTypes();
                foreach ($loadTypes as $type) {
                    if(str($item->file_name)->contains($type->exstantion)){
                        $hasPreview = $type->preview;
                    }
                }
            @endphp
            @if($hasPreview)
                @include($hasPreview, ['media' => $item])

            @else
                <a href="{{ $item->getUrl() }}" target="_blank" class="flex flex-col items-center justify-center  p-4 h-full border dark:border-gray-700 rounded-lg">
                    @if(@$type)
                        <x-icon :name="$type->icon" class="w-32 h-32" />
                    @else
                        <x-icon name="heroicon-o-document" class="w-32 h-32" />
                    @endif
                </a>
            @endif
        @endif
        <div class="flex flex-col gap-4 my-4">
            @if($item->model)
            <div>
                <div>
                    <h1 class="font-bold">{{ trans('filament-file-manager::messages.media.meta.model') }}</h1>
                </div>
                <div class="flex justify-start">
                    <p class="text-sm">
                      {{str($item->model_type)->afterLast('\\')->title()}}[ID:{{ $item->model?->id }}]
                    </p>
                </div>
            </div>
            @endif
            <div>
                <div>
                    <h1 class="font-bold">{{ trans('filament-file-manager::messages.media.meta.file-name') }}</h1>
                </div>
                <div class="flex justify-start">
                    <p class="text-sm">
                        {{ $item->file_name }}
                    </p>
                </div>
            </div>
            <div>
                <div>
                    <h1 class="font-bold">{{ trans('filament-file-manager::messages.media.meta.type') }}</h1>
                </div>
                <div class="flex justify-start">
                    <p class="text-sm">
                        {{ $item->mime_type }}
                    </p>
                </div>
            </div>
            <div>
                <div>
                    <h1 class="font-bold">{{ trans('filament-file-manager::messages.media.meta.size') }}</h1>
                </div>
                <div class="flex justify-start">
                    <p class="text-sm">
                        {{ $item->humanReadableSize }}
                    </p>
                </div>
            </div>
            <div>
                <div>
                    <h1 class="font-bold">{{ trans('filament-file-manager::messages.media.meta.disk') }}</h1>
                </div>
                <div class="flex justify-start">
                    <p class="text-sm">
                        {{ $item->disk  }}
                    </p>
                </div>
            </div>
            @if($item->custom_properties)
                @foreach($item->custom_properties as $key=>$value)
                    @if($value)
                        <div>
                            <div>
                                <h1 class="font-bold">{{str($key)->title()}}</h1>
                            </div>
                            <div class="flex justify-start">
                                <p class="text-sm">
                                    {{ $value }}
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>

@if(filament('filament-file-manager')->allowUserAccess && (!empty($currentFolder->user_id)))
    @if($currentFolder->user_id === auth()->user()->id && $currentFolder->user_type === get_class(auth()->user()))
        <x-slot name="footer">
            {{ ($this->deleteMedia)(['record' => $item]) }}
        </x-slot>
    @endif
@else
    <x-slot name="footer">
        {{ ($this->deleteMedia)(['record' => $item]) }}
    </x-slot>
@endif
