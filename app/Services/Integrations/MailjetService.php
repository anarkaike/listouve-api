<?php
namespace App\Services\Integrations;

use Mailjet\Client;
use Mailjet\Resources;
use Illuminate\Support\Facades\Log;

class MailjetService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            key: config(key: 'services.mailjet.api_key'),
            secret: config(key: 'services.mailjet.api_secret'),
            call: true,
            settings: ['version' => 'v3.1']
        );
    }

    public function sendEmail($toEmail, $toName, $subject, $content)
    {
        $data = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => config('mail.from.address'),
                        'Name' => config('mail.from.name'),
                    ],
                    'To' => [
                        [
                            'Email' => $toEmail,
                            'Name' => $toName,
                        ],
                    ],
                    'Subject' => $subject,
                    'HTMLPart' => $content,
                ],
            ],
        ];

        try {
            $response = $this->client->post(Resources::$Email, ['body' => $data]);
            return $response->success();

        } catch (\Exception $e) {
            Log::error(message: trans('messages.error_sending_email_via_mailjet', ['getMessage' => $e->getMessage()]));
            return false;
        }
    }
}
