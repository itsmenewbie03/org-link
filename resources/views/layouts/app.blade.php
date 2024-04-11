<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-mary-nav sticky class="lg:hidden">
        <x-slot:brand class="flex gap-2 items-center">
            <x-mary-icon name="o-square-3-stack-3d" class="text-primary" />
            <div>{{ config('app.name', 'Laravel') }}</div>
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-mary-nav>

    {{-- MAIN --}}
    <x-mary-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <div class="p-6 pt-3 flex gap-3 items-center h-20">
                <x-mary-icon name="o-academic-cap" class="text-primary" />
                <div class="hidden-when-collapsed">{{ config('app.name', 'Laravel') }}</div>
            </div>

            {{-- MENU --}}
            <x-mary-menu activate-by-route>

                {{-- User --}}
                @if ($user = auth()->user())
                    <x-mary-list-item :item="$user" sub-value="username" no-separator no-hover
                        class="!-mx-2 mt-2 mb-5 border-y border-y-sky-900">
                        <x-slot:actions>
                            <livewire:logout-btn />
                        </x-slot:actions>
                    </x-mary-list-item>
                @endif

                <x-mary-menu-item title="Dashboard" icon="o-computer-desktop" link="{{ route('dashboard') }}" />
                <x-mary-menu-item title="Tenants" icon="o-users" link="{{ route('tenants.index') }}" />
            </x-mary-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    {{-- TOAST area --}}
    <x-mary-toast />
</body>

</html>

</html>
