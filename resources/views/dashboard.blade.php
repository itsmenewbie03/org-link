<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- NOTE: we will only check for updates if were on the dashboard route of the central app --}}
        @if (is_null(tenant('id')))
            @if (Route::current()->getName() === 'dashboard')

                @if (isset($update_result))
                    <x-mary-alert class="alert-info" icon="o-arrow-path" title="{{ $update_result }}" dismissible />
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
            @yield('content')
        @endif
    </div>
</x-app-layout>
