<div class="border rounded-lg"  wire:click="triggerFolder({{$item->id}})">
    <x-filament-file-manager::folder-action :item="$item"/>
</div>
