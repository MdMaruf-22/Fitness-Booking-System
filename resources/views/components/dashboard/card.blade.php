@props(['title', 'value', 'link'])

<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ $title }}</div>
    <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $value }}</div>
    @if ($link)
        <a href="{{ $link }}" class="text-sm text-blue-500 hover:underline mt-2 inline-block">View</a>
    @endif
</div>
