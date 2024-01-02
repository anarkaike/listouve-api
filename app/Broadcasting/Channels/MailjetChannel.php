<?php
namespace App\Broadcasting\Channels;

use App\Models\SaasClient;
use App\Models\User;
use App\Services\Integrations\MailjetService;

use Illuminate\Notifications\Notification;

/**
 * Canal por onde o sistema de notíficação do Laravel está enviando notificações do tipo email usando api do MailJet
 */
class MailjetChannel
{
    public function __construct(
        protected MailjetService $mailjet
    )
    {}

    /**
     * Envia a notificação/email ao notifiable (model que contenha o trait "use Notifiable;")
     *
     * @param $notifiable - Quem recebe a notificação
     * @param Notification $notification - Notificação propriamente dita
     *
     * @return void
     */
    public function send(User|SaasClient $notifiable, Notification $notification)
    {
        $message = $notification->toMail($notifiable);

        $this->mailjet->sendEmail(
            toEmail: $notifiable->email,
            toName: $notifiable->name,
            subject: $message->subject,
            content: (string) $message->render()
        );
    }
}
