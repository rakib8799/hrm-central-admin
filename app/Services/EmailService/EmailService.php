<?php

namespace App\Services\EmailService;

use App\Models\Configuration;
use App\Models\EmailService\EmailProvider;
use Illuminate\Support\Str;

class EmailService
{

    protected Configuration $companyConfiguration;

    public function __construct(Configuration $companyConfiguration)
    {
        $this->companyConfiguration = $companyConfiguration->where('option_name', 'email_provider_id')->first();
    }

    /**
     * @throws \Exception
     */
    public function send($to, $subject, $body)
    {
        $emailProviderId = $this->companyConfiguration->option_value;
        $activeProvider = EmailProvider::find($emailProviderId)->where('is_active', $emailProviderId)->first();

        if (!$activeProvider) {
            throw new \Exception('No active email provider configured.');
        }
        $providerService = $this->getProviderService($activeProvider);
        return $providerService->send($to, $subject, $body);
    }

    protected function getProviderService(EmailProvider $provider): EmailServiceInterface
    {
        $providerName = Str::studly($provider->name);
        $providerClass = "App\\Services\\EmailService\\{$providerName}Service";

        if (!class_exists($providerClass)) {
            throw new \Exception("Provider service class {$providerClass} not found.");
        }

        return new $providerClass($provider);
    }

}
