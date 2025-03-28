<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        @php
            use Illuminate\Support\Facades\Auth;
        @endphp
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar -->
            @php
                $roleId = Auth::user()->role_id ?? null;
            @endphp

            @if ($roleId === 1) {{-- Super Admin --}}
                @include('layouts/sections/menu/superAdminMenu')
            @elseif ($roleId === 2) {{-- Admin --}}
                @include('layouts/sections/menu/adminMenu')
            @elseif ($roleId === 3) {{-- Student --}}
                @include('layouts/sections/menu/studentMenu')
            @else {{-- Default Menu --}}
                @include('layouts/sections/menu/verticalMenu')
            @endif

            <div class="flex-1">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    @yield('content') <!-- Replace $slot with @yield('content') -->
                </main>
            </div>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
