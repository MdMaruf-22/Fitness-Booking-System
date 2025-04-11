@extends('layouts.app')

@section('title', 'Instructor Dashboard')

@section('header')
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
        👩‍🏫 Instructor Dashboard
    </h2>
@endsection

@section('content')
    <div class="py-6 px-4 max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                Your Upcoming Classes
            </h1>
            <a href="{{ route('classes.create') }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow transition">
                ➕ Create Class
            </a>
        </div>

        @if ($classes->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">You have no assigned classes at the moment.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($classes as $class)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 border dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $class->title }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                            📅 {{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y • h:i A') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                            👥 Bookings: {{ $class->bookings_count }} / {{ $class->capacity }}
                        </p>
                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            <a href="{{ route('class.bookings', $class->id) }}"
                               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                📋 View Attendance
                            </a>
                            <a href="{{ route('classes.edit', $class->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('classes.destroy', $class->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this class?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
