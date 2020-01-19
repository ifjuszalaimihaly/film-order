<?php

namespace App\Notifications;

use App\Film;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FilmOrderAdminNotification extends Notification
{
    use Queueable;

    private $user;
    private $film;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Film $film)
    {
        $this->user = $user;
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
        return (new MailMessage)
            ->line('Dear Admin!')
            ->line($this->user->email.' requested the film: '.$this->film->original_title.' ('.$this->film->translated_title.').')
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
