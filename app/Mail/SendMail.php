<?php

namespace App\Mail;

use App\Models\CustomerMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected CustomerMail $customerMail;
    protected string $message;
    public function __construct(CustomerMail $customerMail, string $message)
    {
        $this->customerMail = $customerMail;
        $this->message = $message;
    }

    public function build()
    {
        $customer = $this->customerMail->customer();
        $message = $this->message;
        return $this->from(env('MAIL_USERNAME'), 'Email notification!')
            ->view('mail.sendMessage', compact('customer', 'message'));
    }
}
