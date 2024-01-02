<?php

namespace App\Notifications;

use App\Models\SaasClient;
use Illuminate\{
    Bus\Queueable,
    Notifications\Messages\MailMessage,
    Notifications\Notification,
};


class SaasClientConfirmEmailNotification extends Notification
{
    use Queueable;

    public function __construct(
        private String $codeEmailValidation
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
    public function toMail(SaasClient $notifiable)
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
    public function toArray(SaasClient $notifiable)
    {
        return [
            'subject'               => $notifiable->name . ' • Confirmação de email',
            'view'                  => 'emails.saas-client-confirm-email',
            'saasClient'            => $notifiable->toArray(),
            'codeEmailValidation'   => $this->codeEmailValidation
        ];
    }
}
