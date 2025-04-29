@php
    use Filament\Support\Facades\FilamentView;

    $id = $getId();
    $statePath = $getStatePath();

    $doc_id = array_filter(request()->segments(), fn($r) => is_numeric($r));
    $doc_id = intval(reset($doc_id));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    EDIT {{ $doc_id }} / {{ $id }}

</x-dynamic-component>
