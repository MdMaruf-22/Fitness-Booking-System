@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('header')
<div class="flex items-center justify-between">
    <h2 class="font-bold text-4xl text-gray-800 dark:text-gray-200 flex justify-center items-center">
        🛠️ Admin Dashboard
    </h2>

</div>
@endsection

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        @foreach ([
        [
        'title' => 'Total Users',
        'value' => $totalUsers,
        'icon' => '👥',
        'gradient' => 'from-purple-600 via-indigo-600 to-blue-600',
        'button' => [
        'text' => 'View All Users',
        'action' => "window.location.href='" . route('admin.users') . "'",
        'color' => 'bg-indigo-700 hover:bg-indigo-800'
        ]
        ],
        [
        'title' => 'Total Classes',
        'value' => $totalClasses,
        'icon' => '🏫',
        'gradient' => 'from-emerald-500 via-teal-500 to-green-500',
        'button' => [
        'text' => 'View All classes',
        'action' => "window.location.href='" . route('admin.classes') . "'",
        'color' => 'bg-green-700 hover:bg-green-800'
        ]
        ],
        [
        'title' => 'Total Bookings',
        'value' => $totalBookings,
        'icon' => '📅',
        'gradient' => 'from-sky-500 via-blue-500 to-cyan-500',
        'button' => [
        'text' => 'View All Bookings',
        'action' => "window.location.href='" . route('admin.bookings') . "'",
        'color' => 'bg-blue-700 hover:bg-blue-800'
        ]
        ]
        ] as $stat)
        <div class="relative overflow-hidden group">
            <div class="absolute -inset-1 bg-gradient-to-r {{ $stat['gradient'] }} opacity-20 group-hover:opacity-30 blur-lg transition duration-500"></div>

            <div class="relative h-full p-6 bg-gradient-to-br {{ $stat['gradient'] }} text-white rounded-xl shadow-2xl border border-white/10 overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/10"></div>
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-white/5"></div>

                <div class="relative z-10">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-white/80">{{ $stat['title'] }}</p>
                            <h3 class="mt-2 text-4xl font-bold tracking-tight">{{ $stat['value'] }}</h3>
                        </div>
                        <span class="text-4xl opacity-80">{{ $stat['icon'] }}</span>
                    </div>

                    <button
                        onclick="{{ $stat['button']['action'] }}"
                        class="mt-6 px-5 py-2.5 rounded-lg {{ $stat['button']['color'] }} text-white font-medium shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        {{ $stat['button']['text'] }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <style>
        @keyframes progress {
            0% {
                width: 0;
            }

            100% {
                width: 85%;
            }
        }

        .animate-progress {
            animation: progress 1.5s ease-out forwards;
        }
    </style>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">📊 Users by Role</h3>
            <ul class="space-y-4">
                @foreach ($usersByRole as $role => $count)
                <li class="text-lg text-gray-700 dark:text-gray-300 capitalize">
                    <span class="font-semibold">{{ $role }}:</span> {{ $count }}
                </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">💰 Total Revenue</h3>
            <p class="text-5xl text-green-600 dark:text-green-400 font-bold">৳{{ number_format($totalRevenue, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">📅 Recent Bookings</h3>
            <ul class="space-y-5">
                @forelse ($recentBookings as $booking)
                <li class="text-base text-gray-700 dark:text-gray-300">
                    <strong class="text-indigo-600 dark:text-indigo-400">{{ $booking->user->name }}</strong> booked
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $booking->fitnessClass->title }}</span>
                    <span class="text-sm text-gray-500">on {{ $booking->created_at->format('M d, Y h:i A') }}</span>
                </li>
                @empty
                <li class="text-gray-500 dark:text-gray-400">No recent bookings</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">🧍‍♂️ Recent Registrations</h3>
            <ul class="space-y-5">
                @forelse ($recentUsers as $user)
                <li class="text-base text-gray-700 dark:text-gray-300">
                    <strong class="text-indigo-600 dark:text-indigo-400">{{ $user->name }}</strong> ({{ $user->role }}) joined
                    <span class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                </li>
                @empty
                <li class="text-gray-500 dark:text-gray-400">No new users</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">📈 Users by Role (Chart)</h3>
            <canvas id="roleChart" height="200"></canvas>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">📊 Booking Distribution</h3>
            <canvas id="bookingChart" height="200"></canvas>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const roleData = @json($usersByRole);
    const roleLabels = Object.keys(roleData);
    const roleCounts = Object.values(roleData);

    new Chart(document.getElementById('roleChart'), {
        type: 'bar',
        data: {
            labels: roleLabels,
            datasets: [{
                label: 'Users',
                data: roleCounts,
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const bookingData = {
        labels: ['Paid', 'Unpaid'],
        datasets: [{
            data: [{{ \App\Models\Booking::where('is_paid', true)->count() }}, {{ \App\Models\Booking::where('is_paid', false)->count() }}],
            backgroundColor: ['#34d399', '#f87171']
        }]
    };

    new Chart(document.getElementById('bookingChart'), {
        type: 'doughnut',
        data: bookingData,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
