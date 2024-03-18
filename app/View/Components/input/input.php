<?php

namespace App\View\Components\input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input extends Component
{
    /**
     * Create a new component instance.
     */
    public $label ,$fiwe, $type, $placeholder;
    public function __construct($label,$fiwe, $type,$placeholder)
    {   
        $this->label = $label;
        $this->fiwe = $fiwe;
        $this->type = $type;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input.input');
    }
}