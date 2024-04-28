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

    public function boot()
    {
        // NOTE: `boot` gets called when the delete button is clicked
        // and IDK why it does that, so yeah we need to load the users
        // again.
        smart_db_hack();
        $this->users = DB::table('users')->get();

        foreach ($this->users as $user) {
            $user->role = ucfirst($user->role);
        }
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
    <x-mary-modal wire:model="myModal3" title="Delete User?" persistent class="backdrop-blur">
        <div class="text-justify">
            Deleting this user will <b>PERMANENTLY</b> remove it from the database.
            After deletion, <b> {{ $target_user }} </b> will no longer have access to the system.
            <br>
            <br>
            <b>Warning: This cannot be undone.</b>
        </div>
        <x-slot:actions>
            <x-mary-button label="No, Keep this User" icon="o-x-mark" @click="$wire.myModal3 = false" />
            <x-mary-button label="Yes, Delete this User" icon="o-check" class="btn-primary" wire:click="delete_user" />
        </x-slot:actions>
    </x-mary-modal>
    <x-mary-card title="Users">
        <x-slot:menu>
            <livewire:tenant-users-add-user />
        </x-slot:menu>
        <x-mary-table :headers="$headers" :rows="$users">
            @scope('cell_role', $user)
                <x-mary-badge :value="$user->role" class="{{ $user->role === 'Admin' ? 'badge-primary' : '' }}" />
            @endscope
            @scope('actions', $user)
                <x-mary-button icon="o-trash" wire:click="confirm_delete({{ $user->id }})" spinner
                    class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-mary-table>
    </x-mary-card>
</div>
