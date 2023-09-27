<?php

namespace WireUi;

use Illuminate\Support\Str;
use Illuminate\View\{ComponentAttributeBag, ComponentSlot};
use Livewire\{Component, WireDirective};
use WireUi\Support\{BladeDirectives, ComponentResolver};

class WireUi
{
    public function component(string $name): string
    {
        return (new static())->components()->resolve($name);
    }

    public function components(): ComponentResolver
    {
        return new ComponentResolver();
    }

    public function directives(): BladeDirectives
    {
        return new BladeDirectives();
    }

    public function extractAttributes(mixed $property): ComponentAttributeBag
    {
        return $property instanceof ComponentSlot
            ? $property->attributes
            : new ComponentAttributeBag();
    }

    public function alpine(string $component, array $data = []): string
    {
        $expressions = '';

        $parse = function ($value) {
            if (is_object($value) || is_array($value)) {
                return "JSON.parse(atob('" . base64_encode(json_encode($value)) . "'))";
            } elseif (is_string($value)) {
                return "'" . str_replace("'", "\'", $value) . "'";
            }

            return json_encode($value);
        };

        foreach ($data as $key => $value) {
            $expressions .= "{$key}:{$parse($value)},";
        }

        return <<<EOT
        {$component}({{$expressions}})
        EOT;
    }

    public static function wireModel(Component $component, ComponentAttributeBag $attributes)
    {
        $exists = count($attributes->whereStartsWith('wire:model')->getAttributes()) > 0;

        if (!$exists) {
            return ['exists' => false];
        }

        /** @var WireDirective $model */
        $model = $attributes->wire('model');

        return [
            'exists'     => $exists,
            'name'       => $model->name(),
            'value'      => $attributes->wire('model')->value(), // todo: get value from $component
            'livewireId' => $component->id,
            'modifiers'  => [
                'live'     => $model->modifiers()->contains('live'),
                'blur'     => $model->modifiers()->contains('blur'),
                'debounce' => [
                    'exists' => $model->modifiers()->contains('debounce'),
                    'delay'  => (int) Str::of($model->modifiers()->get(1, '750'))->replace('ms', '')->toString(),
                ],
            ],
        ];
    }
}
