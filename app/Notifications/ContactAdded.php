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
            ->subject(__('New Contacts Added'))
            ->greeting(__('Hello') . ' ' . $this->church->followUpContact->first_name . ',')
            ->line(__('We\'ve added some new contacts for you.'))
            ->action(__('See your new contacts now'), url(route('churches.contacts', [$this->ministry, $this->event, $this->church])))
            ->line(__('Please take care of the new contacts as soon as possible!'))
            ->salutation(__('Best regards, the') . ' ' . $this->ministry->name . ' Team');
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
