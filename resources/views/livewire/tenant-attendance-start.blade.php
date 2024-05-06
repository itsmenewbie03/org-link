<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
use App\Models\TenantAttendance;

new class extends Component {
    public array $year_levels = [['id' => 1, 'name' => '1st Year'], ['id' => 2, 'name' => '2nd Year'], ['id' => 3, 'name' => '3rd Year'], ['id' => 4, 'name' => '4th Year'], ['id' => 5, 'name' => 'Irregular']];

    use Toast;
    public ?object $event = null;

    // NOTE: attendance fields
    public string $name = '';
    public string $email = '';
    public string $course = '';
    public int $year;

    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'course' => 'required|string|min:3',
            'year' => 'required|numeric|min:1|max:5',
        ];
    }

    public function back()
    {
        return $this->redirect(route('events.index'), navigate: true);
    }

    public function save_attendance()
    {
        // HACK: we will do our 999 IQ move again
        // anti sir klevie xD
        $this->name = trim($this->name);
        $this->email = trim($this->email);
        $this->course = trim($this->course);

        $this->validate();
        // TODO: save attendance
        $saved = TenantAttendance::create([
            'event_id' => $this->event->id,
            'name' => $this->name,
            'email' => $this->email,
            'course' => $this->course,
            'year_level' => $this->year,
        ]);
        if (!$saved) {
            return $this->error('Failed to save attendance');
        }
        // NOTE: resetting everything causes issue so we only reset the following fields
        $this->reset(['name', 'email', 'course', 'year']);
        $this->success('Attendance saved successfully');
    }
}; ?>

<div>
    <div class="text-lg breadcrumbs">
        <ul>
            <li><x-mary-icon name="o-clipboard-document-list" label="Attendance" /></li>
            <li><x-mary-icon name="o-rocket-launch" label="Start Attendance" /></li>
        </ul>
    </div>
    <x-mary-card title="{{ $this->event->name }} Attendance">
        <x-mary-form wire:submit="save_attendance">
            <x-mary-input label="Name" wire:model="name" icon="o-user" inline />
            <x-mary-input label="Email" wire:model="email" icon="o-at-symbol" inline />
            <x-mary-input label="Course" wire:model="course" icon="o-academic-cap" inline />
            <x-mary-select placeholder="Select a year level" label="Year" icon="o-star" :options="$year_levels"
                wire:model="year" inline />
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="back" />
                <x-mary-button label="Save" icon="o-arrow-up-on-square" class="btn-primary" type="submit" spinner />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>
