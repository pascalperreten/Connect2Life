<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ministry;
use App\Models\Event;
use App\Models\Church;

class ContactAdded extends Notification implements ShouldQueue
{
    use Queueable;

    public Ministry $ministry;
    public Event $event;
    public Church $church;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ministry $ministry, Event $event, Church $church)
    {
        $this->ministry = $ministry;
        $this->event = $event;
        $this->church = $church;
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
            ->greeting('Hallo ' . $this->church->followUpContact->first_name . ',')
            ->line('Wir haben dir neue Kontakte hinzugefügt.')
            ->action('Sieh dir jetzt deine neuen Kontakte an', url(route('churches.show', [$this->ministry, $this->event, $this->church])))
            ->line('Bitte kümmere dich so schnell wie möglich um die neuen Kontakte!')
            ->salutation('Viele Grüße, Dein ' . $this->ministry->name . ' Team');
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
