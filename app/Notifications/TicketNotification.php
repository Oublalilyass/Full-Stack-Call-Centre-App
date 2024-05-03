<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;


class TicketNotification extends Notification
{
    use Queueable;
    protected $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
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
        ->subject('New Ticket Notification')
        ->line('A new ticket has been created or updated.')
        ->line('Ticket ID: ' . $this->ticket->id)
        ->line('Subject: ' . $this->ticket->subject)
        ->line('Status: ' . $this->ticket->status)
        ->action('View Ticket', url('/tickets/' . $this->ticket->id)) // Link to the specific ticket
        ->line('Thank you for using our application!');
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
