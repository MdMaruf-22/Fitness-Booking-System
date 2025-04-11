@extends('layouts.app')

@section('title', 'All Bookings')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        All Bookings
    </h2>
@endsection

@section('content')
    <div class="py-6 max-w-6xl mx-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Member</th>
                    <th class="px-4 py-2 text-left">Class</th>
                    <th class="px-4 py-2 text-left">Time</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $b)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $b->user->name }}</td>
                        <td class="px-4 py-2">{{ $b->fitnessClass->title }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($b->fitnessClass->start_time)->format('M d, H:i') }}</td>
                        <td class="px-4 py-2">
                            {{ $b->attended ? '✅ Attended' : '❌ Absent' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
