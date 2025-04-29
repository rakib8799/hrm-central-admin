<?php 

namespace App\Services;
use App\Services\APIService\HRM\HRMService;
use App\Services\Company\CompanyService;

class SyncService
{
    protected HRMService $hrmService;
    protected CompanyService $companyService;
    public function __construct(HRMService $hrmService, CompanyService $companyService)
    {
        $this->hrmService = $hrmService;
        $this->companyService = $companyService;
    }

    public function syncConfigurationAcrossCompanies($validatedData)
    {
        $companies = $this->companyService->getCompanies();
        foreach($companies as $company) {
            $this->hrmService->syncConfigurations($validatedData, $company);
        }
    }
}