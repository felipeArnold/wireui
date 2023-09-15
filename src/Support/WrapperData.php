<?php

namespace WireUi\Support;

use Illuminate\Support\Str;

class WrapperData
{
    private array $data = [];

    public function __construct(array $data)
    {
        $this->data = collect($data)
            ->filter(function ($value, string $key) {
                return in_array(Str::kebab($key), self::attributes());
            })
            ->mapWithKeys(fn ($value, string $key) => [
                Str::camel($key) => $value,
            ])
            ->toArray();
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public static function attributes(): array
    {
        return [
            ...self::shared(),
            ...self::extractable(),
        ];
    }

    public static function shared(): array
    {
        return ['id', 'name', 'disabled', 'readonly'];
    }

    public static function extractable(): array
    {
        return [
            'icon',
            'color',
            'label',
            'corner',
            'prefix',
            'shadow',
            'suffix',
            'rounded',
            'errorless',
            'right-icon',
            'shadowless',
            'description',
            'invalidated',
            'with-validation-colors',
            // Classes
            'color-classes',
            'shadow-classes',
            'rounded-classes',
        ];
    }
}
