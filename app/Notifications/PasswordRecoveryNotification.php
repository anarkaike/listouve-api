<?php

namespace App\Notifications;

use App\Models\SaasClient;
use App\Models\User;
use Illuminate\{
    Bus\Queueable,
    Notifications\Messages\MailMessage,
    Notifications\Notification,
};


class PasswordRecoveryNotification extends Notification
{
    use Queueable;

    public function __construct(
    )
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
    public function toMail(SaasClient|User $notifiable)
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)->subject($data['subject'])->markdown($data['markdown'], $data)
            ->line($data['line__1'])
            ->action($data['action']['text'], $data['action']['url'])
            ->line($data['line__2']);
    }

    /**
     * Obtem uma representação da notíficação em formato de array
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(SaasClient|User $notifiable)
    {
        return [
            'subject' => $notifiable->nome . ' • Recuperação de senha',
            'markdown' => 'emails.password-recovery',
            'line__1' => 'Linha 1',
            'action' => [
                'text' => 'Texto da ação',
                'url' => 'http://localhost:4200',
            ],
            'line__2' => 'Linha 2',
            'usuario' => $notifiable->toArray()
        ];
    }
}
