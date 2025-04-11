@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('header')
<h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
    Receptionist Dashboard
</h2>
@endsection

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-dashboard.card title="📅 Total Classes" :value="\App\Models\FitnessClass::count()" link="{{ route('classes.index') }}" />
            <x-dashboard.card title="📋 Total Bookings" :value="\App\Models\Booking::count()" link="{{ route('receptionist.bookings') }}" />
            <x-dashboard.card title="🚀 Upcoming Classes" :value="\App\Models\FitnessClass::where('start_time', '>', now())->count()" link="{{ route('classes.index') }}" />
            <x-dashboard.card title="📆 Today’s Bookings" :value="\App\Models\Booking::whereDate('created_at', today())->count()" link="{{ route('receptionist.bookings') }}" />
        </div>

        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                📅 Class Schedule
            </h2>
            <div class="bg-white dark:bg-gray-900 shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        All upcoming classes are displayed in this embedded Google Calendar.
                    </p>
                </div>
                <div class="w-full">
                    <iframe
                        class="w-full h-[600px] sm:h-[500px] md:h-[550px] lg:h-[600px]"
                        src="https://calendar.google.com/calendar/embed?src=b77db3237b6c7d85913ec6ed1c1a2c947daef193ba202c6166afeaab02a41e9c%40group.calendar.google.com&ctz=Asia%2FDhaka"
                        frameborder="0"
                        scrolling="no"
                        style="border: none;"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 flex flex-wrap gap-4">
            <a href="{{ route('classes.create') }}"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition">
                ➕ Add New Class
            </a>
            <a href="{{ route('receptionist.bookings') }}"
                class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition">
                📄 View All Bookings
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                🕓 Recent Bookings
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-800 dark:text-gray-200">
                    <thead>
                        <tr class="border-b border-gray-300 dark:border-gray-700">
                            <th class="py-3 px-4">User</th>
                            <th class="py-3 px-4">Class</th>
                            <th class="py-3 px-4">Time</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (\App\Models\Booking::whereDate('created_at', today())->latest()->take(5)->with(['user', 'fitnessClass'])->get() as $booking)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 px-4">{{ $booking->user->name }}</td>
                            <td class="py-3 px-4">{{ $booking->fitnessClass->title }}</td>
                            <td class="py-3 px-4">{{ $booking->created_at->format('M d, Y h:i A') }}</td>
                            <td class="py-3 px-4">
                                @if ($booking->attended)
                                <span class="text-green-600 font-medium">Attended</span>
                                @else
                                <span class="text-yellow-600 font-medium">Absent</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">No bookings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
