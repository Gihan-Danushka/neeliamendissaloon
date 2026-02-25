<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf; // Include this if you're using PDF
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdf;

    public function __construct($data, $pdf)
    {
        $this->data = $data;
        $this->pdf = $pdf;
    }

    public function build()
    {
        // return $this->view('emails.invoice') // Create this view
        return $this->view('emails.invoice')
            ->subject('Your Invoice Subject')
            ->attachData($this->pdf->output(), 'invoice.pdf')
            ->with(['data' => $this->data]);
    }
}
