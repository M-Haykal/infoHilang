<?php

namespace App\Jobs;

use App\Mail\SendEmailOtp;
use App\Services\EmailOtpService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $otp;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailable = new SendEmailOtp($this->user, $this->otp, EmailOtpService::TTL_MINUTES);
        Mail::to($this->user->email)->send($mailable);
    }
}
