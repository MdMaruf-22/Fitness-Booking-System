@extends('layouts.app')

@section('title', 'All Classes')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">🏫 All Classes</h2>
        <a href="{{ route('admin.export.classes_pdf') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
            Export as PDF
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
            <tr>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Instructor</th>
                        <th class="px-4 py-2">Start Time</th>
                        <th class="px-4 py-2">Duration</th>
                        <th class="px-4 py-2">Capacity</th>
                        <th class="px-4 py-2">Price</th>
                    </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($classes as $class)
                <tr>
                    <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $class->title }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $class->instructor->name }}</td>
                    <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y h:i A') }}</td>
                    <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $class->duration }} mins</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $class->capacity }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">৳{{ $class->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
