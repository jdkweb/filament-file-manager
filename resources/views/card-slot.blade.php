<div style="position: relative; top: -13px; left: -49px; width: calc(100% + 62px)">
    @php
    $item = $getRecord();
    @endphp
    <div class="flex flex-col justify-start w-full bg-white rounded-xl dark:bg-gray-800 group:dark:hover:bg-gray-500"
         style="height: 330px; border-bottom-left-radius: 0; border-bottom-right-radius: 0">
        <div class="flex flex-col items-center justify-center p-4"
             style="height: 240px">
            @if(str($item->mime_type)->contains('image'))
                <div class="w-full h-full rounded overflow-hidden" style="background: url({{ $item->getUrl() }}?hash={{ md5($item->updated_at) }}) center no-repeat; background-size: cover;"></div>
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
        <div style="height: 120px; max-height: 120px; overflow: hidden" class="border-y  dark:border-gray-700">
            <div class="flex flex-col justify-between p-4 w-full overflow-hidden">
                <h1 class="inline-block break-keep font-semibold text-gray-700 dark:text-gray-200 w-full">
                    {{ Str::limit($item->getCustomProperty('title') ?? $item->name, 30) }}
                </h1>
                <div style="height: 45px;">
                @if($desc = $item->getCustomProperty('description'))
                    <p class="text-sm text-gray-700 dark:text-gray-200 text-center">
                        {{ Str::limit($desc, 64) }}
                    </p>
                @endif
                </div>
                <div class="justify-start px-4 mx-4">
                    <p class="text-gray-500 dark:text-gray-300 text-xs truncate ...">
                        {{ $item->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

