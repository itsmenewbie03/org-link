<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;
    public ?object $event = null;
    public bool $confirm_delete_modal = false;
    public string $confirmation = '';

    public function confirmed()
    {
        return $this->confirmation === $this->event->name;
    }

    public function edit()
    {
        $this->success('Edit ' . $this->event->name);
    }

    public function delete()
    {
        $this->confirm_delete_modal = false;
        $this->error('Delete ' . $this->event->name . 'failed because I\'m tired already xD');
    }

    public function confirm_delete()
    {
        $this->confirm_delete_modal = true;
    }
}; ?>

<div class="flex gap-1">
    <x-mary-modal wire:model="confirm_delete_modal" title="Delete Event?" persistent class="backdrop-blur">
        <div class="text-justify">
            Deleting this event will <b>PERMANENTLY</b> remove it from the database.
            After deletion, <b> {{ $this->event->name }} </b> will no longer be accessible on the system.
            This will also include the attendance data for this event. <b>This action cannot be undone.</b>
            <br>
            <br>
            <x-mary-input label="Please type {{ $this->event->name }} to confirm." wire:model.live="confirmation" />
        </div>
        <x-slot:actions>
            <x-mary-button label="No, Keep this Event" icon="o-x-mark" @click="$wire.confirm_delete_modal = false" />
            <x-mary-button label="Yes, Delete this Event" icon="o-check"
                class="{{ $this->confirmed() ? 'btn-primary' : 'btn-disabled' }}" wire:click="delete" />
        </x-slot:actions>
    </x-mary-modal>
    <x-mary-button icon="o-pencil" class="btn-sm btn-circle btn-ghost" wire:click="edit" />
    <x-mary-button icon="o-trash" class="btn-sm btn-circle btn-ghost text-red-500" wire:click="confirm_delete" />
</div>
