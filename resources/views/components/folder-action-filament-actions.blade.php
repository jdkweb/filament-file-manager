<x-filament-actions::action
    :action="$action"
    :badge="$getBadge()"
    :badge-color="$getBadgeColor()"
    dynamic-component="filament::button"
    :label="$getLabel()"
    :size="$getSize()"
    class="fi-ac-icon-btn-action"
    color="gray"
>
    <x-filament-file-manager::folder-action :item="$item"/>
</x-filament-actions::action>
