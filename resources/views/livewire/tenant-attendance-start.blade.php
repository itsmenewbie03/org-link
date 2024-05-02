<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;
    public ?object $event = null;

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
            <x-mary-input label="Name" wire:model="tenant_name" icon="o-user" inline />
            <x-mary-input label="E-mail" wire:model="tenant_email" icon="o-at-symbol" inline />
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="back" />
                <x-mary-button label="Save" icon="o-arrow-up-on-square" class="btn-primary"
                    wire:click="save_attendance" spinner />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>
