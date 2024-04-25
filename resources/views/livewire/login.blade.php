<?php
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;

new #[Layout('components.layouts.empty')] #[Title('Login')] class
    // <-- Here is the `empty` layout
    extends Component {
    use Toast;

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    // NOTE: this is for changing the db connection
    public string $tenant_id;

    public $tenant;

    public function mount()
    {
        // HACK: this a funny trick so we will have access to tenant_id
        if (is_null(session('tenant_id'))) {
            Log::info('We used our funny hack xD');
            return redirect('/');
        }
        $this->tenant_id = session('tenant_id');
        $this->tenant = Tenant::find($this->tenant_id);
        stupid_db_hack($this->tenant->tenancy_db_name);
        if (auth()->user()) {
            end_stupid_db_hack();
            return redirect(route('dashboard'));
        }
    }

    public function rendering($view, $data)
    {
        $this->tenant = Tenant::find($this->tenant_id);
    }

    public function login()
    {
        $credentials = $this->validate();
        // HACK: we gonna do something stupid (I think it is xD)
        stupid_db_hack($this->tenant->tenancy_db_name);
        if (auth()->attempt($credentials)) {
            request()->session()->regenerate();
            end_stupid_db_hack();
            return redirect()->intended('/');
        }
        $this->addError('email', 'The provided credentials do not match our records.');
    }

    public function request_account()
    {
        $this->error('This feature is disabled for security reasons. Please contact  ' . $this->tenant->name . ', your administrator.', timeout: 3000);
    }
}; ?>

<div class="md:w-96 mx-auto mt-40">

    <!-- <div class="mb-10">Cool image here</div> -->
    <x-mary-form wire:submit="login">
        <x-mary-header title="{{ $this->tenant->organization_name }}" subtitle="Please login to get started!" separator />
        <x-mary-input label="E-mail" wire:model="email" icon="o-envelope" inline />
        <x-mary-input label="Password" wire:model="password" type="password" icon="o-key" inline />

        <x-slot:actions>
            <x-mary-button label="Request for an account" class="btn-ghost" wire:click="request_account" />
            <x-mary-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
        </x-slot:actions>
    </x-mary-form>
</div>
