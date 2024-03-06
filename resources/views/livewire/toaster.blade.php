<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class() extends Component
{
    use Toast;
    public $whatever = "no one care ackshually";
    public $name = "";

    public function toast_deez_nuts()
    {
        sleep(1);
        $this->success("Hello, " . $this->name . "👋");
    }
}; ?>

<div>
    <x-mary-input label="Name" placeholder="Your name" wire:model="name" icon="o-user" hint="Your full name" />
    <x-mary-button wire:click="toast_deez_nuts" label="Greet" icon="o-hand-raised" spinner />
</div>
