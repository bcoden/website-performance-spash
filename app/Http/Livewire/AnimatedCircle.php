<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AnimatedCircle extends Component
{
    public $score;
    public $color;

    public function render()
    {
        return view('livewire.animated-circle');
    }
}
