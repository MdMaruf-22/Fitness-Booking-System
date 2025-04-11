@csrf
<div class="space-y-6">
    <div>
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Class Title</label>
        <input type="text" name="title" value="{{ old('title', $class->title ?? '') }}"
            class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-gray-100"
            required />
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Instructor</label>
        <select name="instructor_id"
            class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
            @foreach ($instructors as $instructor)
                <option value="{{ $instructor->id }}"
                    @selected(old('instructor_id', $class->instructor_id ?? '') == $instructor->id)>
                    {{ $instructor->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Start Time</label>
        <input type="datetime-local" name="start_time"
            value="{{ old('start_time', isset($class) ? date('Y-m-d\TH:i', strtotime($class->start_time)) : '') }}"
            class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Duration (minutes)</label>
        <input type="number" name="duration" value="{{ old('duration', $class->duration ?? '') }}"
            class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Capacity</label>
        <input type="number" name="capacity" value="{{ old('capacity', $class->capacity ?? '') }}"
            class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Description</label>
        <textarea name="description" rows="4"
            class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('description', $class->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Price</label>
        <input type="number" name="price" id="price" step="0.01"
            value="{{ old('price', $class->price ?? '') }}"
            class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
    </div>
</div>

<div class="mt-8">
    <button type="submit"
        class="w-full sm:w-auto inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        {{ $submit ?? 'Save' }}
    </button>
</div>
