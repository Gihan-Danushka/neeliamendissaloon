<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    // Constructor to pass the booking data
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    // Build the email message
    public function build()
    {
        return $this->subject('Booking Reminder') // Subject of the email
                    ->view('emails.booking_reminder'); // Define the view
    }
}

