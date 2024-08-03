<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TagInput extends Component
{
    public $tags;

    /**
     * Create a new component instance.
     */
    public function __construct($tags = '')
    {
        $this->tags = $tags;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tag-input');
    }
}
