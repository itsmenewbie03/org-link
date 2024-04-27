<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rules\Password;

new class extends Component {
    use Toast;
    public bool $myModal2 = false;
    public string $name;
    public string $email;
    public string $password;

    public bool $show_pass = false;

    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'required|string|min:5',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ];
    }

    public function create_user()
    {
        smart_db_hack();
        $this->validate();
        $user = DB::table('users')->insert([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            // NOTE: we will only have two roles `admin` and `user`
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->reset();
        $this->myModal2 = false;
        $this->success('User created successfully!');
        $this->dispatch('refresh_users');
    }

    public function toggle_password()
    {
        $this->show_pass = !$this->show_pass;
    }
}; ?>

<div>
    <x-mary-modal wire:model="myModal2" persistent title="New User" subtitle="Let's get started...">
        <x-mary-form>
            <x-mary-input label="Name" wire:model="name" icon="o-user" inline />
            {{-- HACK: we add hidden to that the autofill will be redirected here --}}
            <input type="email" name="email" autocomplete="email" class="hidden">
            <input type="password" name="email" autocomplete="email" class="hidden">
            {{-- HACK:  end of hack xD --}}
            <x-mary-input label="E-mail" wire:model="email" icon="o-at-symbol" inline />
            <x-mary-input label="Password" wire:model="password" icon="o-lock-closed"
                type="{{ $show_pass ? 'text' : 'password' }}" inline>
                <x-slot:append>
                    <x-mary-button icon="o-eye{{ $show_pass ? '' : '-slash' }}"
                        class="btn-primary rounded-l-none h-full" wire:click="toggle_password" />
                </x-slot:append>
            </x-mary-input>
        </x-mary-form>

        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.myModal2 = false" />
            <x-mary-button label="Create" icon="o-plus" class="btn-primary" wire:click="create_user" spinner />
        </x-slot:actions>
    </x-mary-modal>
    <x-mary-button icon="o-user-plus" class="btn-primary" label="Add User" @click="$wire.myModal2 = true" spinner />
</div>
