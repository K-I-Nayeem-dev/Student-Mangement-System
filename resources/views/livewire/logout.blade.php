<?php

use Livewire\Volt\Component;

new class extends Component {
    public $count = 1;

    public function increment(){
        $this->count++;
    }

    public function decrement(){
        $this->count--;
    }


}; ?>

<div>
    <p>{{ $count }}</p>
    <button wire:cilck='increment'>+</button>
    <button wire:cilck='decrement'>-</button>
</div>
