@extends('layouts.app')

@section('title', 'Fitness Classes')

@section('header')
    <h2 class="text-xl font-semibold leading-tight">Fitness Classes</h2>
@endsection

@section('content')
    <div class="space-y-6">
        <a href="{{ route('classes.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Create New Class
        </a>

        @if (session('success'))
            <div class="p-3 rounded bg-green-100 text-green-700 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold">
                    <tr>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Instructor</th>
                        <th class="px-4 py-2">Start</th>
                        <th class="px-4 py-2">Duration</th>
                        <th class="px-4 py-2">Capacity</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($classes as $class)
                        <tr>
                            <td class="px-4 py-2">{{ $class->title }}</td>
                            <td class="px-4 py-2">{{ $class->instructor->name }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y h:i A') }}</td>
                            <td class="px-4 py-2">{{ $class->duration }} mins</td>
                            <td class="px-4 py-2">{{ $class->capacity }}</td>
                            <td class="px-4 py-2">৳{{ $class->price }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('classes.edit', $class->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 dark:text-gray-400 py-4">No classes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
