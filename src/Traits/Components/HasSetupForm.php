<?php

namespace WireUi\Traits\Components;

use WireUi\Support\WrapperData;
use WireUi\Traits\Components\Concerns\{HasAttributesExtraction, HasSharedAttributes, InteractsWithErrors};

trait HasSetupForm
{
    use HasAttributesExtraction;
    use HasSharedAttributes;
    use InteractsWithErrors;

    protected function sharedAttributes(): array
    {
        return WrapperData::shared();
    }

    protected function extractableAttributes(): array
    {
        return WrapperData::extractable();
    }

    protected function setupForm(array &$data): void
    {
        $this->mergeAttributes($data);

        $this->extractAttributes($data);

        $data['wrapperData'] = new WrapperData($data);
    }
}
