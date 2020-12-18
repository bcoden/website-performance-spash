<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AnimatedCircle extends Component
{
    public $percent;
    public $color;

    public function render()
    {
        return view('livewire.animated-circle');
    }
}
