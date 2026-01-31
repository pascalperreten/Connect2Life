<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Ministry;

class Invitation extends Notification implements ShouldQueue
{
    use Queueable;
    public User $newMember;
    public Ministry $ministry;
    /**
     * Create a new notification instance.
     */
    public function __construct(User $newMember, Ministry $ministry)
    {
        $this->newMember = $newMember;
        $this->ministry = $ministry;
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
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Neue Kontakte')
            ->greeting('Hallo ' . $this->newMember->first_name)
            ->line('Bitte klicke auf den Link unten, um dein Konto einzurichten.')
            ->action('Jetzt Konto einrichten', url(route('invitation', [$this->ministry, $this->newMember->invitation_token])))
            ->line('Danke!')
            ->salutation('Mit freundlichen Grüßen, das ' . $this->ministry->name . '-Team');
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
