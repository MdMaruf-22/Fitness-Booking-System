@extends('layouts.app')

@section('title', 'My Bookings')

@section('header')
    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
        📅 My Bookings
    </h2>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($bookings as $booking)
                @php
                    $classFinished = \Carbon\Carbon::parse($booking->fitnessClass->start_time)->isPast();
                @endphp
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
    </div>
@endsection
