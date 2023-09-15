@php($attrs = $attributes)

<x-wrapper-input
     :data="$wrapperData"
     :attributes="$attrs->only(['wire:key', 'x-data'])"
>
    @include('wireui::components.wrapper.slots')

    <x-wireui::inputs.element :attributes="$attrs->except(['wire:key', 'x-data'])" />
</x-wrapper-input>
