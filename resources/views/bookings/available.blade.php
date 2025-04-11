@extends('layouts.app')

@section('title', 'Available Classes')

@section('header')
    <h2 class="font-bold text-2xl text-gray-800 dark:text-white tracking-tight">
        🏋️ Available Fitness Classes
    </h2>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($classes as $class)
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 ease-in-out p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $class->title }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">{{ $class->description ?? 'No description provided.' }}</p>

                        <div class="text-sm space-y-1 text-gray-700 dark:text-gray-300">
                            <p><strong>👤 Instructor:</strong> {{ $class->instructor->name ?? 'N/A' }}</p>
                            <p><strong>⏰ Time:</strong> {{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y • h:i A') }}</p>
                            <p><strong>👥 Capacity:</strong> {{ $class->bookings->count() }} / {{ $class->capacity }}</p>
                            <p><strong>💳 Price:</strong> <span class="text-indigo-600 dark:text-indigo-400 font-semibold">৳{{ number_format($class->price, 2) }}</span></p>
                        </div>
                    </div>

                    <div class="mt-5">
                        @if ($class->isFull())
                            <span class="inline-block bg-red-100 text-red-800 text-sm font-medium px-4 py-2 rounded-full">
                                Class Full
                            </span>
                        @else
                            <form action="{{ route('bookings.store', $class->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full mt-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition duration-200">
                                    ✅ Book Now
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 dark:text-gray-400">
                    No classes available at the moment.
                </div>
            @endforelse
        </div>
    </div>
@endsection
