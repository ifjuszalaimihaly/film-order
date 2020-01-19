<?php

namespace App\Notifications;

use App\Film;
use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FilmOrderNotification extends Notification
{
    use Queueable;

    private $film;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Film $film)
    {
        $this->film = $film;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        error_log($this->film);
        return (new MailMessage)
            ->line('Dear '.$notifiable->name.'!')
            ->line('You requested the film: '.$this->film->original_title.' ('.$this->film->translated_title.').')
            ->line('Order status: '.$this->film->status->name);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
