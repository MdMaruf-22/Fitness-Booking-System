<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: DejaVu Sans; }
        .header { text-align: center; margin-bottom: 30px; }
        .info { margin-bottom: 20px; }
        .total { font-size: 18px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Fitness Class Booking Invoice</h2>
    </div>

    <div class="info">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Class:</strong> {{ $class->title }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($class->start_time)->toDayDateTimeString() }}</p>
        <p><strong>Amount Paid:</strong> ৳{{ number_format($class->price ) }}</p>
        <p><strong>Payment Method:</strong> {{ ucfirst($booking->payment_method) }}</p>
    </div>

    <p class="total">Thank you for your payment!</p>
</body>
</html>
