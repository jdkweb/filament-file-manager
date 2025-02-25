<x-slot name="trigger" class="w-full h-full">
    <div class="flex flex-col justify-start gap-4 border dark:border-gray-700 rounded-lg shadow-sm p-2 w-full"
         style="height: 350px">
        <div class="flex flex-col items-center justify-center p-4"
             style="height: 240px">
            @if(str($item->mime_type)->contains('image'))
                <div class="w-full h-full rounded-lg" style="background: url({{ $item->getUrl() }}) center no-repeat; background-size: contain"></div>
            @elseif(str($item->mime_type)->contains('video'))
                <video src="{{ $item->getUrl() }}"></video>
            @elseif(str($item->mime_type)->contains('audio'))
                <x-icon name="heroicon-o-musical-note" class="w-32 h-32" />
            @else
                @if($icon = $item->getIcon())
                    <img src="{{ $icon->getIconPath() }}" class="w-32 h-32" />
                @else
                    <x-icon name="heroicon-o-document" class="w-32 h-32" />
                @endif
            @endif
        </div>
        <div style="height: 110px; max-height: 110px; overflow: hidden">
            <div class="flex flex-col justify-between border-t dark:border-gray-700 p-4 w-full">
                <h1 class="inline-block break-keep font-bold w-full">{{ Str::limit(($item->hasCustomProperty('title') ? (!empty($item->getCustomProperty('title')) ? $item->getCustomProperty('title') : $item->name) : $item->name), 30) }}</h1>
                @if($item->hasCustomProperty('description') && !empty($item->getCustomProperty('description')))
                    <div>
                        <div class="flex justify-start mt-1 mb-2">
                            <p class="text-sm">
                                {{ Str::limit(($item->getCustomProperty('description')), 64) }}
                            </p>
                        </div>
                    </div>
                @else
                    <div class="h-24 my-3 pt-2">&#160;</div>
                @endif
            </div>
        </div>
        <div class="justify-start px-4 mx-4">
            <p class="text-gray-600 dark:text-gray-300 text-sm truncate ...">
                {{ $item->created_at->diffForHumans() }}
            </p>
        </div>
    </div>
</x-slot>
