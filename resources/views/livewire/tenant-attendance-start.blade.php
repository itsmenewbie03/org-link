<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    public array $year_levels = [['id' => 1, 'name' => '1st Year'], ['id' => 2, 'name' => '2nd Year'], ['id' => 3, 'name' => '3rd Year'], ['id' => 4, 'name' => '4th Year'], ['id' => 5, 'name' => 'Irregular']];

    use Toast;
    public ?object $event = null;

    // NOTE: attendance fields
    public string $name;
    public string $email;
    public string $course;
    public int $year;

    public function back()
    {
        return $this->redirect(route('events.index'), navigate: true);
    }

    public function save_attendance()
    {
        $this->success('Attendance saved successfully!<br>JK, this is just a demo.');
    }
}; ?>

<div>
    <div class="text-lg breadcrumbs">
        <ul>
            <li><x-mary-icon name="o-clipboard-document-list" label="Attendance" /></li>
        </ul>
    </div>
    <x-mary-card title="{{ $this->event->name }} Attendance">
        <x-mary-form>
            <x-mary-input label="Name" wire:model="name" icon="o-user" inline />
            <x-mary-input label="Email" wire:model="email" icon="o-at-symbol" inline />
            <x-mary-input label="Course" wire:model="course" icon="o-academic-cap" inline />
            <x-mary-select label="Year" icon="o-star" :options="$year_levels" wire:model="selectedUser" inline />
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="back" />
                <x-mary-button label="Save" icon="o-arrow-up-on-square" class="btn-primary"
                    wire:click="save_attendance" spinner />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>
