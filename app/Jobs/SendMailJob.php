<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\CustomerMail;
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
    protected CustomerMail $mailing;
    protected string $name;
    protected string $msg;
    public function __construct(CustomerMail $mailing, string $name, string $msg)
    {
        $this->mailing = $mailing;
        $this->name = $name;
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mail = $this->mailing;
        Mail::to($mail->customer->email)->send(new SendMail($mail, $this->msg, $this->name));
        $mail->update(['status' => CustomerMail::SENT]);
        if($mail->is_last)
        {
            $mail->mailing->update(['status' => Mailing::SENT]);

        }
        else{
            sleep(20);
        }

    }
}
