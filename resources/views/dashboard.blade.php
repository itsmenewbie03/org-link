<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session()->has('error_message'))
            <x-mary-alert class="alert-error" icon="o-exclamation-triangle" title="{{ session('error_message') }}"
                dismissible />
        @endif
        {{-- NOTE: we will only check for updates if were on the dashboard route of the central app --}}
        @if (is_null(tenant('id')))
            @if (Route::current()->getName() === 'dashboard')

                @if (session()->has('update_result'))
                    <x-mary-alert class="alert-info" icon="o-arrow-path" title="{{ session('update_result') }}"
                        dismissible />
                    {{ session()->forget('update_result') }}
                @endif

                @if (is_array(Updater::newVersionAvailable()))
                    @php
                        $update = Updater::newVersionAvailable();
                        $current_version = $update['current_version'];
                        $latest_version = $update['latest_version'];
                    @endphp
                    <x-mary-alert class="alert-success" icon="o-arrow-path" title="Update available"
                        description="OrgLink is updated to {{ $latest_version }}. You are currently using {{ $current_version }}">
                        <x-slot name="actions">
                            <x-mary-button link="{{ route('update') }}" label="Update" />
                        </x-slot>
                    </x-mary-alert>
                @endif
            @endif
        @endif

        @sectionMissing('content')
            <div class="text-lg breadcrumbs">
                <ul>
                    <li><x-mary-icon name="o-computer-desktop" label="Dashboard" /></li>
                </ul>
            </div>
            @if (is_null(tenant('id')))
                <x-mary-header title="OrgLink" subtitle="{{ Updater::getCurrentVersion() }}">
                    <x-slot:middle class="!justify-end">
                        <x-mary-input icon="o-magnifying-glass" placeholder="Search..." />
                    </x-slot:middle>
                    <x-slot:actions>
                        <x-mary-button icon="o-funnel" />
                        <x-mary-button icon="o-plus" class="btn-primary" />
                    </x-slot:actions>
                </x-mary-header>
            @else
                <x-mary-header title="{{ tenant('organization_name') }}" subtitle="Welcome, {{ auth()->user()->name }}">
                    <x-slot:middle class="!justify-end">
                        <x-mary-input icon="o-magnifying-glass" placeholder="Search..." />
                    </x-slot:middle>
                    <x-slot:actions>
                        <x-mary-button icon="o-funnel" />
                        <x-mary-button icon="o-plus" class="btn-primary" />
                    </x-slot:actions>
                </x-mary-header>
            @endif
            <div class="flex gap-4">

                <x-mary-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" />

                <x-mary-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-up"
                    tooltip-bottom="There" />

                <x-mary-stat title="Lost" description="This month" value="34" icon="o-arrow-trending-down"
                    tooltip-left="Ops!" />

                <x-mary-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-down"
                    class="text-orange-500" color="text-pink-500" tooltip-right="Gosh!" />
            </div>
        @else
            @yield('content')
        @endif
    </div>
</x-app-layout>
