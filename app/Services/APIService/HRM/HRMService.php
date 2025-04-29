<?php

namespace App\Services\APIService\HRM;


use App\Services\Company\CompanyService;
use App\Services\ConfigurationService;
use App\Services\HelperService;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class HRMService extends HRMBaseService
{
    // This class is responsible for making requests to the HRM API

    private mixed $hrmAPIUrl;
    private mixed $data;
    private mixed $url;
    private mixed $workspace;
    private mixed $method;
    private mixed $domain;
    private mixed $httpProtocol;
    private CompanyService $companyService;
    private ConfigurationService $configurationService;

    public function __construct( CompanyService $companyService, ConfigurationService $configurationService)
    {
        $this->hrmAPIUrl = env('HR_BEE_HRM_API_URL');
        $this->data = null;
        $this->url = null;
        $this->workspace = null;
        $this->method = null;
        $this->domain = null;
        $this->companyService = $companyService;
        $this->configurationService = $configurationService;
        $this->httpProtocol = $this->configurationService->getConfiguration('company_http_protocol')->option_value;
    }


    public function sendRequest(): Response
    {
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

    public function syncEmailProviders($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/hrbee-hrm/sync/email-providers';
        $this->method = 'POST';
        $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Email providers synced successfully',
        ]);
    }

    public function syncEmailProvidersForCompanies($data): JsonResponse
    {
        $companies = $this->companyService->all();
        foreach ($companies as $company) {
            $this->syncEmailProviders($data, $company);
        }
        return response()->json([
            'success' => true,
            'message' => 'Email events synced successfully',
        ]);
    }

    public function syncEmailEvents($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/hrbee-hrm/sync/email-events';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Email events synced successfully',
        ]);
    }


    public function syncEmailEventsForCompanies($data): JsonResponse
    {
        $companies = $this->companyService->all();
        foreach ($companies as $company) {
            $this->syncEmailEvents($data, $company);
        }
        return response()->json([
            'success' => true,
            'message' => 'Email events synced successfully',
        ]);
    }

    public function syncEmailEventTemplatesForCompanies($data): JsonResponse
    {
        $companies = $this->companyService->all();
        foreach ($companies as $company) {
            $this->syncEmailEventTemplates($data, $company);
        }
        return response()->json([
            'success' => true,
            'message' => 'Email event templates synced successfully',
        ]);
    }

    public function syncEmailEventTemplates($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/hrbee-hrm/sync/email-event-templates';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Email event templates synced successfully',
        ]);
    }

    public function syncSubscriptionPlansForCompanies($data): JsonResponse
    {
        $companies = $this->companyService->all();
        foreach ($companies as $company) {
            $this->syncSubscriptionPlans($data, $company);
        }
        return response()->json([
            'success' => true,
            'message' => 'Subscription plan synced successfully',
        ]);
    }

    public function syncSubscriptionPlans($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/hrbee-hrm/sync/subscription-plans';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Subscription plan synced successfully',
        ]);
    }

    public function syncSubscription($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/hrbee-hrm/sync/subscription';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Subscription synced successfully',
        ]);
    }

    public function syncSubscriptionPlanFeatures($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/hrbee-hrm/sync/subscription-plan-features';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Subscription plan feature synced successfully',
        ]);
    }

    public function syncConfigurations($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/hrbee-hrm/sync/configurations';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Configurations synced successfully',
        ]);
    }
}
