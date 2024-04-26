<?php

namespace App\Jobs\V1;

use App\Models\OTPToken;
use App\Models\SiteAdmin;
use App\Models\User;
use App\Notifications\V1\OTPGenerated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nette\Utils\Random;

class ProcessOTPGenerateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public User|SiteAdmin|null $user)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $token = Random::generate(6, '0-9');

        OTPToken::create([
            'token' => $token,
            'expired_at' => now()->addMinutes((int) config('backend-logging.otp_timeout')),
            'user_id' => $this->user->id,
        ]);

        $this->user->notify(new OTPGenerated($token));
    }
}
