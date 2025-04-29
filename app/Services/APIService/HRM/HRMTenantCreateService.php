<?php

namespace App\Services\APIService\HRM;


use App\Services\HelperService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Services\ConfigurationService;
use App\Services\EmailService\EmailProviderService;

class HRMTenantCreateService extends HRMBaseService
{
    // This class is responsible for making requests to the HRM API

    private mixed $hrmAPIUrl;
    private mixed $data;
    private mixed $url;
    private mixed $domain;
    private mixed $method;
    private mixed $httpProtocol;
    private ConfigurationService $configurationService;
    private EmailProviderService $emailProviderService;

    public function __construct(
        ConfigurationService         $configurationService,
        EmailProviderService $emailProviderService
    )
    {
        $this->hrmAPIUrl = env('HR_BEE_HRM_API_URL');
        $this->data = null;
        $this->url = null;
        $this->domain = null;
        $this->method = null;
        $this->configurationService = $configurationService;
        $this->emailProviderService = $emailProviderService;
        $this->httpProtocol = $this->configurationService->getConfiguration('company_http_protocol')->option_value;
    }


    public function sendRequest(): Response
    {
        $companyHttpProtocol = $this->configurationService->getConfiguration('company_http_protocol');
        $data = $this->data;
        $header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Origin' => $this->domain,
            'X-Api-Key' => env('HR_BEE_HRM_API_KEY'),
        ];

        $url = $this->hrmAPIUrl . $this->url;
        if ($this->method === 'POST') {
            $response = Http::withHeaders($header)->post($url, $data);
        } else {
            $response = Http::withHeaders($header)->get($url, $data);
        }
        return $response;
    }

    public function databaseMigration($company): Response
    {
        $this->data = [
            'database_name' => $company->workspace,
        ];
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->url = '/api/v1/hrbee-hrm/tenant/migration';
        $this->method = 'POST';
        return $this->sendRequest();
    }

    public function initialDataLoad($company): Response
    {
        $emailProvider = $this->emailProviderService->getActiveEmailProvider();
        $supportEmail = $this->configurationService->getConfiguration('support_email')->option_value;
        $supportTelephone = $this->configurationService->getConfiguration('support_telephone')->option_value;
        $this->data = [
            'database_name' => $company->workspace,
            'workspace' => $company->workspace,
            'email_provider_id' => $emailProvider->id,
            'support_email' => $supportEmail,
            'support_telephone' => $supportTelephone,
        ];
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->url = '/api/v1/hrbee-hrm/tenant/run-seeders';
        $this->method = 'POST';
        return $this->sendRequest();
    }

    public function createAdminUser($company, $validatedData)
    {
        $this->data = $validatedData;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->method = 'POST';
        $this->url = '/api/v1/hrbee-hrm/tenant/create-admin-user';
        $response = $this->sendRequest();
        $responseData = json_decode($response, true);
        return $responseData;
    }
}
