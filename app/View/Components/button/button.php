<?php

namespace App\View\Components\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class button extends Component
{
    /**
     * Create a new component instance.
     */

    public $submit, $buttonName;
    public function __construct($submit, $buttonName)
    {
        $this->submit = $submit;
        $this->buttonName = $buttonName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button.button');
    }
}