<?php

use Livewire\Volt\Component;

new class extends Component {
    public $users;
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public function mount()
    {
        // NOTE: role is on all lowercase
        // so we transform it to uppercase here coz I have OCD xD
        foreach ($this->users as $user) {
            $user->role = ucfirst($user->role);
        }
    }
}; ?>

<div>
    @php
        $headers = [
            ['key' => 'id', 'label' => 'User ID'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'role', 'label' => 'Role'],
        ];
    @endphp
    <x-mary-table :headers="$headers" :rows="$users" :sort-by="$sortBy" striped />
</div>
