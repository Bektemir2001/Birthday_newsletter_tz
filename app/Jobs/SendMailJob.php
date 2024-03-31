<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\Mailing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected Mailing $mailing;
    public function __construct(Mailing $mailing)
    {
        $this->mailing = $mailing;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customersMails = $this->mailing->customerMails;
        foreach ($customersMails as $mail)
        {
            Mail::to($mail->customer->email)->send(new SendMail($mail, $this->mailing->msg, $this->mailing->name));
            $mail->update(['status' => 1]);
            sleep(10);
        }

        $this->mailing->update(['status' => 1]);

    }
}
