<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

new class extends Component {
    use Toast;
    public bool $myModal2 = false;
    public string $name;
    public string $email;

    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'required|min:5',
        ];
    }

    public function create_user()
    {
        smart_db_hack();
        // dump(Request::getHost());
        dd(DB::connection());
        // $this->validate();
        // $this->success('User created successfully!');
    }
}; ?>

<div>
    <x-mary-modal wire:model="myModal2" title="New User" subtitle="Let's get started...">
        <x-mary-form>
            <x-mary-input label="Name" wire:model="name" icon="o-user" inline />
            <x-mary-input label="E-mail" wire:model="email" icon="o-at-symbol" inline />
        </x-mary-form>

        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.myModal2 = false" />
            <x-mary-button label="Create" icon="o-plus" class="btn-primary" wire:click="create_user" spinner />
        </x-slot:actions>
    </x-mary-modal>
    <x-mary-button icon="o-user-plus" class="btn-primary" label="Add User" @click="$wire.myModal2 = true" spinner />
</div>
