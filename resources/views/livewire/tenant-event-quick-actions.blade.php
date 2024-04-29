<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>
<x-mary-card title="Quick Actions" class="w-1/3 mr-6" shadow separator>
    <x-mary-menu>
        <x-mary-menu-item title="New Event" icon="o-plus" link="{{ route('events.create') }}" />
        <x-mary-menu-item title="Start Attendance" icon="o-list-bullet" />
    </x-mary-menu>
</x-mary-card>
