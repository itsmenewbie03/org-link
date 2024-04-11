<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;
    public $tenants;

    // NOTE: tenant informations

    public bool $myModal2 = false;
    public string $tenant_email;
    public string $tenant_id;
    public string $tenant_name;

    public function rules()
    {
        return [
            'tenant_id' => 'required|min:3|alpha_dash',
            'tenant_email' => 'required|email',
            'tenant_name' => 'required|min:5',
        ];
    }

    public function create_tenant()
    {
        sleep(1);
        $this->validate();
        // NOTE: i find this weird but we're doing db call here
        // I'm having trouble passing the tenant information to the controller
        $tenant = App\Models\Tenant::create([
            'id' => $this->tenant_id,
            'name' => $this->tenant_name,
            'email' => $this->tenant_email,
        ]);
        $tenant->domains()->create(['domain' => $this->tenant_id . '.localhost']);
        return $this->redirectRoute('tenants.index');
    }
}; ?>

<div>
    <x-mary-modal wire:model="myModal2" title="New Tenant" subtitle="Let's start something new...">
        <x-mary-form>

            <x-mary-input label="ID" wire:model="tenant_id" />
            <x-mary-input label="Name" wire:model="tenant_name" />
            <x-mary-input label="E-mail" wire:model="tenant_email" />

        </x-mary-form>

        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.myModal2 = false" />
            <x-mary-button label="Create" class="btn-primary" wire:click="create_tenant" spinner />
        </x-slot:actions>
    </x-mary-modal>
    @php
        $headers = [
            ['key' => 'id', 'label' => 'Tenant ID'],
            ['key' => 'tenancy_db_name', 'label' => 'Tenant Database Name'],
            ['key' => 'name', 'label' => 'Tenant Name'],
            ['key' => 'email', 'label' => 'Tenant Email'],
        ];
    @endphp
    {{-- You can use any `$wire.METHOD` on `@row-click` --}}
    <x-mary-button icon="o-plus" class="btn-primary" label="Add Tenant" @click="$wire.myModal2 = true" spinner />
    <x-mary-table :headers="$headers" :rows="$tenants" striped />
</div>
