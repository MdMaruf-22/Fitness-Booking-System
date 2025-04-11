<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | Fitness Booking System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-[Figtree] antialiased min-h-screen flex flex-col">
    <main class="flex-1 flex items-center justify-center px-6">
        <div class="text-center max-w-3xl">
            <h2 class="text-5xl md:text-6xl font-extrabold text-red-500 mb-6 animate-pulse drop-shadow-md">
                Welcome to <span class="text-white">Fitness Booking</span>
            </h2>
            <p class="text-lg md:text-xl text-gray-300 leading-relaxed">
                Book your classes, stay fit, and track your journey with ease. Whether you're a morning yogi or a late-night lifter, we’re here to support your goals.
            </p>

            <div class="mt-10 flex justify-center gap-4 flex-wrap">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="bg-red-600 hover:bg-red-700 text-white text-lg px-6 py-3 rounded-lg shadow-lg transition">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-red-600 hover:bg-red-700 text-white text-lg px-6 py-3 rounded-lg shadow-lg transition">
                            Login
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="border border-red-500 text-red-400 hover:bg-red-900 hover:text-white text-lg px-6 py-3 rounded-lg transition">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </main>

    <footer class="text-center text-sm text-gray-400 py-6">
        © {{ date('Y') }} Mohammed Maruf Islam. Stay strong, stay committed 💪
    </footer>
</body>

</html>
