<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
use App\Models\TenantEvents;
use Carbon\Carbon;

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
            // INFO: ensure event name is unique
            'name' => 'required|min:5|unique:events,name',
            'description' => 'required|min:10',
            // INFO: ensure start date is after today
            'start_date' => 'required|date|after:' . Carbon::now()->addHour()->format('Y-m-d H:i'),
            'end_date' =>
                'required|date|after:' .
                Carbon::parse($this->start_date)
                    ->addHour(2)
                    ->format('Y-m-d H:i'),
            'location' => 'required|min:5',
        ];
    }

    public function messages()
    {
        return [
            // INFO: ensure event name is unique
            'name.unique' => 'There is already an event with that name.',
            // NOTE:: events should be schedule at least a day before
            // but as non punctual person we allow it to be at least an hour xD
            'start_date.after' => 'Event must be at least an hour from now',
            'end_date.after' => 'Event end date must be at least more than 2 hours from start date',
        ];
    }

    public function create_event()
    {
        $this->validate();
        // NOTE: for some reason the DB is automatically switching
        // I love it xD
        $event = TenantEvents::create([
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
        ]);
        if ($event) {
            $this->success('Event created successfully');
            // INFO: clear the form after a successful create
            $this->reset();
        } else {
            $this->error('Event creation failed');
        }
    }
}; ?>

<div>
    @php
        $config2 = ['enableTime' => true, 'dateFormat' => 'Y-m-d H:i'];
    @endphp
    <div class="text-lg breadcrumbs">
        <ul>
            <li>
                <a href="{{ route('events.index') }}" wire:navigate>
                    <x-mary-icon name="o-calendar-days" class="opacity-50" label="Events"
                        link="{{ route('events.index') }}" />
                </a>
            </li>
            <li><x-mary-icon name="o-calendar" label="Create Event" /></li>
        </ul>
    </div>
    <x-mary-card title="Create Event" class="w-full" shadow>
        <x-mary-form wire:submit="create_event">
            <x-mary-input label="Event Name" wire:model="name" icon="o-calendar-days" inline />
            <div class="flex gap-4">
                <div class="flex-1">
                    <x-mary-datepicker class="w-full" label="Event Start Date" wire:model="start_date" icon="o-calendar"
                        :config="$config2" inline />
                </div>
                <div class="flex-1">
                    <x-mary-datepicker class="flex-1" label="Event End Date" wire:model="end_date" icon="o-calendar"
                        :config="$config2" inline />
                </div>
            </div>
            <x-mary-textarea label="Event Description" wire:model="description" icon="o-document-text" inline />
            <x-mary-input label="Event Location" wire:model="location" icon="o-map-pin" inline />
            <x-slot:actions>
                <x-mary-button label="Cancel" link="{{ route('events.index') }}" />
                <x-mary-button label="Create" icon="o-plus" class="btn-primary" type="submit" spinner />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>
