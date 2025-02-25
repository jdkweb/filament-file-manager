<x-filament::modal icon="heroicon-o-photo"
                   id="file-selected"
                   width="2xl" sticky-header>
    <x-slot name="heading">
        <span id="media_selected_filename">Bestandsbeheer</span>
    </x-slot>
    <x-slot name="description" class="text-sm py-0 my-0">
        <span id="media_selected_filesize">4545</span>
    </x-slot>
    <x-slot name="trigger">
        <x-filament::icon
            icon="heroicon-m-gif"
            class="h-5 w-5"
        />
    </x-slot>
    <x-slot name="trigger">
        <div class="media_select_gallery_card"
             x-on:click="handler.setImage({{ json_encode($record->file()) }},{{ json_encode($record) }},$dispatch, $refs);">
            <div class="media_select_gallery_card_image"
                 style="background-image: url({{ $record->getImageUrl() }})"></div>
        </div>
    </x-slot>
    <div id="media_select_edit_form_template"
         x-data="{
            media_selected_image_width: '',
            media_selected_image_height: '',
            media_selected_image_alt: '',
            media_selected_image_style: '',
         }">
        <div id="media_selected_image" class="basis-full">
        </div>
        <form id="media_select_edit_form">
            <h3 class="basis-full font-semibold py-2 block text-md my-2">Attributen</h3>
            <div class="basis-full flex flex-row mb-4">
                <div class="basis-1/2 grow">
                    <div class="basis-full flex flex-row gap-4">
                        <div class="basis-1/4 text-sm pt-2">
                            Width:
                        </div>
                        <div class="basis-3/4 grow shrink-0 ">
                            <input type="number" class="rounded-md h-9"
                                   id="media_selected_image_width"
                                   x-model="media_selected_image_width">
                        </div>
                    </div>
                </div>
                <div class="basis-1/2 grow">
                    <div class="basis-full flex flex-row gap-4">
                        <div class="basis-1/4 text-sm pt-2">
                            Height:
                        </div>
                        <div class="basis-3/4 grow shrink-0">
                            <input type="number" class="rounded-md h-9 w-full"
                                   id="media_selected_image_height"
                                   x-model="media_selected_image_height">
                        </div>
                    </div>
                </div>
            </div>
            <div class="basis-full flex flex-row mb-4">
                <div class="w-full basis-full flex flex-row gap-4">
                    <div class="basis-1/4 text-sm pt-2">
                        Alt:&#160;&#160;&#160;&#160;&#160;
                    </div>
                    <div class="basis-3/4 grow shrink-0 ">
                        <input type="text" class="rounded-md h-9 w-full"
                               id="media_selected_image_alt"
                               x-model="media_selected_image_alt">
                    </div>
                </div>
            </div>
            <div class="basis-full flex flex-row mb-4">
                <div class="w-full basis-full flex flex-row gap-4">
                    <div class="basis-1/4 text-sm pt-2">
                        Style:&#160;
                    </div>
                    <div class="basis-3/4 grow shrink-0 ">
                        <input type="text" class="rounded-md h-9 w-full"
                               id="media_selected_image_style"
                               x-model="media_selected_image_style">
                    </div>
                </div>
            </div>
            <div class="w-full pl-16 bg-gray-400">
                <x-filament::button
                    size="xl"
                    style="float: right"
                    color="info"
                    x-on:click="handler.toContent()"
                    icon="heroicon-m-plus">Afbeelding plaatsen
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament::modal>

