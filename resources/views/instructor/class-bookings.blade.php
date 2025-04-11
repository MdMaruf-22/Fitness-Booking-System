@extends('layouts.app')

@section('title', 'Class Bookings')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Attendance for Class : {{ $class->title }}
    </h2>
@endsection

@section('content')
    <div class="py-6 max-w-4xl mx-auto">
        @foreach ($class->bookings as $booking)
            <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-3 flex justify-between items-center">
                <div class="text-gray-900 dark:text-gray-100">
                    <p><strong>👤 Member:</strong> {{ $booking->user->name }}</p>
                    <p>Status: 
                        @if ($booking->attended)
                            <span class="text-green-500 font-semibold">✅ Attended</span>
                        @else
                            <span class="text-yellow-400 font-semibold">❌ Not Attended</span>
                        @endif
                    </p>
                </div>
                @if (!$booking->attended)
                    <form action="{{ route('booking.attend', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Mark Attended
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
@endsection
