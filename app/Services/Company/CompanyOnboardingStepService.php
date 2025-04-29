<?php

namespace App\Services\Company;

use App\Models\Company\CompanyOnboardingStep;
use App\Services\BaseModelService;

class CompanyOnboardingStepService extends BaseModelService
{

    public function model(): string
    {
        return CompanyOnboardingStep::class;
    }

    public function updateOnboardingStep($company, $validatedData): void
    {
        $companyOnboardingStep = CompanyOnboardingStep::firstOrCreate(
            ['company_id' => $company->id]
        );
        $this->update($companyOnboardingStep, $validatedData);
    }
}
