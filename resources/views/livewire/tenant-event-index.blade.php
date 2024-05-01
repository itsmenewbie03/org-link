<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;

    public $upcoming_events = [];
    public $calendar_events = [];
    public $events = [];

    public function boot()
    {
        $this->events = App\Models\TenantEvents::all();
        $this->upcoming_events = App\Models\TenantEvents::where('start_date', '>=', Carbon\Carbon::now())->orderBy('start_date', 'asc')->get();
        // NOTE: this transform the $events to match the desired input of the calendar component
        foreach ($this->events as $evt) {
            $evt->start_date = Carbon\Carbon::parse($evt->start_date);
            $evt->end_date = Carbon\Carbon::parse($evt->end_date);
            if ($evt->start_date->diffInDays($evt->end_date) >= 1) {
                $evt_transformed = [
                    'label' => $evt->name,
                    'description' => $evt->description,
                    'css' => '!bg-rose-200',
                    'range' => [$evt->start_date, $evt->end_date],
                ];
                $this->calendar_events[] = $evt_transformed;
                continue;
            }
            $evt_transformed = [
                'label' => $evt->name,
                'description' => $evt->description,
                'css' => '!bg-purple-200',
                'date' => $evt->start_date,
            ];
            $this->calendar_events[] = $evt_transformed;
        }
    }

    public function getEventReminder(string $date): string
    {
        $eventDate = Carbon\Carbon::parse($date);
        $now = Carbon\Carbon::now();
        $daysDiff = $eventDate->diffInDays($now);

        if ($daysDiff === 0) {
            $hoursLeft = $eventDate->diffInHours($now);
            if ($hoursLeft === 0) {
                return 'Event happening now!';
            } else {
                $hourText = $hoursLeft === 1 ? 'hour' : 'hours';
                return "in $hoursLeft $hourText";
            }
        } else {
            $dayText = $daysDiff === 1 ? 'day' : 'days';
            return "in $daysDiff $dayText";
        }
    }

    public function toaster($message, $type = 'success')
    {
        if ($type === 'success') {
            $this->success($message);
        } else {
            $this->error($message);
        }
    }
}; ?>

<div>
    @if (session('success'))
        {{ $this->toaster(session('success')) }}
    @endif
    <div class="text-lg breadcrumbs">
        <ul>
            <li><x-mary-icon name="o-calendar-days" label="Events" /></li>
        </ul>
    </div>
    <div class="w-full flex">
        <x-mary-card title="Quick Actions" class="w-1/3 mr-6" shadow separator>
            <x-mary-menu>
                <x-mary-menu-item title="New Event" icon="o-plus" link="{{ route('events.create') }}" />
                <x-mary-menu-item title="Start Attendance" icon="o-list-bullet" />
            </x-mary-menu>
        </x-mary-card>
        <x-mary-card title="Upcoming Events" class="w-1/3 mr-6" shadow separator>
            @foreach ($this->upcoming_events as $event)
                <x-mary-list-item :item="$event" no-separator no-hover>
                    <x-slot:value>
                        {{ $event->name }}
                    </x-slot:value>
                    <x-slot:sub-value>
                        {{ $this->getEventReminder($event->start_date) }}
                    </x-slot:sub-value>
                    <x-slot:actions>
                        <livewire:tenant-event-list-quick-actions :event="$event" />
                    </x-slot:actions>
                </x-mary-list-item>
            @endforeach
        </x-mary-card>

        <x-mary-card title="Monthly Events Calendar" class="w-fit" shadow separator>
            {{-- TODO: get rid of this ugly config call --}}
            <x-mary-calendar locale="en-PH" :events="$this->calendar_events" weekend-highlight :config="['settings' => ['iso8601' => false]]" />
        </x-mary-card>
    </div>
</div>
