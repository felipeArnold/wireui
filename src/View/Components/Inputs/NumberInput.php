<?php

namespace WireUi\View\Components\Inputs;

use Illuminate\Contracts\View\View;
use WireUi\Traits\Components\{HasSetupColor, HasSetupForm, HasSetupRounded, HasSetupShadow};
use WireUi\View\Components\BaseComponent;
use WireUi\WireUi\Wrapper\{Colors, Rounders, Shadows};

class NumberInput extends BaseComponent
{
    use HasSetupColor;
    use HasSetupForm;
    use HasSetupRounded;
    use HasSetupShadow;

    public function __construct()
    {
        $this->setColorResolve(Colors::class);
        $this->setShadowResolve(Shadows::class);
        $this->setRoundedResolve(Rounders::class);
    }

    protected function blade(): View
    {
        return view('wireui::components.inputs.number');
    }
}
