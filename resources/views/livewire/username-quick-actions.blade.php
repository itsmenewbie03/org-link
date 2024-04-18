<?php

use Livewire\Volt\Component;

new class extends Component {
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}; ?>

<div>
    <x-mary-button icon="o-cog-6-tooth" link="{{ route('profile') }}" class="btn-circle btn-ghost btn-xs"
        tooltip-left="Profile Settings" />
    <x-mary-button icon="o-arrow-right-on-rectangle" wire:click="logout" class="btn-circle btn-ghost btn-xs"
        tooltip-left="Logout" />
</div>
