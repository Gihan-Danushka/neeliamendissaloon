<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName; // Add properties you want to use in the email
    public $invoiceDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($clientName, $invoiceDetails)
    {
        $this->clientName = $clientName;
        $this->invoiceDetails = $invoiceDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reminder') // Specify the view
                    ->subject('Reminder Notification')
                    ->with([
                        'clientName' => $this->clientName,
                        'invoiceDetails' => $this->invoiceDetails,
                    ]);
    }
}
