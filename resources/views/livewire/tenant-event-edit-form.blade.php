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

    public object $event;

    public function boot()
    {
        $this->name = $this->event->name;
        $this->description = $this->event->description;
        $this->start_date = $this->event->start_date;
        $this->end_date = $this->event->end_date;
        $this->location = $this->event->location;
    }

    public function rules()
    {
        return [
            // INFO: ensure event name is unique
            'name' => 'required|min:5|unique:events,name,' . $this->event->id,
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

    public function edit_event()
    {
        $this->validate();
        // NOTE: for some reason the DB is automatically switching
        // I love it xD
        // TODO: update the entry in the database
        $event = TenantEvents::find($this->event->id);
        $event->name = trim($this->name);
        $event->description = trim($this->description);
        $event->start_date = trim($this->start_date);
        $event->end_date = trim($this->end_date);
        $event->location = trim($this->location);
        $saved = $event->save();
        if (!$saved) {
            $this->error('An error occurred while saving the changes');
        }
        $this->success('Event updated successfully');
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
            <li><x-mary-icon name="o-pencil-square" label="Edit Event" /></li>
        </ul>
    </div>
    <x-mary-card title="Edit Event" class="w-full" shadow>
        <x-mary-form wire:submit="edit_event">
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
                <x-mary-button label="Save" icon="o-check-circle" class="btn-primary" type="submit" spinner />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>
