<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- INFO: this is for the theme changer --}}
    <script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js"></script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-mary-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
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

            @if (!is_null(tenant('id')))
                <x-app-brand name="{{ tenant('organization_name') }}" icon="o-academic-cap" class="p-5 pt-3" />
            @else
                <x-app-brand icon="o-academic-cap" class="p-5 pt-3" />
            @endif

            {{-- MENU --}}
            <x-mary-menu activate-by-route>

                {{-- User --}}
                @if ($user = auth()->user())
                    <x-mary-list-item :item="$user" sub-value="username" no-separator no-hover
                        class="!-mx-2 mt-2 mb-5 border-y border-y-sky-900">
                        <x-slot:actions>
                            <livewire:username-quick-actions />
                        </x-slot:actions>
                    </x-mary-list-item>
                @endif

                <x-mary-menu-item title="Dashboard" icon="o-computer-desktop" link="{{ route('dashboard') }}" />
                {{-- NOTE: this will be the navigation items for the tenant app --}}
                @if (!is_null(tenant('id')))
                    {{-- NOTE: this will only be available if role == admin --}}
                    @if (auth()->user()->role == 'admin')
                        <x-mary-menu-item title="Users" icon="o-users" link="{{ route('users.index') }}" />
                    @endif
                    <x-mary-menu-item title="Events" icon="o-calendar-days" link="{{ route('events.index') }}" />
                    <x-mary-menu-sub title="Attendance" icon="o-clipboard-document-list">
                        <x-mary-menu-item title="Start Attendance" icon="o-rocket-launch"
                            link="{{ route('attendance.index') }}" route="attendance.start" />
                        <x-mary-menu-item title="View Attendances" icon="o-document-text"
                            link="{{ route('attendance.list') }}" route="attendance.list" />
                    </x-mary-menu-sub>
                    <x-mary-menu-sub title="Customizations" icon="o-wrench-screwdriver">
                        <x-mary-menu-item title="Theme" icon="o-sparkles" link="{{ route('customizations.theme') }}" />
                    </x-mary-menu-sub>
                @endif
                {{-- INFO: this will be available only to central apps --}}
                {{-- INFO: this done through checking if tenant is null --}}
                @if (is_null(tenant('id')))
                    <x-mary-menu-item title="Tenants" icon="o-users" link="{{ route('tenants.index') }}" />
                    <x-mary-menu-item title="Experimental" icon="iconpark.experiment-o"
                        link="{{ route('experimentals.index') }}" />
                @endif
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
