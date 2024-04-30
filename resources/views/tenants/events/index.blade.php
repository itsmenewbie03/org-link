<head>
    <link href="https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar@2.7.0/build/vanilla-calendar.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar@2.7.0/build/themes/light.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar@2.7.0/build/themes/dark.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar@2.7.0/build/vanilla-calendar.min.js" defer>
    </script>
</head>
@extends('dashboard')
@section('content')
    @php
        $events = [
            [
                'label' => 'Day off',
                'description' => 'Playing <u>tennis.</u>',
                'css' => '!bg-amber-200',
                'date' => now()->startOfMonth()->addDays(3),
            ],
            [
                'label' => 'Health',
                'description' => 'I am sick',
                'css' => '!bg-green-200',
                'date' => now()->startOfMonth()->addDays(8),
            ],
            [
                'label' => 'Laracon',
                'description' => 'Let`s go!',
                'css' => '!bg-blue-200',
                'range' => [now()->startOfMonth()->addDays(13), now()->startOfMonth()->addDays(15)],
            ],
        ];
    @endphp

    @php
        $users = App\Models\User::take(3)->get();
    @endphp

    <div class="text-lg breadcrumbs">
        <ul>
            <li><x-mary-icon name="o-calendar-days" label="Events" /></li>
        </ul>
    </div>
    <div class="w-full flex">
        <livewire:tenant-event-quick-actions />
        <x-mary-card title="Upcoming Events" class="w-1/3 mr-6" shadow separator>
            @foreach ($users as $user)
                <x-mary-list-item :item="$user" />
            @endforeach
        </x-mary-card>

        <x-mary-card title="Monthly Events Calendar" class="w-fit" shadow separator>
            {{-- TODO: get rid of this ugly config call --}}
            <x-mary-calendar locale="en-PH" :events="$events" weekend-highlight :config="['settings' => ['iso8601' => false]]" />
        </x-mary-card>
    </div>
@endsection
