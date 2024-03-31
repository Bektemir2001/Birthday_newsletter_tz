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
    protected string $name;
    public function __construct(CustomerMail $customerMail, string $message, string $name)
    {
        $this->customerMail = $customerMail;
        $this->message = $message;
        $this->name = $name;
    }

    public function build()
    {
        $customer = $this->customerMail->customer;
        $msg = $this->message;
        $mailing_name = $this->name;
        return $this->from(env('MAIL_FROM_ADDRESS'), $mailing_name)
            ->view('mail.sendMessage', compact('customer', 'msg', 'mailing_name'));
    }
}
