<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bookings PDF</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>All Bookings</h2>
    <table>
        <thead>
            <tr>
                <th>User</th><th>Class</th><th>Amount</th><th>Status</th><th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->fitnessClass->title }}</td>
                    <td>{{ $booking->amount_paid }}</td>
                    <td>{{ $booking->is_paid ? 'Paid' : 'Unpaid' }}</td>
                    <td>{{ $booking->created_at->format('Y-m-d h:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
