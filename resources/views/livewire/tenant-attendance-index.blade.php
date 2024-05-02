<?php

use Livewire\Volt\Component;

new class extends Component {
    public $current_events = [];
    public $event_id = null;
    public bool $myModal2 = !false;

    public function mount()
    {
        $now = Carbon\Carbon::now()->addDay();
        $current_events = App\Models\TenantEvents::where('start_date', '<=', $now)->where('end_date', '>=', $now);
        if (!$current_events->count()) {
            session()->flash('error', 'No event is currently happening.');
            return $this->redirect(route('events.index'), navigate: true);
        }
        $this->current_events = $current_events->get();
    }

    public function back()
    {
        $this->myModal2 = false;
        return $this->redirect(route('events.index'), navigate: true);
    }

    public function start_attendance()
    {
        if ($this->event_id === null) {
            // NOTE: this means that only a single event is happening now
            $this->event_id = $this->current_events[0]->id;
        }
        $this->myModal2 = false;
        return $this->redirect(route('attendance.start', ['event_id' => $this->event_id]), navigate: true);
    }
}; ?>

<div>
    @if ($this->current_events->count() > 1)
        <x-mary-modal wire:model="myModal2" title="Select Event" subtitle="Select the specific event you want to manage"
            persistent class="backdrop-blur">
            <x-mary-form>
                <x-mary-select label="Event" icon="o-calendar" :options="$this->current_events" wire:model="event_id" inline />
            </x-mary-form>
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="back" />
                <x-mary-button label="Start Attendance" icon="o-check-circle" class="btn-primary"
                    wire:click="start_attendance" spinner />
            </x-slot:actions>
        </x-mary-modal>
    @else
        <x-mary-modal wire:model="myModal2" title="Start Attendance?" persistent class="backdrop-blur">
            <div class="text-justify">
                Since <b>{{ $this->current_events[0]->name }}</b> is the only event happening now, Please confirm if you
                want to start the attendance for it.
            </div>
            <x-slot:actions>
                <x-mary-button label="No, Cancel the attendance" icon="o-x-mark" wire:click="back" />
                <x-mary-button label="Yes, Start the attendance" icon="o-check" class="btn-primary"
                    wire:click="start_attendance" />
            </x-slot:actions>
        </x-mary-modal>
    @endif
</div>
