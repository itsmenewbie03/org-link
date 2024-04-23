<?php
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;

new #[Layout('components.layouts.empty')] #[Title('Login')] class
    // <-- Here is the `empty` layout
    extends Component {
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    // NOTE: this is for changing the db connection
    public string $tenant_id;

    public function mount()
    {
        // HACK: this a funny trick so we will have access to tenant_id
        if (is_null(session('tenant_id'))) {
            Log::info('We used our funny hack xD');
            return redirect('/');
        }
        $this->tenant_id = session('tenant_id');
        $this->tenant = Tenant::find($this->tenant_id);
        $this->stupid_db_hack();
        if (auth()->user()) {
            $this->end_stupid_db_hack();
            return redirect(route('dashboard'));
        }
    }

    public function login()
    {
        $credentials = $this->validate();
        // HACK: we gonna do something stupid (I think it is xD)
        $this->stupid_db_hack();
        if (auth()->attempt($credentials)) {
            request()->session()->regenerate();
            $this->end_stupid_db_hack();
            return redirect()->intended('/');
        }
        $this->addError('email', 'The provided credentials do not match our records.');
    }

    public function stupid_db_hack()
    {
        $connection = 'tenant' . $this->tenant_id;
        config(['database.connections.new.database' => $connection]);
        DB::setDefaultConnection('new');
    }

    public function end_stupid_db_hack()
    {
        DB::setDefaultConnection('mysql');
    }
}; ?>

<div class="md:w-96 mx-auto mt-40">
    <x-mary-header title="{{ $this->tenant->organization_name }}" subtitle="Please login to get started!" separator />
    <!-- <div class="mb-10">Cool image here</div> -->
    <x-mary-form wire:submit="login">
        <x-mary-input label="E-mail" wire:model="email" icon="o-envelope" inline />
        <x-mary-input label="Password" wire:model="password" type="password" icon="o-key" inline />

        <x-slot:actions>
            <x-mary-button label="Request for an account" class="btn-ghost" link="/register" />
            <x-mary-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
        </x-slot:actions>
    </x-mary-form>
</div>
