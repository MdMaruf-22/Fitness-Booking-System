@extends('layouts.app')

@section('title', 'All Users')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">📅 All Classes</h2>
        <a href="{{ route('admin.export.users_pdf') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
            Export as PDF
        </a>
    </div>
    <div class="mb-6">
        <label for="role-filter" class="block text-gray-700 dark:text-gray-300 font-medium">Filter by Role</label>
        <select id="role-filter" class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            <option value="">All Roles</option>
            <option value="member">Member</option>
            <option value="receptionist">Receptionist</option>
            <option value="admin">Admin</option>
            <option value="instructor">Instructor</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Registered At</th>
                </tr>
            </thead>
            <tbody id="user-table-body" class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($users as $user)
                <tr class="user-item" data-role="{{ $user->role }}">
                    <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-200">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $user->role }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $user->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('role-filter').addEventListener('change', function() {
        const selectedRole = this.value;
        document.querySelectorAll('.user-item').forEach(item => {
            item.style.display = selectedRole === '' || item.dataset.role === selectedRole ? 'table-row' : 'none';
        });
    });
</script>
@endsection