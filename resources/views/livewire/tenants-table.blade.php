<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

new class extends Component {
    use Toast;
    public $tenants;

    public function mount()
    {
        // NOTE: I am stupid for storing the plan in lowercase
        // so we transform it to uppercase here coz I have OCD xD
        // and this worked xD
        foreach ($this->tenants as $tenant) {
            $tenant->plan = ucfirst($tenant->plan);
        }
    }

    // INFO: maryui opts
    public bool $myModal2 = false;
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    // NOTE: tenant informations
    public string $tenant_email;
    public string $tenant_id;
    public string $tenant_name;
    public string $tenant_org_name;
    // NOTE: nano would be the default plan
    public string $plan = 'nano';

    public function rules()
    {
        return [
            'tenant_id' => 'required|min:3|alpha_dash',
            'tenant_email' => 'required|email',
            'tenant_name' => 'required|min:5',
            'tenant_org_name' => 'required|min:5',
            'plan' => 'required',
        ];
    }

    public function create_tenant()
    {
        $this->validate();
        // NOTE: i find this weird but we're doing db call here
        // I'm having trouble passing the tenant information to the controller
        $tenant = App\Models\Tenant::create([
            'id' => $this->tenant_id,
            'organization_name' => $this->tenant_org_name,
            'name' => $this->tenant_name,
            'email' => $this->tenant_email,
            'plan' => $this->plan,
        ]);
        $tenant->domains()->create(['domain' => $this->tenant_id . '.localhost']);

        // TODO: create a new user in the tenant db
        // NOTE: we'll use the tenant db connection

        // INFO: this a shameless copy from dormy implementation xD
        $connection = 'tenant' . $this->tenant_id;
        $password = Str::random(12);
        config(['database.connections.new.database' => $connection]);
        DB::setDefaultConnection('new');
        User::insert([
            'name' => $this->tenant_name,
            'email' => $this->tenant_email,
            'password' => Hash::make($password),
            // NOTE: the generated account is automatically the admin of the tenant
            'role' => 'admin',
        ]);
        // NOTE: we need to switch back to the default connection
        DB::setDefaultConnection('mysql');
        Mail::to($this->tenant_email)->send(new App\Mail\TenantWelcomeEmail($tenant, $password));
        return $this->redirectRoute('tenants.index');
    }
}; ?>

<div>
    {{-- INFO: create tenant modal --}}
    @php
        $plans = [
            [
                'id' => 'nano',
                'name' => 'Nano',
            ],
            [
                'id' => 'mega',
                'name' => 'Mega',
            ],
            [
                'id' => 'giga',
                'name' => 'Giga',
            ],
        ];
    @endphp
    <x-mary-modal wire:model="myModal2" title="New Tenant" subtitle="Let's start something new...">
        <x-mary-form>

            <x-mary-input label="Domain" wire:model="tenant_id" icon="o-globe-alt" inline />
            <x-mary-input label="Organization Name" wire:model="tenant_org_name" icon="o-user-group" inline />
            <x-mary-input label="Name" wire:model="tenant_name" icon="o-user" inline />
            <x-mary-input label="E-mail" wire:model="tenant_email" icon="o-at-symbol" inline />
            <x-mary-select label="Plan" icon="o-credit-card" :options="$plans" wire:model="plan" inline />
        </x-mary-form>

        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.myModal2 = false" />
            <x-mary-button label="Create" icon="o-plus" class="btn-primary" wire:click="create_tenant" spinner />
        </x-slot:actions>
    </x-mary-modal>
    @php
        $headers = [
            ['key' => 'id', 'label' => 'Tenant Domain'],
            ['key' => 'organization_name', 'label' => 'Tenant Organization Name'],
            ['key' => 'name', 'label' => 'Tenant Name'],
            ['key' => 'email', 'label' => 'Tenant Email'],
            ['key' => 'plan', 'label' => 'Plan'],
        ];
    @endphp
    {{-- You can use any `$wire.METHOD` on `@row-click` --}}
    <x-mary-button icon="o-user-plus" class="btn-primary" label="Add Tenant" @click="$wire.myModal2 = true" spinner />
    <x-mary-table :headers="$headers" :rows="$tenants" :sort-by="$sortBy" striped />
</div>
