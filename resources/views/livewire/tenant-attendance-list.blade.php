<?php

use Livewire\Volt\Component;
use App\Models\TenantAttendance;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $events = null;
    public $event_id = 0;
    public $attendances = [];

    public function load_event_attendance()
    {
        $this->attendances = TenantAttendance::where('event_id', $this->event_id)->get();
        foreach ($this->attendances as $attendance) {
            $attendance->attended_at = \Carbon\Carbon::parse($attendance->created_at)->toDayDateTimeString();
            $attendance->year = match ($attendance->year_level) {
                1 => '1st Year',
                2 => '2nd Year',
                3 => '3rd Year',
                4 => '4th Year',
                5 => 'Irregular',
                default => 'Unknown',
            };
        }
    }

    public function download_attendance_list()
    {
        if (tenant('plan') !== 'giga') {
            $this->error('You are not allowed to download attendance list. Please upgrade your plan to Giga.');
            return;
        }

        if ($this->event_id == 0) {
            $this->error('Please select an event to download attendance list.');
            return;
        }
        // NOTE: no toArray is needed here as initially this is an empty array
        if (empty($this->attendances)) {
            // NOTE: we will allow download without loading the attendance list
            // coz we "love" our user xD
            $this->load_event_attendance();
            // NOTE: to avoid infinite loop we will check if the list is still empty
            if (empty($this->attendances->toArray())) {
                $this->error('No attendance list found for the selected event.');
                return;
            }
            // INFO: retry download after loading the attendance list
            $this->download_attendance_list();
            return;
        }
        $attendances = $this->attendances->toArray();
        // INFO: get selected event name
        $event = $this->events->where('id', $this->event_id)->first()->name;
        $handle = fopen($event . '_Attendance_' . now() . '.csv', 'w');
        foreach ($attendances as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
        $this->success('Attendance list downloaded successfully.');
    }
}; ?>

<div>
    @php
        $headers = [
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'course', 'label' => 'Course'],
            ['key' => 'year', 'label' => 'Year'],
            ['key' => 'attended_at', 'label' => 'Attendance Time'],
        ];
    @endphp
    <div class="text-lg breadcrumbs">
        <ul>
            <li><x-mary-icon name="o-clipboard-document-list" label="Attendance" /></li>
            <li><x-mary-icon name="o-document-text" label="View Attendance" /></li>
        </ul>
    </div>
    <x-mary-card title="Attendance List">
        <x-slot:menu>
            <x-mary-select placeholder="Select event" placeholder-value="0" icon="o-calendar" :options="$events"
                wire:model="event_id">
                <x-slot:append>
                    <x-mary-button icon="o-funnel" class="rounded-l-none btn-primary" tooltip="Load Attendance"
                        wire:click="load_event_attendance" />

                </x-slot:append>
            </x-mary-select>
            <x-mary-button icon="o-arrow-down-tray" tooltip="Download Attendance List"
                wire:click="download_attendance_list" />
        </x-slot:menu>
        <x-mary-table :headers="$headers" :rows="$attendances">
        </x-mary-table>
    </x-mary-card>
</div>
