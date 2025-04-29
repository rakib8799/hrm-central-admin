<?php

namespace App\Services\EmailService;
use SendGrid;
use Exception;
use SendGrid\Mail\Mail;
use App\Services\HelperService;
use Illuminate\Support\Facades\Http;
use App\Models\EmailService\EmailProvider;


class SendgridService implements EmailServiceInterface

{
    protected EmailProvider $provider;

    public function __construct(EmailProvider $provider)
    {
        $this->provider = $provider;
    }

    public function send($to, $subject, $body)
    {
        $email = new Mail();
        $email->setFrom($this->provider->from_email, "Support Hrbee");
        $email->setSubject($subject);
        $email->addTo($to);
        $email->addContent("text/html", $body);
        $sendgrid = new SendGrid($this->provider->api_key);

        try {
            $response = $sendgrid->send($email);
            return $response->statusCode();
        } catch (Exception $e) {
            HelperService::captureException($e);
            return 'Caught exception: '. $e->getMessage();
        }

    }

    public function sendDynamicEmailSendgrid($toEmail, $templateId, $dynamicTemplateData, $attachedFile = null, $subject = null)
    {
        if (empty($toEmail)) {
            return false;
        }

        $mailData = [
            'personalizations' => [
                [
                    'to' => [
                        ['email' => $toEmail]
                    ],
                    'dynamic_template_data' => $dynamicTemplateData
                ]
            ],
            'from' => [
                'email' => config('mail.from.address', 'noreply@example.com')
            ],
            'template_id' => $templateId
        ];

        if ($subject) {
            $mailData['subject'] = $subject;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.sendgrid.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.sendgrid.com/v3/mail/send', $mailData);

            $emailLogData = [
                'from_email' => config('mail.from.address', 'noreply@example.com'),
                'to_email' => $toEmail,
                'subject' => $subject,
                'response' => $response,
                'dynamic_template_data' => $dynamicTemplateData,
                'template_id' => $templateId,
            ];

            return $response->status();
        } catch (\Exception $e) {
            HelperService::captureException($e);
            // Handle exception
            // Log or report the error
            // instead of simply returning false
            return false;
        }
    }
}
