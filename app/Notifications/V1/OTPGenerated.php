<?php

namespace App\Notifications\V1;

use App\Models\OTPToken;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OTPGenerated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public OTPToken|string $token)
    {
        if ($token instanceof OTPToken) {
            $this->token = $token->token;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  User  $notifiable
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('OTP Token to verify account')
            ->greeting('Hi there! ' . $notifiable->first_name)
            ->line('We\'re glad you choose ' . config('app.name') . ', and it appears you\'re attempting to confirm your email.')
            ->line('This is the OTP token for your verification. The OTP token is valid for 5 minutes.')
            ->line(new HtmlString('<strong>' . $this->token . '</strong>'))
            ->line(new HtmlString('<em>Please, do not share OTP token with anyone.<em>'))
            ->line(new HtmlString('The recipient of this email is <a href=\'mailto:' . $notifiable->email . '\'>' . $notifiable->email . '</a>. Please disregard this email if it is not yours. Thank you for understanding.'))
            ->line(new HtmlString('<br />'))
            ->line('Thank you for using our application');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
