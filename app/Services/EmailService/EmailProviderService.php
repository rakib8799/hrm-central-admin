<?php

namespace App\Services\EmailService;


use App\Services\BaseModelService;
use App\Services\ConfigurationService;
use Illuminate\Support\Facades\DB;
use App\Services\Company\CompanyService;
use App\Models\EmailService\EmailProvider;
use App\Services\APIService\HRM\HRMService;

class EmailProviderService extends BaseModelService
{
    private bool $isSync = true;
    private HRMService $hrmService;
    private CompanyService $companyService;
    private ConfigurationService $configurationService;

    public function __construct(HRMService $hrmService, CompanyService $companyService, ConfigurationService $configurationService)
    {
        $this->hrmService = $hrmService;
        $this->companyService = $companyService;
        $this->configurationService = $configurationService;
    }

    public function model(): string
    {
        return EmailProvider::class;
    }

    public function getEmailProviders()
    {
        return $this->model()::all();
    }

    public function getActiveEmailProvider()
    {
        return $this->model()::where('is_active', true)->first();
    }

    public function createEmailProvider($validatedData)
    {
        $result = DB::transaction(function () use($validatedData) {
            $this->model()::query()->update(['is_active' => false]);
            $validatedData['is_active'] = true;
            $emailProvider = $this->create($validatedData);
            $this->configurationService->updateConfiguration(['email_provider_id' => $emailProvider->id]);
            return $emailProvider;
        });
        return $result;
    }

    public function changeStatus(EmailProvider $emailProvider, $isActive)
    {
        $result = DB::transaction(function () use($emailProvider, $isActive) {
            // Change all email providers status to false
            $this->model()::query()->update(['is_active' => false]);
            
            $isActive = ($isActive == true) ? false : true;
            $emailProvider->update(['is_active' => $isActive]);
            if($emailProvider->is_active == true) {
                $this->configurationService->updateConfiguration(['email_provider_id' => $emailProvider->id]);
            }
            return $emailProvider;
        });
        return $result;
    }

    // Following are API related methods
    // public function createEmailProvider($data)
    // {
    //     $emailProvider =  $this->create($data);
    //     if ($this->isSync) {
    //         $data = [
    //             "name" => $emailProvider->name,
    //             "slug" => $emailProvider->slug,
    //             "is_active" => $emailProvider->is_active,
    //             "api_key" => $emailProvider->api_key,
    //             "username" => $emailProvider->username,
    //             "password" => $emailProvider->password,
    //             "base_url" => $emailProvider->base_url,
    //             "from_email" => $emailProvider->from_email,
    //         ];
    //         $this->hrmService->syncEmailProvidersForCompanies($data);
    //     }
    //     return $emailProvider;
    // }

    public function syncEmailProviders($company)
    {
        $emailProviders = $this->getEmailProviders();
        $this->hrmService->syncEmailProviders($emailProviders, $company);
    }

    public function syncEmailProviderAcrossCompanies(EmailProvider $emailProvider)
    {
        $companies = $this->companyService->getCompanies();
        foreach($companies as $company) {
            $this->hrmService->syncEmailProviders($emailProvider, $company);
        }
    }
}
