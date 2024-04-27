<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;
    public $users;
    public $myModal3 = false;
    public $target_user = '';

    protected $listeners = [
        'refresh_users' => 'handleUserRefresh', // Listen for 'componentUpdate' event
    ];

    public function handleUserRefresh()
    {
        $this->boot();
    }

    public function mount()
    {
        // NOTE: role is on all lowercase
        // so we transform it to uppercase here coz I have OCD xD
        foreach ($this->users as $user) {
            $user->role = ucfirst($user->role);
        }
    }

    public function boot()
    {
        // NOTE: `boot` gets called when the delete button is clicked
        // and IDK why it does that, so yeah we need to load the users
        // again.
        smart_db_hack();
        $this->users = DB::table('users')->get();
    }

    public function confirm_delete($id)
    {
        $this->target_user = DB::table('users')->where('id', $id)->value('name');
        $this->myModal3 = true;
    }

    public function delete_user()
    {
        $user = DB::table('users')->where('name', $this->target_user);
        if ($user->value('role') === 'admin') {
            $this->myModal3 = false;
            $this->error('You cannot delete an admin!');
            return;
        }
        $user->delete();
        $this->myModal3 = false;
        $this->success('User deleted successfully!');
        $this->boot();
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
    <x-mary-modal wire:model="myModal3" title="Confirm" persistent class="backdrop-blur">
        <div>Are you sure you want to delete {{ $target_user }}?</div>
        <x-slot:actions>
            <x-mary-button label="Yes" icon="o-check" wire:click="delete_user" />
            <x-mary-button label="No" icon="o-x-mark" class="btn-primary" @click="$wire.myModal3 = false" />
        </x-slot:actions>
    </x-mary-modal>
    <x-mary-table :headers="$headers" :rows="$users">
        @scope('actions', $user)
            <x-mary-button icon="o-trash" wire:click="confirm_delete({{ $user->id }})" spinner class="btn-sm" />
        @endscope
    </x-mary-table>
</div>
