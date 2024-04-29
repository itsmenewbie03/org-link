<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;

    public string $name;
    public string $description;
    public string $start_date;
    public string $end_date;
    public string $location;

    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'description' => 'required|min:10',
            'start_date' => 'required',
            'end_date' => 'required',
            'location' => 'required',
        ];
    }

    public function create_event()
    {
        $this->success('Event created successfully!\nJK xD');
    }
}; ?>

<div>
    @php
        $config2 = ['enableTime' => true, 'dateFormat' => 'Y-m-d H:i'];
    @endphp
    <x-mary-card title="Create Event" class="w-full" shadow>
        <x-mary-form wire:submit="create_event">
            <x-mary-input label="Event Name" wire:model="name" icon="o-calendar-days" />
            <div class="flex gap-4">
                <div class="flex-1">
                    <x-mary-datepicker class="w-full" label="Event Start Date" wire:model="start_date" icon="o-calendar"
                        :config="$config2" />
                </div>
                <div class="flex-1">
                    <x-mary-datepicker class="flex-1" label="Event End Date" wire:model="end_date" icon="o-calendar"
                        :config="$config2" />
                </div>
            </div>
            <x-mary-textarea label="Event Description" wire:model="description" icon="o-document-text" />
            <x-mary-input label="Event Location" wire:model="location" icon="o-map-pin" />
            <x-slot:actions>
                <x-mary-button label="Cancel" link="{{ route('events.index') }}" />
                <x-mary-button label="Create" icon="o-plus" class="btn-primary" type="submit" spinner />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>
