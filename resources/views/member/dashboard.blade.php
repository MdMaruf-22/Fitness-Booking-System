@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('header')
<h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
    👩‍🏫 Member Dashboard
</h2>
@endsection

@section('content')
<div class="py-6 px-4 max-w-6xl mx-auto space-y-8">
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Your Upcoming Bookings</h3>

        @if ($bookings->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">You have no upcoming bookings. Browse available classes to book one.</p>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($bookings->take(3) as $booking)
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 ease-in-out p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                {{ $booking->fitnessClass->title }}
                            </h3>

                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                {{ $booking->fitnessClass->description ?? 'No description available.' }}
                            </p>

                            <p class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                Instructor: {{ $booking->fitnessClass->instructor->name ?? 'Not Assigned' }}
                            </p>

                            <div class="text-sm space-y-1 text-gray-700 dark:text-gray-300">
                                <p><strong>🕒 Time:</strong> {{ \Carbon\Carbon::parse($booking->fitnessClass->start_time)->format('M d, Y • h:i A') }}</p>
                                <p><strong>Status:</strong> 
                                <span class="{{ $booking->attended ? 'text-green-500' : 'text-yellow-500' }}">
                                    {{ $booking->attended ? 'Attended' : 'Not Attended' }}
                                </span>
                            </p>
                            </div>
                        </div>

                        <div class="mt-5 flex justify-between items-center">
                            @php
                                $classFinished = \Carbon\Carbon::parse($booking->fitnessClass->start_time)->isPast();
                            @endphp

                            @if ($classFinished)
                                <span class="text-red-600 font-medium">Class Finished</span>
                            @else
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" 
                                    onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-700 transition duration-300">
                                        Cancel Booking
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('bookings.index') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-300">
                    View All Bookings
                </a>
            </div>
        @endif
    </div>
</div>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Available Classes</h3>
        <div class="space-y-2">
            <p class="text-gray-600 dark:text-gray-400">Explore and book your next class from the list below.</p>
            <a href="{{ route('bookings.available') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                Browse available classes to book your next session.
            </a>
        </div>
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

</div>
@endsection