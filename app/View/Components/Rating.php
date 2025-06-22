<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Rating extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $rating,
        public $editable
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.rating')->with('rating', $this->rating)->with('editable', $this->editable);
    }
}
