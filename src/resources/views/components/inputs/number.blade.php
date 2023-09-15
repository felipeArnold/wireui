@php($attrs = $attributes)

<x-wrapper-input
    :data="$wrapperData"
    :attributes="$attrs->only('wire:key')"
    x-data="wireui_inputs_number({
        disabled: {{ json_encode($disabled) }},
        readonly: {{ json_encode($readonly) }},
    })"
>
    @include('wireui::components.wrapper.slots', [
        'except' => ['prepend', 'append'],
    ])

    <x-slot name="prepend">
        <x-dynamic-component
            :component="WireUi::component('button')"
            :color="$color ?? 'primary'"
            :rounded="Arr::get($roundedClasses, 'prepend', '')"
            x-hold.click.delay.repeat.100ms="minus"
            x-on:keydown.enter="minus"
            class="h-full"
            icon="minus"
            flat
            x-bind:disabled="disableMinus"
        />
    </x-slot>

    <x-wireui::inputs.element
        :attributes="$attrs->class('text-center appearance-number-none')->except(['wire:key', 'x-data'])"
        type="number"
        inputmode="numeric"
        x-ref="input"
        x-on:keydown.up.prevent="plus"
        x-on:keydown.down.prevent="minus"
    />

    <x-slot name="append">
        <x-dynamic-component
            :component="WireUi::component('button')"
            :color="$color ?? 'primary'"
            :rounded="Arr::get($roundedClasses, 'append', '')"
            x-hold.click.delay.repeat.100ms="plus"
            x-on:keydown.enter="plus"
            class="h-full"
            icon="plus"
            flat
            x-bind:disabled="disablePlus"
        />
    </x-slot>
</x-wrapper-input>
