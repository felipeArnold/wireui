<div
    @class([
        'aria-disabled:pointer-events-none aria-disabled:select-none',
        'aria-disabled:opacity-60 aria-disabled:cursor-not-allowed',
        'aria-readonly:pointer-events-none aria-readonly:select-none',
    ])
    @attributes([
        'with-validation-colors' => $withValidationColors,
        'group-invalidated' => $invalidated,
        'aria-disabled' => $disabled,
        'aria-readonly' => $readonly,
    ])
    {{ $attributes
        ->merge(['form-wrapper' => $id ?: 'true'])
        ->only(['wire:key', 'form-wrapper', 'x-data']) }}
>
    @if ($label || $corner)
        <div
            @class([
                'justify-between items-end' => $label,
                'justify-end' => !$label,
                'flex mb-1',
            ])
            name="form.wrapper.header"
        >
            @if ($label)
                <x-wireui::form.label
                    :attributes="WireUi::extractAttributes($label)"
                    :for="$id"
                >
                    {{ $label }}
                </x-wireui::form.label>
            @endif

            @if ($corner)
                <x-wireui::form.label
                    :attributes="WireUi::extractAttributes($corner)"
                    :for="$id"
                >
                    {{ $corner }}
                </x-wireui::form.label>
            @endif
        </div>
    @endif

    <label
        {{ $attributes
            ->except(['wire:key', 'form-wrapper', 'x-data'])
            ->merge(['for' => $id])
            ->class([
                Arr::get($roundedClasses, 'input', ''),
                Arr::get($colorClasses, 'input', ''),
                $shadowClasses => !$shadowless,

                'focus-within:ring-2',
                'relative flex gap-x-2 items-center',
                'ring-1 ring-inset ring-gray-300',
                'transition-all ease-in-out duration-150',

                'pl-3' => !isset($prepend),
                'pr-3' => !isset($append),
                'h-10' => isset($prepend) || isset($append),
                'py-2' => !isset($prepend) && !isset($append),

                'invalidated:bg-negative-50 invalidated:ring-negative-500 invalidated:dark:ring-negative-700',
                'invalidated:dark:bg-negative-700/10 invalidated:dark:ring-negative-600',
            ])
        }}
        name="form.wrapper.container"
    >
        @if (!isset($prepend) && ($prefix || $icon))
            <div
                name="form.wrapper.container.prefix"
                @class([
                    'text-gray-500 pointer-events-none select-none flex items-center whitespace-nowrap',
                    'invalidated:input-focus:text-negative-500',
                    Arr::get($roundedClasses, 'prepend', ''),
                    'invalidated:text-negative-500',
                ])
            >
                @if ($icon)
                    <x-dynamic-component
                        :component="WireUi::component('icon')"
                        :name="$icon"
                        class="w-4.5 h-4.5"
                    />
                @elseif($prefix)
                    <span {{ WireUi::extractAttributes($prefix) }}>
                        {{ $prefix }}
                    </span>
                @endif
            </div>
        @elseif (isset($prepend))
            <div
                name="form.wrapper.container.prepend"
                {{ $prepend->attributes->class([
                    'group/prepend wrapper-prepend-slot',
                    'flex h-full py-0.5 pl-0.5',
                ]) }}
            >
                {{ $prepend }}
            </div>
        @endif

        {{ $slot }}

        @if (!isset($append))
            <div
                name="form.wrapper.container.suffix"
                @class([
                    'text-gray-500 pointer-events-none select-none flex items-center whitespace-nowrap',
                    'invalidated:input-focus:text-negative-500',
                    Arr::get($roundedClasses, 'append', ''),
                    'invalidated:text-negative-500',
                ])
            >
                @if ($rightIcon)
                    <x-dynamic-component
                        :component="WireUi::component('icon')"
                        :name="$rightIcon"
                        class="w-4.5 h-4.5"
                    />
                @elseif($suffix)
                    <span {{ WireUi::extractAttributes($suffix) }}>
                        {{ $suffix }}
                    </span>
                @else
                    <x-dynamic-component
                        :component="WireUi::component('icon')"
                        name="exclamation-circle"
                        class="hidden invalidated:block w-4.5 h-4.5"
                    />
                @endif
            </div>
        @else
            <div
                name="form.wrapper.container.append"
                {{ $append->attributes->class([
                    'group/append wrapper-append-slot',
                    'flex h-full py-0.5 pr-0.5',
                ]) }}
            >
                {{ $append }}
            </div>
        @endif
    </label>

    @if ($description && !$invalidated)
        <x-wireui::form.description
            class="mt-2"
            :for="$id"
            name="form.wrapper.description"
        >
            {{ $description }}
        </x-wireui::form.description>
    @elseif (!$errorless && $invalidated)
        <x-wireui::form.error
            class="mt-2"
            :for="$id"
            :message="$errors->first($name)"
        />
    @endif
</div>
