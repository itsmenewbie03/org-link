<?php

use Livewire\Component;
use Mary\Traits\Toast;

class Toaster extends Component
{
    use Toast;
    public function deez()
    {
        $this->success('We are done, check it out');
    }
}
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <x-mary-toast />
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-mary-input label="Name" placeholder="Your name" icon="o-user" hint="Your full name" />
                    <x-mary-button label="Deez" class="btn-primary" icon="o-heart" wire:click="deez" spinner />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
