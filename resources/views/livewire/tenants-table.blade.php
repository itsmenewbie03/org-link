<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;
    public $tenants;
    public function create_tenant()
    {
        sleep(1);
        $this->success("You think we created a tenant? No we didn't. xD");
    }
}; ?>

<div>
    @php
        $headers = [
            ['key' => 'id', 'label' => 'Tenant ID'],
            ['key' => 'tenancy_db_name', 'label' => 'Tenant Database Name'],
        ];
    @endphp
    {{-- You can use any `$wire.METHOD` on `@row-click` --}}
    <x-mary-button icon="o-plus" class="btn-primary" label="Add Tenant" wire:click="create_tenant" spinner />
    <x-mary-table :headers="$headers" :rows="$tenants" striped />
</div>
