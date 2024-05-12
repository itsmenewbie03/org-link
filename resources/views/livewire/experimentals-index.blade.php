<?php

use Livewire\Volt\Component;

new class extends Component {
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
        dd($this->selected_version);
        // WARN: I WON'T TRY TO IMPLEMENT IT HERE I MIGHT LOSE
        // MY PROGRESS
    }
}; ?>

<div>
    <div class="text-lg breadcrumbs">
        <ul>
            <li><x-mary-icon name="iconpark.experiment-o" label="Experimentals" /></li>
        </ul>
    </div>
    <x-mary-card title="Experimental Features">
        <x-mary-select label="Select a version" placeholder="Latest" icon="iconpark.branchtwo-o" :options="$this->versions"
            wire:model="selected_version" inline
            hint="Select specific version you want to use. This is still experimental be careful.">
            <x-slot:append>
                <x-mary-button label="Start" icon="o-rocket-launch" class="rounded-l-none btn-primary h-full"
                    wire:click="update" />
            </x-slot:append>
        </x-mary-select>
    </x-mary-card>
</div>
