<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\{
    Bus\Queueable,
    Notifications\Messages\MailMessage,
    Notifications\Notification,
};


class LinkAutoRegisterNotification extends Notification
{
    use Queueable;

    public function __construct()
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mailjet'];
    }

    /**
     * Obtem uma representação da notíficação em formato de email
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $notifiable)
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)
            ->subject($data['subject'])
            ->view($data['view'], $data);
    }

    /**
     * Obtem uma representação da notíficação em formato de array
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(User $notifiable)
    {
        return [
            'subject'               => $notifiable->name . ' • Convite para cadastro',
            'view'                  => 'emails.link-auto-register',
            'user'                  => $notifiable->toArray()
        ];
    }
}
