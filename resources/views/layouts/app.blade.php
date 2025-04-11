<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ showNotifications: false }" x-cloak class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans antialiased">

    @include('layouts.navigation')

    @hasSection('header')
    <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-40">
        <div class="max-w-7xl mx-auto py-4 px-6 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                @yield('header')
            </h1>

            <div class="relative">
                <button @click="showNotifications = !showNotifications" class="relative focus:outline-none">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-9.33-4.972A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if(auth()->user()->unreadNotifications->count())
                    <span
                        class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full animate-ping"></span>
                    @endif
                </button>

                <div x-show="showNotifications" @click.away="showNotifications = false"
                    class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50 p-4 max-h-64 overflow-y-auto">
                    <h2 class="text-sm font-semibold mb-3">Notifications</h2>
                    <ul class="space-y-2 text-sm">
                        @forelse(auth()->user()->notifications as $notification)
                        <li class="border-b border-gray-200 dark:border-gray-700 pb-2">
                            {{ $notification->data['message'] }}
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </li>
                        @empty
                        <li class="text-gray-500 dark:text-gray-400">No notifications.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </header>
    @endif

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg transition-all duration-300">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>

    @stack('scripts')
</body>

</html>
