<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Reminder</title>
</head>
<body>
    <h2>Hello {{ $booking->user->first_name }},</h2>
    <p>This is a reminder that you have a booking scheduled:</p>

    <ul>
        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->date)->toFormattedDateString() }}</li>
        <li><strong>Start Time:</strong> {{ $booking->start_time }}</li>
        <li><strong>Total Price:</strong> ${{ $booking->total_price }}</li>
    </ul>

    <p>Thank you for booking with {{ config('app.name') }}!</p>
</body>
</html>
