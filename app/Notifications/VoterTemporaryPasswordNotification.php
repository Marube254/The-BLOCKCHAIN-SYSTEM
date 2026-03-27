<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VoterTemporaryPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $temporaryPassword;

    public function __construct(string $temporaryPassword)
    {
        $this->temporaryPassword = $temporaryPassword;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your IUEA VoteHub temporary password')
            ->greeting('Hello '.$notifiable->first_name.',')
            ->line('Your voter account has been created successfully.')
            ->line('Your temporary password is:')
            ->line('`'.$this->temporaryPassword.'`')
            ->line('Use this password to log in, then immediately change it via the reset password flow.')
            ->line('If you did not request this, please contact the election administrators.')
            ->action('Open VoteHub', route('voter.auth'))
            ->salutation('Best regards, IUEA Electoral Commission');
    }

    public function toArray($notifiable)
    {
        return [
            'temporary_password' => $this->temporaryPassword,
        ];
    }
}
