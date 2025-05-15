<?php

namespace App\Services\Company;

use App\Models\Company\Company;
use App\Services\BaseModelService;
use App\Services\ConfigurationService;
use App\Services\EmailService\EmailService;

class CompanyService extends BaseModelService
{
    private EmailService $emailService;
    private ConfigurationService $configurationService;

    public function __construct(
        EmailService                 $emailService,
        ConfigurationService         $configurationService,
    )
    {
        $this->emailService = $emailService;
        $this->configurationService = $configurationService;
    }

    public function model(): string
    {
        return Company::class;
    }

    public function getCompanies()
    {
        return $this->model()::all();
    }

    public function getCompanyDetails()
    {
        return $this->model()::with(['subscription.subscriptionPlan'])->get();
    }

    public function createCompany($validatedData)
    {
        $domainAdminPortal = $this->configurationService->getConfiguration('domain_admin_portal');
        $companyAdminDomain = $validatedData['workspace']. '-' . $domainAdminPortal->option_value;
        $companyDomainsArray = [
            $companyAdminDomain => $companyAdminDomain
        ];
        $validatedData['domain'] = $companyAdminDomain;
        $validatedData['allowed_domains'] = json_encode($companyDomainsArray);

        $company = $this->create($validatedData);
        return $company;
    }

    public function sendCompanyEmailVerification($company, $emailVerificationData): void
    {
        $title = 'Welcome Aboard';
        $supportDetails = $this->configurationService->getSupportDetails();
        $emailData = ['company' => $company, 'emailVerificationData' => $emailVerificationData, 'supportDetails' => $supportDetails];
        $emailContent = view('email-template.company-onboarding-email-verification', $emailData)->render();
        $this->emailService->send($company->email, $title, $emailContent);
    }

    public function updateCompany($company, $validatedData): Company
    {
        $company->update($validatedData);
        return $company;
    }

    public function updateCompanyStatus($company, $status): void
    {
        $company->update(['status' => $status]);
    }

    public function getCompany($workspace)
    {
        return Company::where('workspace', $workspace)->first();
    }
}
