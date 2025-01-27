<?php
// app/Mail/ContactUsSubmitted.php

namespace App\Mail;

use App\Models\ContactUs;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $contactUs;

    public function __construct(ContactUs $contactUs)
    {
        $this->contactUs = $contactUs;
    }

    public function build()
    {
        return $this->subject('New Contact Us Submission')
            ->view('emails.contact_us')
            ->with('contactUs', $this->contactUs);
    }
}
