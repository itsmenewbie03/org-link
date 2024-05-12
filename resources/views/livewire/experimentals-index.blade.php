<?php

use Livewire\Volt\Component;
use Salahhusa9\Updater\Helpers\Git;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $versions = [];
    public $selected_version = null;
    public function boot()
    {
        $this->versions = Updater::versions();
        $this->versions = collect($this->versions)
            ->map(function ($version) {
                return [
                    'id' => $version,
                    'name' => $version,
                ];
            })
            ->toArray();
    }
    public function update()
    {
        if (Updater::getCurrentVersion() == 'main') {
            $this->error('This feature is not allowed in the bleeding edge version.');
            return;
        }

        if ($this->selected_version == null) {
            $this->error('Please select a version.');
            return;
        }

        Artisan::call('down');
        Git::checkout($this->selected_version);
        Artisan::call('up');
        session()->flash('update_result', 'Now using ' . $this->selected_version);
        return $this->redirectRoute('dashboard');
    }
}; ?>

<div>
    <div class="text-lg breadcrumbs">
        <ul>
            <li><x-mary-icon name="iconpark.experiment-o" label="Experimentals" /></li>
        </ul>
    </div>
    <x-mary-card title="Experimental Features">
        <x-mary-select label="Version" placeholder="Select a version ..." icon="iconpark.branchtwo-o" :options="$this->versions"
            wire:model="selected_version" inline
            hint="Choose the specific version you want to use. This is still experimental be careful.">
            <x-slot:append>
                <x-mary-button label="Start" icon="o-rocket-launch" class="rounded-l-none btn-primary h-full"
                    wire:click="update" />
            </x-slot:append>
        </x-mary-select>
    </x-mary-card>
</div>
