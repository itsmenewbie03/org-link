<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @sectionMissing('content')
            <x-mary-header title="OrgLink" subtitle="Introducing deez to the world!">
                <x-slot:middle class="!justify-end">
                    <x-mary-input icon="o-magnifying-glass" placeholder="Search..." />
                </x-slot:middle>
                <x-slot:actions>
                    <x-mary-button icon="o-funnel" />
                    <x-mary-button icon="o-plus" class="btn-primary" />
                </x-slot:actions>
            </x-mary-header>
            <x-mary-theme-toggle darkTheme="lofi" lightTheme="lofi" />
        @else
            @yield('content')
        @endif
    </div>
</x-app-layout>
