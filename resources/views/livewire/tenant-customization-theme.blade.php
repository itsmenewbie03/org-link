<?php

use Livewire\Volt\Component;

new class extends Component {
    public ?bool $prefersDarkMode = null;
    public array $themes_light = [['value' => 'light', 'label' => 'Light'], ['value' => 'cupcake', 'label' => 'Cupcake'], ['value' => 'bumblebee', 'label' => 'Bumblebee'], ['value' => 'emerald', 'label' => 'Emerald'], ['value' => 'corporate', 'label' => 'Corporate'], ['value' => 'retro', 'label' => 'Retro'], ['value' => 'cyberpunk', 'label' => 'Cyberpunk'], ['value' => 'valentine', 'label' => 'Valentine'], ['value' => 'garden', 'label' => 'Garden'], ['value' => 'aqua', 'label' => 'Aqua'], ['value' => 'lofi', 'label' => 'Lofi'], ['value' => 'pastel', 'label' => 'Pastel'], ['value' => 'fantasy', 'label' => 'Fantasy'], ['value' => 'wireframe', 'label' => 'Wireframe'], ['value' => 'cmyk', 'label' => 'Cmyk'], ['value' => 'autumn', 'label' => 'Autumn'], ['value' => 'acid', 'label' => 'Acid'], ['value' => 'lemonade', 'label' => 'Lemonade'], ['value' => 'winter', 'label' => 'Winter'], ['value' => 'nord', 'label' => 'Nord']];
    public array $themes_dark = [['value' => 'dark', 'label' => 'Dark'], ['value' => 'sunset', 'label' => 'Sunset'], ['value' => 'dim', 'label' => 'Dim'], ['value' => 'night', 'label' => 'Night'], ['value' => 'coffee', 'label' => 'Coffee'], ['value' => 'business', 'label' => 'Business'], ['value' => 'dracula', 'label' => 'Dracula'], ['value' => 'luxury', 'label' => 'Luxury'], ['value' => 'black', 'label' => 'Black'], ['value' => 'forest', 'label' => 'Forest'], ['value' => 'halloween', 'label' => 'Halloween'], ['value' => 'synthwave', 'label' => 'Synthwave']];
    public array $themes = [];

    public function mount()
    {
        $this->themes = $this->prefersDarkMode ? $this->themes_dark : $this->themes_light;
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
            <x-mary-button icon="o-arrow-path" class="btn-ghost" label="Refresh" link="{{ route('customizations.theme') }}"
                no-wire-navigate />
        </x-slot:menu>
        <x-mary-select data-choose-theme icon="o-sparkles" option-value="value" option-label="label" :options="$this->themes"
            inline
            hint="Explore more themes! Change your device's settings to unlock new options. Click refresh after changing." />
    </x-mary-card>
    @script
        <script>
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                $wire.$set('prefersDarkMode', true);
                $wire.$refresh();
            }
            $wire.$set('prefersDarkMode', !true);
        </script>
    @endscript
</div>
