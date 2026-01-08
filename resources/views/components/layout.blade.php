<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Monetra' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        /* Custom scrollbar for sidebar if needed */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-base-200 font-sans text-base-content">

    <div class="drawer lg:drawer-open">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />

        <!-- Drawer Content (Main Page) -->
        <div class="drawer-content flex flex-col h-screen overflow-hidden">
            <!-- Top Header -->
            <x-dashboard.header />

            <!-- Scrollable Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

            <x-dashboard.footer />
        </div>

        <!-- Sidebar (Drawer Side) -->
        <x-dashboard.sidebar />
    </div>
    @livewireScripts
    <script src="{{ asset('js/global-loading.js') }}"></script>
</body>

</html>
