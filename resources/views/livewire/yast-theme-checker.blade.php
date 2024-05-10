<?php

use Livewire\Volt\Component;

new class extends Component {
    public ?bool $prefersDarkMode = null;

    public function rendered()
    {
        if (is_null($this->prefersDarkMode)) {
            // NOTE: the `prefersDarkMode` is not set, so we need to set it
            // this means the script did not ran yet xD
            return;
        }
        sleep(1);
        return $this->redirectRoute('customizations.theme', ['prefersDarkMode' => $this->prefersDarkMode]);
    }
}; ?>

<div>
    <div class="text-lg breadcrumbs">
        <ul>
            <li><x-mary-icon name="o-wrench-screwdriver" label="Customizations" /></li>
            <li><x-mary-icon name="o-sparkles" label="Theme" /></li>
        </ul>
    </div>

    <x-mary-card title="Theme Customizations">
        <x-slot:menu>
            <x-mary-button icon="o-arrow-path" class="btn-ghost btn-disabled" label="Refresh" />
        </x-slot:menu>
        <x-mary-progress class="progress-primary h-0.5" indeterminate />
    </x-mary-card>

    @script
        <script>
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                console.log('dark mode');
                $wire.$set('prefersDarkMode', true);
                return;
            }
            $wire.$set('prefersDarkMode', !true);
        </script>
    @endscript
</div>
