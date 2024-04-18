<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <x-mary-form wire:submit="save6">
        {{-- Full error bag --}}
        {{-- All attributes are optional, remove it and give a try --}}
        <x-mary-errors title="Oops!" description="Please, fix them." icon="o-face-frown" />

        <x-mary-input label="Age" wire:model="age" />
        <x-mary-input label="E-mail" wire:model="email" />

        <x-slot:actions>
            <x-mary-button label="Click me!" class="btn-primary" type="submit" spinner="save6" />
        </x-slot:actions>
    </x-mary-form>
</div>
