<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Classes PDF</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>All Fitness Classes</h2>
    <table>
        <thead>
            <tr>
            <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Instructor</th>
                        <th class="px-4 py-2">Start Time</th>
                        <th class="px-4 py-2">Duration</th>
                        <th class="px-4 py-2">Capacity</th>
                        <th class="px-4 py-2">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $class)
                <tr>
                    <td>{{ $class->title }}</td>
                    <td>{{ $class->instructor->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y h:i A') }}</td>
                    <td>{{ $class->duration }} mins</td>
                    <td>{{ $class->capacity }}</td>
                    <td>৳{{ $class->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
