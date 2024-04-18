<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    {{-- You could elaborate the layout here --}}
    {{-- The important part is to have a different layout from the main app layout --}}
    <x-mary-main full-width>
        <x-slot:content>
            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif
            <div class="flex gap-2 mt-14">
                <x-mary-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" />

                <x-mary-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-up"
                    tooltip-bottom="There" />

                <x-mary-stat title="Lost" description="This month" value="34" icon="o-arrow-trending-down"
                    tooltip-left="Ops!" />

                <x-mary-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-down"
                    class="text-orange-500" color="text-pink-500" tooltip-right="Gosh!" />
            </div>

        </x-slot:content>
    </x-mary-main>
</body>

</html>
