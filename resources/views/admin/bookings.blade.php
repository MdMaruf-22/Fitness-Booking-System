@extends('layouts.app')

@section('title', 'All Bookings')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">📅 All Bookings</h2>
        <a href="{{ route('admin.export.bookings_pdf') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
            Export as PDF
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Class</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Time</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($bookings as $booking)
                <tr>
                    <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $booking->user->name }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $booking->fitnessClass->title }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $booking->date }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $booking->time }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
